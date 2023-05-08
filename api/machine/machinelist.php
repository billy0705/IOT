<?php
$statusCode = 200;
$machineCount = 0;
$locationCount = 0;
$activeLocationCount = 0;
$date = date('Y-m-d');
$tomorrow = strtotime('+1 day');
$tomorrow = date('Y-m-d', $tomorrow);

$url = 'http://10.10.2.108/Solder/api/JT_WS450/JT_WS450Config';
$json = file_get_contents($url);
$config_obj = json_decode($json);

$machine_array = array();
if ($config_obj->statusCode == 200) {
    $machineCount = count($config_obj->jT_WS450_Configs);
    for ($i = 0; $i < $machineCount; $i++) {
        $array = json_decode(json_encode($config_obj->jT_WS450_Configs[$i]), true);
        $Temparray = array();
        $Temparray[] = $array["machineID"];
        $Temparray[] = $array["locationID"];
        $Temparray[] = $array["machineModel"];
        $machine_array[] = $Temparray;
    }
}
else {
    $statusCode = $config_obj->statusCode;
}

$url = 'http://10.10.2.108/Solder/api/JT_WS450/Location';
$json = file_get_contents($url);
$location_obj = json_decode($json);

$location_array = array();
if ($location_obj->statusCode == 200) {
    $locationCount = count($location_obj->locationConfigs);
    for ($i = 0; $i < $locationCount; $i++) {
        $array = json_decode(json_encode($location_obj->locationConfigs[$i]), true);
        
        $fund_f = false;
        for ($j = 0; $j < $machineCount; $j++) {
            if ($machine_array[$j][1] == $array["locationID"]) {
                $machineid = $machine_array[$j][0];
                $machineModel = $machine_array[$j][2];
                $fund_f = true;
                break;
            }
        }
        
        if ($fund_f) {
            $url = 'http://10.10.2.108/Solder/api/jt_ws450/JT_WS450ValuesMachineDate?MachineID='.$machineid.'&Fdate='.$date.'&Edate='.$tomorrow;
            $json = file_get_contents($url);
            $obj = json_decode($json);
            $machineStatus = $obj->statusMessage;
            $Temparray = array();
            $Temparray["locationID"] = $array["locationID"];
            $Temparray["locationName"] = $array["locationName"];
            $Temparray["machineID"] = $machineid;
            $Temparray["machineModel"] = $machineModel;
            $Temparray["machineStatus"] = $machineStatus;
            $location_array[] = $Temparray;
            $activeLocationCount += 1;
        }
    }
}
else {
    $statusCode = $config_obj->statusCode;
}

echo json_encode(array(
    "statusCode" => $statusCode,
    "locationCounts" => $activeLocationCount,
    "locationLists" => $location_array
));
