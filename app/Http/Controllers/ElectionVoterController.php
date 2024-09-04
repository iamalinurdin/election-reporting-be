<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\ElectionVoterResource;
use App\Models\ElectionVoter;
use App\Models\Volunteer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Void_;

class ElectionVoterController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $user = $request->user();

    if ($user->role == 'volunteer') {
      $volunteer = Volunteer::query()->whereHas('user', function ($query) use ($user) {
        $query->where('user_id', $user->id);
      })->with('voters')->first();

      return JsonResponse::success(
        data: ElectionVoterResource::collection($volunteer->voters)
      );
    }

    $limit = $request->query('limit', 10);
    $page = $request->query('page', 10);
    $query = ElectionVoter::query()->with('address');

    if ($request->filled('sex')) {
      $query->where('sex', $request->query('sex'));
    }

    if ($request->filled('classification')) {
      $query->where('age_classification', $request->query('classification'));
    }

    if ($request->filled('province')) {
      $query->whereHas('address', function ($query) use ($request) {
        $query->where('province', $request->query('province'));
      });
    }

    if ($request->filled('city')) {
      $query->whereHas('address', function ($query) use ($request) {
        $query->where('province', $request->query('city'));
      });
    }

    if ($request->filled('district')) {
      $query->whereHas('address', function ($query) use ($request) {
        $query->where('province', $request->query('district'));
      });
    }

    if ($request->filled('subdistrict')) {
      $query->whereHas('address', function ($query) use ($request) {
        $query->where('province', $request->query('subdistrict'));
      });
    }

    $total = $query->count();
    $data = $query->get();

    return JsonResponse::success(
      data: ElectionVoterResource::collection($data),
      meta: JsonResponse::meta(
        total: $total,
        page: $page,
        limit: $limit
      )
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();

      $user = $request->user();

      if ($user->role == 'volunteer') {
        $volunteer = Volunteer::query()->whereHas('user', function ($query) use ($user) {
          $query->where('user_id', $user->id);
        })->first();
      }

      $data = ElectionVoter::create([
        'volunteer_id' => $user->role == 'volunteer' ? $volunteer->id : $request->post('volunteer_id'),
        'voting_location_id' => $request->post('voting_location_id'),
        'name' => $request->post('name'),
        'nik' => $request->post('nik'),
        'age_classification' => $request->post('age_classification'),
        'sex' => $request->post('sex'),
        'coordinate' => $request->post('coordinate'),
        'evidence' => $request->post('evidence'),
      ]);

      $data->address()->create([
        'address' => $request->post('address'),
        'subdistrict' => $request->post('subdistrict'),
        'district' => $request->post('district'),
        'city' => $request->post('city'),
        'province' => $request->post('province'),
      ]);

      // $volunteer->update([
      //   'points' => $volunteer->points += 1
      // ]);

      DB::commit();

      return JsonResponse::success(
        code: Response::HTTP_CREATED,
        data: new ElectionVoterResource($data)
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $data = ElectionVoter::find($id);

      DB::beginTransaction();

      $data->address()->delete();
      $data->delete();

      DB::commit();

      return JsonResponse::success(
        code: Response::HTTP_OK
      );
    } catch (Exception $exception) {
      DB::rollBack();

      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }
}
