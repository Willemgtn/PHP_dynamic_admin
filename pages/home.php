<section class="banner-principal">
    <div class="overlay"></div>
    <div class="center">
        <form method="post" action="" class="ajax">
            <!-- <h2>Qual o seu melhor e-mail?</h2> -->
            <h2><?php echo $sql['mailtitle'] ?></h2>
            <input type="email" name="email" id="" placeholder="yourBestEmail@domain.com" required>
            <input type="hidden" name="form" value="dash">
            <input type="submit" name="emailSend" value="Cadastrar!">
        </form>
    </div>


</section>

<section id="sobre" class="descricao-autor">
    <div class="center">
        <div class="w50 f-left">
            <h2><?php echo $sql['authorname'] ?></h2>
            <p> <?php echo $sql['authordescription'] ?></p>
            <!-- <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit natus accusamus omnis optio distinctio? Ipsum voluptatum consequuntur odit optio et? Natus veniam nostrum, perferendis quidem ipsa doloribus esse ab at?</p>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit natus accusamus omnis optio distinctio? Ipsum voluptatum consequuntur odit optio et? Natus veniam nostrum, perferendis quidem ipsa doloribus esse ab at?</p> -->
        </div>
        <div class="w50 f-right">
            <img class="f-right img-placeholder" src="./img/default_profile.webp" alt="IMG PLACEHOLDER">
        </div>
    </div>
    <div class="clear"></div>

</section>

<section class="especialidades">
    <div class="center">
        <h2 class="title">Especialidades</h2>
        <div class="w33 f-left box-especialidades">
            <h3><i class="fa-brands fa-css3"></i></h3>
            <h3>CSS3</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis at aperiam nemo. Dolorum earum laudantium illo adipisci iure nam laboriosam. Quo cum debitis rem dolorum cumque excepturi deleniti beatae natus!</p>
        </div>
        <div class="w33 f-left box-especialidades">
            <h3><i class="fa-brands fa-html5"></i></h3>
            <h3>HTML5</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis at aperiam nemo. Dolorum earum laudantium illo adipisci iure nam laboriosam. Quo cum debitis rem dolorum cumque excepturi deleniti beatae natus!</p>
        </div>
        <div class="w33 f-left box-especialidades">
            <h3><i class="fa-brands fa-js-square"></i></h3>
            <h3>JavaScript</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis at aperiam nemo. Dolorum earum laudantium illo adipisci iure nam laboriosam. Quo cum debitis rem dolorum cumque excepturi deleniti beatae natus!</p>
        </div>
        <div class="w33 f-left box-especialidades">
            <h3><i class="fa-brands fa-python"></i></h3>
            <h3>Python</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis at aperiam nemo. Dolorum earum laudantium illo adipisci iure nam laboriosam. Quo cum debitis rem dolorum cumque excepturi deleniti beatae natus!</p>
        </div>
        <div class="w33 f-left box-especialidades">
            <h3><i class="fa-solid fa-database"></i></h3>
            <h3>SQL</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis at aperiam nemo. Dolorum earum laudantium illo adipisci iure nam laboriosam. Quo cum debitis rem dolorum cumque excepturi deleniti beatae natus!</p>
        </div>
        <div class="w33 f-left box-especialidades">
            <h3><i class="fa-brands fa-linux"></i></h3>
            <h3>Linux</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis at aperiam nemo. Dolorum earum laudantium illo adipisci iure nam laboriosam. Quo cum debitis rem dolorum cumque excepturi deleniti beatae natus!</p>
        </div>
        <div class="w33 f-left box-especialidades">
            <h3><i class="fa-brands fa-php"></i></h3>
            <h3>PHP</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis at aperiam nemo. Dolorum earum laudantium illo adipisci iure nam laboriosam. Quo cum debitis rem dolorum cumque excepturi deleniti beatae natus!</p>
        </div>

    </div>
    <div class="clear"></div>
</section>