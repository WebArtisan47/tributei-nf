<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Tymon\JWTAuth\Contracts\JWTSubject;
class Entidade extends Authenticatable
{
   
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $guard = 'web';

    // protected $with = ['parceriaHash'];

    protected $fillable = [
            'id',
            'nome',
            'sobrenome',
            'cnpj',
            'cpf',
            'registro',
            'ramo',
            'telefone',
            'celular',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'cep',
            'tipo',
            'atuacao',
            'venda_codigo',
            'venda_tipo',
            'venda_status',
            'venda_quantidade',
            'venda_captura',
            'venda_guia',
            'venda_modulos',
            'venda_expired_at',
            'venda_contract_at',
            'api_token',
            'cargo',
            'vol_notas',
            'ad_link',
            'status',
            'logotipo',
            'venda_desconto',
            'automacao_modulos',
            'cnd_federal',
            'cnd_municipal',
            'cnd_estadual',
            'ecac',
        ];

    public function produto(){
        return $this->hasOne(\App\Models\ProdutoCustomizado::class,'entidade_id');
    }
    public function days(){

        //Create a date object out of a string (e.g. from a database):
        $date1 = new \DateTime($this->created_at);

        //Create a date object out of today's date:
        $date2 = new \DateTime(date('Y-m-d'));

        //Create a comparison of the two dates and store it in an array:
        $diff = (array) date_diff($date1, $date2);

        return $diff['days'];
    }
    public function clientes() {
        if(apiAuth()->user()->tipo == 'SUB-CLIENTE'){
            return $this->belongsToMany(\App\Models\ClientesContabil::class, 'acesso_user_empresas', 'acesso_user_id', 'cliente_contador_id');
        }else{

            return $this->hasMany(\App\Models\ClientesContabil::class, 'id_contador', 'id');
        }
    }
    public function subUser(){
        return $this->hasMany(Autenticacao::class,'entidade_id')->where('tipo','=','SUB-USER');
    }
    public function subCliente(){
        return $this->hasMany(Autenticacao::class,'entidade_id')->where('tipo','=','SUB-CLIENTE');
    }

    public function userAntigo(){
        return $this->belongsTo(\App\User::class,'id');
    }
    public function getEntidadeAttribute(){
        return $this;
    }

    public function getAuthAttribute(){
        if( !$this->status){
            return (object)['jornada'=>0,'email'=>0,'contato'=>0,'tipo'=>0];
        }
        $jornada = Autenticacao::select('jornada','email','contato','tipo')->where('entidade_id',$this->id)->where(function($query){
         $query->where('tipo','CLIENTE')
         ->orWhere('tipo','ADMIN');
        })->first();
        return $jornada;
    }

    public function getUsoBoletoAttribute(){
        if( !$this->status){
            return (object)['venda_quantidade'=>0,'venda_captura'=>0,'venda_guia'=>0,'num_consulta_mva'=>0,'venda_remessa'=>0];
        }
        $produto = $this->produto;
        $parceria = $this->parceria;
        if($parceria && $parceria->parceiro->tipo_parceria == 0){
            $entidade_id = $parceria->parceiro_id;
        }else{
            $entidade_id = $this->id;
        }
            $dia = date('d', strtotime($this->venda_expired_at));
            $mes = date('m', strtotime($this->venda_expired_at));
            $year = date('Y', strtotime($this->venda_expired_at));
            $mes_referencia = (date('d')<=$dia)?(date('m')):(date('m') + 1);
            $pagamento = UsoPagamento::where('entidade_id',$entidade_id)
            ->where('mes_referencia', $mes)->where('ano_referencia', $year)->first();
            if($pagamento){
                return $pagamento;
            }else{
                return UsoPagamento::where('entidade_id',$entidade_id)->orderBy('id','desc')->first();
            }
    }

    public function funcionalidades($modulo = false){
        if(true || ($this->status && !$modulo)){
            return [];
        }
            $tipo = $this->produto->produto->tipo;
            $select = ModulosFuncionalidades::where('tipo_automacao',$tipo)
            //->where('mes_referencia', $mes)
            ->where('modulo','like', '%'.$this->automacao_modulos.'%');
            if($modulo){
                $select->where('modulo','like','%'.$modulo.'%');
            }
            $rows = $select->get();
            $funcionalidades = '';
            foreach($rows as $row)  
                $funcionalidades .= '|'.$row->funcionalidades;
            if($rows){
                return explode('|',$funcionalidades);
            }else{
                return [];
            }

    }

    /**
     * Determine if the model may perform the given permission.
     *
     * @param string|int|\Spatie\Permission\Contracts\Permission $permission
     * @param string|null $guardName
     *
     * @return bool
     * @throws PermissionDoesNotExist
     */
    public function hasPermissionTo($permission, $guardName = null): bool
    {
        $guardName = 'web';
        if (config('permission.enable_wildcard_permission', false)) {
            return $this->hasWildcardPermission($permission, $guardName);
        }

        $permissionClass = $this->getPermissionClass();

        if (is_string($permission)) {
            $permission = $permissionClass->findByName(
                $permission,
                $guardName ?? $this->getDefaultGuardName()
            );
        }

        if (is_int($permission)) {
            $permission = $permissionClass->findById(
                $permission,
                $guardName ?? $this->getDefaultGuardName()
            );
        }

        if (! $permission instanceof Permission) {
            throw new PermissionDoesNotExist;
        }

        return $this->hasDirectPermission($permission) || $this->hasPermissionViaRole($permission);
    }

    // public function parceria(){
    //     return $this->hasOne('App\Models\ParceriaCliente',  'parceiro_cliente_id');

    //     // return $this->belongsToMany
    // }

    // public function parceriaHash(){
    //     return $this->HasOne('App\Models\Parceria',  'parceiro_id');

    //     // return $this->belongsToMany
    // }

    public function xmlCont(){
        //dd('a');
        $user = $this->id;
        return Xml::raw(function($collection)use($user){
            return $collection->aggregate([
                [
                    '$match'=>['user_id'=>$user]
                ],
              [
                '$group'=> [
                    '_id'=>[
                    'user_id' => "\$user_id",
                    'year'=>['$year'=> ['dateFromString'=> [ 'dateString'=> '$data_upload', 'format'=> '%Y-%m-%d' ]]]
                    ],
                  'combined_object_size'=> [ '$sum'=> [ '$bsonSize'=> '$$ROOT' ] ]    
                    
                ]],
                [
                  '$sort'=> [ 'combined_object_size' => -1 ] ,
                ]
            ]);
        });
    }


}
