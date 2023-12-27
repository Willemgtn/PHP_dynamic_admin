<?php 
  $table = [
    1 => '`tb_site.suporte.ticket`',      # id, ticket, email, subject, datetime
    2 => '`tb_site.suporte.interacoes`'   # id, ticket, admin, msg, datetime
  ];
  function ticketExist(string $ticket, array $table){
    $sql = Sql::connect()->prepare("SELECT * FROM $table[1] WHERE ticket = ?");
    $sql->execute(array($ticket));
    if ($sql->rowCount() == 1){
      return $sql->fetch();
    } else {
      return false;
    }
  }
  function getAllInteractionsFromTicket($ticket_id, $table){
    $sql = Sql::connect()->prepare("SELECT * FROM $table[2] WHERE ticket = ? ORDER BY id DESC");
    // print_r($sql);
    $sql->execute(array($ticket_id));
    return $sql->fetchAll();
  }
  function getAllTickets($table){
    $sql = Sql::connect()->prepare("SELECT * FROM $table[1]");
    $sql->execute();
    $tickets = $sql->fetchAll();
    foreach ($tickets as $key => $value) {  
      $tickets[$key]['history'] = getAllInteractionsFromTicket($value['ticket'], $table);
      // print_r(getAllInteractionsFromTicket($value['ticket'], $table));
    }
    return $tickets;
  }
  function createAdminFormResponse($ticket){
    echo "<form method='post'>";
    echo "<textarea name='response'></textarea>";
    echo "<input type='hidden' name='ticket' value='$ticket'></input>";
    echo "<input type='submit' value='Enviar' name='adminResponse'></input>";
    echo "</form>";
  }
  function createAdminAccordion($ticket){
      echo '<div class="accordion" id="">';
      foreach ($ticket as $key => $value) {
      echo '<div class="accordion-item">';
      echo "<h2 class='accordion-header' id='heading_$value[ticket]'>";
      echo "<button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse_$value[ticket]' aria-expanded='true' aria-controls='collapse_$value[ticket]'>
        $value[ticket] : $value[subject]
        </button></h2>";
      echo "<div id='collapse_$value[ticket]' class='accordion-collapse collapse' aria-labelledby='heading_$value[ticket]'>
      <div class='accordion-body'>";
      echo "<a href='http://localhost/PHP_Web_dev/suporte&t=$value[ticket]'>$value[ticket]</a>";
      // echo "History here";
      if (empty($value['history'])){
        // echo "admin respond form here";
        createAdminFormResponse($value['ticket']);
      } else {
        // print_r($value['history']);
        echo "<div class='sup_rev'>";
        foreach ($value['history'] as $history) {
          echo "<p>";
          echo $history['datetime'];
          echo " - ";
          echo $history['admin'] > 0 ? "Admin: " : "";
          echo $history['msg'];
          echo "</p>";
        }
        echo "</div>";
        // if ($value['history'][0]['admin'] == 0 )
          createAdminFormResponse($value['ticket']);
      }
      echo "</div></div></div>";
        }
      echo '</div>';
    
  }


  if (isset($_POST['createNewTicket'])){
    $ticket = md5(uniqid());
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $datetime = date('Y-m-d H:i:s');

    // echo $datetime;
    if ($email == ''){
      Painel::alertJs("E-mail está vazio...");
    } else if ($subject == "") {
      Painel::alertJs("Assunto está vazio...");
    } else {
      $sql = Sql::connect()->prepare("INSERT INTO $table[1] VALUES (null, ?,?,?,?)");
      $sql->execute(array($ticket, $email, $subject, $datetime));
      echo "<h3>Seu ticket foi criado com sucesso, confira seu e-mail para acompanhar o chamado.</h3>";
      echo "<a href=\"./suporte?t=$ticket\">Clique aqui para acompanhar o chamado.</a>";
    }
  }
  if (isset($_GET['t']) && isset($_POST['respond'])){
    $ticket = $_GET['t'];
    $msg = $_POST['msg'];
    $datetime = date('Y-m-d H:i:s');
    if ($ticket != '' and $msg != ''){
      $sql = Sql::connect()->prepare("INSERT INTO $table[2] VALUES (null, ?,?,?,?)");
      $sql->execute(array($ticket, 0, $msg, $datetime));
      echo "<h3>Sua resposta foi enviada</h3>";
    }
  }
  ?>

