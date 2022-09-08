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
        $tipo = $_POST['tipo_cliente'];
        $inscricao = $tipo == 'fisico' ? $_POST['cpf'] : $_POST['cnpj'];

        $imagem = $_FILES['img'] ?? null;
        // $_FILES['img'] returns {name, type, tmp_name}

        // Here is the place for validation and sanitization
        // For the sake of simplicity and flexibility i'm ignoring it 
        $imagem = $imagem ? FileUpload::validadeImage('img') : null;
        $imagem = $imagem ? FileUpload::uploadImage('img', false) : null;

        $data['request'] = $_POST;
        // $data['img'] = $_FILES['img'] ?? null;
        // $data['imgvalid'] = $imagem ? true : false;

        if ($imagem === false) {
            $data['success'] = false;
            $data['msg'] = 'imagem invalida';
            die(json_encode($data));
        }

        $sql = Sql::connect()->prepare("INSERT INTO `$pageTable` VALUES (null,?,?,?,?,?)");
        $sqlarray = [$nome, $email, $tipo, $inscricao, $imagem];
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
        $data['msg'] = 'Cliente inserido sem sucesso';
        die(json_encode($data));
    }
} else if (isset($_GET['delete'])) {
    // $data['success'] = 'true';
    // $data['msg'] = 'Delete scope reached ready to execute function';
    $data['request'] = $_POST;

    // Receive the post id of the client to be deleted.
    // Execute corresponding sql statement 
    // return data 

    $id = $_POST['id'];
    // fetch the img path and delete (unlink) the image of the client
    $sql = Sql::connect()->prepare("SELECT imagem FROM `$pageTable` WHERE id = ?");
    $sql->execute([$id]);
    $imagem = $sql->fetch()['imagem'];
    @unlink('../uploads/' . $imagem);

    $sql = Sql::connect()->prepare("DELETE FROM `$pageTable` WHERE id= ?");
    if ($sql->execute([$id])) {
        $data['success'] = true;
        $msg['msg'] = "Este cliente foi removido com sucesso.";
    } else {
        $data['success'] = false;
        $data['msg'] = "Error: Este cliente não existe mais";
    }

    die(json_encode($data));
} else if (isset($_GET['edit'])) {
    $data['request'] = $_POST;

    $nome = $_POST['nome'];
    $id = $_POST['id'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo_cliente'];
    $inscricao = $tipo == 'fisico' ? $_POST['cpf'] : $_POST['cnpj'];


    $imagem = $_FILES['img'] ?? null;
    // $_FILES['img'] returns {name, type, tmp_name}
    // Here is the place for validation and sanitization of text inputs
    // For the sake of simplicity and flexibility i'm ignoring it and only validating the image format and size.
    $imagem = $imagem ? FileUpload::validadeImage('img') : null;
    $imagem = $imagem ? FileUpload::uploadImage('img', false) : null;

    if ($imagem === false) {
        $data['success'] = false;
        $data['msg'] = 'imagem invalida';
        die(json_encode($data));
    }

    // $sql = Sql::connect()->prepare("SELECT imagem FROM `$pageTable` WHERE id = ?");
    // $sql->execute([$id]);
    // if image true, delete the old one picture, and use it,
    // Else use this one
    // $oldImagem = $sql->fetch()['imagem'];
    $oldImagem = $_POST['imagem_atual'];
    if (!$imagem) {
        $imagem = $oldImagem;
    } else {
        @unlink('../uploads/' . $oldImagem);
    }

    $data['imagem'] = $imagem;
    // $data['img'] = $_FILES['img'] ?? null;
    // $data['imgvalid'] = $imagem ? true : false;



    $sql = Sql::connect()->prepare("UPDATE `$pageTable` SET nome=?, email=?, tipo=?, inscricao=?, imagem=?  WHERE id = ?");
    $sqlarray = [$nome, $email, $tipo, $inscricao, $imagem, $id];
    // $sql->debugDumpParams();
    // print_r($sqlarray);
    // echo "<hr>";
    if ($sql->execute($sqlarray)) {
        $data['success'] = true;
        $data['msg'] = 'Cliente Atualizado com sucesso';
        die(json_encode($data));
    }

    // IF everything went ok:
    $data['success'] = 'not true';
    $data['msg'] = 'Cliente inserido sem sucesso';
    die(json_encode($data));
}






$data['success'] = false;
$data['msg'] = 'No Get matches';
$data['request_post'] = $_POST;
$data['request_get'] = $_GET;



die(json_encode($data));
