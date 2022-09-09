<?php
$pageTable = 'tb_admin.estoque';
$pageTableImg = 'tb_admin.estoque_imagens';
function pageUrl($next = null)
{
    $baseUrl = './clientes';
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
        <label for="comprimento">comprimento:</label>
        <input type="number" name="comprimento" id="" min="0" max="900" step="5" value="0">
        <label for="peso">Peso:</label>
        <input type="number" name="peso" id="" min="0" max="900" step="5" value="0">
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="" min="0" max="900" step="5" value="0">
        <!-- </div> -->
        <!-- <label for="tipo_cliente">Tipo:</label>
        <select name="tipo_cliente" id="">
            <option value="fisico">Fisico</option>
            <option value="juridico">Juridico</option>
        </select>
        <label for="inscricao">CPF: </label>
        <input type="text" name="cpf" id="inscricao" placeholder="000.000.000-00"> -->
        <label for="img">Selecione as imagens:</label>
        <input multiple type="file" name="img[]" id="">
        <input type="submit" name="submit" value="Cadastrar">

    </form>
</section>
<?php // } 
?>