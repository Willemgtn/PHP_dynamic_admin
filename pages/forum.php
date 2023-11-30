<?php 
  $t_forum = '`tb_site.forum`';                   // id, nome
  $t_forum_topicos = '`tb_site.forum.topicos`';   // id, forum_id, nome 
  $t_forum_posts = '`tb_site.forum.posts`';       // id, topico_id, nome, msg

  $url = array_filter(explode('/', $_GET['url']), 'strlen');

  echo '<hr>';
  $controller = new forumController;
  $controller->t_1 = $t_forum;
  $controller->t_2 = $t_forum_topicos;
  $controller->t_3 = $t_forum_posts;

  $controller->tabela = array(1 => $t_forum, 2 => $t_forum_topicos, 3 => $t_forum_posts);
  $controller->url = $url;

  switch (sizeof($url)){
    case 1:
      // echo 'Home';
      // print_r($url);
      // $view = new forumView;
      // $view->homePage();
      // $model = new forumModel;
      // $model-> listForum();
      $controller->home();
      break;
    case 2: 
      // echo 'Topicos';
      // print_r($url);
      $controller->topicos();
      break;
    case 3: 
      // echo 'Topicos -> post <br>';
      // print_r($url);
      $controller->singlePost();
      break;
    default: 
      echo 'Too much';
      print_r($url);
  }
 
  class forumController{
    private $Model ;
    public $tabela;
    public $t_1;
    public $t_2;
    public $t_3;
    public $url;
    public function __construct(){
      $this->Model = new forumModel();
    }
    public function home(){
      if(isset($_POST['titulo_form'])){
        // Missing Validation and cleaning
        $this->Model->createForum($_POST['titulo_form'], $this->t_1);
      }
      $this->Model->listarForums($this->t_1);
    }
    public function topicos(){
      $topico = $this->Model->existe($this->t_1, $this->url[1]);
      if ($topico){
        if(isset($_POST['titulo_topico'])){
          // Missing Validation and cleaning
          $this->Model->createTopico($this->t_2, $this->url[1], $_POST['titulo_topico']);
        }
        $this->Model->listarTopicos($this->t_2, $this->url[1], $topico);
      } else {
        $this->Model->listarForums(($this->t_1));
      }
    }
    public function singlePost(){
      $post_info = $this->Model->existe($this->t_2, $this->url[2]);
      if ($post_info){
        if(isset($_POST['nome']) and isset($_POST['msg'])){
          // Missing Validation and cleaning
          $post = ['nome' => $_POST['nome'], 'msg' => $_POST['msg']];
          $this->Model->createPost($this->tabela, $this->url, $post);
        }
        // print_r($post_info);
        $this->Model->listarPosts($this->tabela, $this->url);
      } else {
        echo "<script>window.location='" . INCLUDE_PATH . "forum/" . $this->url[1] . "'</script>";
      }
    }
  }

  class forumModel{
    private $view;    
    public function __construct(){
      $this->view = new forumView;
    }
    public function listarForums($t_1) {
      $sql = \Sql::connect()->prepare("SELECT * FROM $t_1");
      // $sql->debugDumpParams();
      $sql->execute();
      $sql = $sql->fetchAll();
      $this->view->homePage();
      $this->view->renderForums($sql);
      // print_r($sql);
    }
    public function createForum($t_1, $forum_name){
      $sql = \Sql::connect()->prepare("INSERT INTO $t_1 VALUES (null, ?)");
      $sql->execute(array($forum_name));
      // echo "<script>alert('cadastro realidado')</script>";
    }
    public function existe($table, $id){
      // echo 'Listando topicos <hr>';
      $sql = \Sql::connect()->prepare("SELECT * FROM $table where id = ?");
      $sql->execute(array($id));
      // $sql->debugDumpParams();
      if ($sql->rowCount() == 1){
        // good
        // echo ' good to go!';
        return $sql->fetch(PDO::FETCH_ASSOC);
        // return true;
      } else {
        // echo 'Houston we have a problem!';
        return false;
      }
    }
    public function listarTopicos($table, $forum_id, $topico_titulo){
      // echo 'Listando topicos <hr>';
      $sql = \Sql::connect()->prepare("SELECT * FROM $table where forum_id = ?");
      $sql->execute(array($forum_id));
      $sql = $sql->fetchAll();
      $this->view->topicoPage($topico_titulo);
      $this->view->renderTopicos($forum_id, $sql);
    }
    public function createTopico($table, $forum_id, $nome){
      $sql = \Sql::connect()->prepare("INSERT INTO $table VALUES (null, ?, ?)");
      $sql->execute(array($forum_id, $nome));
      // echo "<script>alert('cadastro realidado')</script>";
    }
    public function listarPosts($table, $url){
      // echo 'Listando topicos <hr>';
      $sql = \Sql::connect()->prepare("SELECT * FROM $table[3] where topico_id = ?");
      $sql->execute(array($url[2]));
      $sql = $sql->fetchAll(PDO::FETCH_ASSOC);

      // print_r($sql);
      
      $forum = $this->existe($table[1], $url[1]);
      $topico = $this->existe($table[2], $url[2]);
      // print_r($topico);

      $this->view->postPage($forum, $topico);
      $this->view->renderPosts($url[2], $sql);
    }
    public function createPost($table, $url, $post){
      $sql = \Sql::connect()->prepare("INSERT INTO $table[3] VALUES (null, ?, ?, ?)");
      $sql->execute(array($url[2], $post['nome'], $post['msg']));
      // echo "<script>alert('cadastro realidado')</script>";
    }
  }

  class forumView{
    public function __construct()
    {
      // $this->homePage();
      // $this->listForums();
    }
    public function homePage(){
      ?>
      <h2>Bem-vindo ao nosso forum</h2>
      
      <?php
    }
    public function topicoPage($nome){
      // echo '';
      echo "<h2>Você está no forum: <a href='" . INCLUDE_PATH . "forum'>Forum</a> > $nome[nome]</h2>";
    }
    public function postPage($topico, $nome){
      // echo '';
      echo "<h2>Você está no forum: ";
      echo "<a href='" . INCLUDE_PATH . "forum'>Forum</a> > ";
      echo "<a href='" . INCLUDE_PATH . "forum/$topico[id]'>$topico[nome]</a> > ";
      echo "$nome[nome]</h2>";
    }

    public function renderForums(array $sql){
      echo '<form action="" method="post">
      <input type="text" name="titulo_form" id="">
      <input type="submit" name="cadastrar-forum" value="Cadastrar">
      </form>';
      echo '<ul>';
      foreach($sql as $key => $value){
        echo "<li><a href='". INCLUDE_PATH . 'forum/' . $value['id'] . "'>$value[nome]</a></li>";
      }
      echo '</ul>';
    }
    public function renderTopicos($forum_id, array $sql){
      echo '<form action="" method="post">
      <input type="text" name="titulo_topico" id="">
      <input type="submit" name="cadastrar-topico" value="Cadastrar topico">
      </form>';
      echo '<ul>';
      foreach($sql as $key => $value){
        echo "<li><a href='". INCLUDE_PATH . "forum/$forum_id/$value[id]'>$value[nome]</a></li>";
      }
      echo '</ul>';
    }
    public function renderPosts($topic_id, array $sql){
      echo '<form action="" method="post">
      <input type="text" name="nome" placeholder="Nome">
      <input type="text" name="msg" placeholder="Mensagem">
      <input type="submit" name="cadastrar-post" value="Cadastrar post">
      </form>';
      echo '<ul>';
      foreach($sql as $key => $value){
        // echo "<li><a href='". INCLUDE_PATH . "forum/$topic_id/$value[id]'>$value[nome]</a></li>";
        echo "<li><b>$value[nome]</b>: $value[msg]</li>";
      }
      echo '</ul>';
    }
    
  }

  
?>
<main class="forum">



</main>