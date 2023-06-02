<?php
    // Set database connection details
    $statusCode = 200;
    $username = '';
    $auth = '';
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
    $currentdate = date("Y-m-d");
    if (isset($_GET['locationid'])){
        $locationid=$_GET['locationid'];
    }
    if (isset($_GET['sensorid'])){
        $sensorid=$_GET['sensorid'];
    }
    if (isset($_GET['timeInterval'])){
        $timeInterval=$_GET['timeInterval'];
    }
    require "GetLocationName.php";
    require "fakedata.php";
    $url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/'.$sensorid;
    $json = file_get_contents($url);
    $obj = json_decode($json);
    $configarray = json_decode(json_encode($obj->lstSensorConfigs[0]), true);
    //$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?locationId='.$locationid.'&SensorId='.$sensorid;
    $url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocDate?locationId='.$locationid.'&DataDate='.$currentdate;
    // echo $url;
    $json = file_get_contents($url);
    $obj = json_decode($json);
    $acount = 0;
    $temperatures = array();
    $humidities = array();
    $timestamps = array();
    $tmax = array();
    $tmin = array();
    $hmax = array();
    $hmin = array();
    $door = array();
    // echo $obj->statusMessage;
    if ($obj->statusMessage == "Data Found"){
        $acount = count($obj->lstDht_Value);
        
        for ($i = 0; $i < $acount; $i++){
            //echo print_r($obj->lstDht_Value[$i])."<br>";
            $array = json_decode(json_encode($obj->lstDht_Value[$i]), true);
            if ($auth === ''){
                $temperatures[] = fake($array["temperature"], $configarray["tmax"], $configarray["tmin"]);
                $humidities[] = fake($array["humidity"], $configarray["hmax"], $configarray["hmin"]);
            }
            else{
                $temperatures[] = $array["temperature"];
                $humidities[] = $array["humidity"];
            }
            $timestamps[] = $array["dataDate"];
            $tmax[] = $configarray["tmax"];
            $tmin[] = $configarray["tmin"];
            $hmax[] = $configarray["hmax"];
            $hmin[] = $configarray["hmin"];
            $door[] = $array["door"];
        }
        $temperatures = array_reverse($temperatures);
        $humidities = array_reverse($humidities);
        $timestamps = array_reverse($timestamps);
        $door = array_reverse($door);
    }
    else {
        // echo $obj->statusMessage;
    }
    echo json_encode(array(
        "statusCode" => $statusCode,
        "locationName" => $locationName,
        "configarray" => $configarray,
        "timestamps" => json_encode($timestamps),
        "temperatures" => json_encode($temperatures),
        "humidities" => json_encode($humidities),
        "door" => json_encode($door),
        "tmax" => json_encode($tmax),
        "tmin" => json_encode($tmin),
        "hmax" => json_encode($hmax),
        "hmin" => json_encode($hmin)
    ));
