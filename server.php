<?php

//constantes com as credencias de acesso ao banco de dados
define('HOST', 'localhost');
define('USER', 'root');
define('SENHA', '');
define('DBNOME', '');

//Criar a conexão com banco de dados

function redirect($rota)
{
  $host  = $_SERVER['HTTP_HOST']; // mudar pra serve.php
  $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\''); // mudar pra serve.php
  $extra = $rota;
  header("Location: http://$host$uri/$extra");
} // mudar pra serve.php
function dd($array)
{
  echo '<pre>';
  echo var_export($array);
  die();
}
try {
  $conn = new pdo('mysql:host=' . HOST . ';dbname=' . DBNOME, USER, SENHA);
} catch (PDOException $e) {
  echo "Erro: Conexão com banco de dados não foi realizada com sucesso." . $e->getMessage();
}

