<?php

namespace App\Http\Controllers;

use App\Models\EmissoesFocus;
use App\Models\Empresas;
use App\Models\PedidosSaidas;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\HashIdsDecode;

class NFeController extends Controller
{
    protected $http;
    protected $baseURLH;
    protected $baseURL;

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
                ], 500);;
            }
        }
    }

    public function EmitirFocus(Request $request)
    {
        $numero_item = 0;
        $simulacao = json_decode(json_encode($request->simulacao));
        $vFrete = 0;
        $vSeg = 0;
        // $empresa = Empresas::where('user_id', $request->user_id)->where('cnpj', $request->fornecedor->cnpj)->first();
        // $ref = $empresa->cnpj ? $empresa->cnnj : $empresa->cpf;

        // $pedido = PedidosSaidas::where('pedido_id', $request->id)->first();
        // if ($pedido) {
        $items = [];

        $fornecedor = json_encode($simulacao->fornecedor);

        $ref = json_decode($fornecedor)->cnpj . "-" . $simulacao->id;

        $clientes = json_encode($simulacao->cliente);

        $produtos = json_encode($request->produtos);

        foreach (json_decode($produtos) as $produto) {
            $numero_item = $numero_item + 1;
            $vFrete = $vFrete + $produto->vFrete;
            $vSeg = $vSeg + $produto->vSeg;

            $item = [
                "numero_item" => $numero_item,
                "codigo_produto" => $produto->codigo_produto,
                "descricao" => $produto->protocolo->descricao ?? "Nenhuma descrição",
                "cfop" => $request->cfop,
                "unidade_comercial" => "un",
                "quantidade_comercial" => $produto->quantidade,
                "valor_unitario_comercial" => $produto->vUnit,
                "valor_unitario_tributavel" => $produto->vUnit,
                "unidade_tributavel" => "un",
                "codigo_ncm" => $produto->produto->ncm_compra,
                "quantidade_tributavel" => $produto->quantidade,
                "valor_bruto" => $produto->calculo->valor + $produto->calculo->valoricmsst ? $produto->calculo->valoricmsst : 0,
                "icms_situacao_tributaria" => "41",
                "icms_origem" => 0,
                "pis_situacao_tributaria" => "07",
                "cofins_situacao_tributaria" => "07"
            ];

            array_push($items, $item);
        }

        $response = $this->http->post($this->baseURLH . "/v2/nfe", [
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/json',

            ],
            "query" => ['token' => 'I9XYti94ZVr0g7t3jR7NhvHPILRUe0Ib', 'ref' => $ref],
            'json' => [
                "natureza_operacao" => $request->natureza_operacao,
                "data_emissao" => date('Y-m-d'),
                "data_entrada_saida" => date('Y-m-d'),
                "tipo_documento" => 1,
                "finalidade_emissao" => 1,
                "consumidor_final" => $simulacao->tipoCalculo === "ICMS" ? 0 : 1,
                "cnpj_emitente" => strlen(json_decode($fornecedor)->cnpj) === 14 ? json_decode($fornecedor)->cnpj : null,
                "cpf_emitente" => strlen(json_decode($fornecedor)->cnpj) === 11 ? json_decode($fornecedor)->cnpj : null,
                "nome_emitente" => json_decode($fornecedor)->nome,
                "nome_fantasia_emitente" => json_decode($fornecedor)->sobrenome,
                "logradouro_emitente" => json_decode($fornecedor)->endereco,
                "numero_emitente" => json_decode($fornecedor)->numero,
                "bairro_emitente" => json_decode($fornecedor)->bairro,
                "municipio_emitente" => json_decode($fornecedor)->cidade,
                "uf_emitente" => json_decode($fornecedor)->estado,
                "cep_emitente" => json_decode($fornecedor)->cep,
                "inscricao_estadual_emitente" => json_decode($fornecedor)->ie,
                "nome_destinatario" => json_decode($clientes)->nome,
                "cnpj_destinatario" => json_decode($clientes)->cpfCnpj,
                "inscricao_estadual_destinatario" => null,
                "telefone_destinatario" => null,
                "logradouro_destinatario" => json_decode($clientes)->endereco,
                "numero_destinatario" => json_decode($clientes)->numero,
                "bairro_destinatario" => json_decode($clientes)->bairro,
                "municipio_destinatario" => json_decode($clientes)->cidade,
                "uf_destinatario" => json_decode($clientes)->estado,
                "pais_destinatario" => "Brasil",
                "cep_destinatario" => json_decode($clientes)->cep,
                "valor_frete" => $vFrete,
                "valor_seguro" => $vSeg,
                "valor_total" => $simulacao->total_pedido,
                "valor_produtos" => $simulacao->total_produto,
                "modalidade_frete" => 0,
                "items" => $items

            ]
        ]);

        if ($response->getStatusCode() === 202) {
            $this->getNota($ref, "I9XYti94ZVr0g7t3jR7NhvHPILRUe0Ib");
            EmissoesFocus::create([
                "empresa" => json_decode($clientes)->nome,
                "fornecedor" => json_decode($fornecedor)->nome,
                "user_id" => HashIdsDecode($request->user_id),
                "pedido_id" => $simulacao->id,
                "ref" => $ref,
                "status" => "Aguardando retorno",
                "mensagem" => null,
                "link_xml" => null,
                "link_danfe" => null
            ]);
        } else {
            return response()->json([
                'message' => $response->getBody()->getContents()
            ], 500);
        }
        // }
    }

    public function CadastrarEmpresaFocus()
    {
    }

    public function getNota($ref, $token)
    {
        try {
            sleep(5);
            $response = $this->http->get($this->baseURLH . "/v2/nfe/" . $ref, [
                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json',
                ],
                "query" => ['token' => 'I9XYti94ZVr0g7t3jR7NhvHPILRUe0Ib', 'ref' => $ref],
            ]);
            if ($response->getStatusCode() === 200) {
                $dados = json_decode($response->getBody()->getContents());
                $emissao =  EmissoesFocus::where('ref', $ref)->first();
                // if($dados->mensagem_sefaz){
                //     $emissao->update([
                //         "status" => $dados->status,
                //         "mensagem" => $dados->mensagem_sefaz,
                //         "link_xml" => $this->baseURLH . $dados->caminho_xml_nota_fiscal,
                //         "link_danfe" => $this->baseURLH . $dados->caminho_danfe
                //     ]);
                //}


                return response()->json([
                    'message' => $response->getBody()->getContents()
                ], 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function EmpresasFocus()
    {
    }
}


// "natureza_operacao" => $request->natureza_operacao,
//                     "data_emissao" => date('Y-m-d'),
//                     "data_entrada_saida" => date('Y-m-d'),
//                     "tipo_documento" => 1,
//                     "finalidade_emissao" => $request->finalidade,
//                     "cnpj_emitente" => "41219310000189",
//                     "cpf_emitente" => null,
//                     "nome_emitente" => $empresa->razao_social,
//                     "nome_fantasia_emitente" => $empresa->nome_fantasia,
//                     "logradouro_emitente" => $empresa->endereco,
//                     "numero_emitente" => $empresa->numero,
//                     "bairro_emitente" => $empresa->bairro,
//                     "municipio_emitente" => $empresa->cidade,
//                     "uf_emitente" => $empresa->uf,
//                     "cep_emitente" => $empresa->cep,
//                     "inscricao_estadual_emitente" => $request->inscricao,
//                     "nome_destinatario" => $request->cliente->nome,
//                     "cpf_destinatario" => $request->cliente->cpfCnpj,
//                     "inscricao_estadual_destinatario" => $request->destIncricao,
//                     "telefone_destinatario" => null,
//                     "logradouro_destinatario" => $request->cliente->endereco,
//                     "numero_destinatario" => $request->cliente->numero,
//                     "bairro_destinatario" => $request->cliente->bairro,
//                     "municipio_destinatario" => $request->cliente->cidade,
//                     "uf_destinatario" => $request->cliente->estado,
//                     "pais_destinatario" => "Brasil",
//                     "cep_destinatario" => $request->cliente->cep,
//                     "valor_frete" => $pedido->vFrete,
//                     "valor_seguro" => $pedido->vSeg,
//                     "valor_total" => $request->total_pedido,
//                     "valor_produtos" => $request->total_produto,
//                     "modalidade_frete" => 0,
//                     "items" => [
//                         $items
//                     ]