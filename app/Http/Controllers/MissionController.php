<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\MissionResource;
use App\Models\Mission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MissionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $type = $request->query('type');
    $data = Mission::all();

    if ($type) {
      $data = Mission::where('type', $type)->get();
    }

    return JsonResponse::success(
      code: Response::HTTP_OK,
      message: 'ok',
      data: MissionResource::collection($data)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = Mission::create([
      'type' => $request->post('type'),
      'text_id' => $request->post('text_id'),
      'text_en' => $request->post('text_en') ?? '-',
    ]);

    return JsonResponse::success(
      code: Response::HTTP_CREATED,
      message: 'ok',
      data: new MissionResource($data)
    );
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
    $data = Mission::find($id);

    $data->update([
      'text' => $request->post('text'),
    ]);

    return JsonResponse::success(
      code: Response::HTTP_OK,
      message: 'ok',
      data: new MissionResource($data)
    );
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $data = Mission::find($id);

    $data->delete();

    return JsonResponse::success(
      code: Response::HTTP_OK,
      message: 'ok',
      data: null
    );
  }

  public function toggleStatus(Request $request, $id)
  {
    try {
      $data = Mission::find($id);

      $data->update([
        'is_active' => !$data->is_active,
      ]);

      return JsonResponse::success(
        code: Response::HTTP_OK,
        message: 'ok',
        data: new MissionResource($data)
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        code: Response::HTTP_INTERNAL_SERVER_ERROR,
        message: $exception->getMessage()
      );
    }
  }
}
