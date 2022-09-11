<?php
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
                        $sql = Sql::connect()->prepare("INSERT INTO `$pageTable` VALUES  (null,?,?,?,?)");
                        $sql->execute([$nome, $tipo, $preco, $imgName]);
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