<?php 
  $t_loja = [ 
    1 => '`tb_admin.estoque`',
    2 => '`tb_admin.estoque_imagens`'
  ]; 

  $url = array_filter(explode('/', $_GET['url']), 'strlen');

  echo '<hr><main class="loja">';
  $controller = new lojaController;
  $controller->tabela = $t_loja;
  $controller->url = $url;

  // print_r($url);
  switch (sizeof($url)){
    case 1:
      $controller->home();
      break;
    case 2: 
      if (isset($url[1]) and $url[1] == 'finalizar'){
        $controller->finalizar();
      }
      // $controller->topicos();
      break;
    case 3: 
      // $controller->singlePost();
      break;
    default: 
      echo 'Too much';
      print_r($url);
  }
 
  class lojaController{
    private $Model ;
    public $tabela;
    public $url;
    public function __construct(){
      $this->Model = new lojaModel();
    }
    public function home(){
      if(isset($_GET['addCart'])){
        $idproduto = (int)$_GET['addCart'];
        if (isset($_SESSION['carrinho']) == false) { 
          $_SESSION['carrinho'] = array();
        };

        if (isset($_SESSION['carrinho'][$idproduto]) == false ){
          $_SESSION['carrinho'][$idproduto] = 1;
        } else {
          $_SESSION['carrinho'][$idproduto]++;
        }

      }
        $this->Model->getAllProdutos($this->tabela);
      
    }
    public function finalizar(){
      // echo "finalizar";
      $this->Model->listarProdutosCarrinho($this->tabela);
    }
  }

  class lojaModel{
    private $view; 
    public function __construct(){
      $this->view = new lojaView;
    }
    public function listarForums($tabela) {
      $sql = \Sql::connect()->prepare("SELECT * FROM $tabela[1]");
      // $sql->debugDumpParams();
      $sql->execute();
      $sql = $sql->fetchAll();
      $this->view->header();
      // $this->view->renderForums($sql);
      // print_r($sql);
    }
    static function getTotalItemsCarrinho(){
      if(isset($_SESSION['carrinho'])){
        $amount = 0;
        foreach ($_SESSION['carrinho'] as $key => $value) {
          $amount+=$value;
        }
      return $amount;
      } else {
        return '0';
      }
    }
    static function getImagensProduto($id, $tabela){
      $sql = Sql::connect()->prepare("SELECT * FROM $tabela WHERE produto_id = id");
      $sql->execute($id);
      $sql = $sql->fetchAll();

      return $sql;
    }
    public function getAllProdutos($tabela){
      $sql = Sql::connect()->prepare("SELECT * FROM $tabela[1]");
      $sql->execute();
      $sql = $sql->fetchAll();

      foreach ($sql as $key => $value) {
        $imagem = Sql::connect()->prepare("SELECT * FROM $tabela[2] WHERE produto_id = $value[id]");
        $imagem->execute();
          // $imagem->debugDumpParams();
        $sql[$key]['imagem'] = $imagem->fetch()['imagem'];
      }

      $this->view->produtosBoxes($sql, $tabela);
    }
    public function listarProdutosCarrinho($tabela){
      $carrinho = $_SESSION['carrinho'];
      $cart = array();

      foreach ($carrinho as $c_key => $c_value) {
        # code...
        $sql = Sql::connect()->prepare("SELECT * FROM $tabela[1] WHERE id = $c_key");
        $sql->execute();
        $sql = $sql->fetch(PDO::FETCH_ASSOC);
        $imagem = Sql::connect()->prepare("SELECT * FROM $tabela[2] WHERE produto_id = $c_key");
        $imagem->execute();
          // $imagem->debugDumpParams();
        $sql['imagem'] = $imagem->fetch(PDO::FETCH_ASSOC)['imagem'];
        $sql['qt'] = $c_value;
        $sql['preco_total'] = $sql['qt'] * $sql['preco'];
        $cart[$c_key] = $sql;
      // print_r($sql);
      // echo "<hr>";
      }
      // print_r($cart);

      $this->view->finalizarCarrinho($cart);
    }
  }

  class lojaView{
    public function __construct()
    {
      // $this->homePage();
      // $this->listForums();
      $this->stylesteet();
      // $this->homepage();
    }
    public function stylesteet(){
      ?>
      <style>
        main{
          /* background: #2196f3; */
        }
        main.loja *{
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          /* font-family: "Open Sans"; */
        }
        main.loja .container {
          max-width: 1100px;
          margin: 0 auto;
          padding: 0 2%;
        }
        main.loja .clear {
          clear: both;
        }
        main.loja header{
          background: #2196f3;
          height: 50px;
        }
        main.loja .logo{
          padding: 10px 0;
          float: left;
        }
        main.loja .logo a{
          font-size: 19px;
          letter-spacing: 3px;
          color: white;
          text-decoration: none;
          text-transform: uppercase;
        }
        main.loja nav.desktop{
          float: right;
        }
        main.loja nav.desktop li{
          font-weight: 300;
          display: inline-block;
        }
        main.loja nav.desktop a {
          display: inline-block;
          padding: 13px 15px;
          color: white;
          text-decoration: none;
          background: #4b4b4b;
        }
        main.loja .chamada-escolher{
          text-align: center;
          background: rbg(230,230,230);
          padding: 15px 0;
        }
        main.loja .chamada-escolher h2{
          color: rbg(180,180,180);
          font-weight: normal;
          font-size: 21px;
        }
        main.loja .lista-itens{
          display: flex;
          justify-content: space-between;
        }
        main.loja .produto-single-box{
          float: left;
          width: 33%;
          padding: 0 15px;
          border: 1px solid black;
          border-radius: 15px;
          text-align: center;
        }
        main.loja .produto-single-box a{
          display: inline-block;
          padding: 5px 15px;
          margin: 5px 0;
          color: white;
          text-decoration: none;
          background: #2196f3;
        }
        main.loja .produto-single-box img{
          width: 100%;
          border-bottom: 1px solid #cccccc;
        }
        main.loja .tabela-pedidos{
          margin-top: 40px;
        }
        main.loja .tabela-pedidos tr td img{
        max-width: 100px;
        }
        main.loja .tabela-pedidos h2{
          margin: 15px 0;
          border-bottom: 2px solid #ccc;
          font-size: 24px;
          color: #ccc;
        }
        main.loja .tabela-pedidos table{
          width: 100%;
          border-collapse: collapse;
          border: 1px solid #ccc;
        }
        main.loja .tabela-pedidos tr:first-child td{
          font-weight: bold;
        }
        main.loja .tabela-pedidos td{
          padding: 8px;
          border: 1px solid #ccc;
        }
        main.loja .finalizar-pedido h2{
          float: right;
        }
        main.loja .finalizar-pedido .btn-pagamento{
          display: inline-block;
          padding: 3px 10px;
          background: #2196f3;
          color: white;
          text-decoration: none;
          float: right;
        }
      </style>
      <?php
    }
    public function header(){
      $carrinho = lojaModel::getTotalItemsCarrinho();
      ?>
      <header>
        <div class="container">
          <div class="logo">
            <a href="<?php echo INCLUDE_PATH;?>loja">Loja virtual</a>
          </div>
            <nav class="desktop">
              <ul>
                <li><a href="javascript:void(0)">
                  <i class="fa-solid fa-cart-shopping"></i> Carrinho(<?php echo $carrinho;?>)</a></li>
                <li><a href="<?php echo INCLUDE_PATH;?>loja/finalizar">finalizar</a></li>
              </ul>
            </nav>
        </div>
      </header>
      <div class="chamada-escolher">
        <div class="container">
          <h2>Escolha seus produtos e compre agora!</h2>
        </div>
      </div>
      <!-- <h2>Bem-vindo ao nosso forum</h2> -->
      
      <?php
    }
    public function footer(){
      echo "<script src='https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js'></script>";
      echo "<script src='" . INCLUDE_PATH . "js/loja.js'></script>";
    }
    public function produtosBoxes($produtos){
      $this->header();
      echo '<div class="lista-itens container">';

      foreach ($produtos as $key => $value) {
        echo '<div class="produto-single-box">';
          echo "<img src='". INCLUDE_PATH ."painel/uploads/$value[imagem]'>";
          echo "<p>$value[nome]</p>";
          echo "<p>Preço: R$ ". Painel::converterMoedaBr($value['preco']) ."</p>";
          echo "<a href='". INCLUDE_PATH . "loja?addCart=$value[id]'>Adicionar no carrinho!</a>";
        echo '</div>';
      }

      echo '</div>';
    }
    public function finalizarCarrinho($carrinho){
      $this->header();
      $total = 0;
      // $carrinho = ['id' => 3, '', 'nome' => 'produto', 'preco' => '100.00'];
      // $carrinho = array($carrinho, $carrinho, $carrinho);
      // print_r($_SESSION['carrinho']);

      echo '<div class="tabela-pedidos container">';
      echo '<h2> <i class="fa fa-shopping-cart"></i> Carrinho : </h2>';
      echo '<table>';
      echo "<tr> 
              <td> </td> 
              <td><p> Descricao: </p></td> 
              <td><p> Preço: </p></td> 
              <td><p> Qt: </p></td> 
              <td> </td> 
            </tr>";

      foreach ($carrinho as $key => $value) {
        echo '<tr>';
          echo "<td><img src='". INCLUDE_PATH ."painel/uploads/$value[imagem]'></td>";
          echo "<td><p>$value[nome]</p></td>";
          echo "<td><p>R$ ". Painel::converterMoedaBr($value['preco']) ."</p></td>";
          echo "<td><p>$value[qt]</p></td>";
          echo "<td><p>R$ ". Painel::converterMoedaBr($value['preco_total']) ."</p></td>";
          // echo "<td><a href='". INCLUDE_PATH . "loja?addCart=$value[id]'>Adicionar no carrinho!</a></td>";
        echo '<tr>';
        $total += $value['preco_total'];
      }
      echo '</table></div>';

      echo "<div class='finalizar-pedido container'>";
        echo "<h2> Total: R$ ".Painel::converterMoedaBr($total)."</h2>";
        echo "<div class='clear'>";
        echo "<a href='' class='btn-pagamento'>Pagar agora!</a>";
      echo "</div>";

      $this->footer();
    }
    
  }

  
?>
</main>
