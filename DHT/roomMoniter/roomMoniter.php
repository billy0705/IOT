<!doctype html public >
<html>
	<head>
		<title>Room Moniter</title>
		<link rel="stylesheet" href="/DHT/styles.css">
		<style>
			th {
			text-align: center;
			vertical-align: middle;
			font-size:90px;
			}
		</style>
		
	</head>
	<body >
		<?php require "../header.php"?>
		<?php
			if (isset($_GET['locationid'])){
				$locationid=$_GET['locationid'];
			}
			if (isset($_GET['sensorid'])){
				$sensorid=$_GET['sensorid'];
			}
			require "../../php/LocationID2Name.php";
			$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?SensorId='.$sensorid.'&locationId='.$locationid;
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$acount = 0;
			// echo $t;
			if ($obj->statusMessage == "Data Found"){
				$acount = count($obj->lstDht_Value);
				$sensor_array = Array();
				$array = json_decode(json_encode($obj->lstDht_Value[0]), true);
				$h = $array["humidity"];
				$t = $array["temperature"];
				$hStatus = 0;
				$tStatus = 0;
			}
			else {
				echo "<a>".$obj->statusMessage."</a>";
			}
		?>
		<script type="text/javascript">
			window.onload=function(){
				printTime();
				setInterval(printTime,1000);
				printSensorData();
				// setInterval(printSensorData,120000);
			}
			function printTime() {
				
				var d=document.getElementById('Date');
				var date=new Date();
				var year=date.getFullYear();
				var mon=("0" + (date.getMonth() + 1)).slice(-2);
				var da=("0" + (date.getDate())).slice(-2);
				var day=date.getDay();
				var h=("0" + (date.getHours())).slice(-2);
				var m=("0" + (date.getMinutes())).slice(-2);
				var s=("0" + (date.getSeconds())).slice(-2);
				var ary = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
				d.innerHTML=year+'-'+mon+'-'+da+' '+' '+h+':'+m+':'+s+'  '+ary[day];
				if (s === "00"){
					console.log(date);
					printSensorData();
				}
			}
			function printSensorData(){
				var url = "../THnow.php?locationid=<?php echo $locationid;?>&sensorid=<?php echo $sensorid;?>";
				console.log(url);
				var txtTemp=document.getElementById('txtTemp');
				var txtHumid=document.getElementById('txtHumid');
				fetch(url,{
					method: "GET",
					mode: "no-cors",
				})
				.then(res => {
					return res.json(); 
				})
				.then(result  => {
					console.log(result);
					console.log(result.temperature);
					console.log(result.humidity);
					console.log(result.tStatus);
					console.log(result.hStatus);
					txtTemp.innerHTML=result.temperature;
					txtHumid.innerHTML=result.humidity;
					if (result.tStatus == "1"){
						console.log(result.tStatus);
						txtTemp.style.backgroundColor="red";
					}
					else{
						txtTemp.style.backgroundColor="lightgreen";
					}
					if (result.hStatus == "1"){
						txtHumid.style.backgroundColor="red";
					}
					else{
						txtHumid.style.backgroundColor="lightgreen";
					}
				}).catch(err => console.error(err));
			}
		</script>
		<table border="1" style="width:100%; height:100vh;">
			<tbody style="width:100%; height:100%;">
					<tr>
						<th rowspan="2"style="width:30%;font-size:3rem;">SensorID :</th>
						<th id="txtSID" rowspan="2" style="width:70%;font-size:4rem;"><?php echo $sensorid?></th>
					</tr>
					<tr></tr>
					<tr>
						<th rowspan="2"style="width:30%;font-size:3rem;">LocationID :</th>
						<th id="txtLID" rowspan="2" style="width:70%;font-size:4rem;"><?php echo $locationName?></th>
					</tr>
					<tr></tr>
					<tr>
						<th rowspan="2"style="width:30%;font-size:3rem;">Temperature :</th>
						<th id="txtTemp" rowspan="2" style="width:70%;font-size:4rem;"></th>
					</tr>
					<tr></tr>
					<tr>
						<th rowspan="2"style="width:30%;font-size:3rem;">Humidity :</th>
						<th id="txtHumid" rowspan="2" style="width:70%;font-size:4rem;"></th>
					</tr>
					<tr></tr>
					<tr>
						<th id="Date" colspan="2" style="width:100%;font-size:6rem;"></th>
					</tr>
				</tbody>
		</table>
	</body>
</html>







