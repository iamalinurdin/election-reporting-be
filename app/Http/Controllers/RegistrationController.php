<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\RegistrationResource;
use App\Models\Registration;
use App\Models\Relawan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 1);
    $total = Registration::count();
    $data = Registration::paginate($limit);

    return JsonResponse::success(
      data: RegistrationResource::collection($data),
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
      $data = Registration::create($request->all());

      return JsonResponse::success(
        data: new RegistrationResource($data)
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
      $data = Registration::where('id', $id)->orWhere('token', $id)->firstOrFail();

      return JsonResponse::success(
        data: new RegistrationResource($data)
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
      DB::beginTransaction();

      $data = Registration::find($id);
      $status = $request->post('status');

      $data->update([
        'status' => $status
      ]);

      if ($status == 'approved') {
        $user = User::create([
          'name' => $data->name,
          'email' => $data->email,
          'password' => Hash::make($data->email),
          'roles' => 'volunteer'
        ]);

        Relawan::create([
          'id_tps' => $request->post('id_tps'),
          'id_posko' => $request->post('id_posko'),
          'nama' => $data->name,
          'alamat' => $data->address,
          'no_handphone' => $data->phone_number,
          'id_user' => $user->id
        ]);
      }

      DB::commit();

      return JsonResponse::success(
        code: Response::HTTP_CREATED,
        data: new RegistrationResource($data)
      );
    } catch (Exception $exception) {
      DB::rollBack();

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
    //
  }
}
