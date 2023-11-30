$(function() {
    $('a.btn-pagamento').click(function(e) {
        e.preventDefault()

        $.ajax({
            url: 'http://localhost/PHP_Web_dev/ajax/finalizarCompras.php',
        }).done(function(data) {
            // console.log(data)
            var isOpenLightbox = PagSeguroLightbox({
                code: data,
            }, {
                success: function(transactionCode) {
                    console.log("usuario foi ate o final")
                },
                abort: function() {
                    console.log('fechou a janela')
                }
            })

        })


        // alert('click')
    })
})