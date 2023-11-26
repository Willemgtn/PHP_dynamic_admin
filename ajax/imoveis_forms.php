<?php
include('../config.php');
$data = array();
$data['sucesso'] = true;
$data = '';

$texto_buscado = $_POST['texto_busca'];
$a_min = $_POST['area-min'];
$a_max = $_POST['area-max'];
$p_min = $_POST['preco-min'];
$p_max = $_POST['preco-max'];
$q = $_POST['q'];

$a_min = $a_min ?: 0;
$a_max = $a_max ?: 10000000.00;
$p_min = $p_min ?: 0;
$p_max = $p_max ?: 10000000.00;

$p_min = str_replace("R$ ", "", $p_min);
$p_max = str_replace("R$ ", "", $p_max);

$p_min = str_replace(".", "", $p_min);
$p_max = str_replace(".", "", $p_max);

$p_min = str_replace(",", ".", $p_min);
$p_max = str_replace(",", ".", $p_max);

$t_1 = "`tb_admin.imoveis`";
$t_2 = "`tb_admin.empreendimentos`";

// print_r($_POST);
// echo "<hr>";

if ($q){
  $sql = \Sql::connect()->prepare("SELECT $t_1.*, $t_2.`nome` as nome_empreendimento FROM $t_1 INNER JOIN $t_2 ON $t_2.`id` = $t_1.`empreendimento_id` WHERE 
    $t_1.`preco` >= ? AND  
    $t_1.`preco` <= ? AND
    $t_1.`area` >= ? AND
    $t_1.`area` <= ? AND
    $t_1.`nome` LIKE ? AND
    $t_2.`id` = ? ".PHP_EOL);
    // echo $sql->debugDumpParams();

    $sql->execute(array($p_min, $p_max, $a_min, $a_max, "%$texto_buscado%", $q));
    // echo $sql->debugDumpParams();

    $result = $sql->fetchall();

} else {
    $sql = \Sql::connect()->prepare("SELECT $t_1.*, $t_2.`nome` as nome_empreendimento FROM $t_1 INNER JOIN $t_2 ON $t_2.`id` = $t_1.`empreendimento_id` WHERE 
      $t_1.`preco` >= ? AND  
      $t_1.`preco` <= ? AND
      $t_1.`area` >= ? AND
      $t_1.`area` <= ? AND
      $t_1.`nome` LIKE ?".PHP_EOL);

      $sql->execute(array($p_min, $p_max, $a_min, $a_max, "%$texto_buscado%"));
      $result = $sql->fetchall();
}
// echo "<hr>";
// print_r(array($texto_buscado, $a_min, $a_max, $p_min, $p_max, $q));
// echo "<hr>";
// print_r($result);
$view = new \views\imoveisView();
$view->imoveis = $result;
$view->renderImoveis();
?>