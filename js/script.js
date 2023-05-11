$(document).ready(function () {
    // setCookie('username', 'user', 1);
    
    
    var loginStatus = isLoggedIn();
    
    // header.html import
    $.ajax({
        url: '/header.html',
        success: function (data) {
            $('.header').html(data);
            
        }
    });

    // Login BTN
    changeLogBtn(loginStatus);
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
            setCookie('username', 'billy', 7);
            loginStatus = isLoggedIn();
            $(this).text('Logout');
        }
        changeLogBtn(loginStatus);
    });

    // Current Link display
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
});



// Get the login form and message element
// const loginForm = document.querySelector('form');
// const message = document.getElementById('message');

function changeLogBtn(loginStatus) {
    if (loginStatus){
        document.getElementsByClassName("login-btn").innerHTML = 'Logout';
        // $('.login-btn').textContent('Login');
    }
    else {
        document.getElementsByClassName("login-btn").innerHTML = 'Login';
        // $('.login-btn').textContent('Logout');
    }
}

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
        console.log("Login Successful");
    }
    else {
        console.log("Login Fail");
    }
    return loginStatus;
}

// Function to handle login form submission
function handleLogin(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    // Check if username and password are correct
    if (username === 'user' && password === '123') {
        setCookie('username', username, 7);
        message.innerText = 'Login successful!';
        loginForm.reset();
    } else {
        message.innerText = 'Invalid username or password.';
    }
}

// Add event listener to login form
// loginForm.addEventListener('submit', handleLogin);

// Check if user is already logged in
// if (isLoggedIn()) {
//     message.innerText = 'Welcome back, ' + getCookie('username') + '!';
// }