<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NFeTecnoSpeedController extends Controller
{
    public function __construct()
    {
        $this->http = new Client([
            'http_errors' => false
        ]);
    }

    protected function Emitir(Request $request){
        
    }
}
