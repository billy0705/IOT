<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Location DashBoard</title>
		<script src="/js/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" href="/css/styles.css?">
	</head>
	<body>
	<div class="header"></div>
		<div >
			<main>
				<hr>
				<?php
					if (isset($_GET['locationid'])){
						$locationid=$_GET['locationid'];
					}
					require "../../../php/LocationID2Name.php";
					
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
				<div class="sensordashboard">
					<a style="display:block; width:10%; font-size:1.5em; font-weight:bold;">Sensor ID</a>
					<a style="display:block; width:10%; font-size:1.5em; font-weight:bold;">Status</a>
					<a style="display:block; width:1px"></a>
					<a style="display:block; width:15%; font-size:1.5em; font-weight:bold;">Temperature</a>
					<a style="display:block; width:1px"></a>
					<a style="display:block; width:15%; font-size:1.5em; font-weight:bold;">Hunidity</a>
							
					<div class="sensordashboard-right" style = "width:28%">
					
					</div>
				</div>
				<hr>
				<?php require "sensorStatus.php"; ?>
			</main>
		</div>
		
		<footer>
			
		</footer>
		
	</body>
	<script src="/js/script.js"></script>
	<!-- ionicon link -->
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>					