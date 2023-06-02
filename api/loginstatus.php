<?php
    if (isset($_COOKIE['auth_token'])) {
        $token = $_COOKIE['auth_token'];
        $userInfo = json_decode(base64_decode($token), true);
        if ($userInfo !== null) {
            $username = $userInfo['username'];
            $auth = $userInfo['auth'];
            echo json_encode(array(
                'success' => true,
                'auth' => $auth,
                'message' => 'Login Success',
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Login info Erroe',
            ));
        }
    }
    else{
        echo json_encode(array(
            'success' => false,
            'message' => 'Cookie Erroe',
        ));
    }
?>