<hr>

<?php
  if (isset($_GET['t'])){
    $ticket = $_GET['t'];
    $ticket = ticketExist($ticket, $table);
    if ($ticket){
      // print_r($ticket);
      echo "<br>";
      $ticket_history = getAllInteractionsFromTicket($ticket['ticket'], $table);
      // $ticket_history = array_reverse($ticket_history);
      // echo "<pre>";
      // print_r($ticket_history);
      // echo "</pre>";
      echo "<br><hr>";
      echo "<h2>$ticket[subject] <span style='font-size:0.4em'>$ticket[datetime]</span></h2><hr>";
      echo "<div class='sup_rev'>";
      foreach ($ticket_history as $key => $value) {
        $admin = $value['admin'] > 0 ? 'Admin: ': '';
        echo "<h3>$admin$value[msg] <span style='font-size:0.5em'>$value[datetime]</span></h3><hr>";
      }
      echo "</div>";
      if (!empty($ticket_history && $ticket_history[0]['admin'] > 0)){
        // echo "you may respond";
        echo '<form method="post">
            <textarea name="msg" id="" cols="30" rows="10"></textarea>
            <input type="submit" value="Enviar" name="respond">
          </form>';
      } else if (!empty($ticket_history && $ticket_history[0]['admin'] == 0)) {
        echo "<br><hr><h3>Aguarde o admin responder para continuar com o suporte</h3>";
      }
    } else {
      echo "Brute-force intervention here!";
    }
  } else {
  ?>
  <a href="http://localhost/PHP_Web_dev/suporte/admin">Admin Portal</a>
  <form action="" method="post">
    <input type="text" name="email" id="" placeholder="E-mail">
    <textarea name="subject" id="" cols="30" rows="10"></textarea>
    <input type="submit" value="Enviar" name="createNewTicket">
  </form>
<?php } 

  if ($_GET['url'] == 'suporte/admin'){


    if(isset($_POST['adminResponse'])){
      $ticket = $_POST['ticket'];
      $response = $_POST['response'];
      $datetime = date('Y-m-d H:i:s');

      if(isset($_POST['response']) && $_POST['response'] == ""){
        echo "Response is empty";
      } else if (isset($_POST['ticket']) && $_POST['ticket'] == ""){
        echo "Ticket is empty";
      } else {
        $sql = Sql::connect()->prepare("INSERT INTO $table[2] VALUES (null, ?,?,?,?)");
        $sql->execute(array($ticket, 1, $response, $datetime));
        // E-mail notification that the ticket has been updated.
      }
    }


    echo "<h1>Hi Admin</h1>";

    # Todo :
      # Open tickets,
      # ticket responses


      $tickets = getAllTickets($table);
      // echo "<pre>";
      // print_r($tickets);
      // echo "</pre>";

      $openTicket = [];
      $respondedTicket = [];
      foreach ($tickets as $key => $value) {
        if ($value['history'][0]['admin'] == 0){
          $openTicket[] = $value;
        } else {
          $respondedTicket[] = $value;
        }
      }
      // print_r($openTicket);
      //     echo "<br>";
      // print_r($respondedTicket);

      echo "<h2> Open Tickets </h2>";
      createAdminAccordion($openTicket);
      echo "<br><h2> Responded Tickets </h2>";
      createAdminAccordion($respondedTicket);
      
  }
  ?>

<!-- <div class="accordion" id="">

  <div class="accordion-item">
    <h2 class="accordion-header" id="heading_">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_" aria-expanded="true" aria-controls="collapse_">
        Accordion Item #1
      </button>
    </h2>

    <div id="collapse_" class="accordion-collapse collapse" aria-labelledby="heading_">
      <div class="accordion-body">

      </div>
    </div>
  </div>
  
</div> -->


<style>
  form > * {
    display: block;
    margin: 10px;
    padding: 5px;
  }
  form > input, textarea{
    width: 95%;
  }
  div.sup_rev {
    display: flex;
    flex-flow: column-reverse

  }
  div.sup_rev > * {

  }
</style>