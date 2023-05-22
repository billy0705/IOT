<?php
    $statusCode = 200;	
    // $SensorID = "1";
    if (isset($_GET['sensorid'])){
        $SensorID=$_GET['sensorid'];
    }
    $url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/' . $SensorID;
    $json = file_get_contents($url);
    $obj = json_decode($json);
    $acount = 0;
    if ($obj->statusMessage == "Sensor Config Found"){
        $acount = count($obj->lstSensorConfigs);
        $config_array = json_decode(json_encode($obj->lstSensorConfigs[0]), true);
    }
    else {
        echo $obj->statusMessage;
    }

    echo json_encode(array(
        "statusCode" => $statusCode,
        "Config" => $config_array
    ));
?>