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
            <h2>main</h2>
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
    }
</style>