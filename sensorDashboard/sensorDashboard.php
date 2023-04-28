<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Sensor DashBoard</title>
		<link rel="stylesheet" href="../css/styles.css?">
	</head>
	<body>
		<?php require "header.php"?>
		<div >
			<main>
				<hr>
				<div class="sensordashboard">
					<a style="display:block; width:150px; font-size:1.5em; font-weight:bold;">Sensor ID</a>
					<a style="display:block; width:100px; font-size:1.5em; font-weight:bold;">Status</a>
					<a style="display:block; width:10px"></a>
					<a style="display:block; width:200px; font-size:1.5em; font-weight:bold;">Temperature</a>
					<a style="display:block; width:10px"></a>
					<a style="display:block; width:180px; font-size:1.5em; font-weight:bold;">Humidity</a>
					<div class="sensordashboard-right">
						
					</div>
				</div>
				<hr>
				<?php
					
					$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorConfig';
					$json = file_get_contents($url);
					$obj = json_decode($json);
					$acount = 0;
					if ($obj->statusMessage == "Data Found"){
						$acount = count($obj->lstSensorConfigs);
						$sensor_array = Array();
						for ($i = 0; $i < $acount; $i++){
							//echo print_r($obj->lstSensorConfigs[$i])."<br>";
							$array = json_decode(json_encode($obj->lstSensorConfigs[$i]), true);
							$Temparray = Array();
							$Temparray[] = $array["sensorID"];
							$Temparray[] = $array["locationID"];
							$Temparray[] = $array["hmin"];
							$Temparray[] = $array["hmax"];
							$Temparray[] = $array["tmin"];
							$Temparray[] = $array["tmax"];
							$Temparray[] = $array["createdate"];
							$Temparray[] = $array["createby"];
							$Temparray[] = $array["status"];
							$Temparray[] = $array["intervalTime"];
							// echo print_r($Temparray)."<br>";
							$sensor_array[] = $Temparray;
						}
						require "sensorstatus.php";
					}
					else {
						echo $obj->statusMessage;
					}
					?>
				<hr>
				<div class="sensordashboard" style="background-color: Gainsboro;">
					<a href="addSensor.php" style="display:block; width:100%;"> + Add Sensor</a>
				</div>
				<hr>
				
			</main>
		</div>
		
		<footer>
			
		</footer>
		
	</body>
</html>					