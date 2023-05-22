<?php
    $url = 'http://10.10.2.108/fromsensor/api/Location/GetLocationConfigByID/' . $locationid;
    $json = file_get_contents($url);
    $obj = json_decode($json);
    if ($obj->statusMessage == "Data Found"){
        $locationName = json_decode(json_encode($obj->lstLocationConfigs[0]), true)["locationName"];
    }
?>