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

<?php if (isset($_GET['add'])) {
?>
    <section id="" class="new-form">
        <h2>
            <i class="fa-solid fa-plus"></i>
            Cadastrar Cliente
        </h2>

        <form class="ajax" action="./api/clientes.php?add" method="post" enctype="multipart/form-data">
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
<?php }
?>
<!-- <script type="text/javascript" src="./js/helperMask.js"></script> -->
<?php if (isset($_GET['edit'])) {
?>
    <section id="" class="new-form">
        <h2>
            <i class="fa-solid fa-pencil"></i>
            Editar/Atualizar Cliente
        </h2>

        <form class="ajax" action="./api/clientes" method="post" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="" placeholder="Nome do Cliente/Empresa" value="<?php ?>">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="" placeholder="E-mail do Cliente/Empresa" value="<?php  ?>">
            <label for="tipo_cliente">Tipo:</label>
            <select name="tipo_cliente" id="">
                <option value="fisico">Fisico</option>
                <option value="juridico">Juridico</option>
            </select>
            <label for="inscricao">CPF: </label>
            <input type="text" name="cpf" id="inscricao" value="<?php  ?>">
            <label for="img">Imagem</label>
            <input type="file" name="img" id="">
            <input type="hidden" name="id" value="<?php echo $_GET['edit'] ?>">
            <input type="submit" value="Cadastrar" disabled>

        </form>
    </section>
<?php }
?>
<section id="" class="">
    <h3>
        <i class="fa-solid fa-address-card"></i>
        Clientes
        <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
    </h3>
    <br>

    <?php
    // -----> SQL <-----
    // $clientes = Sql::connect()->prepare("select * from `$pageTable`");
    // $clientes->execute();
    // $clientes = $clientes->fetchAll();

    ?>


    <!-- SQL fetchAll foreach template -->
    <div class="cardsWrapper">
        <!-- template -->
        <?php
        // -----> SQL <-----
        $clientes = Sql::connect()->prepare("SELECT * from `$pageTable`");
        $clientes->execute();
        $clientes = $clientes->fetchAll();
        foreach ($clientes as $value) {


            // Fake demo filling
            // $value = ['id' => '0', 'nome' => 'Adriaan', 'email' => 'hotmail.gmail.com', 'tipo' => 'fisico2', 'inscricao' => '000.000.000-00'];
            // for ($i = 0; $i < 6; $i++) {

        ?>

            <div class="roundedBorders">
                <img src="./uploads/default_profile.png" alt="">
                <hr>
                <ul>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Nome:</strong>
                        <!-- PHP -->
                        <?php echo $value['nome'] ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>E-mail:</strong>
                        <!-- PHP -->
                        <?php echo $value['email'] ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong>Tipo:</strong>
                        <!-- PHP -->
                        <?php echo ucfirst($value['tipo']) ?>
                    </li>
                    <li><i class="fa-solid fa-pencil"></i>
                        <strong><?php echo $value['tipo'] == 'fisico' ? 'CPF' : 'CNPJ' ?>:</strong>
                        <!-- PHP -->
                        <?php echo $value['inscricao'] ?>
                    </li>
                </ul>
                <hr>
                <div class="d-flex" style="margin:10px 0;">
                    <a class="btn edit" href="<?php echo pageUrl('?edit=' . $value['id']) ?>">edit</a>
                    <a class="btn red delete" href="<?php echo pageUrl('?delete=') ?>" item_id="<?php echo $value['id'] ?>">delete</a>
                </div>
            </div>
        <?php } ?>

    </div>
</section>

<!-- <script src="../js/jquery.mask.js"></script>
<script src="./js/helperMask.js"></script>
<script src="./js/ajax.js"></script> -->