<html>
	<head>
		<title>SQL Server Update (PDO)</title>
		<script src="/js/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" href="../css/styles.css">
	</head>
	<body>
	<div class="header"></div>
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
		<script src="/js/script.js"></script>
	<!-- ionicon link -->
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	</html>