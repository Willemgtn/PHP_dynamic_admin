<?php
$pageTable = 'tb_admin.estoque';
$pageTableImg = 'tb_admin.estoque_imagens';
function pageUrl($next = null)
{
    $baseUrl = './estoque';
    // echo $baseUrl . $next;
    // return $baseUrl . $next;
    return $next ? $baseUrl . $next : $baseUrl;
}
$maxItemsPerPage = 6;

?>

<?php //if (isset($_GET['add'])) {
?>
<section id="" class="new-form">
    <h2>
        <i class="fa-solid fa-plus"></i>
        Cadastrar Produto
    </h2>
    <?php
    if (isset($_POST['submit'])) {
        // Painel::htmlPopUp('ok', 'O produto foi cadastrado com sucesso');
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $largura = $_POST['largura'];
        $altura = $_POST['altura'];
        $comprimento = $_POST['comprimento'];
        $peso = $_POST['peso'];
        $quantidade = $_POST['quantidade'];

        $ok = true;

        // $images;
        if ($_FILES['img']['name'][0] != '') {
            for ($i = 0; $i < count($_FILES['img']['name']); $i++) {
                $imagem = [
                    'name' => $_FILES['img']['name'][$i],
                    'type' => $_FILES['img']['type'][$i],
                    'tmp_name' => $_FILES['img']['tmp_name'][$i],
                    'error' => $_FILES['img']['error'][$i],
                    'size' => $_FILES['img']['size'][$i],
                ];
                if (FileUpload::arrImageValidate($imagem)) {
                    $imagens[] = $imagem;
                }
            }
            echo "Validated " . count($imagens) . " images";
            if (@$imagens) {
                // Painel::htmlPopUp('ok', 'continue');
                foreach ($imagens as $key => $value) {
                    $imagens[$key]['upload_name'] = FileUpload::arrImageUpload($value);
                }
                echo "<pre>";
                print_r($imagens);
                echo "</pre>";

                $sql = Sql::connect()->prepare("INSERT INTO `$pageTable` VALUES (null,?,?,?,?,?,?,?)");
                $sql->execute([$nome, $descricao, $largura, $altura, $comprimento, $peso, $quantidade]);
                $lastInsertedId = Sql::connect()->lastInsertId();
                foreach ($imagens as $key => $value) {
                    Sql::connect()->exec("INSERT INTO `$pageTableImg` VALUES (null,$lastInsertedId,'$value[upload_name]')");
                }
                Painel::htmlPopUp('ok', 'Produto Cadastrado');
            } else {
                Painel::htmlPopUp('error', 'Nenhuma foto selecionada é valida');
            }
        } else {
            Painel::htmlPopUp('error', 'Por favor selecione alguma foto');
        }
    }
    ?>
    <form class="" action="" method="post" enctype="multipart/form-data" resetar>
        <label for="nome">Nome do produto:</label>
        <input type="text" name="nome" id="" placeholder="Nome do Cliente/Empresa">
        <label for="descricao">Descrição do produto:</label>
        <textarea class="tiny" name="descricao" id="" cols="" rows=""></textarea>
        <!-- <input type="descricao" name="text" id="" placeholder="Descricao do produto"> -->
        <!-- <div class="form-row" style="display: flex;"> -->
        <label for="largura">Largura:</label>
        <input type="number" name="largura" id="" min="0" max="900" step="5" value="0">
        <label for="altura">Altura:</label>
        <input type="number" name="altura" id="" min="0" max="900" step="5" value="0">
        <label for="comprimento">Comprimento:</label>
        <input type="number" name="comprimento" id="" min="0" max="900" step="5" value="0">
        <label for="peso">Peso:</label>
        <input type="number" name="peso" id="" min="0" max="900" step="5" value="0">
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="" min="0" max="900" step="5" value="0">
        <!-- </div> -->

        <label for="img">Selecione as imagens:</label>
        <input multiple type="file" name="img[]" id="">
        <input type="submit" name="submit" value="Cadastrar">

    </form>
</section>
<?php // } 
?>
<section id="" class="">
    <h3>
        <i class="fa-solid fa-address-card"></i>
        Produtos
        <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
    </h3>
    <br>
    <div class="w100">
        <form action="" method="post" class="search d-flex" style="margin:20px 0;">
            <!-- <h4>Realize uma busca</h4> -->
            <input type="text" name="busca" id="" style="flex-grow:1;" placeholder="Realize uma busca pelo: nome ou descricao do produto">
            <input type="submit" value="Buscar">
        </form>
    </div>

    <?php
    // -----> SQL <-----
    if (isset($_POST['busca'])) {
        $busca = $_POST['busca'];
        $searchQuery = "WHERE nome LIKE '%$busca%' OR descricao LIKE '%$busca%' ";
    }
    $searchQuery = $searchQuery ?? null;
    // -----> SQL <-----
    $produtos = Sql::connect()->prepare("SELECT * from `$pageTable`  $searchQuery");
    $produtos->execute();
    $produtos = $produtos->fetchAll();
    // 
    if (isset($_POST['busca'])) {
        echo '<div class="busca-resultado"><p>Foram encontrados <b>' . count($produtos) . '</b> resultado(s)</p></div>';
    }

    ?>


    <!-- SQL fetchAll foreach template -->
    <div class="cardsWrapper">
        <!-- template -->
        <?php

        foreach ($produtos as $value) {


            // Fake demo filling
            // $value = ['id' => '0', 'nome' => 'Adriaan', 'email' => 'hotmail.gmail.com', 'tipo' => 'fisico2', 'inscricao' => '000.000.000-00'];
            // for ($i = 0; $i < 6; $i++) {

        ?>

            <div class="roundedBorders">
                <?php
                $sql = Sql::connect()->prepare("SELECT imagem FROM `$pageTableImg` WHERE produto_id = $value[id]");
                $sql->execute();
                $sql = $sql->fetchAll();
                // print_r($sql);
                foreach ($sql as $key => $img) {
                    echo "<img src='./uploads/$img[imagem]'>";
                }
                ?>
                <hr>
                <ul>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Nome:</strong>
                        <!-- PHP -->
                        <?php echo $value['nome'] ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Descrição:</strong>
                        <!-- PHP -->
                        <?php echo $value['descricao'] ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Largura:</strong>
                        <!-- PHP -->
                        <?php echo ucfirst($value['largura']) ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Altura:</strong>
                        <!-- PHP -->
                        <?php echo ucfirst($value['altura']) ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Comprimento:</strong>
                        <!-- PHP -->
                        <?php echo ucfirst($value['comprimento']) ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Peso:</strong>
                        <!-- PHP -->
                        <?php echo ucfirst($value['peso']) ?>
                    </li>
                    <li>
                        <strong>
                            <label for="quantidade">Quantidade:</label>
                        </strong>
                        <form action="" class="search d-flex" style="margin:0;">
                            <input type="number" name="quantidade" id="" value="<?php echo $value['quantidade'] ?>" style="padding-left:10px;" min="0" max="900" step="5">
                            <input type="submit" value="Atualizar" class="btn">
                        </form>
                    </li>
                    <hr style="margin:5px -10px;">
                    <div class="d-flex" style="margin:10px 0;">
                        <a class="btn edit" href="<?php echo pageUrl('?edit=' . $value['id']) ?>">edit</a>
                        <a class="btn red delete" href="<?php echo pageUrl('?delete=') ?>" item_id="<?php echo $value['id'] ?>">delete</a>
                    </div>
                </ul>

            </div>
        <?php } ?>

    </div>
</section>