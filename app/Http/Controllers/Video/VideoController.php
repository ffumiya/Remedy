<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller implements IVideoController
{
    public function show()
    {
        return view('video.show');
    }
}
