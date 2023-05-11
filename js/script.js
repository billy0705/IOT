$(document).ready(function () {
    // setCookie('username', 'user', 1);
    
    
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
    if (loginStatus){
        $('.login-btn').text('Logout');
    }
    else {
        $('.login-btn').text('Login');
    }
    $('.login-btn').click(function() {
        if (loginStatus){
            deleteCookie('username');
            loginStatus = isLoggedIn();
            $(this).text('Login');
        }
        else {
            // setCookie('username', 'billy', 7);
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
    links.each(function() {
        var href = $(this).attr('href');
        // console.log(href);
        // console.log("url-indexOf:",url.indexOf(href));
        // console.log("this:",$(this));
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

    // $("#myBtn").click(function() {
        
    // });
    
    $(".popup-close, .popup-modal").click(function() {
        $(".popup-window").fadeOut();
    });
    
    $(".popup-content").click(function(e) {
        e.stopPropagation();
    });

    $(".login-form").submit(function(event) {

        event.preventDefault();
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        // Check if username and password are correct
        if (username === 'user' && password === '123') {
            alert("Login successful!");
            setCookie('username', username, 7);
            // console.log('Login successful!');
            $('.login-btn').text('Logout');
        } else {
            console.log('Invalid username or password.');
            alert("Login fail !\nInvalid username or password.");
        }
        // $(this).reset();
        $(this).trigger("reset");
        $(".popup-window").fadeOut();
        loginStatus = isLoggedIn();
    });


});

// Function to set a cookie
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
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
    var username = getCookie('username');
    var loginStatus = username !== null
    if (loginStatus) {
        console.log("Login");
    }
    else {
        console.log("Logout");
    }
    return loginStatus;
}

// Function to handle login form submission
function handleLogin(event) {
    event.preventDefault();
    
}
