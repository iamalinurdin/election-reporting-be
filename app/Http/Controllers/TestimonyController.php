<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\TestimonyResource;
use App\Models\Testimony;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestimonyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page  = $request->query('page', 10);
        $total = Testimony::count();
        $data  = Testimony::paginate($limit);

        return JsonResponse::success(
            data: TestimonyResource::collection($data),
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
            $data = Testimony::create([
              'image_path' => $request->post('image_path'),
              'name'       => $request->post('name'),
              'detail_id'  => $request->post('detail_id'),
              'detail_en'  => $request->post('detail_en'),
              'body_id'    => $request->post('body_id'),
              'body_en'    => $request->post('body_en'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_CREATED,
                message: 'ok',
                data: new TestimonyResource($data),
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
            $testimony = Testimony::find($id);

            $testimony->update([
              'name'      => $request->post('name'),
              'detail_id' => $request->post('detail_id'),
              'detail_en' => $request->post('detail_en'),
              'body_id'   => $request->post('body_id'),
              'body_en'   => $request->post('body_en'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_OK,
                message: 'ok',
                data: new TestimonyResource($testimony),
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
            $testimony = Testimony::find($id);

            $testimony->delete();

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

    public function toggleStatus(Request $request, $id)
    {
        try {
            $testimony = Testimony::find($id);

            $testimony->update([
              'is_active' => $request->post('is_active'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_OK,
                message: 'ok',
                data: new TestimonyResource($testimony),
            );
        } catch (Exception $exception) {
            return JsonResponse::error(
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
                message: $exception->getMessage(),
            );
        }
    }
}
