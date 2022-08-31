$(function(){
    var sideMenuOpen = true;
    var windowSize = $(window)[0].innerWidth;

    if(windowSize <= 768){
        sideMenuOpen = false;
    }

    $('.menu-btn').click(function(){
        if(sideMenuOpen){
            // $('aside.menu').animate({'display': 'none'});
            // $('aside.menu').animate({'width': '0'});
            $('aside.menu').hide(500);
            // $('aside.menu').animate({'width':0, 'padding': 0, 'flex': 'unset'})
            sideMenuOpen = false;
        } else {
            // $('aside.menu').animate({'flex': '1 1 10%'})
            $('aside.menu').show(500);
            sideMenuOpen = true;
        }
    })
    $('[actionBtn=delete]').click(function(){
        var txt;
        var r = confirm('Confirm delete request')
        if (r == true){
            return true
        } else {
            return false
        }
    })
    
    // $(window).resize(function(){
    //     windowSize = $(window)[0].innerWidth;
    //     if(windowSize <= 768){
    //         console.log('Screen resized to a width under 768px detected')
    //     } else {
    //         console.log('Screen resized to a widh above 768px detected')
    //     }
    // })

    // window.history.pushState('', '', 'url')
    if($("p.ip").length > 15) {
        $('p.ip').css("background-color", "black");
    }
    for (let i = 0; i < $('p.ip').length; i++) {
        if ($('p.ip')[i].length > 15) {
            const element = $('p.ip')[i];
            element.css('background-color', 'black');        }
    }
    $('html, main').animate({scrollTop: $('footer#slideTo').offset().top}, 2000)
})  