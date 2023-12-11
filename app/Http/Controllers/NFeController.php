<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\PedidosSaidas;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NFeController extends Controller
{
    public function __construct()
    {   

        $this->baseURLH = "https://homologacao.focusnfe.com.br";
        $this->baseURL = "https://api.focusnfe.com.br";
        $this->http = new Client([
            'http-errors' => false
        ]);
    }

    public function createRequest(Request $request)
    {
        $create = [];
        $campos = ["ipi", "cOutro", "user_id", "empresa_id", "pedido_id", "produto_id", "quantidade", "vDescC", "vDescIC", "vFrete", "vICMS", "vSeg", "vUnit",];
        foreach ($campos as $campo) {
            if ($request->$campo) {
                $create[$campo] = $request->$campo;
            }
        }
        if ($create) {
            try {
                PedidosSaidas::create($create);
                return response()->json([
                    'message' => "Request pedido: $request->pedido_id | Adicionado ao banco de dados"
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'mensage' => $e->getMessage()
                ],500);;
            }
        }
    }

    public function EmitirFocus(Request $request){
        $request->pedido;
        $empresa = Empresas::where('user_id', $request->user_id)->where('id', $request->empresa_id)->first();
        $ref = $empresa->cnpj ? $empresa->cnnj : $empresa->cpf;
        $response = $this->http->post($baseURLH . "/v2/nfe?ref=$ref", [
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic XXXXX'
            ],
            'json' => [
                "natureza_operacao"=> $request->natureza_operacao,
                "data_emissao"=> date('Y-m-d'),
                "data_entrada_saida"=>date('Y-m-d'),
                "tipo_documento"=>$request->tipo,
                "finalidade_emissao"=>$request->finalidade,
                "cnpj_emitente"=>$empresa->cnpj,
                "cpf_emitente"=> $empresa->cpf,
                "nome_emitente"=>$empresa->razao_social,
                "nome_fantasia_emitente"=>$empresa->nome_fantasia,
                "logradouro_emitente"=>$empresa->endereco,
                "numero_emitente"=>$empresa->numero,
                "bairro_emitente"=>$empresa->bairro,
                "municipio_emitente"=>$empresa->cidade,
                "uf_emitente"=>$empresa->uf,
                "cep_emitente"=>$empresa->cep,
                "inscricao_estadual_emitente"=>$request->inscricao,
                "nome_destinatario"=>$request->destNome,
                "cpf_destinatario"=>$request->destCpf,
                "inscricao_estadual_destinatario"=>$request->destIncricao,
                "telefone_destinatario"=>$request->destTelefoe,
                "logradouro_destinatario"=>$request->destEndereco,
                "numero_destinatario"=>$request->destNumero,
                "bairro_destinatario"=>$request->destBairro,
                "municipio_destinatario"=>$request->destMunicipio,
                "uf_destinatario"=>$request->destUF,
                "pais_destinatario"=>"Brasil",
                "cep_destinatario"=>$request->destCep,
                "valor_frete"=>$pedido->vFrete,
                "valor_seguro"=>$pedidos->vSeg,
                "valor_total"=>$request->pedido->valor_total,
                "valor_produtos"=>$request->pedido->produto,
                "modalidade_frete"=>0,
                "items"=> [
                  [
                    "numero_item"=>1,
                    "codigo_produto"=>1232,
                    "descricao"=>"Cartu00f5es de Visita",
                    "cfop"=>5923,
                    "unidade_comercial"=>"un",
                    "quantidade_comercial"=>100,
                    "valor_unitario_comercial"=>0.4723,
                    "valor_unitario_tributavel"=>0.4723,
                    "unidade_tributavel"=>"un",
                    "codigo_ncm"=>49111090,
                    "quantidade_tributavel"=>100,
                    "valor_bruto"=>47.23,
                    "icms_situacao_tributaria"=>41,
                    "icms_origem"=>0,
                    "pis_situacao_tributaria"=>"07",
                    "cofins_situacao_tributaria"=>"07"
                ]
                ]
            ]
        ]);
    }   

    public function CadastrarEmpresaFocus(){

    }

    public function EmpresasFocus(){

    }
}
