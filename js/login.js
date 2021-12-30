$(function() {
    $('#toLogin').on('click',function() {
        sendLoginAJAX();
    })
    
    function sendLoginAJAX() {
        var account = $('#account').val();
        var pwd = $('#pwd').val();

        $.ajax({
            url: '/login.php',
            data: {
                "account": account,
                "pwd": pwd
            },
            type: 'POST',
            dataType: 'text',
            success: function (msg) {
                $('.status').html(msg);
            },
            timeout: 2000,
            error: function () {
                console.error('Error occurs when parsing the data from server!');
            },
        })
    }
})