<?php
$pageTable = 'tb_admin.imoveis';
$pageTableImg = 'tb_admin.imoveis_imagens';
function pageUrl($next = null)
{
    $baseUrl = './imoveis';
    return $next ? $baseUrl . $next : $baseUrl;
}
$maxItemsPerPage = 6;

$view = new \views\imoveisView();
$view->empreendimentos = \models\imoveisModel::getAllEmpreendimentos();

if(isset($_GET['q'])){
  $query = strip_tags(($_GET['q']));
  $view->imoveis = \models\imoveisModel::getImoveisByEmpreendimento($query);
  $view->q = $query;
} else {
  $view->imoveis = \models\imoveisModel::getAllImoveis();
}
// $empreendimentos = \models\imoveisModel::getAllEmpreendimentos();


?>


<main class="imoveis">
    <div class="center">
        <?php 
          $view->renderSideBar(); 
          $view->renderImoveis();
        
        ?>
       
    </div>
</main>

<script>
  $(function(){
    // setInterval(function(){
    //   sendRequest();
    // },3000);
    $(":input").bind('keyup change input', function(){
      sendRequest();
    })

    function sendRequest(){
      $('form').ajaxSubmit({
        data:{'nome_imovel' : $('input[name=texto-busca').val()},
        success:function(data){
          $('section.main').html(data);
        }
      })
    }
  })
</script>

<style>
    section.search {
        display: flex;
        flex-direction: column;
        /* margin: 4px; */
    }

    section.search>section,
    section.search>form>section 
    {
        display: inline-block;
        border: 1px solid black;
        border-radius: 10px;
        padding: 4px;
        margin: 8px 0;
    }

    section.search>form{
      display: contents;
    }

    section.search>form>section input {
        width: 100%;
        padding-left: 4px;
    }

    main.imoveis {
        /* display: flex; */
        /* width: 1280px; */
    }

    main.imoveis div.center {
        display: flex;

    }

    section.main {
        margin: 8px;
        flex-grow: 1;
    }

    div.imoveis_wrapper {}

    div.imoveis_wrapper>div {

        display: flex;
        margin: 20px 0;
        /* padding: 20px; */
        /* width: 100%; */
    }

    div.imoveis_wrapper>div>div.img {
        width: 200px;
    }
    div.imoveis_wrapper>div>div>img {
        width: 200px;
    }

    div.imoveis_wrapper>div>table {
        /* background-color: #999; */
        background-color: rgba(0, 69, 69, 0.3);
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        width: 100%;
        padding-left: 32px;
    }

    div.imoveis_wrapper>div>table>tbody>tr>td {
        border-bottom: 1px solid black;
        padding-left: 10px;
    }

    div.imoveis_wrapper>div>table>tbody>tr:last-child>td {
        border-bottom: none;
    }

    div.imoveis_wrapper>div>table>tbody:not(tr>:last-child) {
        border-bottom: 1px solid pink;
    }
</style>