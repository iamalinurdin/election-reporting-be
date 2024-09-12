<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\RecapitulationResultResource;
use App\Models\ElectionParticipant;
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
    $page = $request->query('page', 10);
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
    $data = $query->paginate($limit);

    return JsonResponse::success(
      data: RecapitulationResultResource::collection($data),
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
      $location = $request->post('voting_location_id');
      $participant = $request->post('election_participant_id');
      $result = RecapitulationResult::where('voting_location_id', $location)
        ->where('election_participant_id', $participant)
        ->first();

      if ($result) {
        $result->update([
          'vote_counts' => $request->post('vote_counts'),
          'evidence' => $request->post('evidence') ?? '-',
        ]);

        return JsonResponse::success(
          code: Response::HTTP_OK,
          data: new RecapitulationResultResource($result)
        );
      } else {
        $data = RecapitulationResult::create([
          'voting_location_id' => $request->post('voting_location_id'),
          'election_participant_id' => $request->post('election_participant_id'),
          'vote_counts' => $request->post('vote_counts'),
          'evidence' => $request->post('evidence'),
        ]);

        return JsonResponse::success(
          code: Response::HTTP_CREATED,
          data: new RecapitulationResultResource($data)
        );
      }
    } catch (Exception $exception) {
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

  /**
   * Undocumented function
   *
   * @param Request $request
   * @return void
   */
  public function summary(Request $request)
  {
    $participants = ElectionParticipant::with('recapitulationResults')->get();
    if ($request->query('type') == 'overall-recapitulations') {
      $total = collect($participants->map(function ($participant) {
        return $participant->recapitulationResults->map(function ($item) {
          return $item->vote_counts;
        });
      }))->map(function ($item) {
        $v = $item->reduce(function ($carry, $val) {
          return $carry + $val;
        });

        return $v;
      })->sum();
      $data = $participants->map(function ($participant) use ($total) {
        $results = $participant->recapitulationResults->reduce(function ($carry, $result) {
          return $carry + $result->vote_counts;
        });
        $description = "{$participant->election_number} - {$participant->participant_name} & $participant->vice_participant_name";

        return [
          'id' => $participant->id,
          'election_number' => $participant->election_number,
          'description' => $description,
          'in_percent' => (float) number_format(($results / $total) * 100, 2) / 100,
          'in_total' => $results
        ];
      });

      return JsonResponse::success(
        data: $data
      );
    }
  }
}
