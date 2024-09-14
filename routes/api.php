<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AboutProgrammeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FlagshipProgrammeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\PoskoController;
// use App\Http\Controllers\RelawanController;
// use App\Http\Controllers\TokohController;
// use App\Http\Controllers\TpsController;
// use App\Http\Controllers\BannerController;
// use App\Http\Controllers\DaftarPemilihController;
// use App\Http\Controllers\BroadcastingNotifikasiController;
// use App\Http\Controllers\CalonController;
// use App\Http\Controllers\SuaraController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ElectionParticipantController;
use App\Http\Controllers\ElectionVoterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicFigureController;
use App\Http\Controllers\RecapitulationResultController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VotingLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
  Route::get('notifications', [NotificationController::class, 'index']);
  Route::get('achievements', [VolunteerController::class, 'achievements']);

  Route::apiResource('election-voters', ElectionVoterController::class);
});

Route::post('login', LoginController::class);
Route::post('logout', LogoutController::class)->middleware('auth:sanctum');
Route::post('file', MediaController::class);
Route::put('testimonies/{id}/toggle-status', [TestimonyController::class, 'toggleStatus']);
Route::put('missions/{id}/toggle-status', [MissionController::class, 'toggleStatus']);
Route::put('about-programmes/{id}/toggle-status', [AboutProgrammeController::class, 'toggleStatus']);
Route::put('flagship-programmes/{id}/toggle-status', [FlagshipProgrammeController::class, 'toggleStatus']);
Route::get('configurations/latest', [ConfigurationController::class, 'latest']);
Route::get('abouts/latest', [AboutController::class, 'latest']);
Route::put('registrations/approval', [RegistrationController::class, 'approval']);
Route::get('communities/export', [CommunityController::class, 'export']);
Route::put('users/toggle-status', [UserController::class, 'toggleStatus']);
Route::get('recapitulation-results/summary', [RecapitulationResultController::class, 'summary']);
Route::get('volunteers/summary', [VolunteerController::class, 'summary']);

Route::apiResource('abouts', AboutController::class);
Route::apiResource('articles', ArticleController::class);
Route::apiResource('testimonies', TestimonyController::class)->except('show');
Route::apiResource('galleries', GalleryController::class);
Route::apiResource('missions', MissionController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('permissions', PermissionController::class);
Route::apiResource('flagship-programmes', FlagshipProgrammeController::class);
Route::apiResource('about-programmes', AboutProgrammeController::class);
Route::apiResource('registrations', RegistrationController::class);
Route::apiResource('configurations', ConfigurationController::class);
Route::apiResource('voting-locations', VotingLocationController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('volunteers', VolunteerController::class);
Route::apiResource('communities', CommunityController::class);
Route::apiResource('recapitulation-results', RecapitulationResultController::class);
Route::apiResource('election-participants', ElectionParticipantController::class);
Route::apiResource('public-figures', PublicFigureController::class);
Route::apiResource('parties', PartyController::class);
Route::apiResource('organizations', OrganizationController::class);

// Route::apiResource('posko', PoskoController::class);
// Route::prefix('posko')->group(function () {
//   Route::post('store', [PoskoController::class, 'store']);
//   Route::post('update/{id}', [PoskoController::class, 'update']);
//   Route::get('destroy/{id}', [PoskoController::class, 'destroy']);
// });

// Route::apiResource('relawan', RelawanController::class);
// Route::prefix('relawan')->group(function () {
//   Route::post('register-akun', [RelawanController::class, 'registerRelawan']);
//   Route::post('store', [RelawanController::class, 'store']);
//   Route::post('update/{id}', [RelawanController::class, 'update']);
//   Route::get('destroy/{id}', [RelawanController::class, 'destroy']);
// });

// Route::apiResource('tokoh', TokohController::class);
// Route::prefix('tokoh')->group(function () {
//   Route::post('store', [TokohController::class, 'store']);
//   Route::post('update/{id}', [TokohController::class, 'update']);
//   Route::get('destroy/{id}', [TokohController::class, 'destroy']);
// });

// Route::apiResource('tps', TpsController::class);
// Route::prefix('tps')->group(function () {
//   Route::post('store', [TpsController::class, 'store']);
//   Route::post('update/{id}', [TpsController::class, 'update']);
//   Route::get('destroy/{id}', [TpsController::class, 'destroy']);
// });

// Route::apiResource('banner', BannerController::class);
// Route::prefix('banner')->group(function () {
//   Route::post('store', [BannerController::class, 'store']);
//   Route::post('update/{id}', [BannerController::class, 'update']);
//   Route::get('destroy/{id}', [BannerController::class, 'destroy']);
// });

// Route::apiResource('calon', CalonController::class);
// Route::prefix('calon')->group(function () {
//   Route::post('store', [CalonController::class, 'store']);
//   Route::post('update/{id}', [CalonController::class, 'update']);
//   Route::get('destroy/{id}', [CalonController::class, 'destroy']);
// });

// Route::apiResource('suara', SuaraController::class);
// Route::prefix('suara')->group(function () {
//   Route::post('store', [SuaraController::class, 'create']);
// });

// Route::prefix('relawan/v1')
//   ->middleware(['auth:sanctum'])
//   ->group(function () {
//     Route::apiResource('daftar-pemilih', DaftarPemilihController::class);
//     Route::prefix('daftar-pemilih')->group(function () {
//       Route::post('store', [DaftarPemilihController::class, 'store']);
//       Route::post('update/{id}', [DaftarPemilihController::class, 'update']);
//       Route::get('destroy/{id}', [DaftarPemilihController::class, 'destroy']);
//     });
//   });

// Route::post('message', [BroadcastingNotifikasiController::class, 'message']);
