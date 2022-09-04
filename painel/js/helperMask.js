$(function(){
    // alert('...');
    $('#inscricao').mask('999.999.999-99');

    $("[name='tipo_cliente']").change(function(){
        // var Val = $(this).val();
        console.log(Val);
        if(Val == 'fisico'){
            $('#inscricao').mask('999.999.999-99');
            $('#inscricao').attr("name", 'cpf');
            $('[for=inscricao]').html('CPF:');
        } else if (Val == 'juridico'){
            $('#inscricao').mask('99.999.999/9999-99');
            $('#inscricao').attr("name", 'cnpj');
            $('[for=inscricao]').html('CNPJ:');
        }
    })
})