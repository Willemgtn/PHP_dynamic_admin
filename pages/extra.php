<section class="extras">
    <div class="center">
        <div class="w50 f-left">
            <h2 class="title">Depoimentos</h2>
            <?php
            // print_r(DButils::flexSelectAll('tb_site.depoimentos', null, null, 'order_id DESC LIMIT 3'));
            foreach (DButils::flexSelectAll('tb_site.depoimentos', 'order_id DESC LIMIT 3') as $key => $value) {
                # code...
                // print_r($key);
                // print_r($value);

            ?>
                <div class=" depoimentos-single">
                    <p><?php echo $value['conteudo'] ?></p>
                    <p class="nome-autor"><?php echo $value['autor'] ?></p>
                </div>
            <?php     }
            ?>
            <!-- <div class=" depoimentos-single">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum in, eos corrupti ipsum porro mollitia? Dolores necessitatibus vitae molestias nulla fugiat officiis ipsa animi exercitationem placeat! Rem aperiam dicta odio.</p>
                <p class="nome-autor">Lorem Ipsum</p>
            </div>
            <div class=" depoimentos-single">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum in, eos corrupti ipsum porro mollitia? Dolores necessitatibus vitae molestias nulla fugiat officiis ipsa animi exercitationem placeat! Rem aperiam dicta odio.</p>
                <p class="nome-autor">Lorem Ipsum</p>
            </div> -->
        </div>
        <div id="servicos" class="w50 f-right">
            <h2 class="title">Serviços</h2>
            <div class="servicos">
                <ul>
                    <?php
                    // print_r(DButils::flexSelectAll('tb_site.depoimentos', null, null, 'order_id DESC LIMIT 3'));
                    foreach (DButils::flexSelectAll('tb_site.service', 'order_id DESC LIMIT 3') as $key => $value) {
                        # code...
                        // print_r($key);
                        // print_r($value);

                    ?>


                        <li><?php echo $value['service']; ?></li>
                    <?php } ?>


                    <!-- <li>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maxime aspernatur, aliquid impedit delectus eum distinctio dolores voluptatem voluptates illo fugiat. Natus autem ad illum molestias itaque debitis consectetur odit veniam?</li>
                    <li>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maxime aspernatur, aliquid impedit delectus eum distinctio dolores voluptatem voluptates illo fugiat. Natus autem ad illum molestias itaque debitis consectetur odit veniam?</li> -->
                </ul>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</section>