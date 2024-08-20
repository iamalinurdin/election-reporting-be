<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\CommunityResource;
use App\Models\Community;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 10);
    $total = Community::count();
    $data = Community::with('address')->paginate($limit);

    return JsonResponse::success(
      data: CommunityResource::collection($data),
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

      $data = Community::create([
        'name' => $request->post('name'),
        'nik' => $request->post('nik'),
        'phone_number' => $request->post('phone_number'),
        'coordinate' => $request->post('coordinate'),
        'description' => $request->post('description'),
        'photo' => $request->post('photo'),
      ]);

      $data->address()->create([
        'address' => $request->post('address'),
        'subdistrict' => $request->post('subdistrict'),
        'district' => $request->post('district'),
        'city' => $request->post('city'),
        'province' => $request->post('province'),
      ]);

      DB::commit();

      return JsonResponse::success(
        code: Response::HTTP_CREATED,
        data: new CommunityResource($data)
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
      $data = Community::find($id);

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
