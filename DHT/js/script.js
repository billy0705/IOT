$(document).ready(function () {
    $.ajax({
        url: '/DHT/header.html',
        success: function (data) {
            // console.log(data);
            $('.header').html(data);
            var url = window.location.pathname;
            console.log(url);
            var links = $('.navbar-link');
            console.log(links);
            links.each(function() {
                var href = $(this).attr('href');
                console.log(href);
                console.log(url.indexOf(href));
                console.log($(this))
                if (href === '/'){
                    if (url === href){
                        $(this).addClass("active");
                    }
                    else{
                        $(this).removeClass("active");
                    }
                }
                else {
                    if (url.includes(href)){
                        $(this).addClass("active");
                    }
                    else{
                        $(this).removeClass("active");
                    }
                }
            });
        }
    });
});