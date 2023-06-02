$(document).ready(function () {

    var loginStatus = isLoggedIn();

    // header.html import
    $.ajax({
        url: '/template/header.html',
        async: false,
        success: function (data) {
            $('.header').html(data);
            console.log("header load succsee!!");
        }
    });

    // Login BTN
    // changeLogBtn(loginStatus);
    if (loginStatus) {
        $('.login-btn').text('Logout');
    }
    else {
        $('.login-btn').text('Login');
    }
    $('.login-btn').click(function () {
        loginStatus = isLoggedIn();
        if (loginStatus) {
            deleteCookie('auth_token');
            loginStatus = isLoggedIn();
            $(this).text('Login');
            location.reload();
        }
        else {
            // loginStatus = isLoggedIn();
            // $(this).text('Logout');
            $(".popup-window").fadeIn();
        }
        // changeLogBtn(loginStatus);
    });

    // Current Link display
    var url = window.location.pathname;
    console.log(url);
    var links = $('.navbar-link');
    // console.log(links);
    links.each(function () {
        var href = $(this).attr('href');
        // console.log(href);
        // console.log("url-indexOf:",url.indexOf(href));
        // console.log("this:",$(this));
        if (href === '/') {
            if (url === href) {
                $(this).addClass("active");
            }
            else {
                $(this).removeClass("active");
            }
        }
        else {
            if (url.includes(href)) {
                $(this).addClass("active");
            }
            else {
                $(this).removeClass("active");
            }
        }
    });


    $(".popup-close, .popup-modal").click(function () {
        $(".popup-window").fadeOut();
    });

    $(".popup-content").click(function (e) {
        e.stopPropagation();
    });

    $(".login-form").submit(function (event) {

        event.preventDefault();
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        login(username, password);
        $(this).trigger("reset");
        $(".popup-window").fadeOut();
    });


});

function login(username, password) {
    message = '';
    var url = '/api/login.php';
    var data = {
        "username": username,
        "password": password
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(function (response) {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('POST 請求失敗');
            }
        })
        .then(function (data) {
            console.log(data);
            if (data.success == true) {
                console.log(data.message);
                alert("Login successful!");
                setCookie(data.username, data.auth, data.token, 1);
                $('.login-btn').text('Logout');
                message = "Login successful!";
                location.reload();
            }
            else {
                message = data.message;
                alert(data.message);
                console.log(data.message);
            }
            loginStatus = isLoggedIn();
            console.log("login status", loginStatus);
            return message;
        })
        .catch(function (error) {
            console.error(error);
        });

}

// Function to set a cookie
function setCookie(value, auth, token, minutes) {
    let expires = "";
    if (minutes) {
        let date = new Date();
        date.setTime(date.getTime() + (minutes * 1 * 60 * 60 * 1000));
        expires = " expires=" + date.toUTCString();
    }
    token = "auth_token" + "=" + (token || "") + ";";
    document.cookie = token + expires + "; path=/";
    // auth=${userInfo.auth}
}

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

}

// Function to get a cookie
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Function to check if user is logged in
function isLoggedIn() {
    loginStatus = false;

    $.ajax({
        url: '/api/loginstatus.php',
        type: 'GET',
        async: false,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            console.log(response.success);
            loginStatus = response.success === true
            if (loginStatus) {
                console.log("Login");
            }
            else {
                console.log("Logout");
            }
        },
        error: function (error) {
            console.error('AJAX GET error:', error);
        }
    });
    return loginStatus;
}

// Function to handle login form submission
function handleLogin(event) {
    event.preventDefault();

}
