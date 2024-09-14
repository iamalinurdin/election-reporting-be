<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\ChangePasswordRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(ChangePasswordRequest $request)
  {
    try {
      $user = $request->user();
      $oldPassword = $request->post('old_password');
      $checkPassword = Hash::check($oldPassword, $user->password);

      if (!$checkPassword) {
        return JsonResponse::error(
          message: "your password incorrect",
          code: Response::HTTP_FORBIDDEN
        );
      }

      $password = $request->post('password');
      $user->update([
        'password' => Hash::make($password),
      ]);

      return JsonResponse::success(
        message: "your password changed",
        data: null
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }
}
