<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\RegistrationResource;
use App\Models\Registration;
use App\Models\Relawan;
use App\Models\User;
use App\Models\Volunteer;
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
    $query = Registration::query()->with('address');

    if ($request->filled('name')) {
      $name = $request->query('name');

      $query->where('name', 'LIKE', "%{$name}%");
    }

    if ($request->filled('email')) {
      $email = $request->query('email');

      $query->where('email', 'LIKE', "%{$email}%");
    }

    $total = $query->count();
    $data = $query->paginate($limit);

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
      DB::beginTransaction();

      $data = Registration::create([
        'name' => $request->post('name'),
        'email' => $request->post('email'),
        'phone_number' => $request->post('phone_number'),
        'nik' => $request->post('nik'),
        'coordinate' => $request->post('coordinate'),
        'has_organization' => $request->post('has_organization'),
        'organization_id' => $request->post('organization_id', null)
      ]);

      $data->address()->create([
        'address' => $request->post('address'),
        'subdistrict' => $request->post('subdistrict'),
        'district' => $request->post('district'),
        'city' => $request->post('city'),
        'province' => $request->post('province'),
      ]);

      DB::commit();

      return JsonResponse::success(
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

  /**
   * Undocumented function
   *
   * @param Request $request
   * @param string $id
   * @return void
   */
  public function approval(Request $request)
  {
    try {
      DB::beginTransaction();

      $status = $request->post('status');
      $id = $request->post('id');
      $data = Registration::find($id);

      $data->update([
        'status' => $status
      ]);

      if ($status == 'approved') {
        $user = User::create([
          'name' => $data->name,
          'email' => $data->email,
          'password' => Hash::make($data->email),
        ]);

        $user->assignRole('volunteer');

        $volunteer = Volunteer::create([
          'voting_location_id' => $request->post('voting_location_id'),
          'post_id' => $request->post('post_id'),
          'party_id' => $request->post('party_id'),
          'nik' => $data->nik,
          'phone_number' => $data->phone_number,
          'coordinate' => $data->coordinate,
          'user_id' => $user->id,
          'organization_id' => $data->organization_id,
        ]);

        $volunteer->address()->create([
          'address' => $data->address->address,
          'subdistrict' => $data->address->subdistrict,
          'district' => $data->address->district,
          'city' => $data->address->city,
          'province' => $data->address->province,
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
}
