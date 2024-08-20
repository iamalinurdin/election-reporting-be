<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MediaController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    try {
      $media = $request->file('media');
      $name = time();
      $filename = $name . "." . $media->getClientOriginalName();
      $hostname = env('APP_URL');

      $media->storeAs('media', $filename, 'public');

      return JsonResponse::success(
        code: Response::HTTP_CREATED,
        data: [
          'url' => "{$hostname}/storage/media/{$filename}"
        ]
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }
}
