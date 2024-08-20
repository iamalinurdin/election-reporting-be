<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posko;
use App\Traits\ApiResponseTrait;
use Exception;
use App\Http\Requests\PoskoRequest;

class PoskoController extends Controller
{
    //
    use ApiResponseTrait;

    public function index(Request $request){
      $limit = $request->query('limit', 10);

      $results = Posko::with(['relawan'])->filterSort($request);

      $results = $results->paginate($limit)->appends([
          'limit' => $limit,
      ]);

      return $this->successResponse($results);
    }

    public function store(PoskoRequest $request){
        try{
          $validatedData = $request->validated();

          $result = Posko::create($validatedData);

          return $this->createdResponse($result);
        }catch(Exception $e){
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function show($id){
      $result = Posko::with(['relawan'])->where('id', $id)->first();

      if (!empty($result)) {
        return $this->successResponse($result);
      }else{
        return $this->notFoundResponse();
      }
    }

    public function update(PoskoRequest $request, $id){
      try{
        $validatedData = $request->validated();

        $result = Posko::where('id',$id)->update($validatedData);

        return $this->createdResponse($result);
      }catch(Exception $e){
          return $this->badRequestResponse($e->getMessage());
      }
    }

    public function destroy($id)
    {
      try{

        Posko::where('id',$id)->delete();

        return $this->successResponse();
      }catch(Exception $e){
          return $this->badRequestResponse($e->getMessage());
      }
    }
}
