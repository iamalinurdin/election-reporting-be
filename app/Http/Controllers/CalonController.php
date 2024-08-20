<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calon;
use App\Http\Requests\CalonRequest;
use App\Traits\ApiResponseTrait;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CalonController extends Controller
{
  //
  use ApiResponseTrait;

  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);

    $results = Calon::with(['suaras.tps'])->filterSort($request);

    $results = $results->paginate($limit)->appends([
      'limit' => $limit,
    ]);

    return $this->successResponse($results);
  }

  public function store(Request $request)
  {
    try {
      // $validatedData = $request->validated();

      // $foto_calon = $validatedData['foto_calon'];
      // $name_foto_calon = time() . '_' . '.' . $foto_calon->getClientOriginalExtension();
      // $image_foto_calon = Image::make($foto_calon->getRealPath());
      // $image_foto_calon->resize(750, 750, function ($constraint) {
      //   $constraint->aspectRatio();
      // })->save('images/calon/' . $name_foto_calon);

      // $foto_wakil_calon = $validatedData['foto_wakil_calon'];
      // $name_foto_wakil_calon = time() . '_' . '.' . $foto_wakil_calon->getClientOriginalExtension();
      // $image_foto_wakil_calon = Image::make($foto_wakil_calon->getRealPath());
      // $image_foto_wakil_calon->resize(750, 750, function ($constraint) {
      //   $constraint->aspectRatio();
      // })->save('images/wakil-calon/' . $name_foto_wakil_calon);

      // $result = Calon::create([
      //   'no_urut' => $validatedData['no_urut'],
      //   'nama_calon' =>  $validatedData['nama_calon'],
      //   'nama_wakil_calon' => $validatedData['nama_wakil_calon'],
      //   'foto_calon' => $name_foto_calon,
      //   'foto_wakil_calon' => $name_foto_wakil_calon
      // ]);

      $result = Calon::create([
        'no_urut' => $request->post('no_urut'),
        'nama_calon' =>  $request->post('nama_calon'),
        'nama_wakil_calon' => $request->post('nama_wakil_calon'),
        'foto_calon' => $request->post('foto_calon'),
        'foto_wakil_calon' => $request->post('foto_wakil_calon')
      ]);

      return $this->createdResponse($result);
    } catch (Exception $e) {
      return $this->badRequestResponse($e->getMessage());
    }
  }

  public function show(string $id)
  {
    $result = Calon::with(['suaras.tps'])->where('id', $id)->first();

    if (!empty($result)) {
      return $this->successResponse($result);
    } else {
      return $this->notFoundResponse();
    }
  }

  public function update(CalonRequest $request, string $id)
  {
    try {
      $validatedData = $request->validated();

      $foto_calon = $validatedData['foto_calon'];
      $name_foto_calon = time() . '_' . '.' . $name_foto_calon->getClientOriginalExtension();
      $image_foto_calon = Image::make($foto_calon->getRealPath());
      $image_foto_calon->resize(750, 750, function ($constraint) {
        $constraint->aspectRatio();
      })->save('images/calon/' . $name_foto_calon);

      $foto_wakil_calon = $validatedData['foto_wakil_calon'];
      $name_foto_wakil_calon = time() . '_' . '.' . $foto_wakil_calon->getClientOriginalExtension();
      $image_foto_wakil_calon = Image::make($foto_wakil_calon->getRealPath());
      $image_foto_wakil_calon->resize(750, 750, function ($constraint) {
        $constraint->aspectRatio();
      })->save('images/wakil-calon/' . $name_foto_wakil_calon);

      $result = Calon::where('id', $id)->update([
        'no_urut' => $validatedData['no_urut'],
        'nama_calon' =>  $validatedData['nama_calon'],
        'nama_wakil_calon' => $validatedData['nama_wakil_calon'],
        'foto_calon' => $name_foto_calon,
        'foto_wakil_calon' => $name_foto_wakil_calon
      ]);

      return $this->createdResponse($result);
    } catch (Exception $e) {
      return $this->badRequestResponse($e->getMessage());
    }
  }

  public function destroy(string $id)
  {
    try {

      $calon = Calon::findOrFail($id);
      $path_calon = 'images/calon/';
      $path_wakil_calon = 'images/wakil-calon';
      File::delete($path_calon . $calon->foto_calon);
      File::delete($path_wakil_calon . $calon->foto_wakil_calon);
      $calon->delete();

      return $this->successResponse();
    } catch (Exception $e) {
      return $this->badRequestResponse($e->getMessage());
    }
  }
}
