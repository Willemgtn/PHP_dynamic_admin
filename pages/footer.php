<div style="padding:  2em;"></div>
<footer class="">
    <div class="center">
        <p>
            <i class="fa-solid fa-copyright"></i>
            Todos os direitos reservados
        </p>
    </div>
</footer>

<script>
    $(function() {
        $('header.pageHeader nav i').click(function() {
            var menuIcon = $('header.pageHeader nav .menu-btn i')
            var listaMenu = $('header.pageHeader nav>ul')
            if (listaMenu.is(':hidden') == true) {
                // listaMenu.fadeIn();
                listaMenu.slideToggle();
                menuIcon.removeClass('fa-bars')
                menuIcon.addClass('fa-xmark')

            } else {
                // listaMenu.fadeOut();
                listaMenu.slideToggle();
                menuIcon.removeClass('fa-xmark')
                menuIcon.addClass('fa-bars')
            }
        })
    })
    // Animate scroll event to targeted interest point.
    // $('html, body').animate({scrollTop: $('footer').offset().top}, 2000)
</script>
<!-- <script src="./js/slider.js"></script> -->
<script src="./js/animarEspecialidades.js"></script>
<script src="./js/ajaxForm.js"></script>
<?php

Painel::loadJS(['jquery.mask.js', 'helperMask.js', 'jquery.maskMoney.js'], 'imoveis', true);
?>
</body>

</html>