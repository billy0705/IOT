<?php
    if (isset($_COOKIE['auth_token'])) {
        $token = $_COOKIE['auth_token'];
        $userInfo = json_decode(base64_decode($token), true);
        if ($userInfo !== null) {
            $username = $userInfo['username'];
            $role = $userInfo['role'];
            echo json_encode(array(
                'success' => true,
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