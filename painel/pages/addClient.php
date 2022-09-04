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
<!-- <script type="text/javascript" src="./js/helperMask.js"></script> -->


<!-- <style>
    section.new-form form label,
    section.new-form form input,
    section.new-form form textarea {
        display: block;
        width: 100%;
    }

    section.new-form form label {
        margin-top: 16px;
    }

    section.new-form form input {
        height: 2em;
        padding-left: 1em;
    }

    section.new-form form textarea {
        padding-left: 1em;
        resize: vertical;
    }

    section.new-form form select {
        width: 100px;
        margin-top: 0.5em;
    }

    section.new-form form input[type=file] {
        padding: 1em;
        border: 1px solid black;
        height: unset;
        margin-top: 0.2em;
        border-radius: 0.8em;
    }

    section.new-form form input[type=submit] {
        margin-top: 16px;
    }
</style> -->