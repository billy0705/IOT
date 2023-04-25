<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Location DashBoard</title>
		<link rel="stylesheet" href="../css/styles.css">
	</head>
	<body>
		<?php require "header.php"?>
		<div >
			<main>
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