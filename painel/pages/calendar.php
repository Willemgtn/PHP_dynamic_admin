<?php 
  $mes = $_GET['mes'] ?? date('m', time());
  $ano = $_GET['ano'] ?? date('Y', time());
  $diasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
  $diaInicialDoMes = date('N', strtotime("$ano-$mes-01"));
  // echo $diaInicialDoMes;
  $dataAtual = date('Y-m-d', time());
?>

<section class="new-form">



<h2><i class="fa-regular fa-calendar-days"></i> Calendario e Agenda | 
<?php echo date('F', strtotime("$ano-$mes-01")); echo " " . date('Y', strtotime("$ano-$mes-01"));?></h2>

<table class="calendario-table">
  <tr>
    <td>Domingo</td>
    <td>Segunda</td>
    <td>Terça</td>
    <td>Quarta</td>
    <td>Quinta</td>
    <td>Sexta</td>
    <td>Sabado</td>
  </tr>

  <?php 
    $n = 1;
    $z = 0;
    $diasMes += $diaInicialDoMes;
    while($n <= $diasMes){
      if($diaInicialDoMes == 7 && $z != $diaInicialDoMes){
        $z = 7;
        $n = 8;
      }
      if ($n % 7 == 1){echo '<tr>';}
      if ($z >= $diaInicialDoMes){ 
        $dia = $n - $diaInicialDoMes; 
        if ("$ano-$mes-$dia" == $dataAtual){
          echo "<td dia=\"$ano-$mes-$dia\" class=\"day-selected\">$dia</td>";  
        }else {
          $dia = $dia < 10 ? '0' . $dia : $dia ;
          echo "<td dia=\"$ano-$mes-$dia\">$dia</td>";
        }
      } else {
        echo "<td></td>"; $z++;
      }
      if($n % 7 == 0){echo '</td>';}
      $n++;
    }
  ?>
</table>

  <section class="new-form">
    <form method="post" action="./api/calendar.php" class="new-form">  
    <div class="card-title">
      Tarefas de <?php echo date('d/m/Y', time()); ?>
    </div>
      <input type="text" name="tarefa" id="">
      <input type="hidden" name="date" value="<?php echo date('Y-m-d', time()); ?>">
      <input type="hidden" name="acao" value="insert">
      <input type="submit" value="Cadastrar">
    </form>
  </section>

  <div class="box-tarefas-wrapper">
    <div class="card-title">
      Tarefas de <?php echo date('d/m/Y', time()); ?>
    </div>
    <div class="box-tarefas">
      <?php $sql = Sql::connect()->prepare("SELECT * FROM `tb_admin.agenda` WHERE date = ?");
      $sql->execute(array($dataAtual));
      
      foreach ($sql as $key => $value) {  ?>
        <div class="box-tarefas-single">
          <h2><i class="fa fa-pencil"></i> <?php echo $value['tarefa'];?></h2>
        </div>
      <?php }?>

    </div>
      <div class="clear"></div>
  </div>
</section>
<script>

</script>

<style>
  table.calendario-table td{
    border: 1px solid #ccc;
    text-align: center;
    cursor: pointer;
  }
  td.day-selected{
    /* background: rgb(220, 220, 220); */
    background: white;
  }
  .box-tarefas-single{
    /* background: #f4b03e; */
    float: left;
    width: 33%;
    border: 4px solid white;
    color: white;
  }
  .box-tarefas-single h2 {
    font-size: 20px;
    padding: 0 8px;
  }
</style>