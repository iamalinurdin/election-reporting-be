<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\ConfigurationResource;
use App\Models\Configuration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page  = $request->query('page', 10);
        $total = Configuration::count();
        $data  = Configuration::paginate($limit);

        return JsonResponse::success(
            data: ConfigurationResource::collection($data),
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
            $data = Configuration::create([
              'color'    => $request->post('color'),
              'app_name' => $request->post('app_name'),
              'logo'     => $request->post('logo'),
            ]);

            return JsonResponse::success(
                code: Response::HTTP_CREATED,
                data: new ConfigurationResource($data),
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
        $data = Configuration::latest()->first();

        return JsonResponse::success(
            code: Response::HTTP_OK,
            data: new ConfigurationResource($data),
        );
    }
}
