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
<?php if (isset($_GET['view'])) {
    $view = (int)$_GET['view'];

    $empreendimento = Sql::connect()->query("SELECT * FROM `tb_admin.empreendimentos` WHERE id = $view")->fetch();
    // $empreendimento = $empreendimento->fetch();
    $imoveis = Sql::connect()->query("SELECT * FROM `$pageTable` WHERE empreendimento_id = $view")->fetchAll();
    $imoveis = [];
    for ($i = 0; $i < 10; $i++) {
        $imoveis[] = [
            'id' => $i,
            'nome' => "Imovel $i",
            'preco' => '10.000,00',
            'area' => '1000'
        ];
    }
    $empreendimentos = Sql::connect()->query("SELECT id, nome FROM `tb_admin.empreendimentos`")->fetchAll();

    //  Adicionar um imovel ao empreendimento
    if (isset($_GET['add'])) {
?>
        <h2>
            <i class="fa-solid fa-pencil"></i>
            Adicionar um imovel a um empreendimento
        </h2>
        <section class="new-form">
            <form class="" action="" method="post" enctype="multipart/form-data" style="flex-grow:1; margin-left:10px;">
                <label style="margin-top:0" for="nome">Nome:</label>
                <input type="text" name="nome" id="" placeholder="Nome do imovel">

                <label for="empreendimento">Empreendimento:</label>
                <select name="empreendimento" id="">
                    <?php
                    foreach ($empreendimentos as $key => $value) {
                        $nome_empre = ucfirst($value['nome']);
                        echo "<option value='$value[id]'>$nome_empre</option>";
                    }
                    ?>
                    <!-- <option value="residencial">Residencial</option>
                    <option value="comercial">Comercial</option> -->
                </select>

                <label for="preco">Preço:</label>
                <input type="text" name="preco" id="" Placeholder="" mask="brl" ">
                <label for=" area">Area:</label>
                <input type="text" name="area" id="" Placeholder="">

                <label for=" img">Selecione as imagens:</label>
                <input multiple type="file" name="img[]" id="">
                <input type="submit" name="submit" value="Atualizar">

            </form>
        </section>
    <?php
    } else if (isset($_GET['edit'])) {
    ?>
        <section class="new-form">
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
        </h2>
        <?php


        // Product SQL QUERY
        // $empreendimento = Sql::connect()->query("SELECT * FROM `tb_admin.empreendimentos` WHERE id = $view");
        // $empreendimento = $empreendimento->fetch();
        // Image SQL QUERY
        // $productInfoImg = Sql::connect()->query("SELECT * FROM `$pageTableImg` WHERE produto_id = $edit");
        // $productInfoImg = $productInfoImg->fetchAll(PDO::FETCH_ASSOC);
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
                        echo "<td> $value[preco] </td>";
                        echo "<td> $value[area] M² </td>";
                        echo "<td> <a class='btn edit' href='./imoveis?view=$view&edit=$value[id]'>Edit</a></td>";
                        echo '</tr>';
                    }
                    // $imoveis
                    ?>
                </tbody>
            </table>
        </div>
    </section>
<?php  } ?>