<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Solder Machine DashBoard</title>
		<link rel="stylesheet" href="../css/styles.css?">
	</head>
	<body>
		<?php require "header.php"?>
		<div >
			<main>
				<hr>
				<div class="sensordashboard">
					<a  style="display:block; width:15%; font-size:1.5em; font-weight:bold;">LocationID</a>
					<a style="display:block; width:15%; font-size:1.5em; font-weight:bold;">MachineID</a>
					<a style="display:block; width:15%; font-size:1.5em; font-weight:bold;">LocationName</a>
					<a style="display:block; width:15%; font-size:1.5em; font-weight:bold;">Model</a>
					<a style="display:block; width:10%; font-size:1.5em; font-weight:bold;">Status</a>
					<div class="sensordashboard-right">
						
					</div>
				</div>
				<hr>
				<?php
					$url = 'http://10.10.2.108/Solder/api/JT_WS450/Location';
					$json = file_get_contents($url);
					$obj = json_decode($json);
					//$acount = 0;
					$location_array = array();
					// echo $obj->statusMessage;
					if ($obj->statusCode == 200){
						$acount = count($obj->locationConfigs);
						for ($i = 0; $i < $acount; $i++){
							$array = json_decode(json_encode($obj->locationConfigs[$i]), true);
							$Temparray = array();
							$Temparray[] = $array["locationID"];
							$Temparray[] = $array["locationName"];
							$location_array[] = $Temparray;
						}
					}
					
					require "solderMachineStatus.php";
					
				?>
				<hr>
				<div class="sensordashboard" style="background-color: Gainsboro;">
				<a href="addmachine.php" style="display:block; width:100%;"> + Add Machine</a>
				</div>
				<hr>
				
			</main>
		</div>
		
		<footer>
			
		</footer>
		
	</body>
</html>					