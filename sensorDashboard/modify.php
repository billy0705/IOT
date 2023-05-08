<html>
	<head>
		<title>Modify Sensor</title>
		<script src="/js/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" href="../css/styles.css">
	</head>
	<body>
	<div class="header"></div>
		<?php
			$SensorID = "1";
			if (isset($_GET['sensorid'])){
				$SensorID=$_GET['sensorid'];
			}
			$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/' . $SensorID;
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$acount = 0;
			if ($obj->statusMessage == "Sensor Config Found"){
				$acount = count($obj->lstSensorConfigs);
				$array = json_decode(json_encode($obj->lstSensorConfigs[0]), true);
				$RowID = $array["rowID"];
				$SensorID = $array["sensorID"];
				$LocationID = $array["locationID"];
				$hmin = $array["hmin"];
				$hmax = $array["hmax"];
				$tmin = $array["tmin"];
				$tmax = $array["tmax"];
				$createdate = $array["createdate"];
				$creatby = $array["createby"];
				$status = $array["status"];
				$intervalTime = $array["intervalTime"];
				// echo print_r($Temparray)."<br>";

			}
			else {
				echo $obj->statusMessage;
			}
		?>
		<form action="update.php" name="frmAdd" method="post">
			<table width="284" border="1">
				<tr>
					<th width="120">RowID</th>
					<td width="238"><input type="text" name="txtRowID" size="10" value=<?php echo $RowID?>></td>
					</tr>
				<tr>
				<tr>
					<th width="120">SensorID</th>
					<td width="238"><input type="text" name="txtSensorID" size="10" value=<?php echo $SensorID?>></td>
					</tr>
				<tr>
					<th width="120">LocationID</th>
					<td><input type="text" name="txtLocationID" size="20" value=<?php echo $LocationID?>></td>
				</tr>
				<tr>
					<th width="120">Humidity Min.</th>
					<td><input type="text" name="txtHmin" size="6" value=<?php echo $hmin?>></td>
				</tr>
				<tr>
					<th width="120">Humidity Max.</th>
					<td><input type="text" name="txtHmax" size="6" value=<?php echo $hmax?>></td>
				</tr>
				<tr>
					<th width="120">Temperature Min.</th>
					<td><input type="text" name="txtTmin" size="6" value=<?php echo $tmin?>></td>
				</tr>
				<tr>
					<th width="120">Temperature Max.</th>
					<td><input type="text" name="txtTmax" size="6" value=<?php echo $tmax?>></td>
				</tr>
				<tr>
					<th width="120">Create By</th>
					<td><input type="text" name="txtCreatby" size="6" value=<?php echo $creatby?>></td>
				</tr>
				<tr>
					<th width="120">Status</th>
					<td><input type="text" name="txtStatus" size="6" value=<?php echo $status?>></td>
				</tr>
				<tr>
					<th width="120">Interval Time</th>
					<td><input type="text" name="txtIntervalTime" size="6" value=<?php echo $intervalTime?>></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="submit">
		</form>
	</body>
	<script src="/js/script.js"></script>
	<!-- ionicon link -->
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>