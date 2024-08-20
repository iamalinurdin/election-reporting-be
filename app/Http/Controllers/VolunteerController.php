<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\VolunteerResource;
use App\Models\Volunteer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 10);
    $query = Volunteer::query()->with('address', 'user', 'post', 'votingLocation');

    if ($request->filled('name')) {
      $query->whereHas('user', function ($query) use ($request) {
        $query->where('name', 'LIKE', "%{$request->query('name')}%");
      });
    }

    $total = $query->count();
    $data = $query->get();

    return JsonResponse::success(
      data: VolunteerResource::collection($data),
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
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $data = Volunteer::with('user', 'address')->find($id);

    return JsonResponse::success(
      data: new VolunteerResource($data)
    );
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      $data = Volunteer::find($id);

      DB::beginTransaction();

      $data->update([
        'voting_location_id' => $request->post('voting_location_id') ?? $data->voting_location_id,
        'post_id' => $request->post('post_id') ?? $data->post_id,
        'phone_number' => $request->post('phone_number') ?? $data->phone_number,
        'coordinate' => $request->post('coordinate') ?? $data->coordinate,
      ]);

      $data->address()->update([
        'address' => $request->post('address') ?? $data->address->address,
        'subdistrict' => $request->post('subdistrict') ?? $data->address->subdistrict,
        'district' => $request->post('district') ?? $data->address->district,
        'city' => $request->post('city') ?? $data->address->city,
        'province' => $request->post('province') ?? $data->address->province,
      ]);

      DB::commit();

      return JsonResponse::success(
        data: new VolunteerResource($data)
      );
    } catch (Exception $exception) {
      DB::rollBack();

      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $data = Volunteer::find($id);

      DB::beginTransaction();

      $data->address()->delete();
      $data->user()->delete();
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
