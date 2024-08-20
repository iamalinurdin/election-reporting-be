<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    try {
      $email = $request->post('email');
      $password = $request->post('password');

      $user = User::where('email', $email)->firstOrFail();

      $checkPassword = Hash::check($password, $user->password);

      if (!$checkPassword) {
        return JsonResponse::error(
          code: Response::HTTP_FORBIDDEN,
          message: 'password is incorrect'
        );
      }

      $token = $user->createToken('auth_token')->plainTextToken;

      return JsonResponse::success(
        code: Response::HTTP_OK,
        message: 'ok',
        data: [
          'user' => $user,
          'access_token' => $token,
          'token_type' => 'Bearer'
        ]
      );
    } catch (ModelNotFoundException $exception) {
      return JsonResponse::error(
        code: Response::HTTP_UNAUTHORIZED,
        message: $exception->getMessage()
      );
    } catch (Exception $exception) {
      return JsonResponse::error(
        code: Response::HTTP_INTERNAL_SERVER_ERROR,
        message: $exception->getMessage()
      );
    }
  }
}
