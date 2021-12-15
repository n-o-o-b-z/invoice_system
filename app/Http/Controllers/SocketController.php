<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocketController extends Controller
{
    public function test()
    {
        return view('test-socket');
    }

}