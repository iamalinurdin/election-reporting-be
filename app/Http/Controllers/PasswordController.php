<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
  /**
   * Undocumented function
   *
   * @param Request $request
   * @return void
   */
  public function sendResetLink(Request $request)
  {
    try {
      $email = $request->post('email');
      $status = Password::sendResetLink([
        'email' => $email
      ]);

      if ($status == Password::RESET_LINK_SENT) {
        return JsonResponse::success(
          message: __($status)
        );
      } else {
        return JsonResponse::error(
          message: __($status)
        );
      }
    } catch (Exception $exception) {
      return JsonResponse::error(
        message: $exception->getMessage()
      );
    }
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @return void
   */
  public function resetPassword(Request $request)
  {
    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function (User $user, string $password) {
        $user->forceFill([
          'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
      }
    );

    if ($status === Password::PASSWORD_RESET) {
      return JsonResponse::success(
        message: __($status)
      );
    } else {
      return JsonResponse::error(
        message: __($status)
      );
    }
  }
}
