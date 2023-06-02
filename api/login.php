<?php

// 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 
    $postData = file_get_contents('php://input');
    
    // 
    $jsonData = json_decode($postData, true);
    
    if ($jsonData) {
        // check username and password match or not
        $username = $jsonData['username'];
        $password = $jsonData['password'];
        if ($username === "user" && $password === "123"){
            $check = true;
            $auth = "admin";
        }
        else if ($username === "ems" && $password === "123"){
            $check = true;
            $auth = "b2";
        }

        else if ($username === "smm" && $password === "123"){
            $check = true;
            $auth = "b1";
        }
        else{
            $check = false;
        }

        $userInfo = [
            'username' => $username,
            'auth' => $auth
        ];
        $token = base64_encode(json_encode($userInfo));
        if ($check){
            $response = [
                'success' => true,
                'message' => 'POST success',
                'username' => $username,
                'auth' =>$auth,
                'token' => $token
            ];
            // setcookie('auth_token', $token, time() + 3600, '/');
            echo json_encode($response);
        }
        else{
            $response = [
                'success' => false,
                'message' => 'username or password error'
            ];
            echo json_encode($response);
        }
    } else {
        // 
        $response = [
            'success' => false,
            'message' => 'JSON Format Error'
        ];
        echo json_encode($response);
    }
} else {
    // 
    $response = [
        'success' => false,
        'message' => 'POST request error',
        'method' => $_SERVER['REQUEST_METHOD'],
        'data' => $_POST
    ];
    echo json_encode($response);
}

?>