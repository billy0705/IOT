<html>
	<head>
		<title>SQL Server (PDO)</title>
		<script src="/js/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" href="/css/styles.css">
	</head>
	<body>
	<div class="header"></div>
		<?php
			$url = "http://10.10.2.108/fromsensor/api/SensorConfig/AddSensorConfig?sid=".$_POST["txtSensorID"]
					."&lid=".$_POST["txtLocationID"]
					."&hmin=".$_POST["txtHmin"]
					."&hmax=".$_POST["txtHmax"]
					."&tmin=".$_POST["txtTmin"]
					."&tmax=".$_POST["txtTmax"]
					."&createby=".$_POST["txtCreatby"]
					."&status=".$_POST["txtStatus"]
					."&interval=".$_POST["txtIntervalTime"];
			$opts = array('http' =>
				array(
					'method' => 'POST',
					'header' => 'Content-Length: 0',
				)
			);
			$context = stream_context_create($opts);
			$result = file_get_contents($url, false, $context);
			echo $result;
			?>
		</body>
		<script src="/dht/js/script.js"></script>
	<!-- ionicon link -->
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	</html>	