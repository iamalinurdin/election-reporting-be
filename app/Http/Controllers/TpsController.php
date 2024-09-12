<?php

namespace App\Http\Controllers;

use App\Http\Requests\TpsRequest;
use App\Models\Tps;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class TpsController extends Controller
{
    //
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $results = Tps::with(['relawan'])->filterSort($request);

        $results = $results->paginate($limit)->appends([
            'limit' => $limit,
        ]);

        return $this->successResponse($results);
    }

    public function store(TpsRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $result = Tps::create($validatedData);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function show(string $id)
    {
        $result = Tps::with(['relawan'])->where('id', $id)->first();

        if (!empty($result)) {
            return $this->successResponse($result);
        } else {
            return $this->notFoundResponse();
        }
    }

    public function update(TpsRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            $result = Tps::where('id', $id)->update($validatedData);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            Tps::where('id', $id)->delete();

            return $this->successResponse();
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }
}
