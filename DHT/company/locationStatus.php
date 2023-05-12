<?php foreach ($sensor_array as $row) { ?>
	<?php
		$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByLoc/'.$row[0];
		$json = file_get_contents($url);
		$obj = json_decode($json);
		$acount = 0;
		$total = 0;
		$active = 0;
		$stop = 0;
		$hStatus = 0;
		$tStatus = 0;
		$h = "";
		$t = "";
		if ($obj->statusMessage == "Sensor Config Found"){
			$acount = count($obj->lstSensorConfigs);
			$total = $acount;
			
			for ($i = 0; $i < $acount; $i++){
				$h = 0;
				$t = 0;
				//echo print_r($obj->lstSensorConfigs[$i])."<br>";
				$array = json_decode(json_encode($obj->lstSensorConfigs[$i]), true);
				if ($array["status"] == 'A'){
					$active += 1;
					$url = 'http://localhost/displayDashboard/company/THnow.php?locationid='. $array["locationID"] .'&sensorid=' . $array["sensorID"];
					$json = file_get_contents($url);
					$obj2 = json_decode($json);
					$data = json_decode(json_encode($obj2), true);
					$h = $data["humidity"];
					$t = $data["temperature"];
					$hStatus = $data["hStatus"];
					$tStatus = $data["tStatus"];
				}
				else{
					$stop += 1;
				}
			}
		}
		else {
			//echo $obj->statusMessage;
		}
	?>
	<?php if ($total != 0) { ?>
		<div class="sensordashboard" style="height:20%">
			<a style="display:block; width:10%; font-size:1em;"><?php echo $row[0];?></a>
			<a style="display:block; width:18%; font-size:1em;"><?php echo $row[1];?></a>
			<a style="display:block; width:8%; font-size:1em;"><?php echo $total;?></a>
			<a style="display:block; width:8%; font-size:1em;"><?php echo $active;?></a>
			<a style="display:block; width:8%; font-size:1em;"><?php echo $stop;?></a>
			<a style="display:block; width:15%; font-size:1em;" <?php if ($tStatus == 0) echo ' class="active"'; else echo ' class = "down"'?>><?php echo $t?></a>
			<a style="display:block; width:10px"></a>
			<a style="display:block; width:15%; font-size:1em;" <?php if ($hStatus == 0) echo ' class="active"'; else echo ' class = "down"'?>><?php echo $h?></a>
			<div class="sensordashboard-right" style = "width:10%">
				<a style = "width:100%; font-size:1em;" class="modify" href="./locationStatusBoard/locationStatusBoard.php?locationid=<?php echo $row[0];?>">Sensor List</a>
			</div>
		</div>
		<hr>
	<?php }?>
<?php } ?>