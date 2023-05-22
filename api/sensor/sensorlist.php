<?php
$statusCode = 200;	
$sensor_count = 0;
$role = '';
if (isset($_COOKIE['auth_token'])) {
    $token = $_COOKIE['auth_token'];
    $userInfo = json_decode(base64_decode($token), true);
    if ($userInfo !== null) {
        $username = $userInfo['username'];
        $role = $userInfo['role'];
    } else {
        $username = '';
        $role = '';
    }
}		
$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorConfig';
$json = file_get_contents($url);
$sensor_obj = json_decode($json);
$acount = 0;
if ($sensor_obj->statusMessage == "Data Found"){
    $acount = count($sensor_obj->lstSensorConfigs);
    $sensor_array = Array();
    $h = 0;
    $t = 0;
    $hStatus = 0;
    $tStatus = 0;
    for ($i = 0; $i < $acount; $i++){
        //echo print_r($obj->lstSensorConfigs[$i])."<br>";
        $array = json_decode(json_encode($sensor_obj->lstSensorConfigs[$i]), true);
        $locationid = $array["locationID"];
        require "../dht/GetLocationName.php";
        $lastdataurl = 'http://localhost/api/dht/lastdata.php?locationid='. $array["locationID"] .'&sensorid=' . $array["sensorID"].'&role=' . $role;
        $json = file_get_contents($lastdataurl);
        // echo $lastdataurl;
        $data_obj = json_decode($json);
        $data = json_decode(json_encode($data_obj), true);
        $h = $data["humidity"];
        $t = $data["temperature"];
        $hStatus = $data["hStatus"];
        $tStatus = $data["tStatus"];
        $Temparray = Array();
        $Temparray["sensorID"] = $array["sensorID"];
        $Temparray["locationID"] = $array["locationID"];
        $Temparray["locationName"] = $locationName;
        $Temparray["temperature"] = $t;
        $Temparray["humidity"] = $h;
        $Temparray["tStatus"] = $tStatus;
        $Temparray["hStatus"] = $hStatus;
        $Temparray[] = $array["hmin"];
        $Temparray[] = $array["hmax"];
        $Temparray[] = $array["tmin"];
        $Temparray[] = $array["tmax"];
        $Temparray[] = $array["createdate"];
        $Temparray[] = $array["createby"];
        $Temparray["status"] = $array["status"];
        $Temparray[] = $array["intervalTime"];
        // echo print_r($Temparray)."<br>";
        $sensor_array[] = $Temparray;
        $sensor_count += 1;
    }
    // require "sensorstatus.php";
}
else {
    // echo $obj->statusMessage;
}


echo json_encode(array(
    "statusCode" => $statusCode,
    "sensorCount" => $sensor_count,
    "sensorLists" => $sensor_array
));