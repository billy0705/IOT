<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Location DashBoard</title>
		<link rel="stylesheet" href="/DHT/styles.css?">
	</head>
	<body>
		<?php require "header.php"?>
		<div >
			<main>
				
				<div class="sensordashboard">
					<a  style="display:block; width:10%; font-size:1.5em; font-weight:bold;">LocationID</a>
					<a style="display:block; width:18%; font-size:1.5em; font-weight:bold;">Location Name</a>
					<a style="display:block; width:8%; font-size:1.5em; font-weight:bold;">Total</a>
					<a style="display:block; width:8%; font-size:1.5em; font-weight:bold;">Active</a>
					<a style="display:block; width:8%; font-size:1.5em; font-weight:bold;">Stop</a>
					<a style="display:block; width:15%; font-size:1.5em; font-weight:bold;">Temperature</a>
					<a style="display:block; width:10px"></a>
					<a style="display:block; width:15%; font-size:1.5em; font-weight:bold;">Humidity</a>
					<div class="sensordashboard-right" style = "width:10%">
						<!-- <a style = "width:100%" class="modify"></a> -->
					</div>
				</div>
				<hr>
				<?php
					$url = 'http://10.10.2.108/fromsensor/api/Location/GetListLocationConfig';
					$json = file_get_contents($url);
					$obj = json_decode($json);
					//$acount = 0;
					$count = 0;
					$sensor_array = array();
					// echo $obj->statusMessage;
					if ($obj->statusMessage == "Data Found"){
						$acount = count($obj->lstLocationConfigs);
						for ($i = 0; $i < $acount; $i++){
							$array = json_decode(json_encode($obj->lstLocationConfigs[$i]), true);
							$Temparray = array();
							$Temparray[] = $array["locationID"];
							$Temparray[] = $array["locationName"];
							$sensor_array[] = $Temparray;
							$count = $count + 1;
						}
					}
					
					require "locationStatus.php";
					
				?>
				
			</main>
		</div>
		
		<footer>
			
		</footer>
		
	</body>
</html>					