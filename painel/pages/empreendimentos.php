<?php
UsersMod::verifyPermission(1);

$pageTable = 'tb_admin.empreendimentos';
$pageTableImg = 'tb_admin.empreendimentos_imagens';
function pageUrl($next = null)
{
    $baseUrl = './empreendimentos';
    // echo $baseUrl . $next;
    // return $baseUrl . $next;
    return $next ? $baseUrl . $next : $baseUrl;
}
$maxItemsPerPage = 6;


?>

<?php // if (isset($_GET['add'])) {
?>

<!-- Addicionar Empreendimentos -->

<section id="" class="new-form">
    <h2>
        <i class="fa-solid fa-plus"></i>
        Cadastrar Empreendimento
    </h2>
    <?php
    if (isset($_POST['submit'])) {
        // Painel::htmlPopUp('ok', 'O produto foi cadastrado com sucesso');
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];
        $preco = $_POST['preco'];
        $imagem = $_FILES['img'];

        // print_r($imagem);
        if ($nome != '' and $preco != '') {
            if ($_FILES['img']['name'] == '') {
                Painel::htmlPopUp('error', 'Selecione uma imagem por favor.');
            } else {

                // Imagem é valida?
                if (!FileUpload::arrImageValidate($imagem)) {
                    Painel::htmlPopUp('error', 'A imagem selecionada não é valida');
                } else {
                    $imgName = FileUpload::arrImageUpload($imagem);
                    if (isset($imgName)) {
                        $lastId = Sql::connect()->query("SELECT id from `$pageTable` ORDER BY id DESC LIMIT 1")->fetch()[0];
                        $sql = Sql::connect()->prepare("INSERT INTO `$pageTable` VALUES  (null,?,?,?,?,?)");
                        $sql->execute([$nome, $tipo, $preco, $imgName, $lastId + 1]);
                        Painel::htmlPopUp('ok', 'Empreendimento cadastrado');
                    }
                }
            }
        } else {
            Painel::htmlPopUp('error', 'Titulo e preço são exigidos');
        }
    }
    ?>
    <form class="" action="" method="post" enctype="multipart/form-data" resetar>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="" placeholder="Nome do empreendimento">

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="">
            <option value="residencial">Residencial</option>
            <option value="comercial">Comercial</option>
        </select>
        <label for="preco">Preço:</label>
        <input type="text" name="preco" id="" Placeholder="" mask="brl">

        <label for="img">Selecione as imagens:</label>
        <input multiple type="file" name="img" id="">
        <input type="submit" name="submit" value="Cadastrar">

    </form>
</section>
<?php // } 
?>

<!-- Listar Empreendimentos -->

<section id="" class="">
    <h3>
        <i class="fa-solid fa-address-card"></i>
        Empreendimentos
        <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
    </h3>
    <br>

    <?php
    // $sql = Sql::connect()->prepare("SELECT * FROM `$pageTable` ");
    // $sql->execute();
    // if ($sql->rowCount() > 0) {
    //     Painel::htmlPopUp('warn', "Há empreendimentos em falta no estoque! Clique <a href='./estoque?pendentes'>Aqui</a> para visualiza-los!");
    // }
    // Painel::htmlPopUp('warn', "Há empreendimentos em falta no estoque! Clique <a href='./estoque?pendentes'>Aqui</a> para visualiza-los!");

    ?>
    <div class="w100">
        <form action="" method="post" class="search d-flex" style="margin:20px 0;">
            <!-- <h4>Realize uma busca</h4> -->
            <input type="text" name="busca" id="" style="flex-grow:1;" placeholder="Realize uma busca pelo: nome ou descricao do produto">
            <input type="submit" value="Buscar">
        </form>
    </div>

    <?php

    if (isset($_GET['delete'])) {
        $delete = (int)$_GET['delete'];
        if (is_int(intval($_GET['delete']))) {
            $empreendimento = Sql::connect()->prepare("SELECT id, imagem FROM `$pageTable` WHERE id = ?");
            $empreendimento->execute([$delete]);
            // echo $empreendimento->rowCount();
            if ($empreendimento->rowCount() == 1) {
                $value = $empreendimento->fetch();
                @unlink('./uploads/' . $value['imagem']);
                $empreendimento = Sql::connect()->prepare("DELETE FROM `$pageTable` WHERE id = ?");
                $empreendimento->execute([$delete]);
                Painel::htmlPopUp('ok', 'empreendimento and image were deleted.');
                // }

            }
            // print_r($empreendimentos->fetch());
        } else {
            Painel::htmlPopUp('error', 'Sql injection?');
        }
    }
    // -----> SQL <-----
    if (isset($_POST['busca'])) {
        $busca = $_POST['busca'];
        $searchQuery = "WHERE (nome LIKE '%$busca%' ) ";
    }
    $searchQuery = $searchQuery ?? null;
    // -----> SQL <-----
    $empreendimentos = Sql::connect()->prepare("SELECT * from `$pageTable`  $searchQuery ORDER BY order_id ASC");
    $empreendimentos->execute();
    $empreendimentos = $empreendimentos->fetchAll();
    // 
    if (isset($_POST['busca'])) {
        echo '<div class="busca-resultado"><p>Foram encontrados <b>' . count($empreendimentos) . '</b> resultado(s)</p></div>';
    }



    ?>


    <!-- SQL fetchAll foreach template -->
    <div class="cardsWrapper">
        <!-- template -->
        <?php
        foreach ($empreendimentos as $value) {
        ?>

            <div class="boxes" id="item_<?php echo $value['id'] ?>">
                <?php
                // $sql = Sql::connect()->prepare("SELECT imagem FROM `$pageTableImg` WHERE produto_id = $value[id]");
                // $sql->execute();
                // $sql = $sql->fetchAll();
                // // print_r($sql);
                // foreach ($sql as $key => $img) {
                //     echo "<img src='./uploads/$img[imagem]'>";
                // }
                echo "<img src='./uploads/$value[imagem]'>";
                ?>
                <hr>
                <ul>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Nome:</strong>
                        <!-- PHP -->
                        <?php echo $value['nome'] ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Tipo:</strong>
                        <!-- PHP -->
                        <?php echo $value['tipo'] ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Preço:</strong>
                        <!-- PHP -->
                        <?php echo ucfirst($value['preco']) ?>
                    </li>


                    <hr style="margin:5px -10px;">
                    <div class="d-flex" style="margin:10px 0;">
                        <a class="btn edit" href="<?php echo pageUrl('?edit=' . $value['id']) ?>">edit</a>
                        <a class="btn red delete" href="<?php echo pageUrl('?delete=' . $value['id']) ?>" item_id="<?php echo $value['id'] ?>">delete</a>
                    </div>
                </ul>

            </div>
        <?php } ?>

    </div>
</section>

<link rel="stylesheet" href="./css/jquery-ui.min.css">