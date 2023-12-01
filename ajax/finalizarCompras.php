<?php
include('../config.php');
$t_loja = [ 
  1 => '`tb_admin.estoque`',
  2 => '`tb_admin.estoque_imagens`'
]; 

$data['token'] = PAGSEGURO_TOKEN;
$data['email'] = PAGSEGURO_EMAIL;
$data['currency'] = 'BRL';
$data['notificationURL'] = INCLUDE_PATH . 'ajax/pagseguroRetorno.php';
$data['reference'] = uniqid();

$index = 1;
$carrinho = $_SESSION['carrinho'];

foreach ($carrinho as $c_key => $c_value) {
  $sql = Sql::connect()->prepare("SELECT * FROM $t_loja[1] WHERE id = $c_key");
  $sql->execute();
  $sql = $sql->fetch(PDO::FETCH_ASSOC);
  $sql['qt'] = $c_value;

  $data["itemId$index"] = $sql['id'];             //product_id ??
  $data["itemQuantity$index"] = $c_value;
  $data["itemDescription$index"] = $sql['nome'];
  $data["itemAmount$index"] = $sql['preco'];
  $index++;
}

// echo "<pre>";
// print_r($data);
// echo "</pre>";
// echo "<hr>";

$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout";
$data = http_build_query($data);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$xml = curl_exec($curl);

// echo "<pre>";
// print_r($xml);
// echo "</pre>";
// echo "<hr>";

curl_close($curl);
$xml = simplexml_load_string($xml);

echo $xml->code;