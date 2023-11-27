<?php


  

?>
<main>             
  <h2><a href="./chat"> <i class="fa-regular fa-comments"></i> Chat</a></h2>

  <div class="box-chat-online">
    <?php
      for ($i= 0; $i < 0; $i++){

      
    ?>
    <div class="mensagem-chat">
      <span>Username:</span>
      <p>MSG content</p>
    </div>
    <?php } ?>
  </div>
  <section class="new-form">
  <form method="post" action="./api/chat.php" class="new-form">
    <textarea name="" id="" cols="" rows="5"></textarea>
    <input type="submit" name="acao" value="enviar">
  </form>
  </section>


</main>
<style>
  .box-chat-online{
    margin: 20px 0;
    border: 1px solid #ccc;
    padding: 20px 10px;
    height: 400px;
    overflow-y: scroll;
  }
  .mensagem-chat{
    padding: 8px 0;
    border-bottom: 1px dotted rgb(210,210,210);
  }
  .mensagem-chat span{
    background: #00bfa5;
    padding: 0 4px;
    border-radius: 10px;
  }
  .mensagem-chat p{
    font-size: 17px;
    color: #646464;
    margin-bottom: 0px;
  }
</style>