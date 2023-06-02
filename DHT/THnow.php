<?php
	if (isset($_GET['locationid'])){
		$locationid=$_GET['locationid'];
	}
	if (isset($_GET['sensorid'])){
		$sensorid=$_GET['sensorid'];
	}
	require "./php/fakedata.php";
	$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?SensorId='.$sensorid.'&locationId='.$locationid;
	$json = file_get_contents($url);
	$obj = json_decode($json);
	$url2 = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/'.$sensorid;
	$json2 = file_get_contents($url2);
	$obj2 = json_decode($json2);
	$configarray = json_decode(json_encode($obj2->lstSensorConfigs[0]), true);
	$time = date("Y-m-d H:i:s", time());
	// echo $t;
	if ($obj->statusMessage == "Data Found"){
		$sensor_array = Array();
		$array = json_decode(json_encode($obj->lstDht_Value[0]), true);
		$h = fake($array["humidity"], $configarray["hmax"], $configarray["hmin"]);
		$t = fake($array["temperature"], $configarray["tmax"], $configarray["tmin"]);
		$time = $array["dataDate"];
		$door = $array["door"];
		$hStatus = 0;
		$tStatus = 0;
		if ($h > $configarray["hmax"] or $h < $configarray["hmin"]){
			$hStatus = 0;
		}
		if ($t > $configarray["tmax"] or $t < $configarray["tmin"]){
			$tStatus = 0;
		}
		echo json_encode(array(
			"temperature" => $t,
			"humidity" => $h,
			"tStatus" => $tStatus,
			"hStatus" => $hStatus,
			"timestamp" => $time,
			"door" => $door
		));
	}
	else {
		echo "<a>".$obj->statusMessage."</a>";
	}
?>