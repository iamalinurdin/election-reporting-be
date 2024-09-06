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
      // dd($request->header('x-app-platform'));

      $email = $request->post('email');
      $password = $request->post('password');
      $platform = $request->header('x-app-platform');
      $user = User::where('email', $email)->firstOrFail();

      if (
        ($user->role == 'volunteer' && $platform == 'mobile') ||
        (($user->role == 'admin' || $user->role == 'super-admin') && $platform == 'dashboard')
      ) {
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
      } else {
        return JsonResponse::error(
          code: Response::HTTP_FORBIDDEN,
          message: "you can't login using this credential"
        );
      }
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
