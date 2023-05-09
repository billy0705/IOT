<?php
$statusCode = 200;
$activeLocationCount = 0;
$location_info_array = array();


$url = 'http://10.10.2.108/fromsensor/api/Location/GetListLocationConfig';
$json = file_get_contents($url);
$location_obj = json_decode($json);
//$acount = 0;
$count = 0;
$location_array = array();
// echo $obj->statusMessage;
if ($location_obj->statusMessage == "Data Found"){
    $acount = count($location_obj->lstLocationConfigs);
    for ($i = 0; $i < $acount; $i++){
        $array = json_decode(json_encode($location_obj->lstLocationConfigs[$i]), true);
        $Temparray = array();
        $Temparray[] = $array["locationID"];
        $Temparray[] = $array["locationName"];
        $location_array[] = $Temparray;
        $count = $count + 1;
    }
}
else{
    $statusCode = $location_obj->statusCode;
}


foreach ($location_array as $row){
    $url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByLoc/'.$row[0];
    $json = file_get_contents($url);
    $sensor_obj = json_decode($json);
    $acount = 0;
    $total = 0;
    $active = 0;
    $stop = 0;
    $hStatus = 0;
    $tStatus = 0;
    $h = "";
    $t = "";
    if ($sensor_obj->statusMessage == "Sensor Config Found"){
        $acount = count($sensor_obj->lstSensorConfigs);
        $total = $acount;
        
        for ($i = 0; $i < $acount; $i++){
            $h = 0;
            $t = 0;
            $Temparray = array();
            //echo print_r($obj->lstSensorConfigs[$i])."<br>";
            $array = json_decode(json_encode($sensor_obj->lstSensorConfigs[$i]), true);
            if ($array["status"] == 'A'){
                $active += 1;
                $url = 'http://localhost/displayDashboard/THnow.php?locationid='. $array["locationID"] .'&sensorid=' . $array["sensorID"];
                $json = file_get_contents($url);
                $obj2 = json_decode($json);
                $data = json_decode(json_encode($obj2), true);
                $Temparray["locationID"] = $array["locationID"];
                $Temparray["locationName"] = $row[1];
                $Temparray["humidity"] = $data["humidity"];
                $Temparray["temperature"] = $data["temperature"];
                $Temparray["hStatus"] = $data["hStatus"];
                $Temparray["tStatus"] = $data["tStatus"];
                $activeLocationCount += 1;
            }
            else{
                $stop += 1;
            }
            $Temparray["total"] = $active + $stop;
            $Temparray["active"] = $active;
            $Temparray["stop"] = $stop;
            $location_info_array[] = $Temparray;
        }
    }
    else {
        // $statusCode = $sensor_obj->statusCode;
    }
}

echo json_encode(array(
    "statusCode" => $statusCode,
    "locationCounts" => $activeLocationCount,
    "locationLists" => $location_info_array
));


?>