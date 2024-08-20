<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\RelawanController;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 10);
    $total = User::count();
    $data = User::with('roles')->paginate($limit);

    return JsonResponse::success(
      data: UserResource::collection($data),
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
      $data = User::create([
        'name' => $request->post('name'),
        'email' => $request->post('email'),
        'password' => Hash::make($request->post('password')),
        'roles' =>$request->post(roles)
      ]);

      $data->assignRole($request->post('roles'));

      if($request->post('kategori') == 'relawan'){
        RelawanController::storeRelawan($request);
      }

      return JsonResponse::success(
        code: Response::HTTP_CREATED,
        data: new UserResource($data)
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
