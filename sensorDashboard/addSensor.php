<html>
	<head>
		<title>Add Sensor</title>
		<link rel="stylesheet" href="../css/styles.css">
	</head>
	<body>
		<?php require "header.php"?>
		<form action="save.php" name="frmAdd" method="post">
			<table width="284" border="1">
				<tr>
					<th width="120">SensorID</th>
					<td width="238"><input type="text" name="txtSensorID" size="10"></td>
				</tr>
				<tr>
					<th width="120">LocationID</th>
					<td><input type="text" name="txtLocationID" size="20"></td>
				</tr>
				<tr>
					<th width="120">Humidity Min.</th>
					<td><input type="text" name="txtHmin" size="6"></td>
				</tr>
				<tr>
					<th width="120">Humidity Max.</th>
					<td><input type="text" name="txtHmax" size="6"></td>
				</tr>
				<tr>
					<th width="120">Temperature Min.</th>
					<td><input type="text" name="txtTmin" size="6"></td>
				</tr>
				<tr>
					<th width="120">Temperature Max.</th>
					<td><input type="text" name="txtTmax" size="6"></td>
				</tr>
				<tr>
					<th width="120">Create By</th>
					<td><input type="text" name="txtCreatby" size="6"></td>
				</tr>
				<tr>
					<th width="120">Status</th>
					<td><input type="text" name="txtStatus" size="6"></td>
				</tr>
				<tr>
					<th width="120">Interval Time</th>
					<td><input type="text" name="txtIntervalTime" size="6"></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="submit">
		</form>
	</body>
</html>