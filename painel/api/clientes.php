<?php

include("../../config.php");
$pageTable = "tb_admin.clientes";

if (!Painel::logado()) {
    $data = ['success' => false, 'error' => 'You must be logged in'];
    die(json_encode($data));
}
// echo "<hr><pre><p>Post:</p>";
// print_r($_POST);
// echo "</pre><hr>";

if (isset($_GET['add'])) {
    if (isset($_POST)) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $tipoCliente = $_POST['tipo_cliente'];
        $inscricao = $tipoCliente == 'fisico' ? $_POST['cpf'] : $_POST['cnpj'];

        $imagem = $_FILES['img'] ?? null;
        // $_FILES['img'] returns {name, type, tmp_name}

        // Here is the place for validation and sanitization
        // For the sake of simplicity and flexibility i'm ignoring it 
        $imagem = $imagem ? FileUpload::validadeImage('img') : null;
        $imagem = $imagem ? FileUpload::uploadImage('img', false) : null;

        $data['nome'] = $nome;
        $data['email'] = $email;
        $data['tipo'] = $tipoCliente;
        $data['inscricao'] = $inscricao;
        $data['imagem'] = $imagem ?? null;
        // $data['img'] = $_FILES['img'] ?? null;
        // $data['imgvalid'] = $imagem ? true : false;

        if ($data['imagem'] === false) {
            $data['success'] = false;
            $data['msg'] = 'imagem invalida';
            die(json_encode($data));
        }

        $sql = Sql::connect()->prepare("INSERT INTO `$pageTable` VALUES (null,?,?,?,?,?)");
        $sqlarray = [$data['nome'], $data['email'], $data['tipo'], $data['inscricao'], $data['imagem']];
        // $sql->debugDumpParams();
        // print_r($sqlarray);
        // echo "<hr>";
        if ($sql->execute($sqlarray)) {
            $data['success'] = true;
            $data['msg'] = 'Cliente inserido com sucesso';
            die(json_encode($data));
        }

        // IF everything went ok:
        $data['success'] = 'not true';
        $data['msg'] = 'Cliente inserido com sucesso';
        die(json_encode($data));
    }
} else if (isset($_GET['delete'])) {
    $data['success'] = 'true';
    $data['msg'] = 'Delete scope reached ready to execute function';
    $data['request'] = $_POST;

    // Receive the post id of the client to be deleted.
    // Execute corresponding sql statement 
    // return data 

    $id = $_POST['id'];
    // fetch the img path and delete (unlink) the image of the client
    $sql = sql::connect()->prepare("SELECT imagem FROM `$pageTable` WHERE id = ?");
    $sql = $sql->execute([$id]);
    $imagem = $sql->fetch()['imagem'];
    @unlink('../uploads/' . $imagem);

    $sql = Sql::connect()->prepare("DELETE FROM `$pageTable` WHERE id= ?");
    if ($sql->execute([$id])) {
        $data['success'] = true;
        $msg['msg'] = "Este cliente foi removido com sucesso.";
    }

    die(json_encode($data));
} else if (isset($_GET['edit'])) {
}






$data['success'] = false;
$data['msg'] = 'No Get matches';
$data['request_post'] = $_POST;
$data['request_get'] = $_GET;



die(json_encode($data));
