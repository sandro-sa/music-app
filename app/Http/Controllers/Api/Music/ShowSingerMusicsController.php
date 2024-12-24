<?php

namespace  App\Http\Controllers\Api\Music;

use App\Models\Music\Music;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Music\MusicResource;



class ShowSingerMusicsController extends Controller
{
    public function __invoke($id)
    {
        $musics = Music::where('singer_id',$id)->get();
        $musics->load(['rhythm','tone']);
        return MusicResource::collection($musics);
       
    }
}
