<?php foreach ($sensor_array as $row) { ?>
	<div class="sensordashboard">
		<a style="display:block; width:150px" href="sensorStatusBoard/sensorStatusBoard.php?sensorid=<?php echo $row[0];?>" ><?php echo $row[0];?></a>
		<a style="display:block; width:100px" <?php if ($row[8] == 'A') echo ' class="active"'; else echo ' class = "down"'?>><?php if ($row[8] == 'A') echo 'Active'; else echo 'Stop'?></a>
		<?php if ($row[8] == 'A'){ ?>
			<?php
				$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?SensorId='.$row[0].'&locationId='.$row[1];
				$json = file_get_contents($url);
				$obj = json_decode($json);
				$acount = 0;
				$hStatus = 0;
				$tStatus = 0;
				if ($obj->statusMessage == "Data Found"){
					$acount = count($obj->lstDht_Value);
					$sensor_array = Array();
					$array = json_decode(json_encode($obj->lstDht_Value[0]), true);
					$h = $array["humidity"];
					$t = $array["temperature"];
					if ($h > $row[3] or $h < $row[2]){
						$hStatus += 1;
					}
					if ($t > $row[5] or $t < $row[4]){
						$tStatus += 1;
					}
				?>
				<a style="display:block; width:10px"></a>
				<a style="display:block; width:200px" <?php if ($tStatus == 0) echo ' class="active"'; else echo ' class = "down"'?>><?php echo $t?></a>
				<a style="display:block; width:10px"></a>
				<a style="display:block; width:180px" <?php if ($hStatus == 0) echo ' class="active"'; else echo ' class = "down"'?>><?php echo $h?></a>
				<?php
				}
				else {
					echo $obj->statusMessage;
				}
			?>
			<?php } ?>
		<div class="sensordashboard-right">
			<a class="modify" href="./sensorStatusBoard/sensorStatusBoard.php?sensorid=<?php echo $row[0]?>">Config</a>
			<a style="display:block; width:10px"></a>
			<a class="modify" href="./modify.php?sensorid=<?php echo $row[0]?>">Modify</a>
		</div>
	</div>
	<hr>
<?php } ?>