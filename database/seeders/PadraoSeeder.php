<?php

namespace Database\Seeders;

use App\Models\Empresas;
use App\Models\User;
use Illuminate\Database\Seeder;

class PadraoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "nome" => "Waldir",
            'email' => "waldir@tributei.net",
            'api_token_tributei' => "YDmFIAkdQ4wm6-YDJZVb4pKo9Fk-YDWfuJEVPI.Zc",
            'api_token_focus' => null,
            'cpf' => "01249447283",
            'cnpj' => "",
            'telefone' => "(96) 98104-5845",
            'endereco' => "Acelino de leão",
            'numero' => "1129",
            'bairro' => "Trem",
            'cidade' => "Macapa",
            'estado' => "AP",
            'cep' => "68901092",
            'user' => "ADMIN",
            'ramo' => "Administrador",
            'status' => "Ativo",
            'emissoes' => "99999",
            'qtdemissoes' => "0",
            'password' => bcrypt("tributei@2024"), 
        ]);

        Empresas::create([
            'razão_social' => "TESTE MT",
            'nome_fantasia' => "TESTE MT",
            'cnpj' => "05995840000155",
            'user_id' => "1",
            'telefone' => "",
            'endereco' => "AV DOS UIRAPURUS",
            'numero' => "189",
            'bairro' => "centro",
            'cidade' => "Nova Mutum",
            'estado' => "MT",
            'cep' => "78450000"
        ]);
    }
}
