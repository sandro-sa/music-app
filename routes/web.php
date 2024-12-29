<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\App\ToneController;
use App\Http\Controllers\Web\App\ChordController;
use App\Http\Controllers\Web\App\MusicController;
use App\Http\Controllers\Web\App\RhythmController;
use App\Http\Controllers\Web\App\SingerController;
use App\Http\Controllers\Web\Web\ShowMusicController;
use App\Http\Controllers\Web\App\CreateMusicController;
use App\Http\Controllers\Web\App\ShowSingerMusicController;
use App\Http\Controllers\Web\App\ShowSingerMusicsController;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/letra/{id}', [ShowMusicController::class, 'index']);


Route::get('/acorde', [ChordController::class, 'index'])->middleware('auth')->name('acorde');
Route::get('/musico', [SingerController::class, 'index'])->middleware('auth')->name('musico');
Route::get('/editor', [CreateMusicController::class, 'index'])->middleware('auth')->name('editor');
Route::get('/musica', [MusicController::class, 'index'])->name('musica');
Route::get('/tom', [ToneController::class, 'index'])->middleware('auth')->name('tom');
Route::get('/ritimo', [RhythmController::class, 'index'])->middleware('auth')->name('ritimo');

Route::get('lista/musicas/{id}', [ShowSingerMusicsController::class, 'index'])->name('lista.musicas');
Route::get('ver/musica/', [ShowSingerMusicController::class, 'index'])->name('ver.musica');