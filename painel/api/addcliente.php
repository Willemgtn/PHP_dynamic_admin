<?php

include("../../config.php");


if (!Painel::logado()) {
    $data = ['success' => false, 'error' => 'You must be logged in'];
    die(json_encode($data));
}

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
    // $sql = Sql::connect()->prepare("INSERT INTO $pageTable VALUES (null,?,?,?,?,?)");
    // if ($sql->execute($data)) {
    //     $data['success'] = true;
    //     $data['msg'] = 'Cliente inserido com sucesso';
    //     die(json_encode($data));
    // }

    // IF everything went ok:
    $data['success'] = true;
    $data['msg'] = 'Cliente inserido com sucesso';
    die(json_encode($data));
}





$data['success'] = false;

die(json_encode($data));
