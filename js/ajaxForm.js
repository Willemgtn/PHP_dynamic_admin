$(function(){
    $('body').on('submit','form.ajax',function(event){
        event.preventDefault();
        // alert('enviando');
        var form = $(this);
        $.ajax({
            beforeSend: function(){
                $('body').append('<div id="loader"><div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            },
            url: 'http://localhost/danki/dev1.0/projeto/ajax/form.php',
            // url: 'http://localhost/danki/dev1.0/projeto/ajax/testing_zone.php',
            method: 'post',
            dataType: 'json',
            data: form.serialize()


        }).done(function(response){
            // console.log('hi', response);

            setTimeout(() => {
                $("body").remove('#loader');
                $('#loader').remove('*');
            }, 3000);

            console.log(response);
            if(response.success){
                // ...
                // alert('Data.success')
                $('body').append(`<div class="success-box"> ${response.msg}</div>`);
                setTimeout(() => {
                   $('.success-box').remove('*');
                   $('body').remove('.success-box');
                }, 5000);
            // } else if (data.sucess)  {
            //     alert('Data.sucess')
            } else {
                // ..
                // alert('Data.else')
                $('body').append(`<div class="error-box"> ${response.msg}</div>`);

                $('#loader').remove('*')
                setTimeout(() => {
                    $('.error-box').remove('*');
                    $('body').remove('.error-box');
                 }, 5000);
            }
        });
        // return false;
    })
})