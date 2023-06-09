<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Sensor DashBoard</title>
		<script src="/js/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" href="/css/styles.css?">
	</head>
	<body>
	<div class="header"></div>
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
	<script>
		function checkLoginPage() {
			
			$.ajax({
				url: '/api/loginstatus.php',
				type: 'GET',
				async: false,
				dataType: 'json',
				success: function (response) {
					loginStatus = response.success === true
					if (loginStatus) {
						console.log("Login");
					}
					else {
						console.log("Logout");
						alert("Please Login");
						window.location.href = '/';
						
					}
				},
				error: function (error) {
					console.error('AJAX GET error:', error);
				}
			});
		}
		checkLoginPage();
	</script>
	<script src="/js/script.js"></script>
	<!-- ionicon link -->
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>					