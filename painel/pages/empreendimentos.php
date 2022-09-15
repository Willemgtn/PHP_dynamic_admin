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

<?php if (isset($_GET['add'])) {
?>

    <!-- Addicionar Empreendimento -->

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
<?php }
?>
<!-- Editar Empreendimento -->
<?php if (isset($_GET['edit'])) {
    $edit = (int)$_GET['edit'];


?>
    <section id="" class="new-form">
        <h2>
            <i class="fa-solid fa-pencil"></i>
            Alterar Empreendimento
        </h2>
        <?php
        if (isset($_POST['submit'])) {
            // Painel::htmlPopUp('ok', 'O produto foi cadastrado com sucesso');
            $nome = $_POST['nome'];
            $tipo = $_POST['tipo'];
            $preco = $_POST['preco'];
            $imagem = $_FILES['img'];
            $old_image = Sql::connect()->query("SELECT imagem FROM `$pageTable` WHERE id = $edit")->fetch()['imagem'];
            $ok = true;

            $imagem = FileUpload::validadeImage('img') ? $imagem : null;
            if ($imagem) {
                $imagem = FileUpload::uploadImage('img');
                unlink('uploads/' . $old_image);
            }

            $imagem = $imagem ?? $old_image;

            $sql = Sql::connect()->prepare("UPDATE `$pageTable` SET nome=?, tipo=?, preco=?, imagem=? WHERE id = ?");
            if ($sql->execute([$nome, $tipo, $preco, $imagem, $edit])) {


                Painel::htmlPopUp('ok', 'Empreendimento foi Atualizado');
            } else {
                Painel::htmlPopUp('error', 'Todos os campos são obrigatorios');
            }
        }

        if (isset($_POST['atualizar'])) {
            $quantidade = (int)$_POST['quantidade'];
            $produto_id = (int)$_POST['produto_id'];
            if ($quantidade < 0) {
                Painel::htmlPopUp('error', 'Me explique como você ficou devendo mercadorias');
            } else {
                $update = Sql::connect()->prepare("UPDATE `$pageTable` SET quantidade = ? WHERE id = ?");
                if ($update->execute([$quantidade, $produto_id])) {
                    Painel::htmlPopUp('ok', 'Atualizado com sucesso');
                } else {
                    Painel::htmlPopUp('error', 'Erro Interno');
                }
            }
        }
        if (isset($_GET['deleteImg'])) {
            $delete = (int)$_GET['deleteImg'];
            if (is_int(intval($_GET['deleteImg']))) {
                $product = Sql::connect()->prepare("SELECT id FROM `$pageTable` WHERE id = ?");
                $product->execute([$edit]);
                // echo $product->rowCount();
                if ($product->rowCount() == 1) {
                    // product exists, proceed to delete it.
                    $productImages = Sql::connect()->prepare("SELECT imagem FROM `$pageTableImg` WHERE id = ?");
                    $productImages->execute([$delete]);
                    $productImages = $productImages->fetchAll();
                    foreach ($productImages as $key => $value) {
                        // echo "<img src='./uploads/$value[imagem]'>";
                        @unlink('./uploads/' . $value['imagem']);
                    }


                    $productImages = Sql::connect()->prepare("DELETE FROM `$pageTableImg` WHERE id = ?");
                    $productImages->execute([$delete]);

                    Painel::htmlPopUp('ok', 'Images was deleted.');
                }
                // print_r($product->fetch());
            } else {
                Painel::htmlPopUp('error', 'Sql injection?');
            }
        }
        // Product SQL QUERY
        $empreendimento = Sql::connect()->query("SELECT * FROM `$pageTable` WHERE id = $edit");
        $empreendimento = $empreendimento->fetch();
        // Image SQL QUERY
        // $productInfoImg = Sql::connect()->query("SELECT * FROM `$pageTableImg` WHERE produto_id = $edit");
        // $productInfoImg = $productInfoImg->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="productInfoImg">
            <div style="height: 100%;">
                <?php
                // foreach ($productInfoImg as $key => $value) {
                // for ($i = 0; $i < 10; $i++) {
                echo "<img src='./uploads/$empreendimento[imagem]'>";
                // echo "<a href='estoque?edit=$edit&deleteImg=$empreendimento[id]'>X Excluir</a></div>";
                // }
                // }
                ?>
            </div>
            <form class="" action="" method="post" enctype="multipart/form-data" style="flex-grow:1; margin-left:10px;">
                <label style="margin-top:0" for="nome">Nome:</label>
                <input type="text" name="nome" id="" placeholder="Nome do empreendimento" value="<?php echo $empreendimento['nome'] ?>">

                <label for="tipo">Tipo:</label>
                <select name="tipo" id="">
                    <option value="residencial" <?php echo $empreendimento == 'residencial' ? 'selected' : '' ?>>Residencial</option>
                    <option value="comercial" <?php echo $empreendimento == 'comercial' ? 'selected' : '' ?>>Comercial</option>
                </select>
                <label for="preco">Preço:</label>
                <input type="text" name="preco" id="" Placeholder="" mask="brl" value="<?php echo $empreendimento['preco'] ?>">

                <label for="img">Selecione as imagens:</label>
                <input multiple type="file" name="img" id="">
                <input type="submit" name="submit" value="Atualizar">

            </form>
        </div>
    </section>
<?php  }
?>

<!-- Listar Empreendimentos -->

<section id="" class="">
    <h2>
        <i class="fa-solid fa-address-card"></i>
        Empreendimentos
        <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
    </h2>
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
                        <a class="btn blue" href="<?php echo './imoveis?view=' . $value['id'] ?>">view</a>
                        <a class="btn red delete" href="<?php echo pageUrl('?delete=' . $value['id']) ?>" item_id="<?php echo $value['id'] ?>">delete</a>
                    </div>
                </ul>

            </div>
        <?php } ?>

    </div>
</section>

<link rel="stylesheet" href="./css/jquery-ui.min.css">