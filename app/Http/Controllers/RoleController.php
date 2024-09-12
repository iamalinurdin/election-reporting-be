<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\RoleResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page  = $request->query('page', 10);
        $total = Role::count();
        $data  = Role::with('permissions')->paginate($limit);

        return JsonResponse::success(
            data: RoleResource::collection($data),
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
            $data = Role::create([
              'name' => $request->post('name'),
            ]);

            $data->syncPermissions($request->post('permissions'));

            return JsonResponse::success(
                code: Response::HTTP_CREATED,
                data: new RoleResource($data),
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
            $data = Role::findOrFail($id);

            return JsonResponse::success(
                data: new RoleResource($data),
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
            $data = Role::findOrFail($id);

            $data->update([
              'name' => $request->post('name'),
            ]);

            $data->syncPermissions($request->post('permissions'));

            return JsonResponse::success(
                code: Response::HTTP_OK,
                data: new RoleResource($data),
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
        //
    }
}
