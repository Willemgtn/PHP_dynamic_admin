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
            echo "<hr><pre>";
            // print_r(\models\imoveisModel::getAllEmpreendimentos());
            // print_r(\models\imoveisModel::getImovelById(1));
            print_r(\models\imoveisModel::getImovelImagens(1));
            echo "<hr></pre>";

            for ($i = 0; $i < 5; $i++) { ?>
                <div class="imoveis_wrapper">
                    <div>
                        <img src="./painel/uploads/62ee0ef454c83.jpeg" alt="">
                        <!-- <img src="./painel/uploads/<?php echo @$value['imagens'][0]['imagem'] ?>"> -->
                        <table>
                            <tr>
                                <td>Nome do Imovel:
                                    <?php echo @$value['nome'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Area:
                                    <?php echo @$value['area'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Preço:
                                    <?php echo @$value['preco'] ?>
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

    div.imoveis_wrapper>div>img {
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