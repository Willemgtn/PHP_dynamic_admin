$(function(){
    $('form.ajax').ajaxForm({
        dataType: 'json',

        beforeSend: function(){
            $('form.ajax').animate({'opacity':'0.4'});
            $('form.ajax').find('input[type=submit]').attr('disabled', 'true');
        },
        success: function(data){
            // console.log("OK!")
            $('form.ajax').animate({'opacity':'1'});
            $('form.ajax').find('input[type=submit]').removeAttr('disabled');
            $('.box-alert').remove();
            if(data.success){
                $('form.ajax').prepend('<div class="box-alert ok ">Sucesss</div>');
            } else {
                $('form.ajax').prepend('<div class="box-alert error ">Error</div>');
            }
            console.log(data)
        }
    })
})