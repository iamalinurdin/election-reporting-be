<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\RecapitulationResultResource;
use App\Models\RecapitulationResult;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecapitulationResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page  = $request->query('page', 10);
        $query = RecapitulationResult::query()->with('votingLocation', 'votingLocation.address', 'participant');

        if ($request->filled('province')) {
            $query->whereHas('votingLocation.address', function ($query) use ($request) {
                $query->where('province', $request->query('province'));
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('votingLocation.address', function ($query) use ($request) {
                $query->where('city', $request->query('city'));
            });
        }

        if ($request->filled('district')) {
            $query->whereHas('votingLocation.address', function ($query) use ($request) {
                $query->where('district', $request->query('district'));
            });
        }

        if ($request->filled('subdistrict')) {
            $query->whereHas('votingLocation.address', function ($query) use ($request) {
                $query->where('subdistrict', $request->query('subdistrict'));
            });
        }

        $total = $query->count();
        $data  = $query->paginate($limit);

        return JsonResponse::success(
            data: RecapitulationResultResource::collection($data),
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
        try {
            $location    = $request->post('voting_location_id');
            $participant = $request->post('election_participant_id');
            $result      = RecapitulationResult::where('voting_location_id', $location)
              ->where('election_participant_id', $participant)
              ->first();

            if ($result) {
                $result->update([
                  'vote_counts' => $request->post('vote_counts'),
                  'evidence'    => $request->post('evidence') ?? '-',
                ]);

                return JsonResponse::success(
                    code: Response::HTTP_OK,
                    data: new RecapitulationResultResource($result),
                );
            } else {
                $data = RecapitulationResult::create([
                  'voting_location_id'      => $request->post('voting_location_id'),
                  'election_participant_id' => $request->post('election_participant_id'),
                  'vote_counts'             => $request->post('vote_counts'),
                  'evidence'                => $request->post('evidence'),
                ]);

                return JsonResponse::success(
                    code: Response::HTTP_CREATED,
                    data: new RecapitulationResultResource($data),
                );
            }
        } catch (Exception $exception) {
            return JsonResponse::error(
                message: $exception->getMessage(),
            );
        }
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
