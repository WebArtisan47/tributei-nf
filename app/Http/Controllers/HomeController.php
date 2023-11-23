<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        // REQUEST TRIBUTEI SAÍDAS 
        $clientes = $this->http->get('https://apisaidas.tributei.net/api/05995840000155/simulador/clientes', [
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer YDmFIAkdQ4wm6-YDJZVb4pKo9Fk-YDWfuJEVPI.Zc'
            ]
        ])->getBody()->getContents();
        
        $pedidos = $this->http->get('https://apisaidas.tributei.net/api/05995840000155/simulador/pedidos', [
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer YDmFIAkdQ4wm6-YDJZVb4pKo9Fk-YDWfuJEVPI.Zc'
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

        return Inertia::render('Home', ['clientes' => json_decode($clientes), 'produtos' => json_decode($produtos), 'pedidos' => json_decode($pedidos)]);
    }
}
