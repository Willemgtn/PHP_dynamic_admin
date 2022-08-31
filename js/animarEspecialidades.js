$(function(){
    var atual = -1;
    var boxes = $('.box-especialidades');
    var maximo = boxes.length -1;
    var timer;
    var animacaoDelay = 2;

    executarAnimacao();

    function executarAnimacao(){
        boxes.hide();
        timer = setInterval(logicaAnimacao, animacaoDelay*1000);
        function logicaAnimacao(){
            atual++;
            if(atual > maximo){

                clearInterval(timer);
                return false;
            }

            boxes.eq(atual).fadeIn();
        }
    }
})