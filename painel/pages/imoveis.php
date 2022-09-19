<?php
$pageTable = 'tb_admin.imoveis';
$pageTableImg = 'tb_admin.imoveis_imagens';
function pageUrl($next = null)
{
    $baseUrl = './imoveis';
    // echo $baseUrl . $next;
    // return $baseUrl . $next;
    return $next ? $baseUrl . $next : $baseUrl;
}
$maxItemsPerPage = 6;
?>



<!-- Visualizar Imoveis referente ao Empreendimento -->
<?php
if (!isset($_GET['view'])) {
    header('Location: ./empreendimentos');
}
if (isset($_GET['view'])) {
    $view = (int)$_GET['view'];

    $empreendimento = Sql::connect()->query("SELECT * FROM `tb_admin.empreendimentos` WHERE id = $view")->fetch();
    // $empreendimento = $empreendimento->fetch();
    // $imoveis = Sql::connect()->query("SELECT * FROM `$pageTable` WHERE empreendimento_id = $view")->fetchAll();
    // $imoveis = [];
    // for ($i = 0; $i < 10; $i++) {
    //     $imoveis[] = [
    //         'id' => $i,
    //         'nome' => "Imovel $i",
    //         'preco' => '10.000,00',
    //         'area' => '1000'
    //     ];
    // }
    // $empreendimentos = Sql::connect()->query("SELECT id, nome FROM `tb_admin.empreendimentos`")->fetchAll();

    //  Adicionar um imovel ao empreendimento
    if (isset($_GET['add'])) {
?>

        <section class="new-form">
            <h2>
                <i class="fa-solid fa-pencil"></i>
                Adicionar um imovel a um empreendimento
            </h2>
            <?php
            if (isset($_POST['submit'])) {
                $nome = $_POST['nome'];
                $empre_id = $_POST['empreendimento'];
                // $preco = number_format($_POST['preco'], 2, '.', ',');
                $preco = $_POST['preco'];
                $area = $_POST['area'];

                $preco = str_replace('.', '', $preco);
                $preco = str_replace(',', '.', $preco);

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
                    // echo "<pre>";
                    // print_r($_POST);
                    // print_r($imagens);
                    // echo "</pre>";

                    // echo "Validated " . count($imagens) . " images";
                    if (@$imagens) {
                        $sql = Sql::connect()->prepare("INSERT INTO `$pageTable` VALUES (null,?,?,?,?)");
                        $sql->execute([$empre_id, $nome, $preco, $area]);



                        // Painel::htmlPopUp('ok', 'continue');
                        foreach ($imagens as $key => $value) {
                            $imagens[$key]['upload_name'] = FileUpload::arrImageUpload($value);
                        }
                        // echo "<pre>";
                        // print_r($imagens);
                        // echo "</pre>";

                        $lastId = Sql::connect()->lastInsertId();

                        foreach ($imagens as $key => $value) {
                            Sql::connect()->exec("INSERT INTO `$pageTableImg` VALUES (null,$lastId,'$value[upload_name]')");
                        }
                        Painel::htmlPopUp('ok', 'Produto foi Atualizado');
                    } else {
                        Painel::htmlPopUp('error', 'Nenhuma foto selecionada é valida');
                    }
                } else {
                    Painel::htmlPopUp('error', 'Selecione pelo menos uma imagem');
                }
            }
            ?>
            <form class="" action="" method="post" enctype="multipart/form-data" style="flex-grow:1; margin-left:10px;">
                <label style="margin-top:0" for="nome">Nome:</label>
                <input type="text" name="nome" id="" placeholder="Nome do imovel">

                <!-- <label for="empreendimento">Empreendimento:</label> -->
                <input type="hidden" name="empreendimento" value="<?php echo $view ?>">
                <!-- <select name="empreendimento" id=""> -->
                <?php
                // foreach ($empreendimentos as $key => $value) {
                //     $nome_empre = ucfirst($value['nome']);
                //     echo "<option value='$value[id]'>$nome_empre</option>";
                // }
                ?>
                <!-- <option value="residencial">Residencial</option>
                    <option value="comercial">Comercial</option> -->
                <!-- </select> -->

                <label for="preco">Preço:</label>
                <input type="text" name="preco" id="" Placeholder="" mask="brl" ">
                <label for=" area">Area:</label>
                <input type="text" name="area" id="" Placeholder="">

                <label for=" img">Selecione as imagens:</label>
                <input multiple type="file" name="img[]" id="">
                <input type="submit" name="submit" value="Cadastrar">

            </form>
        </section>
    <?php
        // Editing imoveis 
    } else if (isset($_GET['edit'])) {
        $edit = (int)$_GET['edit'];

    ?>
        <section class="new-form">
            <h2>
                <i class="fa-solid fa-pencil"></i>
                Editar imovel em empreendimento
            </h2>

            <?php
            if (isset($_POST['submit'])) {
                $nome = $_POST['nome'];
                $empre_id = $_POST['empreendimento'];
                $preco = $_POST['preco'];
                $area = $_POST['area'];

                $preço = str_replace('.', '', $preco);
                $preço = str_replace(',', '.', $preco);

                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";

                $sql = Sql::connect()->prepare("UPDATE `$pageTable` SET nome=?, preco=?, area=? WHERE id = ?");
                $sql->execute([$nome, $preco, $area, $edit]);

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
            }
            if (isset($_GET['deleteImg'])) {
                $delete = (int)$_GET['deleteImg'];
                if (is_int(intval($_GET['deleteImg']))) {
                    $imovel = Sql::connect()->prepare("SELECT id FROM `$pageTable` WHERE id = ?");
                    $imovel->execute([$edit]);
                    // echo $product->rowCount();
                    if ($imovel->rowCount() == 1) {
                        // imovel exists, proceed to delete img.
                        $imovelImg = Sql::connect()->prepare("SELECT imagem FROM `$pageTableImg` WHERE id = ?");
                        $imovelImg->execute([$delete]);
                        // print_r($imovelImg);
                        if ($imovelImg->rowCount() == 1) {
                            $imovelImages = Sql::connect()->prepare("SELECT imagem FROM `$pageTableImg` WHERE id = ?");
                            $imovelImages->execute([$delete]);
                            $imovelImages = $imovelImages->fetchAll();
                            foreach ($imovelImages as $key => $value) {
                                // echo "<img src='./uploads/$value[imagem]'>";
                                @unlink('./uploads/' . $value['imagem']);
                            }


                            $imovelImages = Sql::connect()->prepare("DELETE FROM `$pageTableImg` WHERE id = ?");
                            $imovelImages->execute([$delete]);

                            Painel::htmlPopUp('ok', 'Images was deleted.');
                        }
                    }
                    // print_r($product->fetch());
                } else {
                    Painel::htmlPopUp('error', 'Sql injection?');
                }
            }
            $imovel = Sql::connect()->query("SELECT * FROM `$pageTable` WHERE empreendimento_id = $view AND id = $edit")->fetch();

            $imovelImg = Sql::connect()->query("SELECT * FROM `$pageTableImg` WHERE imovel_id = $edit");
            $imovelImg = $imovelImg->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="productInfoImg">
                <?php
                foreach ($imovelImg as $key => $value) {
                    // for ($i = 0; $i < 10; $i++) {
                    echo "<div><img src='./uploads/$value[imagem]'><a href='imoveis?view=$view&edit=$edit&deleteImg=$value[id]'>X Excluir</a></div>";
                    // }
                }
                ?>
            </div>

            <form class="" action="" method="post" enctype="multipart/form-data" style="flex-grow:1; margin-left:10px;">
                <label style="margin-top:0" for="nome">Nome:</label>
                <input type="text" name="nome" id="" placeholder="Nome do imovel" value="<?php echo $imovel['nome'] ?>">

                <!-- <label for="empreendimento">Empreendimento:</label> -->
                <input type="hidden" name="empreendimento" value="<?php echo $view ?>">
                <!-- <select name="empreendimento" id=""> -->
                <?php
                // foreach ($empreendimentos as $key => $value) {
                //     $nome_empre = ucfirst($value['nome']);
                //     echo "<option value='$value[id]'>$nome_empre</option>";
                // }
                ?>
                <!-- <option value="residencial">Residencial</option>
                    <option value="comercial">Comercial</option> -->
                <!-- </select> -->

                <label for="preco">Preço:</label>
                <input type="text" name="preco" id="" Placeholder="" mask="brl" value="<?php echo $imovel['preco'] ?>">
                <label for=" area">Area:</label>
                <input type="text" name="area" id="" Placeholder="" value="<?php echo $imovel['area'] ?>">

                <label for=" img">Selecione as imagens:</label>
                <input multiple type="file" name="img[]" id="">
                <input type="submit" name="submit" value="Atualizar">

            </form>
        </section>
    <?php
    }
    ?>
    <section id="" class="new-form">
        <h2>
            <i class="fa-solid fa-pencil"></i>
            Visuar imoveis do Empreendimento
            <a style="float: right;" class="btn green" href="<?php echo pageUrl("?view=$view&add"); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
            <div class="clear"></div>
        </h2>
        <?php
        if (isset($_GET['delete'])) {
            $delete = (int)$_GET['delete'];
            if (is_int(intval($_GET['delete']))) {
                $imovel = Sql::connect()->prepare("SELECT id FROM `$pageTable` WHERE id = ?");
                $imovel->execute([$delete]);
                // print_r($imovel);
                // echo "<br>";
                // echo $product->rowCount();
                if ($imovel->rowCount() == 1) {
                    // product exists, proceed to delete it.
                    $imovelImages = Sql::connect()->prepare("SELECT imagem FROM `$pageTableImg` WHERE imovel_id = ?");
                    $imovelImages->execute([$delete]);
                    // $imovelImages->debugDumpParams();
                    // echo "<br>";
                    $imovelImages = $imovelImages->fetchAll();
                    // print_r($imovelImages);
                    // echo "<br>";
                    foreach ($imovelImages as $key => $value) {
                        echo "<img src='./uploads/$value[imagem]'>";
                        @unlink('./uploads/' . $value['imagem']);
                    }


                    $imovelImages = Sql::connect()->prepare("DELETE FROM `$pageTableImg` WHERE imovel_id = ?");
                    $imovelImages->execute([$delete]);
                    $sql = SQL::connect()->prepare("DELETE FROM `$pageTable` WHERE id = ?")->execute([$delete]);

                    Painel::htmlPopUp('ok', 'Imovel foi deletado.');
                }
                // print_r($product->fetch());
            } else {
                Painel::htmlPopUp('error', 'Sql injection?');
            }
        }

        // Product SQL QUERY
        // $empreendimento = Sql::connect()->query("SELECT * FROM `tb_admin.empreendimentos` WHERE id = $view");
        // $empreendimento = $empreendimento->fetch();
        // Image SQL QUERY
        // $productInfoImg = Sql::connect()->query("SELECT * FROM `$pageTableImg` WHERE produto_id = $edit");
        // $productInfoImg = $productInfoImg->fetchAll(PDO::FETCH_ASSOC);
        $imoveis = Sql::connect()->query("SELECT * FROM `$pageTable` WHERE empreendimento_id = $view")->fetchAll();
        ?>

        <div class="productInfoImg">
            <div style="height: 100%; padding: 8px">
                <div>head</div>
                <hr>
                <?php
                echo "<img src='./uploads/$empreendimento[imagem]'>";
                ?>
            </div>
            <div style="flex-grow:1; text-align: left; padding: 8px;">
                <div>head</div>
                <hr>
                <p>Nome: <?php echo $empreendimento['nome'] ?></p>
                <hr>
                <p>Tipo: <?php echo $empreendimento['tipo'] ?></p>
                <hr>
            </div>
        </div>
        <br>
        <br>
        <div>
            <table class="w100" style="">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <!-- <td>Empreendimento</td> -->
                        <td>Preço</td>
                        <td>Area</td>
                        <td>#</td>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($imoveis as $key => $value) {
                        echo '<tr>';
                        echo "<td> $value[nome] </td>";
                        echo "<td> R$ " . number_format($value['preco'], 2, '.', ',') . "</td>";
                        echo "<td> $value[area] M² </td>";
                        echo "<td> <a class='btn edit' href='./imoveis?view=$view&edit=$value[id]'>Edit</a> <a confirm class='btn red' href='./imoveis?view=$view&delete=$value[id]'>delete</a> </td>";
                        echo '</tr>';
                    }
                    // $imoveis
                    ?>
                </tbody>
            </table>
        </div>
    </section>
<?php  } ?>