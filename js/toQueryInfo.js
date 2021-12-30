$(function() {
    $('.content-box').on('click', '.record', function() {
        var title = $(this).find('.info .title').text();
        var author = $(this).find('.info .author').text();
        window.open('/queryInfo.php?title=' + title + '&author=' + author);
    })
})