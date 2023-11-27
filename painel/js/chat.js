$(function() {
    // $('form').ajaxForm({
    //     success: function(data) {
    //         console.log(data)
    //     }
    // })

    $(".box-chat-online").scrollTop($(".box-chat-online")[0].scrollHeight);

    $('form').submit(function() {
        insertChat();
        return false;
    })

    $('textarea').keyup(function(e) {
        var code = e.keyCode || e.which;
        if (code == 13) { //Enter KeyCode
            insertChat()
        }
    })

    function insertChat() {
        var msg = $('textarea').val();
        $('textarea').val('');
        $.ajax({
            url: './api/chat.php',
            method: 'post',
            // data: { 'msg': msg }
            data: { 'msg': msg, 'acao': "enviar" }
        }).done(function(data) {
            console.log(data)
            $(".box-chat-online").scrollTop($(".box-chat-online")[0].scrollHeight);
        })

    }

    function retrieveChat() {
        // console.log('Retrieving latest messages');
        $.ajax({
            url: './api/chat.php',
            method: 'post',
            // data: { 'msg': msg }
            data: {}
        }).done(function(data) {
            console.log(data)
            $(".box-chat-online").html(data)
            $(".box-chat-online").scrollTop($(".box-chat-online")[0].scrollHeight);
        })
    }
    setInterval(function() {
        retrieveChat();
    }, 3000)
})