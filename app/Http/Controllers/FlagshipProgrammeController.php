<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\FlagshipProgrammeResource;
use App\Models\FlagshipProgramme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FlagshipProgrammeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 10);
    $total = FlagshipProgramme::count();
    $data = FlagshipProgramme::paginate($limit);

    return JsonResponse::success(
      data: FlagshipProgrammeResource::collection($data),
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
      $data = FlagshipProgramme::create([
        'image' => $request->post('image'),
        'text_id' => $request->post('text_id'),
        'text_en' => $request->post('text_en'),
        'description_id' => $request->post('description_id'),
        'description_en' => $request->post('description_en'),
      ]);

      return JsonResponse::success(
        code: Response::HTTP_CREATED,
        data: new FlagshipProgrammeResource($data)
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
    try {
      $data = FlagshipProgramme::findOrFail($id);

      return JsonResponse::success(
        data: new FlagshipProgrammeResource($data)
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      $data = FlagshipProgramme::findOrFail($id);

      $data->update([
        'text_id' => $request->post('text_id'),
        'text_en' => $request->post('text_en'),
        'description_en' => $request->post('description_en'),
        'description_en' => $request->post('description_en'),
      ]);

      return JsonResponse::success(
        data: new FlagshipProgrammeResource($data)
      );
    } catch (Exception $exception) {
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
      $data = FlagshipProgramme::findOrFail($id);

      $data->delete();

      return JsonResponse::success(
        data: null
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }

  public function toggleStatus(Request $request, $id)
  {
    try {
      $data = FlagshipProgramme::find($id);

      $data->update([
        'is_active' => $request->post('is_active'),
      ]);

      return JsonResponse::success(
        code: Response::HTTP_OK,
        message: 'ok',
        data: new FlagshipProgrammeResource($data)
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        code: Response::HTTP_INTERNAL_SERVER_ERROR,
        message: $exception->getMessage()
      );
    }
  }
}
