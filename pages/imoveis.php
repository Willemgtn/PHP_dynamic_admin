<?php
$pageTable = 'tb_admin.imoveis';
$pageTableImg = 'tb_admin.imoveis_imagens';
function pageUrl($next = null)
{
    $baseUrl = './imoveis';
    return $next ? $baseUrl . $next : $baseUrl;
}
$maxItemsPerPage = 6;
?>

<main class="imoveis">
    <div class="center">
        <section class="search">
            <section class="search1">
                <h2>O que você procura?</h2>
                <input type="text" name="texto_busca" id="">
            </section>

            <section class="search2">

                <form action="./ajax/imoveis.php" method="post">
                    <h2>Area minima:</h2>
                    <input type="text" name="area-min" id="">
                    <h2>Area maxima:</h2>
                    <input type="text" name="area-max" id="">
                    <h2>Preco minimo:</h2>
                    <input type="text" name="preco-min" mask="brl">
                    <h2>Preco maximo:</h2>
                    <input type="text" name="preco-min" mask="brl">

                </form>
            </section>
        </section>
        <section class="main">
            <!-- LISTAR IMOVEIS -->
            <p>
                Listando
                <strong>100</strong>
                Imoveis
            </p>           

            <hr>
            <?php
            if (1 == 0 ){
                echo "<hr><pre>";
                print_r(\models\imoveisModel::getAllEmpreendimentos());
                // print_r(\models\imoveisModel::getImovelById(3));
                print_r(\models\imoveisModel::getImovelImagens(3));
                echo "<hr></pre>";
            }
            

            $empreendimentos = \models\imoveisModel::getAllEmpreendimentos();
            foreach ($empreendimentos as $key => $value) {
                $imoveis[] = \models\imoveisModel::getImoveisByEmpreendimento($value['id']);
            }
            // echo "<hr><pre>";
            // print_r($imoveis);
            // echo "<hr></pre>";
            foreach ($imoveis[0] as $key => $value) {
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
    </div>
</main>

<style>
    section.search {
        display: flex;
        flex-direction: column;
        /* margin: 4px; */
    }

    section.search>section {
        display: inline-block;
        border: 1px solid black;
        border-radius: 10px;
        padding: 4px;
        margin: 8px 0;
    }

    section.search>section input {
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
        background-color: #999;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        width: 100%;
        padding-left: 32px;
    }

    div.imoveis_wrapper>div>table>tbody>tr>td {
        border-bottom: 1px solid black;
    }

    div.imoveis_wrapper>div>table>tbody>tr:last-child>td {
        border-bottom: none;
    }

    div.imoveis_wrapper>div>table>tbody:not(tr>:last-child) {
        border-bottom: 1px solid pink;
    }
</style>