<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page  = $request->query('page', 10);
        $total = About::count();
        $data  = About::paginate($limit);

        return JsonResponse::success(
            data: AboutResource::collection($data),
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
            $data = About::create([
              'text' => $request->post('text'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_CREATED,
                data: new AboutResource($data),
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

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function latest()
    {
        $data = About::latest()->first();

        return JsonResponse::success(
            code: Response::HTTP_OK,
            data: new AboutResource($data),
        );
    }
}
