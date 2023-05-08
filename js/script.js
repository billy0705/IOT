$(document).ready(function () {
    $.ajax({
        url: 'http://127.0.0.1/header.html',
        success: function (data) {
            console.log(data);
            $('.header').html(data);
        }
    });
});