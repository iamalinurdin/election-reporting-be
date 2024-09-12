<?php

namespace App\Http\Controllers;

use App\Exports\RelawanExport;
use App\Http\Requests\RelawanRequest;
use App\Models\Relawan;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class RelawanController extends Controller
{
    //
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $results = Relawan::with(['posko', 'tps' , 'daftarPemilih'])->filterSort($request);

        $results = $results->paginate($limit)->appends([
            'limit' => $limit,
        ]);

        return $this->successResponse($results);
    }

    public function store(RelawanRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $result = Relawan::create($validatedData);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function registerRelawan(RelawanRequest $request)
    {
        try {
            $user = $this->createUser($request);

            $validatedData = $request->validated();

            $result = Relawan::create($validatedData);

            $result->update([
              'id_user' => $user->id,
            ]);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function createUser($request)
    {
        $data = User::create([
          'name'     => $request->nama,
          'email'    => $request->email,
          'password' => Hash::make($request->password),
          'roles'    => $request->roles,
        ]);

        return $data;
    }

    public function show(string $id)
    {
        $result = Relawan::with(['posko', 'tps', 'daftarPemilih'])->where('id', $id)->first();

        if (!empty($result)) {
            return $this->successResponse($result);
        } else {
            return $this->notFoundResponse();
        }
    }

    public function update(RelawanRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            $result = Relawan::where('id', $id)->update($validatedData);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            Relawan::where('id', $id)->delete();

            return $this->successResponse();
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function export()
    {
        $relawan = Relawan::with(['posko', 'tps'])->get();

        return Excel::download(new RelawanExport($relawan), 'Data Relawan.xlsx');
    }
}
