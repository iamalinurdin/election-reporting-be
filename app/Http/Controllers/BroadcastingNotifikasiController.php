<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Notifications\BroadcastingNotif;
use App\Models\Message;
use App\Models\Relawan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BroadcastingNotifikasiController extends Controller
{
  //
  use ApiResponseTrait;

  public function message(Request $request)
  {

    $relawan = Relawan::findOrFail($request->id_relawan);
    $message = Message::create([
      'id_user' => $relawan->id_user,
      'title'  => $request->title,
      'description'  => $request->description
    ]);

    User::find($relawan->id_user)->notify(new BroadcastingNotif($message));

    return $this->successResponse($message);
  }
}
