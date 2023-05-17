<?php
$statusCode = 200;
$activeLocationCount = 0;
$location_info_array = array();
$username = '';
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
    $hStatus = 1;
    $tStatus = 1;
    $h = "";
    $t = "";
    $Temparray = array();
    $locationID = $row[0];
    $locationName = $row[1];
    // echo $row[0]."<br>".$row[1]."<br>";
    if ($sensor_obj->statusMessage == "Sensor Config Found"){
        $acount = count($sensor_obj->lstSensorConfigs);
        $total = $acount;
        
        for ($i = 0; $i < $acount; $i++){
            $h = 0;
            $t = 0;
            
            // echo print_r($sensor_obj->lstSensorConfigs[$i])."<br>";
            $array = json_decode(json_encode($sensor_obj->lstSensorConfigs[$i]), true);
            if ($array["status"] == 'A'){
                $active += 1;
                $lastdataurl = 'http://localhost/api/dht/lastdata.php?locationid='. $array["locationID"] .'&sensorid=' . $array["sensorID"].'&role=' . $role;
                // echo $lastdataurl."<br>";
                $json = file_get_contents($lastdataurl);
                $obj2 = json_decode($json);
                $data = json_decode(json_encode($obj2), true);
                if ($data["result"] != ''){
                    $stop += 1;
                }
                else{
                    $active += 1;
                    $h = $data["humidity"];
                    $t = $data["temperature"];
                    $hStatus = $data["hStatus"];
                    $tStatus = $data["tStatus"];
                }
                // $activeLocationCount += 1;
            }
            else if($array["status"] == 'S'){
                $lastdataurl = 'http://localhost/api/dht/lastdata.php?locationid='. $array["locationID"] .'&sensorid=' . $array["sensorID"].'&role=' . $role;
                // echo $lastdataurl."<br>";
                $json = file_get_contents($lastdataurl);
                $obj2 = json_decode($json);
                $data = json_decode(json_encode($obj2), true);
                if ($data["result"] != ''){
                    $active += 1;
                    $h = $data["humidity"];
                    $t = $data["temperature"];
                    $hStatus = $data["hStatus"];
                    $tStatus = $data["tStatus"];
                }
                else{
                    $stop += 1;
                }
                
            }
        }
        $Temparray["locationID"] = $locationID;
        $Temparray["locationName"] = $locationName;
        $Temparray["humidity"] = $h;
        $Temparray["temperature"] = $t;
        $Temparray["hStatus"] = $hStatus;
        $Temparray["tStatus"] = $tStatus;
        $Temparray["total"] = $active + $stop;
        $Temparray["active"] = $active;
        $Temparray["stop"] = $stop;
        $activeLocationCount += 1;
        $location_info_array[] = $Temparray;
    }
    else {
        // $statusCode = $sensor_obj->statusCode;
    }
    
}

echo json_encode(array(
    "statusCode" => $statusCode,
    "locationCounts" => $activeLocationCount,
    "locationLists" => $location_info_array,
    // "role" => $role
));


?>