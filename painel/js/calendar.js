$(function() {
    $('td').click(function() {
        $('td').removeClass('day-selected')
        $(this).addClass('day-selected')
        var dia = $(this).attr('dia')
        var novoDia = $(this).attr('dia').split('-')
        novoDia = novoDia[2] + '/' + novoDia[1] + '/' + novoDia[0]
            // alert(novoDia)
        trocarDatas($(this).attr("dia"), novoDia)
        getAgenda($(this).attr('dia'))
    })

    function trocarDatas(nformatado, formatado) {
        $('input[name=date]').attr('value', nformatado.toString())
        $('form .card-title').html('Adicionar Tarefa Para: ' + formatado)
        $('.box-tarefas-wrapper .card-title').html('Tarefa para: ' + formatado)
    }

    function getAgenda(date) {
        $('.box-tarefas').html('')
        $.ajax({
            url: './api/calendar.php',
            method: 'post',
            data: { 'date': date, 'acao': 'get' }
        }).done(function(data) {
            console.log(data)
            $('.box-tarefas').html(data)
        })
    }

    $('form').ajaxForm({
        success: function(data) {
            console.log(data)
            $('.box-tarefas').append(data)
            $('form')[0].reset()
        }
    })
})