<html>
	<head>
		<title>SQL Server Update (PDO)</title>
		<link rel="stylesheet" href="../css/styles.css">
	</head>
	<body>
		<?php require "header.php"?>
		<?php
			$url = "http://10.10.2.108/fromsensor/api/SensorConfig/UpdateSensorConfig?sid=".$_POST["txtSensorID"]
					."&lid=".$_POST["txtLocationID"]
					."&hmin=".$_POST["txtHmin"]
					."&hmax=".$_POST["txtHmax"]
					."&tmin=".$_POST["txtTmin"]
					."&tmax=".$_POST["txtTmax"]
					."&interval=".$_POST["txtIntervalTime"]
					."&status=".$_POST["txtStatus"]
					."&RowID=".$_POST["txtRowID"];
					/*http://10.10.2.108/fromsensor/api/SensorConfig/UpdateSensorConfig?sid=14
					&lid=10
					&hmin=31
					&hmax=62
					&tmin=23
					&tmax=28
					&interval=300
					&RowID=4d3ee533-1cb6-43b7-b8cc-f4019c9e2179 */
			$opts = array('http' =>
				array(
					'method' => 'PUT',
					'header' => 'Content-Length: 0',
				)
			);
			$context = stream_context_create($opts);
			$result = file_get_contents($url, false, $context);
			//echo $url;
			echo $result;
			?>
		</body>
	</html>