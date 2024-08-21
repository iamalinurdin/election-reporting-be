<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\PublicFigureResource;
use App\Models\PublicFigure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PublicFigureController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 1);
    $query = PublicFigure::query()->with('address');

    $total = $query->count();
    $data = $query->get();

    return JsonResponse::success(
      data: PublicFigureResource::collection($data),
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

      $data = PublicFigure::create([
        'name' => $request->post('name'),
        'type' => $request->post('type'),
        'phone_number' => $request->post('phone_number'),
        'coordinate' => $request->post('coordinate'),
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
        data: new PublicFigureResource($data)
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
    //
  }
}
