<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\VolunteerResource;
use App\Models\Address;
use App\Models\User;
use App\Models\Volunteer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VolunteerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 1);
    $query = Volunteer::query()->with('address', 'user', 'post', 'votingLocation', 'party', 'organization');

    if ($request->filled('name')) {
      $query->whereHas('user', function ($query) use ($request) {
        $query->where('name', 'LIKE', "%{$request->query('name')}%");
      });
    }

    if ($request->filled('filterType') == 'jumlah-relawan') {
      $queryCountVolunteers = Address::query()->where('addressable_type', Volunteer::class);

      if ($request->filled('district')) {
        $queryCountVolunteers
          ->select('subdistrict AS name', DB::raw('count(*) as total'))
          ->groupBy('subdistrict')
          ->where('district', $request->query('district'));

        $total = $queryCountVolunteers->count();
        $data = $queryCountVolunteers->get();
        $value = $data->map(function ($item) {
          return [
            'name' => $item->name,
            'total' => $item->total ?? 0
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value),
          meta: JsonResponse::meta(
            total: $total,
            page: $page,
            limit: $limit
          )
        );
      }

      if ($request->filled('city')) {
        $queryCountVolunteers
          ->select('district AS name', DB::raw('count(*) as total'))
          ->groupBy('district')
          ->where('city', $request->query('city'));

        $total = $queryCountVolunteers->count();
        $data = $queryCountVolunteers->get();
        $value = $data->map(function ($item) {
          return [
            'name' => $item->name,
            'total' => $item->total ?? 0
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value),
          meta: JsonResponse::meta(
            total: $total,
            page: $page,
            limit: $limit
          )
        );
      }

      if ($request->filled('province')) {
        $queryCountVolunteers
          ->select('city AS name', DB::raw('count(*) as total'))
          ->groupBy('city')
          ->where('province', $request->query('province'));

        $total = $queryCountVolunteers->count();
        $data = $queryCountVolunteers->get();
        $value = $data->map(function ($item) {
          return [
            'name' => $item->name,
            'total' => $item->total ?? 0
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value),
          meta: JsonResponse::meta(
            total: $total,
            page: $page,
            limit: $limit
          )
        );
      }

      $queryCountVolunteers
        ->select('province AS name', DB::raw('count(*) as total'))
        ->groupBy('province');

      $total = $queryCountVolunteers->count();
      $data = $queryCountVolunteers->get();
      $value = $data->map(function ($item) {
        return [
          'name' => $item->name,
          'total' => $item->total ?? 0
        ];
      });

      return JsonResponse::success(
        data: VolunteerResource::collection($value),
        meta: JsonResponse::meta(
          total: $total,
          page: $page,
          limit: $limit
        )
      );
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
      $start = $request->filled('start_date');
      $end = $request->filled('end_date');

      $query->whereBetween('created_at', [$start, $end]);
    }

    if ($request->filled('province')) {
      $query->whereHas('address', function ($query) use ($request) {
        $query->where('province', $request->query('province'));
      });
    }

    if ($request->filled('city')) {
      $query->whereHas('address', function ($query) use ($request) {
        $query->where('city', $request->query('city'));
      });
    }

    if ($request->filled('district')) {
      $query->whereHas('address', function ($query) use ($request) {
        $query->where('district', $request->query('district'));
      });
    }

    if ($request->filled('subdistrict')) {
      $query->whereHas('address', function ($query) use ($request) {
        $query->where('subdistrict', $request->query('subdistrict'));
      });
    }

    $total = $query->count();
    $data = $query->get();

    return JsonResponse::success(
      data: VolunteerResource::collection($data),
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

      $email = $request->post('email');
      $user = User::create([
        'name' => $request->post('name'),
        'email' => $email,
        'password' => Hash::make($email),
      ]);

      $user->assignRole($request->post('role'));

      $volunteer = Volunteer::create([
        'user_id' => $user->id,
        'party_id' => $request->post('party_id'),
        'organization_id' => $request->post('organization_id'),
        'voting_location_id' => $request->post('voting_location_id'),
        'post_id' => $request->post('post_id'),
        'nik' => $request->post('nik'),
        'phone_number' => $request->post('phone_number'),
        'coordinate' => $request->post('coordinate'),
        'points' => 0
      ]);

      $volunteer->address()->create([
        'address' => $request->post('address'),
        'subdistrict' => $request->post('subdistrict'),
        'district' => $request->post('district'),
        'city' => $request->post('city'),
        'province' => $request->post('province'),
      ]);

      DB::commit();

      return JsonResponse::success(
        code: Response::HTTP_CREATED
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
    $data = Volunteer::with('user', 'address')->find($id);

    return JsonResponse::success(
      data: new VolunteerResource($data)
    );
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    try {
      $data = Volunteer::find($id);

      DB::beginTransaction();

      $data->update([
        'voting_location_id' => $request->post('voting_location_id') ?? $data->voting_location_id,
        'post_id' => $request->post('post_id') ?? $data->post_id,
        'phone_number' => $request->post('phone_number') ?? $data->phone_number,
        'coordinate' => $request->post('coordinate') ?? $data->coordinate,
      ]);

      $data->address()->update([
        'address' => $request->post('address') ?? $data->address->address,
        'subdistrict' => $request->post('subdistrict') ?? $data->address->subdistrict,
        'district' => $request->post('district') ?? $data->address->district,
        'city' => $request->post('city') ?? $data->address->city,
        'province' => $request->post('province') ?? $data->address->province,
      ]);

      DB::commit();

      return JsonResponse::success(
        data: new VolunteerResource($data)
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
    try {
      $data = Volunteer::find($id);

      DB::beginTransaction();

      $data->address()->delete();
      $data->user()->delete();
      $data->delete();

      DB::commit();

      return JsonResponse::success(
        code: Response::HTTP_OK
      );
    } catch (Exception $exception) {
      DB::rollBack();

      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @return void
   */
  public function summary(Request $request)
  {
    if ($request->query('filterType') == 'jumlah-relawan') {
      $query = Address::query()->where('addressable_type', Volunteer::class);
      if ($request->filled('district')) {
        $query
          ->select('subdistrict AS name', DB::raw('count(*) as total'))
          ->groupBy('subdistrict')
          ->where('district', $request->query('district'));

        $total = $query->count();
        $data = $query->get();
        $value = $data->map(function ($item) {
          return [
            'name' => $item->name,
            'total' => $item->total ?? 0
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value),
        );
      }

      if ($request->filled('city')) {
        $query
          ->select('district AS name', DB::raw('count(*) as total'))
          ->groupBy('district')
          ->where('city', $request->query('city'));

        $total = $query->count();
        $data = $query->get();
        $value = $data->map(function ($item) {
          return [
            'name' => $item->name,
            'total' => $item->total ?? 0
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value),
        );
      }
    }

    if ($request->query('filterType') == 'kinerja-relawan') {
      $query = Volunteer::query()->with('address', 'user', 'post', 'votingLocation', 'party', 'organization');

      if ($request->filled('subdistrict')) {
        $value = $query->whereHas('address', function ($query) use ($request) {
          $city = $request->query('city');
          $district = $request->query('district');
          $subdistrict = $request->query('subdistrict');

          $query->where('city', $city)
            ->where('district', $district)
            ->where('subdistrict', $subdistrict);
        })->get()->map(function ($item) {
          return [
            'id' => $item->id,
            'name' => $item->user->name,
            'voters_count' => $item->voters->count()
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value)
        );
      }

      if ($request->filled('district')) {
        $value = $query->whereHas('address', function ($query) use ($request) {
          $query->where('city', $request->query('city'))->where('district', $request->query('district'));
        })->get()->map(function ($item) {
          return [
            'id' => $item->id,
            'name' => $item->user->name,
            'voters_count' => $item->voters->count()
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value)
        );
      }

      if ($request->filled('city')) {
        $value = $query->whereHas('address', function ($query) use ($request) {
          $query->where('city', $request->query('city'));
        })->get()->map(function ($item) {
          return [
            'id' => $item->id,
            'name' => $item->user->name,
            'voters_count' => $item->voters->count()
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value)
        );
      }

      if ($request->filled('province')) {
        $query
          ->select('city AS name', DB::raw('count(*) as total'))
          ->groupBy('city')
          ->where('province', $request->query('province'));

        $total = $query->count();
        $data = $query->get();
        $value = $data->map(function ($item) {
          return [
            'name' => $item->name,
            'total' => $item->total ?? 0
          ];
        });

        return JsonResponse::success(
          data: VolunteerResource::collection($value),
        );
      }

      $query
        ->select('province AS name', DB::raw('count(*) as total'))
        ->groupBy('province');

      $total = $query->count();
      $data = $query->get();
      $value = $data->map(function ($item) {
        return [
          'name' => $item->name,
          'total' => $item->total ?? 0
        ];
      });

      return JsonResponse::success(
        data: VolunteerResource::collection($value),
      );
    }
  }
}
