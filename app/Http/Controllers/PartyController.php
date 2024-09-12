<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\PartyResource;
use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page  = $request->query('page', 1);
        $limit = $request->query('limit', 10);
        $query = Party::query();
        $total = $query->count();
        $data  = $query->paginate($limit);

        return JsonResponse::success(
            data: PartyResource::collection($data),
            meta: JsonResponse::meta(
                total: $total,
                page: $page,
                limit: $limit,
            ),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
