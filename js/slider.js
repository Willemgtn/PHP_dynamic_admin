$(function(){
    var curSlide = 0;
    var maxSlide = $('.banner-single').length - 1;
    var delay = 3;
    var animateDelay = 2;

    initSlider();
    changeSlide();

    function initSlider(){
        $('.banner-single').hide();
        $('.banner-single').eq(0).show();

        for(var i =0; i<=maxSlide; i++){
            var content = $('.slideBullets').html();
            if (i == 0){
                content+='<span class="active-slider"></span>';
            } else {
                content+='<span></span>';
                $('.slideBullets').html(content);
            }
        }
    }

    function changeSlide(){
        setInterval(function(){
            $('.banner-single'.eq(curSlide).stop().fadeOut(animateDelay * 1000));

            curSlide++;
            if(curSlide > maxSlide){
                curSlide = 0;
                $('.banner-single').eq(curSlide).stop().fadeIn(animateDelay * 1000);
                //Show active bullter dinamically
                $('slideBullets span').removeClass('active-slider');
                $('slideBullets span').eq(curSlide).addCLass('active-slider');
            }
        }, delay * 1000);
    }

    $('body').on('click', '.slidebullets span', function(){
        var currentBullet = $(this);
        $('.banner-single').eq(curSlide).stop().fadeOut(1000);
        curSlide = currentBullet.index();
        $('.banner-single').eq(curSlide).stop().fadeIn(1000);
        $('.slidebullets span').removeClass('active-slider');
        currentBullet.addClass('active-slider');
    })
})