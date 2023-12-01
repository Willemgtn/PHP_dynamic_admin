<?php

include('../config.php');
$t_loja = [ 
  1 => '`tb_admin.estoque`',
  2 => '`tb_admin.estoque_imagens`',
  3 => '`tb_admin.loja.vendas`'
]; 
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

function xml2array ( $xmlObject, $out = array () ){
  $xml = simplexml_load_string($xmlObject, 'SimpleXMLElement', LIBXML_NOCDATA);
  $out = json_decode(json_encode((array)$xml), TRUE);
    return $out;
}
function pagseguroStatus($statusCode){
  switch ($statusCode) {
    case 1:
      $out = 'Aguardando pagamento';
      break;
    case 2:
      $out = 'Em analise';
      break;
    case 3:
      $out = 'Paga';
      break;
    case 4:
      $out = 'Disponivel';
      break;
    case 5:
      $out = 'Em disputa';
      break;
    case 6:
      $out = 'Devolvida';
      break;
    case 7:
      $out = 'Cancelada';
      break;
    default:
      $out = false;
      break;
  }
  return $out;
}


$email = PAGSEGURO_EMAIL;
$token = PAGSEGURO_TOKEN;

if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
  $notification_code = (string) $_POST['notificationCode'];
 

  $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . "?email=$email&token=$token";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $transaction = curl_exec($curl);
  curl_close($curl);

  if($transaction == 'Unauthorized'){
    die('Unauthorized: Um erro ocorreu com a solicitação');
  }

  $php_transaction = xml2array($transaction);
  echo "<hr><pre>";
  print_r($php_transaction);
  echo "</pre><hr>";
  $transaction = simplexml_load_string($transaction);
  $transactionStatus = $transaction->status;
  $transactionStatus = pagseguroStatus($transactionStatus);
  $reference_id = $transaction->reference;
  // Sql::connect()->exec("UPDATE $t_loja[1] SET status = '$transactionStatus' WHERE reference_id = '$reference_id'");
  echo $transactionStatus;
  echo "<hr><pre>";
  print_r($transaction);
  echo "</pre><hr>";

  $transactionInfo = [
    // 'notification_code' => $notification_code,
    'reference_id' => $php_transaction['reference'],
    'code' => $php_transaction['code'],
    'grossAmount' => $php_transaction['grossAmount'],
    'status' => pagseguroStatus($php_transaction['status'])
  ];

  $sql = sql::connect()->prepare("SELECT * FROM $t_loja[3] WHERE reference_id = ?");
  $sql->execute(array( $php_transaction['reference']));
  if($sql->rowCount() == 0){
    $sql = sql::connect()->prepare("Insert into $t_loja[3] VALUES(null, ?,?,?,?,?)");
    $sql->execute(array($notification_code, $transactionInfo['reference_id'],$transactionInfo['code'],$transactionInfo['grossAmount'], $transactionInfo['status']));
  } else {
    $sql = Sql::connect()->prepare("UPDATE $t_loja[3] SET notification_code=?, code=?, grossAmount=?, `status`=? WHERE reference_id = ?");
    $sql->execute([$notification_code, $transactionInfo['code'],$transactionInfo['grossAmount'], $transactionInfo['status'], $transactionInfo['reference_id'] ]);
  }

  
} else {
  echo "Sorry nothing here...";
}

  // $notification_code = '99F13392BB68BB682AB774CDFFBA24FAAA9C';

  // $sql = sql::connect()->prepare("SELECT * FROM $t_loja[3] WHERE notification_code = ?");
  // $sql->execute(array($notification_code));
  // if($sql->rowCount() == 0){
  //   $sql = sql::connect()->prepare("Insert into $t_loja[3] VALUES(null, ?,?,?,?,?)");
  //   $sql->execute(array($notification_code, '','','',''));
  // }

  // $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $notification_code . "?email=$email&token=$token";

  // $curl = curl_init($url);
  // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  // $transaction = curl_exec($curl);
  // curl_close($curl);

  // if($transaction == 'Unauthorized'){
  //   die('Um erro ocorreu com a solicitação');
  // }
  // echo "<hr><pre>";
  // print_r($transaction);
  // echo "</pre><hr>";

  // $php_transaction = xml2array($transaction);

  

  // $php_transaction = xml2array($transaction);
  // echo "<hr><pre>";
  // print_r($php_transaction);
  // echo "</pre><hr>";

  // $transactionInfo = [
  //   // 'notification_code' => $notification_code,
  //   'reference_id' => $php_transaction['reference'],
  //   'code' => $php_transaction['code'],
  //   'grossAmount' => $php_transaction['grossAmount'],
  //   'status' => pagseguroStatus($php_transaction['status'])
  // ];
  // $sql = Sql::connect()->prepare("UPDATE $t_loja[3] SET reference_id=?, code=?, grossAmount=?, `status`=? WHERE notification_code = ?");
  // $sql->execute([$transactionInfo['reference_id'],$transactionInfo['code'],$transactionInfo['grossAmount'], $transactionInfo['status'], $notification_code]);


  // // $items = $php_transaction['items']['item'];
  // echo "<hr><pre>";
  // print_r($transactionInfo);
  // echo "</pre><hr>";

// print_r($_POST);