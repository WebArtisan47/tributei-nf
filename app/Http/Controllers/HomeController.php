<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResourse;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $http;
    public function __construct()
    {
        $this->http = new Client([
            'http_errors' => false,
        ]);
    }

    public function index(){

        $id = Auth::id();
        $user = new UserResourse(User::findOrFail($id));
        
        $clientes = "";
        $produtos = "";
        $pedidos = "";
        
        // REQUEST TRIBUTEI SAÍDAS 
        if($user->api_token_tributei != null){

            $clientes = $this->http->get('https://apisaidas.tributei.net/api/05995840000155/simulador/clientes', [
                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer YDWauEpovnjBQ-YDVPOPAh4ta.E-YDhdCjkazwv6A'
                ]
            ])->getBody()->getContents();
            
            $pedidos = $this->http->get('https://apisaidas.tributei.net/api/05995840000155/simulador/pedidos', [
                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer YDWauEpovnjBQ-YDVPOPAh4ta.E-YDhdCjkazwv6A'
                ]
            ])->getBody()->getContents();
            $produtos = $this->http->post('https://api.tributei.net/api/05995840000155/produtos/search', [
                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer YDmFIAkdQ4wm6-YDJZVb4pKo9Fk-YDWfuJEVPI.Zc'
                ],
                'json' => [
                    'query' => ''
                ]
    
            ])->getBody()->getContents();
        }
        //dd( ['clientes' => json_decode($clientes), 'produtos' => json_decode($produtos), 'pedidos' => json_decode($pedidos), 'user' => $user]);
        return Inertia::render('Home', ['clientes' => json_decode($clientes), 'produtos' => json_decode($produtos), 'pedidos' => json_decode($pedidos), 'user' => $user]);
        
    }
}
