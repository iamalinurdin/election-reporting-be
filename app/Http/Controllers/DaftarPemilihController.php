<?php

namespace App\Http\Controllers;

use App\Exports\DaftarPemilihExport;
use App\Helpers\JsonResponse;
use App\Http\Requests\DaftarPemilihRequest;
use App\Http\Resources\DaftarPemilihResource;
use App\Models\DaftarPemilih;
use App\Models\Relawan;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class DaftarPemilihController extends Controller
{
    //
    use ApiResponseTrait;

    public function index(Request $request)
    {
        // $limit = $request->query('limit', 10);
        // $id_relawan = auth()->user()->relawan->id;
        // $results = DaftarPemilih::with(['relawan'])->where('id_relawan', $id_relawan)->filterSort($request);

        // $results = $results->paginate($limit)->appends([
        //   'limit' => $limit,
        // ]);

        // return $this->successResponse($results);

        $limit = $request->query('limit', 10);
        $page  = $request->query('page', 10);
        $total = DaftarPemilih::count();
        $data  = DaftarPemilih::paginate($limit);

        return JsonResponse::success(
            data: DaftarPemilihResource::collection($data),
            meta: JsonResponse::meta(
                total: $total,
                page: $page,
                limit: $limit,
            ),
        );
    }

    public function store(Request $request)
    {
        try {
            // $validatedData = $request->validated();

            // $photo = $validatedData['photo'];
            // $name_photo = time(). '.' . $photo->getClientOriginalExtension();
            // $image = Image::make($photo->getRealPath());
            // $image->resize(750,750, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save('images/daftar_pemilih/'.$name_photo);

            // $id_relawan = auth()->user()->relawan->id;

            // $result = DaftarPemilih::create($validatedData);
            // $result->update([
            //   'photo' => $name_photo,
            //   'id_relawan'=>$id_relawan
            // ]);

            // return $this->createdResponse($result);

            $data = DaftarPemilih::create([
              'id_relawan'   => $request->post('id_relawan'),
              'nama_pemilih' => $request->post('nama_pemilih'),
              'nik'          => $request->post('nik'),
              'alamat'       => $request->post('alamat'),
              'kordinat'     => $request->post('kordinat'),
              'photo'        => $request->post('photo'),
            ]);

            // $this->updateRatingrelawan($id_relawan);

            return JsonResponse::success(
                code: Response::HTTP_CREATED,
                data: $data,
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function updateRatingrelawan($id_relawan)
    {
        $relawan = Relawan::where('id', $id_relawan)->first();

        $count_relawan = $relawan->count_pemilih;

        $new_count_relawan = 1 + (int) $count_relawan;

        if ($new_count_relawan <= 100) {
            $relawan->update([
              'count_pemilih' => $new_count_relawan,
              'star'          => 0,
            ]);
        }

        if ($new_count_relawan == 100 && $new_count_relawan < 200) {
            $relawan->update([
              'count_pemilih' => $new_count_relawan,
              'star'          => 1,
            ]);
        }
        if ($new_count_relawan == 200 && $new_count_relawan < 300) {
            $relawan->update([
              'count_pemilih' => $new_count_relawan,
              'star'          => 2,
            ]);
        }

        if ($new_count_relawan == 300 && $new_count_relawan < 400) {
            $relawan->update([
              'count_pemilih' => $new_count_relawan,
              'star'          => 3,
            ]);
        }

        if ($new_count_relawan == 400 && $new_count_relawan < 500) {
            $relawan->update([
              'count_pemilih' => $new_count_relawan,
              'star'          => 4,
            ]);
        }

        if ($new_count_relawan == 500 && $new_count_relawan > 500) {
            $relawan->update([
              'count_pemilih' => $new_count_relawan,
              'star'          => 5,
            ]);
        }
    }

    public function show(string $id)
    {
        $result = DaftarPemilihRequest::with(['relawan'])->where('id', $id)->first();

        if (!empty($result)) {
            return $this->successResponse($result);
        } else {
            return $this->notFoundResponse();
        }
    }

    public function update(DaftarPemilihRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            $photo      = $validatedData['photo'];
            $name_photo = time() . '.' . $photo->getClientOriginalExtension();
            $image      = Image::make($photo->getRealPath());
            $image->resize(750, 750, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/daftar_pemilih/' . $name_photo);

            $result = DaftarPemilih::where('id', $id)->update([
              'nama_pemilih' => $$validatedData['nama_pemilih'],
              'nik'          => $validatedData['nik'],
              'alamat'       => $validatedData['alamat'],
              'kordinat'     => $validatedData['kordinat'],
              'link'         => $name_photo,
            ]);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $daftar_pemilih = DaftarPemilih::findOrFail($id);
            $path           = 'images/daftar_pemilih/';
            File::delete($path . $banner->image);
            $daftar_pemilih->delete();

            return $this->successResponse();
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function export()
    {
        $daftar_pemilih = DaftarPemilih::all();

        return Excel::download(new DaftarPemilihExport($daftar_pemilih), 'Data Daftar Pemilih.xlsx');
    }
}
