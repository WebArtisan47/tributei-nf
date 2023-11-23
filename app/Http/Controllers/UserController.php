<?php

namespace App\Http\Controllers;

use App\Models\Entidade;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function App\Helpers\routeId;

class UserController extends Controller
{
    public function index(){

    }

    public function show(){
        $id = routeId();
        $user = Entidade::where('id',$id)->first();
        return Inertia::render('User/Show', ['user' => $user]);
    }
}
