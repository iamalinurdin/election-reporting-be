<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Resources\ElectionParticipantResource;
use App\Models\ElectionParticipant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ElectionParticipantController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $limit = $request->query('limit', 10);
    $page = $request->query('page', 10);
    $total = ElectionParticipant::count();
    $data = ElectionParticipant::with('recapitulationResults', 'recapitulationResults.votingLocation')->paginate($limit);

    return JsonResponse::success(
      data: ElectionParticipantResource::collection($data),
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
      $data = ElectionParticipant::create([
        'election_number' => $request->post('election_number'),
        'election_type' => $request->post('election_type'),
        'participant_name' => $request->post('participant_name'),
        'vice_participant_name' => $request->post('vice_participant_name'),
        'participant_photo' => $request->post('participant_photo'),
        'vice_participant_photo' => $request->post('vice_participant_photo'),
      ]);

      return JsonResponse::success(
        code: Response::HTTP_CREATED,
        data: new ElectionParticipantResource($data)
      );
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
    try {
      $participant = ElectionParticipant::find($id);

      $participant->recapitulationResults()->delete();
      $participant->delete();

      return JsonResponse::success(
        code: Response::HTTP_OK,
        message: 'ok',
        data: null
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        code: Response::HTTP_INTERNAL_SERVER_ERROR,
        message: $exception->getMessage()
      );
    }
  }
}
