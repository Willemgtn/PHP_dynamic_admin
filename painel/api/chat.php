<?php 
  include('../../config.php');

  $data['sucesso'] = true;
  $data['mensagem'] = "";

  if(!Painel::logado()){
    die("Você não está logado");
  }

  // echo 'mensagem recebida com sucesso';
  // print_r($_POST);


  if(isset($_POST['acao']) and ($_POST['acao'] == 'enviar')){
    $msg = strip_tags($_POST['msg']);

    $sql = Sql::connect()->prepare("INSERT INTO `tb_admin.chat` VALUES (null, ?, ?)");
    $sql->execute(array($_SESSION['id'], $msg));
  } else {
    $chat = Sql::connect()->prepare("SELECT user_id, msg, name  FROM `tb_admin.chat` INNER JOIN `tb_admin.users` ON `tb_admin.chat`.`user_id` = `tb_admin.users`.`id` ORDER BY `tb_admin.chat`.id DESC LIMIT 10");
    $chat->execute();
    $chat = $chat->fetchAll(PDO::FETCH_ASSOC);
    $chat = array_reverse($chat);
    // print_r($chat);
    foreach ($chat as $key => $value) {
      ?>
      <div class="mensagem-chat">
        <span><?php echo $value['name'];?></span>
        <p><?php echo $value['msg'];?></p>
      </div>
      <?php
    }
  }

?>