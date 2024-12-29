<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\Music\ToneController;
use App\Http\Controllers\Web\Music\ChordController;
use App\Http\Controllers\Web\Music\MusicController;
use App\Http\Controllers\Web\Music\RhythmController;
use App\Http\Controllers\Web\Music\SingerController;
use App\Http\Controllers\Web\Music\CreateMusicController;
use App\Http\Controllers\Web\Music\ShowSingerMusicController;
use App\Http\Controllers\Web\Music\ShowSingerMusicsController;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/acorde', [ChordController::class, 'index'])->middleware('auth')->name('acorde');
Route::get('/musico', [SingerController::class, 'index'])->middleware('auth')->name('musico');
Route::get('/editor', [CreateMusicController::class, 'index'])->middleware('auth')->name('editor');
Route::get('/musica', [MusicController::class, 'index'])->name('musica');
Route::get('/tom', [ToneController::class, 'index'])->middleware('auth')->name('tom');
Route::get('/ritimo', [RhythmController::class, 'index'])->middleware('auth')->name('ritimo');

Route::get('lista/musicas/{id}', [ShowSingerMusicsController::class, 'index'])->name('lista.musicas');
Route::get('ver/musica/', [ShowSingerMusicController::class, 'index'])->name('ver.musica');