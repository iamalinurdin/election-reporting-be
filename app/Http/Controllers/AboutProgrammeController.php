<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\AboutProgrammeResource;
use App\Models\AboutProgramme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AboutProgrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page  = $request->query('page', 10);
        $total = AboutProgramme::count();
        $data  = AboutProgramme::paginate($limit);

        return JsonResponse::success(
            data: AboutProgrammeResource::collection($data),
            meta: JsonResponse::meta(
                total: $total,
                page: $page,
                limit: $limit,
            ),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = AboutProgramme::create([
              'image'   => $request->post('path'),
              'text_id' => $request->post('text_id'),
              'text_en' => $request->post('text_en'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_CREATED,
                data: new AboutProgrammeResource($data),
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                message: $exception->getMessage(),
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = AboutProgramme::findOrFail($id);

            return JsonResponse::success(
                data: new AboutProgrammeResource($data),
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                message: $exception->getMessage(),
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = AboutProgramme::findOrFail($id);

            $data->update([
              'image'   => $request->post('path'),
              'text_id' => $request->post('text_id'),
              'text_en' => $request->post('text_en'),
            ]);

            return JsonResponse::success(
                data: new AboutProgrammeResource($data),
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                message: $exception->getMessage(),
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = AboutProgramme::findOrFail($id);

            $data->delete();

            return JsonResponse::success(
                data: null,
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                message: $exception->getMessage(),
            );
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $data = AboutProgramme::find($id);

            $data->update([
              'is_active' => $request->post('is_active'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_OK,
                message: 'ok',
                data: new AboutProgrammeResource($data),
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
                message: $exception->getMessage(),
            );
        }
    }
}
