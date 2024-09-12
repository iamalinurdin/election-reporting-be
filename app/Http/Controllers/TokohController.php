<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokohRequest;
use App\Models\Tokoh;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class TokohController extends Controller
{
    //
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $results = Tokoh::filterSort($request);

        $results = $results->paginate($limit)->appends([
            'limit' => $limit,
        ]);

        return $this->successResponse($results);
    }

    public function store(TokohRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $result = Tokoh::create($validatedData);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function show(string $id)
    {
        $result = Tokoh::where('id', $id)->first();

        if (!empty($result)) {
            return $this->successResponse($result);
        } else {
            return $this->notFoundResponse();
        }
    }

    public function update(TokohRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            $result = Tokoh::where('id', $id)->update($validatedData);

            return $this->createdResponse($result);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            Tokoh::where('id', $id)->delete();

            return $this->successResponse();
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }
    }
}
