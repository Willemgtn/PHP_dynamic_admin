<?php
  include('../../config.php');

  $data['sucesso'] = true;
  $data['mensagem'] = "";

  if(!Painel::logado()){
    die("Você não está logado");
  }

  // echo 'mensagem recebida com sucesso';
  // print_r($_POST);

  if(isset($_POST['date']) and $_POST['acao'] == 'get'){
    // Validate Date
    $date = $_POST['date'];

    $sql = Sql::connect()->prepare("SELECT * FROM `tb_admin.agenda` WHERE date = ?");
    $sql->execute(array($date));
    
    foreach ($sql as $key => $value) {
      ?>
      <div class="box-tarefas-single">
        <h2><i class="fa fa-pencil"></i> <?php echo $value['tarefa'];?></h2>
      </div>
      <?php
    }
  }

  if(isset($_POST['date']) and $_POST['acao'] == 'insert' and !empty($_POST['tarefa'])){
    // Validate Date
    $date = $_POST['date'];
    $tarefa = $_POST['tarefa'];

    $sql = Sql::connect()->prepare("INSERT INTO `tb_admin.agenda` VALUES (null, ?, ?)");
    $sql->execute(array($tarefa, $date));
  } 

?>