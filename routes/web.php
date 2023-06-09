<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\GameController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('web');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    // Vriendenschapsverzoek verzenden
    Route::post('/friend-request/{receiver}', [FriendRequestController::class, 'sendFriendRequest'])->name('friend-request.send');

    // Vriendenschapsverzoek accepteren
    Route::post('/friend-request/{sender}/accept', [FriendRequestController::class, 'acceptFriendRequest'])->name('friend-request.accept');

    // Vriendenschapsverzoek Weigeren/Verwijderen
    Route::post('/friend-request/{sender}/reject', [FriendRequestController::class, 'rejectFriendRequest'])->name('friend-request.reject');

    // Index & Join Lobby
    Route::get('/', [LobbyController::class, 'index'])->name('lobby.index');
    Route::post('/join', [LobbyController::class, 'join'])->name('lobby.join');

    // Lobby aanmaken
    Route::post('/create-lobby', [LobbyController::class, 'create'])->name('lobby.create');

    // Lobby verlaten
    Route::post('/lobby/leave', [LobbyController::class, 'leave'])->name('lobby.leave')->middleware('auth');

    // Game starten
    Route::post('/lobby/start', [LobbyController::class, 'start'])->name('lobby.start');

    // Game actief
    Route::get('/game/play/{lobbyId}', [GameController::class, 'play'])->name('game.play');

    // Game woord opslaan
    Route::post('/games/save-word/{lobbyId}', [GameController::class, 'saveWord'])->name('game.saveWord');

    // Game woord gokken
    Route::post('/games/guess-word/{lobbyId}', [GameController::class, 'guessWord'])->name('game.guessWord');

    

});
