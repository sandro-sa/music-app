<?php

namespace  App\Http\Controllers\Web\Music;

use App\Http\Controllers\Controller;

class ToneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('music-app.tone');
    }
}
