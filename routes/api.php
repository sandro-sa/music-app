<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Music\ToneController;
use App\Http\Controllers\Api\Music\ChordController;
use App\Http\Controllers\Api\Music\MusicController;
use App\Http\Controllers\Api\Music\RhythmController;
use App\Http\Controllers\Api\Music\SingerController;
use App\Http\Controllers\Api\Music\ShowSingerMusicsController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('chord',ChordController::class);
Route::apiResource('singer',SingerController::class);
Route::apiResource('music',MusicController::class);
Route::get('singer_musics/{id}',ShowSingerMusicsController::class);
Route::apiResource('tone',ToneController::class);
Route::apiResource('rhythm',RhythmController::class);