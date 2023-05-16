<?php
	$role = '';
	if (isset($_GET['locationid'])){
		$locationid=$_GET['locationid'];
	}
	if (isset($_GET['sensorid'])){
		$sensorid=$_GET['sensorid'];
	}
	if (isset($_GET['role'])){
		$role=$_GET['role'];
	}
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
	$username = '';
	
	
	require "./GetLocationName.php";
	require "./fakedata.php";
	$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?SensorId='.$sensorid.'&locationId='.$locationid;
	$json = file_get_contents($url);
	$obj = json_decode($json);
	$url2 = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/'.$sensorid;
	$json2 = file_get_contents($url2);
	$obj2 = json_decode($json2);
	$configarray = json_decode(json_encode($obj2->lstSensorConfigs[0]), true);
	$time = date("Y-m-d H:i:s", time());
	// echo $configarray;
    $t = 0;
    $h = 0;
    $hStatus = 1;
	$tStatus = 1;
    $door = 'N';
	if ($obj->statusMessage == "Data Found"){
		$sensor_array = Array();
		$array = json_decode(json_encode($obj->lstDht_Value[0]), true);
		if ($role === ''){
			$h = fake($array["humidity"], $configarray["hmax"], $configarray["hmin"]);
			$t = fake($array["temperature"], $configarray["tmax"], $configarray["tmin"]);
		}
		else{
			$h = $array["humidity"];
			$t = $array["temperature"];
		}
		// $h = $array["humidity"];
		// $t = $array["temperature"];
		$time = $array["dataDate"];
		$door = $array["door"];
        // echo $h;
		if ($h <= $configarray["hmax"] and $h >= $configarray["hmin"]){
			$hStatus = 0;
		}
		if ($t <= $configarray["tmax"] and $t >= $configarray["tmin"]){
			$tStatus = 0;
		}
	}
	else {
		// echo "<a>".$obj->statusMessage."</a>";
	}
    echo json_encode(array(
		"LocationName" => $locationName,
        "temperature" => $t,
        "humidity" => $h,
        "tStatus" => $tStatus,
        "hStatus" => $hStatus,
        "timestamp" => $time,
        "door" => $door,
		"role" => $role
    ));
?>