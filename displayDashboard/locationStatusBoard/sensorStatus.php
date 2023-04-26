<?php foreach ($sensor_array as $row) { ?>
	<div class="sensordashboard">
		<a style="display:block; width:10%" href="../roomMoniter/roomMoniter.php?locationid=<?php echo $row[1]?>&sensorid=<?php echo $row[0]?>"><?php echo $row[0];?></a>
		<a style="display:block; width:10%" <?php if ($row[8] == 'A') echo ' class="active"'; else echo ' class = "down"'?>><?php if ($row[8] == 'A') echo 'Active'; else echo 'Stop'?></a>
		<?php if ($row[8] == 'A'){ ?>
			<?php
				$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?SensorId='.$row[0].'&locationId='.$row[1];
				$json = file_get_contents($url);
				$obj = json_decode($json);
				$acount = 0;
				if ($obj->statusMessage == "Data Found"){
					$acount = count($obj->lstDht_Value);
					$sensor_array = Array();
					$array = json_decode(json_encode($obj->lstDht_Value[0]), true);
					$h = $array["humidity"];
					$t = $array["temperature"];
					$hStatus = 0;
					$tStatus = 0;
					if ($h > $row[3] or $h < $row[2]){
						$hStatus = 1;
					}
					if ($t > $row[5] or $t < $row[4]){
						$tStatus = 1;
					}
				?>
				<a style="display:block; width:1px"></a>
				<a <?php if ($tStatus == 0) echo ' class="active"'; else echo ' class = "down"'?> style="display:block; width:15%"><?php echo $t;?></a>
				<a style="display:block; width:1px"></a>
				<a <?php if ($hStatus == 0) echo ' class="active"'; else echo ' class = "down"'?> style="display:block; width:15%"><?php echo $h;?></a>
				<?php
				}
				else {
					echo "<a>".$obj->statusMessage."</a>";
				}
			?>
			<?php } ?>
			<div class="sensordashboard-right" style = "width:28%">
				<a style = "display:block; width:40%" class="modify" href="../roomMoniter/roomMoniterPro.php?locationid=<?php echo $row[1];?>&sensorid=<?php echo $row[0];?>">Moniter</a>
				<a style="display:block; width:5px"></a>
				<!--<a style = "display:block; width:25%" class="modify" href="../displayDashboard.php?locationid=<?php echo $row[1];?>&sensorid=<?php echo $row[0];?>">All-time<br>Display</a>-->
				<a style = "display:block; width:40%" class="modify" href="../record/records.php?locationid=<?php echo $row[1];?>&sensorid=<?php echo $row[0];?>">Records</a>
			</div>
		
	</div>
	<hr>
<?php } ?>