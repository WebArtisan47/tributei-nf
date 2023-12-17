<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResourse;
use App\Models\EmissoesFocus;
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
        $emissoes = EmissoesFocus::where('user_id', $id)->orderBy('id', 'DESC')->get();
        foreach($emissoes as $emissao){
            if($emissao->link_xml === null){
                $this->getNota($emissao->ref, "I9XYti94ZVr0g7t3jR7NhvHPILRUe0Ib", $emissao->id);
            }
        }
        
        // REQUEST TRIBUTEI SAÍDAS 
        if($user->api_token_tributei != null){

            $clientes = $this->http->get('https://apisaidas.tributei.net/api/00104603000303/simulador/clientes', [
                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer YDWauEpovnjBQ-YDVPOPAh4ta.E-YDhdCjkazwv6A'
                ]
            ])->getBody()->getContents();
            
            $pedidos = $this->http->get('https://apisaidas.tributei.net/api/00104603000303/simulador/pedidos', [
                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer YDWauEpovnjBQ-YDVPOPAh4ta.E-YDhdCjkazwv6A'
                ]
            ])->getBody()->getContents();
            $produtos = $this->http->post('https://api.tributei.net/api/00104603000303/produtos/search', [
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
        //  dd( ['clientes' => json_decode($clientes), 'produtos' => json_decode($produtos), 'pedidos' => json_decode($pedidos), 'user' => $user]);
        return Inertia::render('LayoutAuthenticated.vue', ['emissoes' => $emissoes ,'clientes' => json_decode($clientes), 'produtos' => json_decode($produtos), 'pedidos' => json_decode($pedidos), 'user' => $user]);
        
    }
    public function getNota($ref, $token, $id)
    {
        $this->http = new Client([
            'http-errors' => false
        ]);
        $this->baseURLH = "https://homologacao.focusnfe.com.br";
        try {
            
            $response = $this->http->get($this->baseURLH . "/v2/nfe/" . $ref, [
                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json',

                ],
                "query" => ['token' => 'lj0iXg9ifG0uksmvjaRDfNBnnlVbCCOY', 'ref' => $ref],
            ]);
           
            if ($response->getStatusCode() === 200) {
                $dados = json_decode($response->getBody()->getContents());
                    $emissao = EmissoesFocus::find($id);
                    $update = [
                        "status" => $dados->status,
                        "mensagem" => $dados->mensagem_sefaz??null,
                    ];
                    if(isset($dados->caminho_xml_nota_fiscal)){
                        $update += ["link_xml" => $this->baseURLH . $dados->caminho_xml_nota_fiscal??null,];
                    }
                    if(isset($dados->caminho_danfe)){
                        $update += ["link_danfe" => $this->baseURLH . $dados->caminho_danfe??null];
                    }
                    $emissao->update($update);
                
               
                return response()->json([
                    'message' => $response->getBody()->getContents()
                ], 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
