<?php
include("../../config.php");

UsersMod::verifyPermission(1);

$pageTable = 'tb_admin.empreendimentos';
$pageTableImg = 'tb_admin.empreendimentos_imagens';
function pageUrl($next = null)
{
    $baseUrl = './empreendimentos';
    // echo $baseUrl . $next;
    // return $baseUrl . $next;
    return $next ? $baseUrl . $next : $baseUrl;
}

if (!Painel::logado()) {
    $data = ['success' => false, 'error' => 'You must be logged in'];
    die(json_encode($data));
}

UsersMod::verifyPermission(1);

if (isset($_POST['tipo']) && $_POST['tipo'] == 'ordenar') {
    $data['msg'] = "You've reached the target";

    $ids = $_POST['item'];
    $i = 1;
    foreach ($ids as $key => $value) {
        $sql = Sql::connect()->prepare("update `$pageTable` SET order_id = $i WHERE  id = ?");
        $sql->execute([$value]);
        // $sql->debugDumpParams();
        $i++;
    }
}

$data = $_POST;
die(json_encode($data));
