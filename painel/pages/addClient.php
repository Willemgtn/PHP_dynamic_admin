<?php
$pageTable = 'tb_admin.clientes';
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
        Cadastrar Cliente
    </h2>

    <form class="ajax" action="./api/addcliente.php" method="post" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="" placeholder="Nome do Cliente/Empresa">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="" placeholder="E-mail do Cliente/Empresa">
        <label for="tipo_cliente">Tipo:</label>
        <select name="tipo_cliente" id="">
            <option value="fisico">Fisico</option>
            <option value="juridico">Juridico</option>
        </select>
        <label for="inscricao">CPF: </label>
        <input type="text" name="cpf" id="inscricao">
        <label for="img">Imagem</label>
        <input type="file" name="img" id="">
        <input type="submit" value="Cadastrar" disabled>

    </form>
</section>
<?php //} 
?>
<!-- <script type="text/javascript" src="./js/helperMask.js"></script> -->

<section id="" class="">
    <h3>
        <i class="fa-solid fa-address-card"></i>
        Clientes
        <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
    </h3>
    <br>

    <!-- SQL fetchAll foreach template -->



    <!-- custom -->
    <div class="cardsWrapper">
        <!-- template -->
        <div class="roundedBorders">
            <img src="./uploads/default_profile.png" alt="">
            <hr>
            <ul>
                <li><i class="fa-solid fa-pencil"></i>
                    <strong>Nome:</strong>
                    <!-- PHP -->
                </li>
                <li><i class="fa-solid fa-pencil"></i>
                    <strong>E-mail:</strong>
                    <!-- PHP -->
                </li>
                <li><i class="fa-solid fa-pencil"></i>
                    <strong>Tipo:</strong>
                    <!-- PHP -->
                </li>
                <li><i class="fa-solid fa-pencil"></i>
                    <strong>Cpf:</strong>
                    <!-- PHP -->
                </li>
            </ul>
            <div class="d-flex" style="margin-bottom: 10px;">
                <a class="btn edit" href="./?edit">edit</a>
                <a class="btn red" href="./?delete">delete</a>
            </div>
        </div>
    </div>

</section>