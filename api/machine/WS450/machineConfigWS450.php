<?php
    $statusCode = 200;
    if (isset($_GET['machineID'])){
        $machineID=$_GET['machineID'];
    }
    $configurl = "http://10.10.2.108/Solder/api/JT_WS450/JT_WS450Config/" . $machineID;
    $json = file_get_contents($configurl);
    $config_obj = json_decode($json);
    if ($config_obj->statusCode == 200) {
        $machineConfig = json_decode(json_encode($config_obj->jT_WS450_Configs[0]), true);
    }
    else {
        $statusCode = $config_obj->statusCode;
    }
    $locationid = $machineConfig["locationID"];
    $locationurl = "http://10.10.2.108/Solder/api/JT_WS450/Location/" . $locationid;
    $json = file_get_contents($locationurl);
    $location_obj = json_decode($json);
    if ($location_obj->statusCode == 200){
        $locationname = json_decode(json_encode($location_obj->locationConfigs[0]), true)["locationName"];
    }
    else {
        $statusCode = $config_obj->statusCode;
    }
    echo json_encode(array(
        "statusCode" => $statusCode,
        "locationName" => $locationname,
        "machineConfig" => $machineConfig
    ));
    ?>