<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    $request->user()->currentAccessToken()->delete();

    return JsonResponse::success(
      code: Response::HTTP_OK,
      message: 'ok',
      data: null
    );
  }
}
