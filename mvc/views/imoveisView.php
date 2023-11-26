<?php

namespace views;

class imoveisView
{
  public $imoveis;
  public $empreendimentos;
  public $q ='';

  public function renderSideBar(){
    ?>
    <section class="search sidebar">
          <form action="./ajax/imoveis_forms.php" method="post">
            <section class="search1">
                <h3>O que você procura?</h3>
                <input type="text" name="texto_busca" id="">
              <!-- </form> -->
            </section>

            <section class="search2">
                <!-- <form action="./ajax/formularios.php" method="post"> -->
                    <h3>Area minima:</h3>
                    <input type="text" name="area-min" id="">
                    <h3>Area maxima:</h3>
                    <input type="text" name="area-max" id="">
                    <h3>Preco minimo:</h3>
                    <input type="text" name="preco-min" mask="brl">
                    <h3>Preco maximo:</h3>
                    <input type="text" name="preco-max" mask="brl">
                <input type="hidden" name="q" value="<?php echo $this->q;?>">
                
            </section>
          </form>

            <section class="empreendimentos">
              <?php 
                foreach($this->empreendimentos as $key => $value){
                  
                  echo '<div><a href="'. pageUrl('?q=' . $value['id']).'">'.$value['nome'].'</a></div>';
                }
              ?>
            </section>
        </section>
    <?php
  }
  public function renderImoveis(){
    ?>
     <section class="main">
            <!-- LISTAR IMOVEIS -->
            <p>
                Listando
                <strong><?php echo count($this->imoveis);?></strong>
                Imoveis
            </p>           

            <hr>
            <?php
            if (1 == 0 ){
                echo "<hr><pre>";
                print_r(\models\imoveisModel::getAllEmpreendimentos());
                // print_r(\models\imoveisModel::getImovelById(3));
                // print_r(\models\imoveisModel::getImovelImagens(3));
                echo "<hr>";
                // print_r(\models\imoveisModel::getAllImoveis());
                echo "<hr></pre>";
            }
            

            // $empreendimentos = \models\imoveisModel::getAllEmpreendimentos();
            // foreach ($empreendimentos as $key => $value) {
            //     $imoveis[] = \models\imoveisModel::getImoveisByEmpreendimento($value['id']);
            // }
            // echo "<hr><pre>";
            // print_r($imoveis);
            // echo "<hr></pre>";
            foreach ($this->imoveis as $key => $value) {
                # code...
                $imovel = \models\imoveisModel::getImovelImagens($value['id']);
                $imovel_imagens = $imovel['imagens'];
            ?>
                <div class="imoveis_wrapper">  
                    <div>
                        <div id="imovel_id_<?php echo $imovel['id']?>" class="img carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner">
                        <?php 
                          // print_r($imovel_imagens);
                            foreach($imovel_imagens as $key => $value){
                              $active = $key == array_key_first($imovel_imagens) ? ' active' : '' ;
                                echo '<div class="carousel-item'.$active.'"> <img src="./painel/uploads/' . $value['imagem'] . '" class="d-block w-100 alt="..."></div>';
                            }

                        ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#imovel_id_<?php echo $imovel['id']?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                         </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#imovel_id_<?php echo $imovel['id']?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                            </div>
                        </div>
                        <table>
                            <tr>
                                <td>Nome do Imovel:
                                    <?php echo @$imovel['nome'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Area:
                                    <?php echo @$imovel['area'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Preço: R$
                                    <?php echo number_format(@$imovel['preco'], 2, ',', '.'); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </section>
    <?php
  }
  public function renderStyleSheet(){
    ?>

    <?php
  }
}
?>