<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suara;
use App\Models\Tps;
use App\Http\Requests\SuaraRequest;
use App\Traits\ApiResponseTrait;
use Exception;

class SuaraController extends Controller
{
  //
  use ApiResponseTrait;

  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);

    $results = Tps::with(['suaras.calon'])->filterSort($request);

    $results = $results->paginate($limit)->appends([
      'limit' => $limit,
    ]);

    return $this->successResponse($results);
  }

  public function create(SuaraRequest $request)
  {
    try {
      $validatedData = $request->validated();

      $suara = Suara::where('id_calon', $validatedData['id_calon'])->where('id_tps', $validatedData['id_tps'])->first();
      if (!empty($suara)) {
        $new_total_perolehan = (int)$validatedData['total_perolehan'] + (int)$suara->total_perolehan;
        $result = $suara->update(['total_perolehan' => $new_total_perolehan]);
        return $this->createdResponse($result);
      } else {
        $result = Suara::create([
          'id_calon' => $request->post('id_calon'),
          'id_tps' => $request->post('id_tps'),
          'total_perolehan' => $request->post('total_perolehan'),
        ]);
        return $this->createdResponse($result);
      }
    } catch (Exception $e) {
      return $this->badRequestResponse($e->getMessage());
    }
  }
}
