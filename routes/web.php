<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Music\ToneController;
use App\Http\Controllers\Web\Music\ChordController;
use App\Http\Controllers\Web\Music\MusicController;
use App\Http\Controllers\Web\Music\RhythmController;
use App\Http\Controllers\Web\Music\SingerController;
use App\Http\Controllers\Web\Music\CreateMusicController;
use App\Http\Controllers\Web\Music\ShowSingerMusicController;
use App\Http\Controllers\Web\Music\ShowSingerMusicsController;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/acorde', [ChordController::class, 'index'])->name('acorde');
Route::get('/musico', [SingerController::class, 'index'])->name('musico');
Route::get('/editor', [CreateMusicController::class, 'index'])->name('editor');
Route::get('/musica', [MusicController::class, 'index'])->name('musica');
Route::get('/tom', [ToneController::class, 'index'])->name('tom');
Route::get('/ritimo', [RhythmController::class, 'index'])->name('ritimo');

Route::get('lista/musicas/{id}', [ShowSingerMusicsController::class, 'index'])->name('lista.musicas');
Route::get('ver/musica/', [ShowSingerMusicController::class, 'index'])->name('ver.musica');