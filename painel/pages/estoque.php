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

<?php if (isset($_GET['add'])) {
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
                // echo "Validated " . count($imagens) . " images";
                if (@$imagens) {
                    // Painel::htmlPopUp('ok', 'continue');
                    foreach ($imagens as $key => $value) {
                        $imagens[$key]['upload_name'] = FileUpload::arrImageUpload($value);
                    }
                    // echo "<pre>";
                    // print_r($imagens);
                    // echo "</pre>";

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
            <input type="text" name="nome" id="" placeholder="Nome do produto">
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
<?php  }
?>
<?php if (isset($_GET['edit'])) {
    $edit = (int)$_GET['edit'];


?>
    <section id="" class="new-form">
        <h2>
            <i class="fa-solid fa-pencil"></i>
            Alterar Produto
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

            $sql = Sql::connect()->prepare("UPDATE `$pageTable` SET nome=?, descricao=?, largura=?, altura=?, comprimento=?, peso=?, quantidade=? WHERE id = ?");
            $sql->execute([$nome, $descricao, $largura, $altura, $comprimento, $peso, $quantidade, $edit]);

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

                // echo "Validated " . count($imagens) . " images";
                if (@$imagens) {
                    // Painel::htmlPopUp('ok', 'continue');
                    foreach ($imagens as $key => $value) {
                        $imagens[$key]['upload_name'] = FileUpload::arrImageUpload($value);
                    }
                    // echo "<pre>";
                    // print_r($imagens);
                    // echo "</pre>";


                    foreach ($imagens as $key => $value) {
                        Sql::connect()->exec("INSERT INTO `$pageTableImg` VALUES (null,$edit,'$value[upload_name]')");
                    }
                    Painel::htmlPopUp('ok', 'Produto foi Atualizado');
                } else {
                    Painel::htmlPopUp('error', 'Nenhuma foto selecionada é valida');
                }
            }
            // else {
            // No image to add
            //     Painel::htmlPopUp('error', 'Por favor selecione alguma foto');
            // }
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
        $productInfo = Sql::connect()->query("SELECT * FROM `$pageTable` WHERE id = $edit");
        $productInfo = $productInfo->fetch();
        // Image SQL QUERY
        $productInfoImg = Sql::connect()->query("SELECT * FROM `$pageTableImg` WHERE produto_id = $edit");
        $productInfoImg = $productInfoImg->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="productInfoImg">
            <?php
            foreach ($productInfoImg as $key => $value) {
                // for ($i = 0; $i < 10; $i++) {
                echo "<div><img src='./uploads/$value[imagem]'><a href='estoque?edit=$edit&deleteImg=$value[id]'>X Excluir</a></div>";
                // }
            }
            ?>
        </div>
        <form class="" action="" method="post" enctype="multipart/form-data" resetar>
            <label for="nome">Nome do produto:</label>
            <input type="text" name="nome" id="" placeholder="Nome do produto" value="<?php echo $productInfo['nome'] ?>">
            <label for="descricao">Descrição do produto:</label>
            <textarea class="tiny" name="descricao" id="" cols="" rows=""><?php echo $productInfo['descricao'] ?></textarea>
            <!-- <input type="descricao" name="text" id="" placeholder="Descricao do produto"> -->
            <!-- <div class="form-row" style="display: flex;"> -->
            <label for="largura">Largura:</label>
            <input type="number" name="largura" id="" min="0" max="900" step="5" value="<?php echo $productInfo['largura'] ?>">
            <label for="altura">Altura:</label>
            <input type="number" name="altura" id="" min="0" max="900" step="5" value="<?php echo $productInfo['altura'] ?>">
            <label for="comprimento">Comprimento:</label>
            <input type="number" name="comprimento" id="" min="0" max="900" step="5" value="<?php echo $productInfo['comprimento'] ?>">
            <label for="peso">Peso:</label>
            <input type="number" name="peso" id="" min="0" max="900" step="5" value="<?php echo $productInfo['peso'] ?>">
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="" min="0" max="900" step="5" value="<?php echo $productInfo['quantidade'] ?>">
            <!-- </div> -->

            <label for="img">Selecione as imagens:</label>
            <input multiple type="file" name="img[]" id="">
            <input type="submit" name="submit" value="Alterar">

        </form>
    </section>
<?php  }
?>
<?php if (!isset($_GET['pendentes'])) {
?>
    <section id="" class="">
        <h3>
            <i class="fa-solid fa-address-card"></i>
            Produtos
            <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
        </h3>
        <br>

        <?php
        $sql = Sql::connect()->prepare("SELECT * FROM `$pageTable` WHERE quantidade = 0");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            Painel::htmlPopUp('warn', "Há produtos em falta no estoque! Clique <a href='./estoque?pendentes'>Aqui</a> para visualiza-los!");
        }
        // Painel::htmlPopUp('warn', "Há produtos em falta no estoque! Clique <a href='./estoque?pendentes'>Aqui</a> para visualiza-los!");

        ?>
        <div class="w100">
            <form action="" method="post" class="search d-flex" style="margin:20px 0;">
                <!-- <h4>Realize uma busca</h4> -->
                <input type="text" name="busca" id="" style="flex-grow:1;" placeholder="Realize uma busca pelo: nome ou descricao do produto">
                <input type="submit" value="Buscar">
            </form>
        </div>

        <?php
        if (isset($_POST['atualizar'])) {
            $quantidade = $_POST['quantidade'];
            $produto_id = $_POST['produto_id'];
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
        if (isset($_GET['delete'])) {
            $delete = (int)$_GET['delete'];
            if (is_int(intval($_GET['delete']))) {
                $product = Sql::connect()->prepare("SELECT id FROM `$pageTable` WHERE id = ?");
                $product->execute([$delete]);
                // echo $product->rowCount();
                if ($product->rowCount() == 1) {
                    // product exists, proceed to delete it.
                    $productImages = Sql::connect()->prepare("SELECT imagem FROM `$pageTableImg` WHERE produto_id = ?");
                    $productImages->execute([$delete]);
                    $productImages = $productImages->fetchAll();
                    foreach ($productImages as $key => $value) {
                        // echo "<img src='./uploads/$value[imagem]'>";
                        @unlink('./uploads/' . $value['imagem']);
                    }


                    $productImages = Sql::connect()->prepare("DELETE FROM `$pageTableImg` WHERE produto_id = ?");
                    $productImages->execute([$delete]);
                    $product = Sql::connect()->prepare("DELETE FROM `$pageTable` WHERE id = ?");
                    $product->execute([$delete]);
                    Painel::htmlPopUp('ok', 'Product and images were deleted.');
                }
                // print_r($product->fetch());
            } else {
                Painel::htmlPopUp('error', 'Sql injection?');
            }
        }
        // -----> SQL <-----
        if (isset($_POST['busca'])) {
            $busca = $_POST['busca'];
            $searchQuery = "AND (nome LIKE '%$busca%' OR descricao LIKE '%$busca%') ";
        }
        $searchQuery = $searchQuery ?? null;
        // -----> SQL <-----
        $produtos = Sql::connect()->prepare("SELECT * from `$pageTable` WHERE quantidade > 0 $searchQuery");
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
                            cm
                        </li>
                        <li><i class="fa-solid fa-pencil"></i>
                            <strong>Altura:</strong>
                            <!-- PHP -->
                            <?php echo ucfirst($value['altura']) ?>
                            cm
                        </li>
                        <li><i class="fa-solid fa-pencil"></i>
                            <strong>Comprimento:</strong>
                            <!-- PHP -->
                            <?php echo ucfirst($value['comprimento']) ?>
                            cm
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
                            <form action="" method="post" class="search d-flex" style="margin:0;">
                                <input type="number" name="quantidade" id="" value="<?php echo $value['quantidade'] ?>" style="padding-left:10px;" min="0" max="900" step="5">
                                <input type="hidden" name="produto_id" value="<?php echo $value['id'] ?>">
                                <input type="submit" name="atualizar" value="Atualizar" class="btn">
                            </form>
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
<?php  } else {
?>
    <section id="" class="">
        <h3>
            <i class="fa-solid fa-address-card"></i>
            <a href="<?php echo pageUrl() ?>">Produtos</a>
            > Produtos em falta
            <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
        </h3>
        <br>

        <?php
        $sql = Sql::connect()->prepare("SELECT * FROM `$pageTable` WHERE quantidade = 0");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            Painel::htmlPopUp('warn', "Há produtos em falta no estoque! Clique <a href='./estoque?pendentes'>Aqui</a> para visualiza-los!");
        }
        // Painel::htmlPopUp('warn', "Há produtos em falta no estoque! Clique <a href='./estoque?pendentes'>Aqui</a> para visualiza-los!");

        ?>
        <div class="w100">
            <form action="" method="post" class="search d-flex" style="margin:20px 0;">
                <!-- <h4>Realize uma busca</h4> -->
                <input type="text" name="busca" id="" style="flex-grow:1;" placeholder="Realize uma busca pelo: nome ou descricao do produto">
                <input type="submit" value="Buscar">
            </form>
        </div>

        <?php
        if (isset($_POST['atualizar'])) {
            $quantidade = $_POST['quantidade'];
            $produto_id = $_POST['produto_id'];
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
        if (isset($_GET['delete'])) {
            $delete_id = (int)$_GET['delete'];
            // if($id){//Proceed}
            if (is_int(intval($_GET['delete']))) {
                $product = Sql::connect()->prepare("SELECT id FROM `$pageTable` WHERE id = ?");
                $product->execute([$deleteId]);
                // echo $product->rowCount();
                if ($product->rowCount() == 1) {
                    // product exists, proceed to delete it.
                    $productImages = Sql::connect()->prepare("SELECT imagem FROM `$pageTableImg` WHERE produto_id = $deleteId");
                    $productImages->execute([$_GET['delete']]);
                    $productImages = $productImages->fetchAll();
                    foreach ($productImages as $key => $value) {
                        // echo "<img src='./uploads/$value[imagem]'>";
                        @unlink('./uploads/' . $value['imagem']);
                    }

                    $productImages = Sql::connect()->exec("DELETE FROM `$pageTableImg` WHERE produto_id = $clienteId");
                    // $productImages->execute([$_GET['delete']]);
                    $product = Sql::connect()->exec("DELETE FROM `$pageTable` WHERE id = $deleteId");
                    // $product->execute([$_GET['delete']]);
                    Painel::htmlPopUp('ok', 'Product and images were deleted.');
                }
                // print_r($product->fetch());
            } else {
                Painel::htmlPopUp('error', 'Sql injection?');
            }
        }
        // -----> SQL <-----
        if (isset($_POST['busca'])) {
            $busca = $_POST['busca'];
            $searchQuery = "AND (nome LIKE '%$busca%' OR descricao LIKE '%$busca%') ";
        }
        $searchQuery = $searchQuery ?? null;
        // -----> SQL <-----
        $produtos = Sql::connect()->prepare("SELECT * from `$pageTable` WHERE quantidade = 0 $searchQuery");
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
                            cm
                        </li>
                        <li><i class="fa-solid fa-pencil"></i>
                            <strong>Altura:</strong>
                            <!-- PHP -->
                            <?php echo ucfirst($value['altura']) ?>
                            cm
                        </li>
                        <li><i class="fa-solid fa-pencil"></i>
                            <strong>Comprimento:</strong>
                            <!-- PHP -->
                            <?php echo ucfirst($value['comprimento']) ?>
                            cm
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
                            <form action="" method="post" class="search d-flex" style="margin:0;">
                                <input type="number" name="quantidade" id="" value="<?php echo $value['quantidade'] ?>" style="padding-left:10px;" min="0" max="900" step="5">
                                <input type="hidden" name="produto_id" value="<?php echo $value['id'] ?>">
                                <input type="submit" name="atualizar" value="Atualizar" class="btn">
                            </form>
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
<?php  }
?>