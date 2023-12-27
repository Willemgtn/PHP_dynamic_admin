<?php
$t_social = [
  1 => '`tb_site.social.membros`',
  2 => '`tb_site.social.feed`',
  3 => '`tb_site.social.solicitacoes`',

  ];
  function solicitarAmizade($idAmigo, $t_social){
    $sql = Sql::connect()->prepare("INSERT INTO $t_social[3] values (null, ?, ?, 0)");
    $sql->execute([$_SESSION['social']['id'], $idAmigo]);
  }
  function amigoPendente($idAmigo, $t_social){
    // if (isAmigo($idAmigo, $t_social)) {return false;}
    $sql = Sql::connect()->prepare("SELECT * FROM $t_social[3] WHERE (id_from=? AND id_to=? AND status=0)");
    $sql->execute(array($_SESSION['social']['id'], $idAmigo));
    if($sql->rowCount() == 1){
      return true;
    } else {
      return false;
    }
  }
  function getNumeroSolicitacoes($tabela){
    $selectAll =  Sql::connect()->prepare("SELECT *  FROM $tabela[3] WHERE id_to=? and status=0");
    $selectAll->execute(array($_SESSION['social']['id']));
    echo $selectAll->rowCount();
  }
  function aceitarSolicitacao($idAmigo, $tabela){
    $verifyRequest = Sql::connect()->prepare("SELECT * FROM $tabela[3] WHERE id_from=? and id_to=?");
    $verifyRequest->execute(array($idAmigo, $_SESSION['social']['id']));
    if($verifyRequest->rowCount() == 1){
      // good request.
      // echo "valid request";
      $sql = Sql::connect()->prepare("UPDATE $tabela[3] SET status=1 WHERE id_from=? and id_to=?");
      $sql->execute(array($idAmigo, $_SESSION['social']['id']));
      Painel::alertJs("Friend request accepted");
    } else {
      echo "no such request";
    }
  }
  function isAmigo($idAmigo, $tabela){
    $sql = Sql::connect()->prepare("SELECT * FROM $tabela[3] WHERE 
    (id_from=? and id_to=? and status=1) OR (id_from=? and id_to=? and status=1)" );
    $sql->execute(array($idAmigo, $_SESSION['social']['id'],$_SESSION['social']['id'],$idAmigo));
    if($sql->rowCount() == 1){
      return true;
    } else {
      return false;
    }
    }
  function rejeitarSolicitacao($idAmigo, $tabela){
    $verifyRequest = Sql::connect()->prepare("SELECT * FROM $tabela[3] WHERE id_from=? and id_to=?");
    $verifyRequest->execute(array($idAmigo, $_SESSION['social']['id']));
    if($verifyRequest->rowCount() == 1){
      // good request.
      echo "valid request";
      $sql = Sql::connect()->prepare("DELETE FROM $tabela[3] WHERE id_from=? and id_to=?");
      $sql->execute(array($idAmigo, $_SESSION['social']['id']));
      // Painel::alertJs("Friend request accepted");
    } else {
      echo "no such request";
    }
  }
  function listarAmigos($tabela){
    $sql_from = Sql::connect()->prepare("SELECT * FROM $tabela[3] INNER JOIN $tabela[1] ON $tabela[3].id_to = $tabela[1].id WHERE (id_from=? AND status=1)");
    $sql_from->execute(array($_SESSION['social']['id']));
    $sql_from = $sql_from->fetchAll();
    $sql_to = Sql::connect()->prepare("SELECT * FROM $tabela[3] INNER JOIN $tabela[1] ON $tabela[3].id_from = $tabela[1].id WHERE (id_to=? AND status=1)");
    $sql_to->execute(array($_SESSION['social']['id']));
    $sql_to = $sql_to->fetchAll();
    $sql = array_merge($sql_from, $sql_to);
    return $sql;
  }


  if(isset($_POST['login'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = Sql::connect()->prepare("SELECT * FROM $t_social[1] WHERE email=? AND senha=?");
    $sql->execute([$email, $senha]);
    if ($sql->rowcount() == 1){
      $_SESSION['social'] = $sql->fetch();
      Painel::alertJs("Login efetuado com sucesso!");
    } else {
      Painel::alertJs("E-mail ou senha incorretos!");
    }
  }
  if($_GET['url'] == 'social/logout'){
    $_SESSION['social'] = [];
    Painel::alertJs("logout");
    Painel::redirect(INCLUDE_PATH . 'social');
  }

  if (isset($_POST['cadastro'])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['password'];
    $imagem = $_FILES['imagem'];
    
    

    if ($nome === ''){
      echo "sem nome";
      Painel::alertJs("O campo nome não pode estar vázio");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      Painel::alertJs("O e-mail não é valido");
    } else if ($senha === ''){
      Painel::alertJS("O campo senha não pode estar vazio");
    } else if (!FileUpload::validadeImage('imagem')){
      Painel::alertJS("A imagem é invalida");
    } else {
      $sql = Sql::connect()->prepare("SELECT * FROM $t_social[1] WHERE email =?");
      // $sql->debugDumpParams();
      $sql->execute([$email]);
      if ($sql->rowCount() == 0){
        $imagem = FileUpload::uploadImage('imagem');
        $sql = Sql::connect()->prepare("INSERT INTO $t_social[1] VALUES (null, ?, ?,?,?)");
        $sql->execute([$nome, $email, $senha, $imagem]);
        Painel::alertJS("O cadastro foi realizado com sucesso!");
      } else {
        Painel::alertJS("E-mail já cadastrado!");
      }
      
    }
  }
?>

<main class="social">
<header>
  <div class="container">
    <div class="logo">
      <a href="<?php echo INCLUDE_PATH ?>social">Rede Social</a>
    </div>
    <div class="form-login">
    <?php if(!isset($_SESSION['social']) or empty($_SESSION['social'])) {
      ?>
    
      <form action="" method="post">
        <input type="text" name="email" id="" placeholder="E-mail...">
        <input type="password" name="senha" id="" placeholder="Senha...">
        <input type="submit" name="login" value="Logar">
      </form>
      <?php } else {  ?>
        <a href="<?php echo INCLUDE_PATH; ?>social/solicitacoes" class="btn hovertext" data-hover="Solicitações"><i class="fa-solid fa-user-plus"></i> (<?php getNumeroSolicitacoes($t_social);?>)</a>
        <a href="<?php echo INCLUDE_PATH; ?>social/comunidade" class="btn hovertext" data-hover="Comunidade"><i class="fa-solid fa-users"></i></a>
        <a href="<?php echo INCLUDE_PATH; ?>social/logout" class="btn hovertext" data-hover="Sair"><i class="fa-solid fa-door-open"></i></a> 
      <?php }
      ?>
        
    </div>
  </div>
</header>

<?php if(!isset($_SESSION['social']) or empty($_SESSION['social'])) {  ?>
  <section class="cadastro">
    <div class="container">
      <h2>Efetue o cadastro:</h2>
      <form action="" method="post" enctype="multipart/form-data">  
        <input type="text" name="nome" id="" placeholder="Nome...">
        <input type="email" name="email" id="" placeholder="E-mail...">
        <input type="password" name="password" id="" placeholder="Senha...">
        <p>Escolha sua foto de perfil:</p>
        <input type="file" name="imagem" id="">
        <input type="submit" name="cadastro" value="Cadastrar">
      </form>
    </div>
  </section>
<?php } else if ($_GET['url'] == 'social'){?>
  <?php 
    if(isset($_POST['acao'])){
      $id = $_SESSION['social']['id'];
      $msg = strip_tags($_POST['mensagem']);
      
      if ($msg !== ''){
        $sql = Sql::connect()->prepare("INSERT INTO $t_social[2] values (null, ?,?)");
        $sql->execute([$id, $msg]);
        Painel::redirect(INCLUDE_PATH . 'social');
      } else {
        Painel::alertJs("Mensagem não pode estar vazia.");
      }
    }
    ?>
  <div class="main-container" style="max-width: 1280px;">
    <section class="info w40">
      <h2><?php echo $_SESSION['social']['nome']; ?></h2>
      <img src="<?php echo INCLUDE_PATH .'painel/uploads/' . $_SESSION['social']['imagem']; ?>" alt="">
      <div class="amizades">
        <h3>
          <i class="fa-solid fa-users"></i>
            Minhas amizades
        </h3>
        <div class="amizades-wrapper">
          <?php 
            // for ($i=0; $i<6; $i++){
            //   echo "<div class='amizades-single'>  </div>";
            //   }
            $amigos = listarAmigos($t_social);
            // echo "<pre>";
            // print_r($amigos);
            // echo "</pre>";
            foreach ($amigos as $key => $value) {
              echo "<div class='amizades-single' style='background-image: url(\"".INCLUDE_PATH . "painel/uploads/$value[imagem]"."\")'>  </div>";
              // echo $value["nome"];
              }
          ?>
        </div>
      </div>
    </section>

    <section class="feed w60">
      <h2>O que está pensando hoje?</h2>
      <form action="" method="post">
        <textarea name="mensagem" id="" cols="" rows="4" placeholder="Qual a boa? ..."></textarea>
        <input type="submit" name="acao" value="Enviar">
        <div class="clear"></div>
      </form>

      <?php 
        $feed = Sql::connect()->prepare("SELECT * FROM $t_social[1] INNER JOIN $t_social[2] on $t_social[2].membro_id = $t_social[1].id ORDER BY $t_social[2].id DESC");
        $feed->execute();
        $feed = $feed->fetchAll();
        // print_r($feed);
        foreach ($feed as $key => $value) {
        ?>
      <div class="post-single-user">
        <div class="img-user-post">
          <img src="<?php echo INCLUDE_PATH ."painel/uploads/$value[imagem]";?>" alt="">
        </div>
        <div class="post-user-single">
          <p><?php echo $value['nome']; ?> :</p>
          <p><?php echo $value['post']; ?></p>
        </div>
        <div class="clear"></div>
      </div>
      <?php }?>
      
    </section>
  </div>
<?php } else if ($_GET['url'] == 'social/comunidade') {?>
  <?php 
    if(isset($_GET['addFriend'])){
      $idAmigo = (int)$_GET['addFriend'];
      if(amigoPendente($idAmigo, $t_social) == false){
        solicitarAmizade($idAmigo, $t_social);
        Painel::alertJs("Solicitação Enviada!");
      } else {
        Painel::redirect(INCLUDE_PATH . 'social/comunidade');
      }
      Painel::redirect(INCLUDE_PATH . 'social/comunidade');
    }
    ?>

    <section class="comunidade">
      <div class="container">
        <div class="w100">
          <h2 class="title">Comunidade</h2>
          <?php 
            $selectAll =  Sql::connect()->prepare("SELECT * FROM $t_social[1]");
            $selectAll->execute();
            $selectAll = $selectAll->fetchAll();
            foreach ($selectAll as $key => $value) {
              if ($value['id'] == $_SESSION['social']['id'])
              continue;
            ?>
            <div class="membro-listagem">
              <div class="box-imagem">
                <div style="background-image: url('<?php echo INCLUDE_PATH . "painel/uploads/$value[imagem]"?>');" class="box-imagem-wrapper"></div>
              </div>
              <p><i class="fa fa-user"></i><?php echo $value['nome']?></p>
              <?php if (isAmigo($value['id'], $t_social)) {?>
                <a style="opacity: 0.8;" href="javascript:void(0)" class='ok'>Amigos</a>
              <?php } else if(amigoPendente($value['id'], $t_social) == false ) {?>
                <a href="<?php echo INCLUDE_PATH ."social/comunidade?addFriend=$value[id]"?>" >Adicionar como amigo</a>
                <?php } else {?>
                <a style="opacity: 0.4;" href="javascript:void(0)">Solicitação Enviada!</a>
                <?php } ?>
            </div>
          <?php } ?>
          <div class="clear"></div>
        </div>
      </div>
    </section>
<?php } else if ($_GET['url'] == 'social/solicitacoes') {?>
  <?php 
    if(isset($_GET['aceitar'])){
      $idAmigo = (int)$_GET['aceitar'];
      aceitarSolicitacao($idAmigo, $t_social);
      Painel::redirect(INCLUDE_PATH . 'social/solicitacoes');
    }
    if(isset($_GET['rejeitar'])){
      $idAmigo = (int)$_GET['rejeitar'];
      rejeitarSolicitacao($idAmigo, $t_social);
      Painel::redirect(INCLUDE_PATH . 'social/solicitacoes');
    }
    ?>
  <section class="solicitacoes">
      <div class="container">
        <div class="w100">
          <h2 class="title">solicitacoes</h2>
          <?php 
            $selectAll =  Sql::connect()->prepare("SELECT *  FROM $t_social[1] INNER JOIN $t_social[3] on $t_social[3].id_from = $t_social[1].id  WHERE id_to=? and status=0");
            // $t_social[3].'id_from', $t_social[3].'id_to', $t_social[3].'status',$t_social[1].nome, $t_social[1].email, $t_social[1].imagem
            // $selectAll->debugDumpParams();
            $selectAll->execute(array($_SESSION['social']['id']));
            $selectAll = $selectAll->fetchAll();
            // echo "<pre>";
            // print_r($selectAll);
            // echo "</pre>";
            foreach ($selectAll as $key => $value) {
              // if ($value['id'] == $_SESSION['social']['id'])
              // continue;
            ?>
            <div class="membro-listagem">
              <div class="box-imagem">
                <div style="background-image: url('<?php echo INCLUDE_PATH . "painel/uploads/$value[imagem]"?>');" class="box-imagem-wrapper"></div>
              </div>
              <p><i class="fa fa-user"></i><?php echo $value['nome']?></p>
              <a href="<?php echo INCLUDE_PATH ."social/solicitacoes?aceitar=$value[id_from]"?>" class="btn-ok"><i class="fa-regular fa-square-check"></i> Aceitar</a>
              <a href="<?php echo INCLUDE_PATH ."social/solicitacoes?rejeitar=$value[id_from]"?>" class="btn-no"><i class="fa-solid fa-square-xmark"></i> Rejeitar</a>
            </div>
          <?php } ?>
          <div class="clear"></div>
        </div>
      </div>
    </section>


<?php } ?>

</main>

<style>
        .w40{
          width: 40%;
          }
        .w60{
          width: 60%;
          }
        
        main.social{
          background: #e0f2f1;
          }
        main.social *{
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          /* font-family: "Open Sans"; */
          }
        main.social .container {
          max-width: 1100px;
          margin: 0 auto;
          padding: 0 2%;
          }
        main.social .clear {
          clear: both;
          }
        main.social header{
          background: #64b5f6;
          height: 50px;
          }
        main.social .logo{
          padding: 6px 0;
          float: left;
          }
        main.social .logo a{
          font-size: 19px;
          color: white;
          text-decoration: none;
          text-transform: uppercase;
          letter-spacing: 5px;
          }
        main.social header .form-login{
          float:right;
          /* padding: 10px auto; */
          margin: 10px auto;
          }
        main.social .form-login input[type=text],
        main.social .form-login input[type=password]{
          width: 200px;
          height: 25px;
          border: 1px solid #ccc;
          padding-left: 8px;
          }
        main.social .form-login input[type=submit]{
          background: #2196f3;
          border: 0;
          cursor: pointer;
          color: white;
          height: 25px;
          width: 120px;
          }
        main.social .form-login a{
          color: white;
          padding: 0 10px;

        }
        main.social .box{
          margin: 20px auto;
          background-color: white;
          padding: 30px 15px;
          }
        main.social section.cadastro h2{
          text-align: center;
          font-weight: normal;
          color: rbg(180,180,180);
          font: 20px;
          text-transform: uppercase;
          border-bottom: 2px solid rgb(180,180,180);
          }
        main.social section.cadastro input[type=text],
        main.social section.cadastro input[type=email],
        main.social section.cadastro input[type=password]{
          width: 100%;
          height: 35px;
          border: 1px solid #ccc;
          padding-left: 8px;
          margin-bottom: 5px;
          }
        main.social section.cadastro input[type=file]{
          border: 1px solid #ccc;
          width: 100%;
          padding: 8px;
          }
        main.social section.cadastro input[type=submit]{
          display: block;
          margin: 10px 0;
          width: 200px;
          cursor:pointer;
          background: #2196f3;
          }
        div.main-container > section { 
          float: left;
          margin: 10px;
          background: white;
          border-radius: 10px;
          padding: 10px;
          }
        div.main-container { display:flex; margin: auto;}
        div.main-container section h2 { text-align: center; border-bottom: 1px solid #ccc;}
        div.main-container section.info img { 
          width: 100%; 
          margin-bottom: 20px; 
          max-width: 200px;
          }
        div.main-container section.info .amizades { 

          }
        div.main-container section.info .amizades h3{ 
          background: #2196f3;
          padding: 5px 10px;
          color: white;
          }
        div.main-container section.info .amizades .amizades-wrapper{
          /* position: absolute; */
          /* left: 5px;
          top: 5px;
          width: calc(100% - 10px);
          height: calc(100% - 10px);
          background-size: 100% 100%;
          background: #ccc; */
          }
        div.main-container section.info .amizades .amizades-single{
          width: calc(33.3% - 6px);
          height: 10px;
          background: #ccc;
          padding-top: 33.3%;
          float: left;
          margin: 3px;
          background-size: 100%;
          background-repeat: no-repeat;
          }
        main.social  .membro-listagem{
          width: 20%;
          float:left;
          padding: 8px;
          }
        main.social  .box-imagem{
          width: 100%;
          padding-top: 100%;
          position: relative;
          }
        main.social  .box-imagem-wrapper{
          width: 100%;
          height: 100%;
          position: absolute;
          left: 0;
          top: 0;
          background-size: 100% 100%;
          }
        .membro-listagem a{
          text-decoration: none;
          color: white;
          background-color: #2196f3;
          padding: 5px;
          font-size: 14px;
          }
        .membro-listagem a.ok{
          background: lightgreen;
          }
        section.solicitacoes .membro-listagem a.btn-ok{
          background: lightgreen;
          width: 48%;
          float: left;
          }
        section.solicitacoes .membro-listagem a.btn-no{
          background: lightcoral;
          float: right;
          width: 48%;
          }
        pre{
          width: 100%;
          display: block;
          color: black;
          }
        section.feed form textarea {
          width: 100%;
          padding: 10px;
          margin-top: 10px;
          }
        section.feed form input[type=submit] {
          float: right;
          padding: 8px 24px;
          background-color: #64b5f6;
          border: none;
          color: white;
          cursor: pointer;
          }
        section.feed .img-user-post{
          float: left;
        }
        section.feed .img-user-post img{
          width: 60px;
          height: 60px;
          border-radius: 30px;
          margin: 0px 10px 0 0px;
        }
        section.feed .post-single-user{
          padding: 5px;
          border: 1px solid black;
          margin-top: 5px;
        }
        section.feed .post-single-user p:first-child{
          color: #64b5f6;
        }
        
          main.social nav.desktop{
          float: right;
          }
        main.social nav.desktop li{
          font-weight: 300;
          display: inline-block;
          }
        main.social nav.desktop a {
          display: inline-block;
          padding: 13px 15px;
          color: white;
          text-decoration: none;
          background: #4b4b4b;
          }
        .hovertext {
          position: relative;
          /* border-bottom: 1px dotted black; */
          }
        .hovertext:before {
          content: attr(data-hover);
          visibility: hidden;
          opacity: 0;
          /* width: 140px; */
          /* background-color: black; */
          color: #2196f3;
          text-align: center;
          border-radius: 5px;
          padding: 20px 0;
          transition: opacity 1s ease-in-out;
          position: absolute;
          z-index: 1;
          right: 0;
          top: 110%;
          }

        .hovertext:hover:before {
          opacity: 1;
          visibility: visible;
          }
</style>