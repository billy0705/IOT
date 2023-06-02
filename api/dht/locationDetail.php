<?php
    $statusCode = 200;
    $username = '';
    $auth = '';
    if (isset($_GET['locationid'])){
        $locationid=$_GET['locationid'];
    }
    if (isset($_COOKIE['auth_token'])) {
        $token = $_COOKIE['auth_token'];
        $userInfo = json_decode(base64_decode($token), true);
        if ($userInfo !== null) {
            $username = $userInfo['username'];
            $auth = $userInfo['auth'];
        } else {
            $username = '';
            $auth = '';
        }
    }
    require "./GetLocationName.php";
    $url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByLoc/'.$locationid;
    $json = file_get_contents($url);
    $locationObj = json_decode($json);
    $acount = 0;
    $total = 0;
    $active = 0;
    $stop = 0;
    $sensor_count = 0;
    $location_array = Array();
    $sensor_array = Array();
    $location_array["locationID"] = $locationid;
    $location_array["locationName"] = $locationName;

    if ($locationObj->statusMessage == "Sensor Config Found"){
        $acount = count($locationObj->lstSensorConfigs);
        $total = $acount;
        
        for ($i = 0; $i < $acount; $i++){
            $array = json_decode(json_encode($locationObj->lstSensorConfigs[$i]), true);
            $Temparray = Array();
            $Temparray["sensorID"] = $array["sensorID"];
            $Temparray["locationID"] = $array["locationID"];
            $Temparray["hmin"] = $array["hmin"];
            $Temparray["hmax"] = $array["hmax"];
            $Temparray["tmin"] = $array["tmin"];
            $Temparray["tmax"] = $array["tmax"];
            $Temparray["createdate"] = $array["createdate"];
            $Temparray["createby"] = $array["createby"];
            $Temparray["status"] = $array["status"];
            $Temparray["intervalTime"] = $array["intervalTime"];
            // if ($auth === ''){
            //     $lastdataurl = 'http://localhost/api/dht/lastdatafake.php?locationid='. $array["locationID"] .'&sensorid=' . $array["sensorID"];
            // }
            // else{
            //     $lastdataurl = 'http://localhost/api/dht/lastdata.php?locationid='. $array["locationID"] .'&sensorid=' . $array["sensorID"];
            // }
            $lastdataurl = 'http://localhost/api/dht/lastdata.php?locationid='. $array["locationID"] .'&sensorid=' . $array["sensorID"].'&auth=' . $auth;
            // echo $url;
            $json = file_get_contents($lastdataurl);
            $last_obj = json_decode($json);
            $last_obj = json_decode(json_encode($last_obj), true);
            $Temparray["humidity"] = $last_obj["humidity"];
            $Temparray["temperature"] = $last_obj["temperature"];
            $Temparray["hStatus"] = $last_obj["hStatus"];
            $Temparray["tStatus"] = $last_obj["tStatus"];
            
            if ($array["status"] = 'A'){
                $active += 1;
            }
            else{
                $stop += 1;
            }
            $sensor_count = $sensor_count + 1;
        }
        $sensor_array[] = $Temparray;
    }
    else {
        //echo $obj->statusMessage;
    }
    $location_array["total"] = $active + $stop;
    $location_array["active"] = $active;
    $location_array["stop"] = $stop;
    echo json_encode(array(
        "statusCode" => $statusCode,
        "location_array" => $location_array,
        "sensor_count" => $sensor_count,
        "sensor_array" => $sensor_array,
    ));
?>