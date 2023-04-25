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
				//echo print_r($obj->lstSensorConfigs[$i])."<br>";
				$array = json_decode(json_encode($obj->lstSensorConfigs[$i]), true);
				if ($array["status"] == 'A'){
					$active += 1;
					$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?SensorId='.$array["sensorID"].'&locationId='.$array["locationID"];
					$json = file_get_contents($url);
					$obj2 = json_decode($json);
					if ($obj2->statusMessage == "Data Found"){
						$data = json_decode(json_encode($obj2->lstDht_Value[0]), true);
						$h = $data["humidity"];
						$t = $data["temperature"];
						if ($h > $array["hmax"] or $h < $array["hmin"]){
							$hStatus += 1;
						}
						if ($t > $array["tmax"] or $t < $array["tmin"]){
							$tStatus += 1;
						}
					}
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
		<div class="sensordashboard">
			<a  style="display:block; width:10%">LocationID:<br><?php echo $row[0];?></a>
			<a style="display:block; width:15%">Location Name : <br><?php echo $row[1];?></a>
			<a style="display:block; width:10%">Total Number: <br><?php echo $total;?></a>
			<a style="display:block; width:10%">Now Active : <br><?php echo $active;?></a>
			<a style="display:block; width:10%">Now Stop : <br><?php echo $stop;?></a>
			<a style="display:block; width:15%" <?php if ($tStatus == 0) echo ' class="active"'; else echo ' class = "down"'?>>Temperature<br><?php echo $t?></a>
			<a style="display:block; width:10px"></a>
			<a style="display:block; width:15%" <?php if ($hStatus == 0) echo ' class="active"'; else echo ' class = "down"'?>>Humidity<br><?php echo $h?></a>
			<div class="sensordashboard-right" style = "width:10%">
				<a style = "width:100%" class="modify" href="./locationStatusBoard/locationStatusBoard.php?locationid=<?php echo $row[0];?>">List<br> All Sensor</a>
			</div>
		</div>
		<hr>
	<?php }?>
<?php } ?>