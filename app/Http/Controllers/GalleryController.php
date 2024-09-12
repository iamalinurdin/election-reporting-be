<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page  = $request->query('page', 10);
        $total = Gallery::count();
        $data  = Gallery::paginate($limit);

        return JsonResponse::success(
            data: GalleryResource::collection($data),
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
            $data = Gallery::create([
              'path'       => $request->post('path'),
              'caption_id' => $request->post('caption_id'),
              'caption_en' => $request->post('caption_en'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_CREATED,
                message: 'ok',
                data: new GalleryResource($data),
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
                message: $exception->getMessage(),
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
        try {
            $gallery = Gallery::find($id);

            $gallery->update([
              'caption_id' => $request->post('caption_id'),
              'caption_en' => $request->post('caption_en'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_OK,
                message: 'ok',
                data: new GalleryResource($gallery),
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
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
            $gallery = Gallery::find($id);

            $gallery->delete();

            return JsonResponse::success(
                code: Response::HTTP_OK,
                message: 'ok',
                data: null,
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
                message: $exception->getMessage(),
            );
        }
    }
}
