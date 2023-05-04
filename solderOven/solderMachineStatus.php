<?php
$url = 'http://10.10.2.108/Solder/api/JT_WS450/JT_WS450Config';
$json = file_get_contents($url);
$obj = json_decode($json);
//$acount = 0;
$count = 0;
$machine_array = array();
// echo $obj->statusMessage;
if ($obj->statusCode == 200) {
	$acount = count($obj->jT_WS450_Configs);
	for ($i = 0; $i < $acount; $i++) {
		$array = json_decode(json_encode($obj->jT_WS450_Configs[$i]), true);
		$Temparray = array();
		$Temparray[] = $array["machineID"];
		$Temparray[] = $array["locationID"];
		$Temparray[] = $array["machineModel"];
		$machine_array[] = $Temparray;
		$count = $count + 1;
	}
}
?>
<?php foreach ($location_array as $row) { ?>
	<?php
	$fund_f = false;
	for ($i = 0; $i < $count; $i++) {
		if ($machine_array[$i][1] == $row[0]) {
			$machineid = $machine_array[$i][0];
			$machineModel = $machine_array[$i][2];
			$fund_f = true;
			break;
		}
	}
	?>
	<?php if ($fund_f) { ?>
		<div class="sensordashboard">
			<a style="display:block; width:15%; font-size:1em;"><?php echo $row[0];?></a>
			<a style="display:block; width:15%; font-size:1em;"><?php echo $machineid;?></a>
			<a style="display:block; width:15%; font-size:1em;"><?php echo $row[1];?></a>
			<a style="display:block; width:15%; font-size:1em;"><?php echo $machineModel;?></a>
			<a style="display:block; width:10%; font-size:1em;" class="active">Active</a>

			<div class="sensordashboard-right">
				<a class="modify" href="ovenDisplay.php?machineID=<?php echo $machineid;?>">DashBoard</a>
			</div>
		</div>
		<hr>
	<?php } ?>
<?php } ?>