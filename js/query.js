$(function () {
    var inputBox = $('input#query');
    var contentBox = $('.content-box');
    var startIndex = endIndex = 0;
    var queryString = '';
    var lock = 0;

    inputBox.on('keyup', FastThrottleMe(function () {
            // 发送请求条件：字符长度超过 >= 1, 字符包含汉字
            var ch_reg = new RegExp("[\\u4E00-\\u9FFF]+", "g");

            if (inputBox.val().length >= 1 && ch_reg.test(inputBox.val())) {
                lock = 0;
                startIndex = endIndex = 0;
                var value = inputBox.val();
                value = value.replace(/[^\u4e00-\u9fa5|,]+/, '');

                queryString = value;
                QueryAndParse(value, startIndex);
            }
            else {
                lock = 1;
                contentBox.html('');
                $('.count').html('');
            }
        }
    ))

    $(document).on('scroll', SlowThrottleMe(function () {
        var scrollPercent = 100 * $(window).scrollTop() / ($(document).height() - $(window).height());
        if (scrollPercent >= 90) {
            // 添加记录
            if (startIndex < endIndex) {
                QueryAndParse(queryString, startIndex);
            }
        }
    },))

    function HandleData(data) {
        if (data && data.status == 200 && data.result.length) {
            if (lock) {
                $('.count').html('');
                return;
            }

            if (!startIndex) {
                contentBox.html('');
            }

            for (let i = 0; i < data.result.length; i++) {
                let record = $('<div class="record"></div>');

                let info = $('<div class="info"></div>');
                let title = $('<span class="title"></span>');
                let author = $('<span class="author"></span>');

                let paragraph = $('<div class="paragraph"></div>');
                let tip = $('<div class="tip">点击查看全诗</div>');

                title.html(data.result[i].title);
                author.html(data.result[i].author);
                info.append(title, author);

                paragraph.html('“ ' + data.result[i].paragraph + ' ”');
                record.append(info, paragraph, tip);
                contentBox.append(record);
            }
            startIndex += 20;
        }
        else {
            contentBox.html('');
        }
    }

    function QueryAndParse(queryString, startIndex) {
        $.ajax({
            url: '/requirements/queryProcess.php',
            data: {
                "query_string": queryString,
                "start_index": startIndex
            },
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                endIndex = data.total;
                $('.count').text('查询结果：相关记录 ' + data.total + ' 条');
                HandleData(data);
            },
            timeout: 5000,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                let the_status = XMLHttpRequest.status, readyState = XMLHttpRequest.readyState;
                console.log(`${the_status}\n${readyState}\n${textStatus}\n${errorThrown}`);
            },
        })
    }

    function FastThrottleMe(cb){
        var start = +new Date();
        return function() {
            var now = new Date();
            if(now - start > 100){
                start = now;
                cb();
            }
        }
    }

    function SlowThrottleMe(cb){
        var start = +new Date();
        return function() {
            var now = new Date();
            if(now - start > 400){
                start = now;
                cb();
            }
        }
    }
})