<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Sensor Status Board</title>
		<script src="../../js/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="statusboard.css">
	</head>
	<body>
	<div class="header"></div>
		<?php
			$SensorID = "1";
			if (isset($_GET['sensorid'])){
				$SensorID=$_GET['sensorid'];
			}
			$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/' . $SensorID;
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$acount = 0;
			if ($obj->statusMessage == "Sensor Config Found"){
				$acount = count($obj->lstSensorConfigs);
				$array = json_decode(json_encode($obj->lstSensorConfigs[0]), true);
				$sensorID = $array["sensorID"];
				$locationID = $array["locationID"];
				$hmin = $array["hmin"];
				$hmax = $array["hmax"];
				$tmin = $array["tmin"];
				$tmax = $array["tmax"];
				$createdate = $array["createdate"];
				$createby = $array["createby"];
				$status = $array["status"];
				$intervalTime = $array["intervalTime"];
				// echo print_r($Temparray)."<br>";

			}
			else {
				echo $obj->statusMessage;
			}
			$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?SensorId='.$sensorID.'&locationId='.$locationID;
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$acount = 0;
			$h = "";
			$t = "";
			if ($obj->statusMessage == "Data Found"){
				$acount = count($obj->lstDht_Value);
				$sensor_array = Array();
				$array = json_decode(json_encode($obj->lstDht_Value[0]), true);
				$h = $array["humidity"];
				$t = $array["temperature"]; 
			
			}
			else {
				//echo $obj->statusMessage;
			}

		?>
		<div style="height:100vh">
			<div class="" style="height:100vh">
				<div class="config-title" style="height:6vh; background-color: #00ff30;">
					<a class="" href="" style="height:100%;">Sensor Dashboard</a>
				</div>
				<div class="config-id" style="height:13vh; ">
					<div style="background-color: LightSkyBlue;">
						<a class="" >Sensor ID:<br><?php echo $sensorID?></a>
					</div>
					<div style="background-color: PaleTurquoise;">
						<a class="" >Location ID:<br><?php echo $locationID?></a>	
					</div>
				</div>
				<div class="config-table" style="height:45vh;">
					<div class="config-table-row" style="background-color: yellow;">
						<div></div>
						<div><a class="" >Min.</a></div>
						<div><a class="" >Now</a></div>
						<div><a class="" >Max.</a></div>
					</div>
					<div class="config-table-row" style="background-color: pink;">
						<div><a class="" >T</a></div>
						<div><a class="" style="color:red"><?php echo $tmin?></a></div>
						<div><a class="" ><?php echo $t;?></a></div>
						<div><a class="" style="color:red"><?php echo $tmax?></a></div>
					</div>
					<div class="config-table-row" style="background-color: cornsilk;">
						<div><a class="" >H</a></div>
						<div><a class="" style="color:red"><?php echo $hmin?></a></div>
						<div><a class="" ><?php echo $h;?></a></div>
						<div><a class="" style="color:red"><?php echo $hmax?></a></div>
					</div>
					
				</div>
				<div class="config-createinfo" style="height:13vh; ">
					<div style="background-color: greenyellow;">
						<a class="" href="">Create Date:<br><?php echo $createdate?></a>
					</div>
					<div style="background-color: gold;">
						<a class="" href="">Create By:<br><?php echo $createby?></a>	
					</div>
				</div>
				<div class="config-other" style="height:13vh; ">
					<div style="background-color: LightSteelBlue;">
						<a class="" href="">Status:<br><?php echo $status?></a>
					</div>
					<div style="background-color: LightCyan;">
						<a class="" href="">Interval:<br><?php echo $intervalTime?></a>	
					</div>
					<div style="background-color: Gainsboro;">
						<a class="" href="../modify.html?sensorid=<?php echo $sensorID?>">Modify</a>	
					</div>
				</div>
			</div>
		</div>
		<footer>
		</footer>
	</body>
	<script src="../../js/script.js"></script>
	<!-- ionicon link -->
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>					