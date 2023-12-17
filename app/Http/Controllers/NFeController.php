<?php

namespace App\Http\Controllers;

use App\Models\EmissoesFocus;
use App\Models\Empresas;
use App\Models\PedidosSaidas;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        $ref = json_decode($fornecedor)->cnpj . "-" . $simulacao->id . date("d-m-Y h:i:s");

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
                "valor_bruto" => $produto->vProd,
                "icms_situacao_tributaria" => 41,
                "icms_origem" => 0,
                "pis_situacao_tributaria" => "07",
                "cofins_situacao_tributaria" => "07"
            ];
            if($produto->vDesc_IC){
                $desc = $produto->vDesc_IC;
                if($produto->vDesc_C){
                    $vDesc_C = $produto->vDesc_C;
                    $desc = $produto->vDesc_IC + $produto->vDesc_C;
                    $descaplicado = true;
                }
                    $item += [
                        "valor_desconto" => $desc
                    ];
            }
            if($produto->vDesc_C && $descaplicado != true){
                $desc = $produto->vDesc_C;
                $item += [
                    "valor_desconto" => $desc
                ];
            }

            array_push($items, $item);
        }

        $response = $this->http->post($this->baseURLH . "/v2/nfe", [
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/json',

            ],
            "query" => ['token' => 'lj0iXg9ifG0uksmvjaRDfNBnnlVbCCOY', 'ref' => $ref],
            'json' => [
                "natureza_operacao" => $request->natureza_operacao,
                "data_emissao" => '2023-12-16',
                "data_entrada_saida" =>  '2023-12-16',
                "tipo_documento" => 1,
                "finalidade_emissao" => 1,
                "cnpj_emitente" => "41219310000189",
                "cpf_emitente" => null,
                "nome_emitente" => "ANA MARTHA CURSOS ONLINE LTDA",
                "nome_fantasia_emitente" => "ANA MARTHA CURSOS ONLINE LTDA",
                "logradouro_emitente" => "Rua Armando de Oliveira Cobra",
                "numero_emitente" => "50",
                "bairro_emitente" => "Parque Residencial Aquarius",
                "municipio_emitente" => "São José dos Campos",
                "uf_emitente" => "SP",
                "cep_emitente" => "12246-002",
                "inscricao_estadual_emitente" => "125239889115",
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
                "valor_produtos" => $simulacao->total_produto + ($vDesc_C ? $vDesc_C : 0),
                "modalidade_frete" => 0,
                "items" => $items

            ]
        ]);

        if ($response->getStatusCode() === 202) {
            $this->getNota($ref, "lj0iXg9ifG0uksmvjaRDfNBnnlVbCCOY");
            EmissoesFocus::create([
                "empresa" => json_decode($clientes)->nome,
                "fornecedor" => "ANA MARTHA CURSOS ONLINE LTDA",
                "user_id" =>  1,
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
                "query" => ['token' => 'lj0iXg9ifG0uksmvjaRDfNBnnlVbCCOY', 'ref' => $ref],
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


    public function DownloadFile(Request $request)
    {

        // Substitua 'URL_DO_ARQUIVO' pela URL real do seu arquivo XML
        $fileUrl = $request->url;

        // Faça a solicitação para obter o conteúdo do arquivo
        $fileContent = Http::get($fileUrl)->body();

        // Salve o conteúdo temporariamente em um arquivo local
        $tempFilePath = tempnam(sys_get_temp_dir(), 'downloaded_file');
        file_put_contents($tempFilePath, $fileContent);

        // Obtenha o nome do arquivo da URL ou defina um nome personalizado
        $fileName = pathinfo(parse_url($fileUrl, PHP_URL_PATH), PATHINFO_FILENAME);

        // Defina os headers para permitir o download
        $headers = [
            'Content-Type' => 'application/' . $request->ext,
            'Content-Disposition' => "attachment; filename={$fileName}." . $request->ext,
        ];

        // Retorne o arquivo para o cliente
        return response()->download($tempFilePath, "{$fileName}." . $request->ext, $headers)->deleteFileAfterSend(true);
    }
}



// "natureza_operacao" => $request->natureza_operacao,
// "data_emissao" => date('Y-m-d'),
// "data_entrada_saida" => date('Y-m-d'),
// "tipo_documento" => 1,
// "finalidade_emissao" => 1,
// "consumidor_final" => $simulacao->tipoCalculo === "ICMS" ? 0 : 1,
// "cnpj_emitente" => strlen(json_decode($fornecedor)->cnpj) === 14 ? json_decode($fornecedor)->cnpj : null,
// "cpf_emitente" => strlen(json_decode($fornecedor)->cnpj) === 11 ? json_decode($fornecedor)->cnpj : null,
// "nome_emitente" => json_decode($fornecedor)->nome,
// "nome_fantasia_emitente" => json_decode($fornecedor)->sobrenome,
// "logradouro_emitente" => json_decode($fornecedor)->endereco,
// "numero_emitente" => json_decode($fornecedor)->numero,
// "bairro_emitente" => json_decode($fornecedor)->bairro,
// "municipio_emitente" => json_decode($fornecedor)->cidade,
// "uf_emitente" => json_decode($fornecedor)->estado,
// "cep_emitente" => json_decode($fornecedor)->cep,
// "inscricao_estadual_emitente" => json_decode($fornecedor)->ie,
// "nome_destinatario" => json_decode($clientes)->nome,
// "cnpj_destinatario" => json_decode($clientes)->cpfCnpj,
// "inscricao_estadual_destinatario" => null,
// "telefone_destinatario" => null,
// "logradouro_destinatario" => json_decode($clientes)->endereco,
// "numero_destinatario" => json_decode($clientes)->numero,
// "bairro_destinatario" => json_decode($clientes)->bairro,
// "municipio_destinatario" => json_decode($clientes)->cidade,
// "uf_destinatario" => json_decode($clientes)->estado,
// "pais_destinatario" => "Brasil",
// "cep_destinatario" => json_decode($clientes)->cep,
// "valor_frete" => $vFrete,
// "valor_seguro" => $vSeg,
// "valor_total" => $simulacao->total_pedido,
// "valor_produtos" => $simulacao->total_produto,
// "modalidade_frete" => 0,
// "items" => $items



// "empresa" => json_decode($clientes)->nome,
// "fornecedor" => json_decode($fornecedor)->nome,
// "user_id" => HashIdsDecode($request->user_id),
// "pedido_id" => $simulacao->id,
// "ref" => $ref,
// "status" => "Aguardando retorno",
// "mensagem" => null,
// "link_xml" => null,
// "link_danfe" => null