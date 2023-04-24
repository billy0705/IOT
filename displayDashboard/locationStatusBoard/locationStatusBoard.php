<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Location DashBoard</title>
		<link rel="stylesheet" href="../../css/styles.css">
	</head>
	<body>
		<?php require "../header.php"?>
		<div >
			<main>
				<hr>
				<?php
					if (isset($_GET['locationid'])){
						$locationid=$_GET['locationid'];
					}
					$file = fopen("../../location.csv","r");
					$sensor_array = Array();
					while(! feof($file)){
						 
						$array = fgetcsv($file);
						if ($array[0] == $locationid){
							$locationName = $array[1];
							break;
						}
					}
					fclose($file);
					
				?>
				<div class="sensordashboard" style="background-color: CornflowerBlue;">
					<a href="locationStatusBoard.php?locationid=<?php echo $locationid;?>" style="display:block; width:15%">Location ID:<br><?php echo $locationid;?></a>
					<a style="display:block; width:25%">Location Name : <br><?php echo $locationName;?></a>
					<?php
						$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByLoc/'.$locationid;
						$json = file_get_contents($url);
						$obj = json_decode($json);
						$acount = 0;
						$total = 0;
						$active = 0;
						$stop = 0;
						if ($obj->statusMessage == "Sensor Config Found"){
							$acount = count($obj->lstSensorConfigs);
							$total = $acount;
							$sensor_array = Array();
							for ($i = 0; $i < $acount; $i++){
								//echo print_r($obj->lstSensorConfigs[$i])."<br>";
								$array = json_decode(json_encode($obj->lstSensorConfigs[$i]), true);
								if ($array["status"] = 'A'){
									$active += 1;
								}
								else{
									$stop += 1;
								}
							}
						}
						else {
							//echo $obj->statusMessage;
						}
						
					?>
					<a style="display:block; width:15%">Total Number: <br><?php echo $total;?></a>
					<a style="display:block; width:15%">Now Active : <br><?php echo $active;?></a>
					<a style="display:block; width:15%">Now Stop : <br><?php echo $stop;?></a>
				</div>
				<hr>
				<?php 
					$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByLoc/'.$locationid;
					$json = file_get_contents($url);
					$obj = json_decode($json);
					$acount = 0;
					if ($obj->statusMessage == "Sensor Config Found"){
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
						require "sensorStatus.php";
					}
					else {
						echo $obj->statusMessage;
					}?>
			</main>
		</div>
		
		<footer>
			
		</footer>
		
	</body>
</html>					