<!DOCTYPE html>
<html>
	<head>
		<title>24-Hour Temperature and Humidity Chart</title>
		<link rel="stylesheet" href="../../css/styles.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
		
		
		<!-- <meta http-equiv="refresh" content="10" >  refresh page every 10 seconds -->
		<style>
			#chart-container {
			position: relative;
			width: 70%;
			height: 100vh;
			float: left;
			}
			
			#chart {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100vh;
			}
			th {
			text-align: center;
			vertical-align: middle;
			font-size:30px;
			}
			#Date {
			text-align: center;
			vertical-align: middle;
			font-size:25px;
			}
		</style>
	</head>
	<?php
		// Set database connection details
		$locationid = "10";
		$sensorid = "1234";
		$currentdate = date("Y-m-d");
		if (isset($_GET['locationid'])){
			$locationid=$_GET['locationid'];
		}
		if (isset($_GET['sensorid'])){
			$sensorid=$_GET['sensorid'];
		}
		$file = fopen("../../location.csv","r");
		while(! feof($file)){
			$array = fgetcsv($file);
			if ($array[0] == $locationid){
				$locationName = $array[1];
				break;
			}
		}
		fclose($file);
		$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/'.$sensorid;
		$json = file_get_contents($url);
		$obj = json_decode($json);
		$configarray = json_decode(json_encode($obj->lstSensorConfigs[0]), true);
		//$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocationSensor?locationId='.$locationid.'&SensorId='.$sensorid;
		$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocDate?locationId='.$locationid.'&DataDate='.$currentdate;
		$json = file_get_contents($url);
		$obj = json_decode($json);
		$acount = 0;
		// echo $obj->statusMessage;
		if ($obj->statusMessage == "Data Found"){
			$acount = count($obj->lstDht_Value);
			$temperatures = array();
			$humidities = array();
			$timestamps = array();
			$tmax = array();
			$tmin = array();
			$hmax = array();
			$hmin = array();
			for ($i = 0; $i < $acount; $i++){
				//echo print_r($obj->lstDht_Value[$i])."<br>";
				$array = json_decode(json_encode($obj->lstDht_Value[$i]), true);
				$temperatures[] = $array["temperature"];
				$humidities[] = $array["humidity"];
				$timestamps[] = $array["dataDate"];
				$tmax[] = $configarray["tmax"];
				$tmin[] = $configarray["tmin"];
				$hmax[] = $configarray["hmax"];
				$hmin[] = $configarray["hmin"];
			}
			$temperatures = array_reverse($temperatures);
			$humidities = array_reverse($humidities);
			$timestamps = array_reverse($timestamps);
		}
		else {
			echo $obj->statusMessage;
		}
	?>
	<body>
		<?php require "../header.php"?>
		
		<div id="chart-container">
			<canvas id="chart"></canvas>
		</div>
		<div style="float:right; width:30%;">
			<button id="reset-zoom-button">Reset Zoom</button>
			<a id="simple" href="./roomMoniter.php?locationid=<?php echo $locationid;?>&sensorid=<?php echo $sensorid;?>">Simple Moniter</a>
			<a id="simple" href="./roomMoniterPro.php?locationid=<?php echo $locationid;?>&sensorid=<?php echo $sensorid;?>">5 Min</a>
			<a id="simple" href="./roomMoniterPro30min.php?locationid=<?php echo $locationid;?>&sensorid=<?php echo $sensorid;?>">30 Min</a>
			<div class="" style="float:right; margin: auto;">
				<a style = "width : 150px" class="modify" href="../locationStatusBoard/locationStatusBoard.php?locationid=<?php echo $locationid;?>">Back</a>
			</div>
			<table border="1" style="width:100%; height:50vh;">
				<tbody style="width:100%; height:100%;">
					<tr>
						<th rowspan="2"style="width:30%;font-size:1rem;">SensorID :</th>
						<th id="txtSID" rowspan="2" style="width:70%"><?php echo $sensorid?></th>
					</tr>
					<tr></tr>
					<tr>
						<th rowspan="2"style="width:30%;font-size:1rem;">LocationID :</th>
						<th id="txtLID" rowspan="2" style="width:70%"><?php echo $locationName?></th>
					</tr>
					<tr></tr>
					<tr>
						<th rowspan="2"style="width:30%;font-size:1rem;">Temperature :</th>
						<th id="txtTemp" rowspan="2" style="width:70%"></th>
					</tr>
					<tr></tr>
					<tr>
						<th rowspan="2"style="width:30%;font-size:1rem;">Humidity :</th>
						<th id="txtHumid" rowspan="2" style="width:70%"></th>
					</tr>
					<tr></tr>
					<tr>
						<th id="Date" colspan="2" style="width:100%"></th>
					</tr>
				</tbody>
			</table>
		</div>
		
		
		
		
		<script>
			
			timeArray = <?php echo json_encode($timestamps); ?>;
			temperatureArray = <?php echo json_encode($temperatures); ?>;
			humidityArray = <?php echo json_encode($humidities); ?>;
			inputData = {};
			
			var timeoffset = 7;
			//console.log(timearray);
			var chartData = {
				labels: timeArray,
				datasets: [
				{
					label: 'Temperature',
					data:temperatureArray,
					borderColor: 'green',
					fill: false
				},
				{
					label: 'Humidity',
					data: humidityArray,
					borderColor: 'blue',
					fill: false
				},
				{
					data: <?php echo json_encode($tmax); ?>,
					fill: false,
					borderColor: 'rgba(255, 0, 0, 0.3)',
					label: 'Temperature Upper Limit',
					pointRadius: 0,
					pointHoverRadius: 0,
				},
				{
					data: <?php echo json_encode($tmin); ?>,
					fill: 2,
					borderColor: 'rgba(255, 0, 0, 0.3)',
					backgroundColor: 'rgba(0, 255, 0, 0.3)',
					label: 'Temperature Lower Limit',
					pointRadius: 0,
					pointHoverRadius: 0
					
				},
				{
					data: <?php echo json_encode($hmax); ?>,
					fill: false,
					borderColor: 'rgba(255, 0, 0, 0.3)',
					label: 'Humidity Upper Limit',
					pointRadius: 0,
					pointHoverRadius: 0
				},
				{
					data: <?php echo json_encode($hmin); ?>,
					fill: 4,
					borderColor: 'rgba(255, 0, 0, 0.3)',
					backgroundColor: 'rgba(0, 255, 0, 0.3)',
					label: 'Humidity Lower Limit',
					pointRadius: 0,
					pointHoverRadius: 0
				}
				]
			};
			
			var chartOptions = {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					xAxes: [{
						type: 'time',
						time: {
							parser: 'YYYY-MM-DDTHH:mm:ss',
							tooltipFormat: 'YYYY-MM-DDTHH:mm:ss',
							unit: 'hour',
						},
					}],
				},
			};
			
			var ctx = document.getElementById('chart').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'line',
				data: chartData,
				options: chartOptions
			});
			
			
			
			// Function to update chart data
			function updateChartData() {
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
					/* console.log(result.temperature);
					console.log(result.humidity);
					console.log(result.timestamp); */
					
					last_date = timeArray[timeArray.length - 1];
					
					//console.log(last_date);
					if (last_date != result.timestamp){
						timeArray.push(result.timestamp);
						temperatureArray.push(result.temperature);
						humidityArray.push(result.humidity);
						
						/* chart.data.datasets[0].data.push(result.temperature);
						chart.data.datasets[1].data.push(result.humidity);
						chart.data.datasets[2].data.push(<?php echo $configarray["tmax"]?>);
						chart.data.datasets[3].data.push(<?php echo $configarray["tmin"]?>);
						chart.data.datasets[4].data.push(<?php echo $configarray["hmax"]?>);
						chart.data.datasets[5].data.push(<?php echo $configarray["hmin"]?>);
						chart.data.labels.push(result.timestamp);
						
						chart.update(); */
					}
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
			
			
			 function handleInputData() {
				//console.log(timearray);
				inputData = {};
				//var d=document.getElementById('Date');
				
				for (var i = 0; i < timeArray.length; i++){
					time = moment(timeArray[i])
					time.add(timeoffset, 'hours');
					//console.log(time);
					//console.log(typeof time);
					var roundedTime = new Date(Math.ceil(time.valueOf() / (15 * 60 * 1000)) * 15 * 60 * 1000);
					var roundedTimeString = roundedTime.toISOString();
					//console.log(roundedTimeString);
					
					 if (inputData[roundedTimeString]) {
						inputData[roundedTimeString].tempsum += temperatureArray[i];
						inputData[roundedTimeString].humidsum += humidityArray[i];
						inputData[roundedTimeString].count++;
					} else {
						inputData[roundedTimeString] = {
							tempsum: temperatureArray[i],
							humidsum: humidityArray[i],
							count: 1
						};
					} 
				}
				//d.innerHTML=time.getUTCHours();
				
				//console.log(inputData);
			} 
			
			function updateChart() {
				var timedata = [];
				var tempdata = [];
				var humiddata = [];
				var tmaxdata = [];
				var tmindata = [];
				var hmaxdata = [];
				var hmindata = [];
				
				for (var time in inputData) {
					var tempaverage = inputData[time].tempsum / inputData[time].count;
					var humidaverage = inputData[time].humidsum / inputData[time].count;
					timedata.push(time);
					tempdata.push(tempaverage);
					humiddata.push(humidaverage);
					tmaxdata.push(<?php echo $configarray["tmax"]?>);
					tmindata.push(<?php echo $configarray["tmin"]?>);
					hmaxdata.push(<?php echo $configarray["hmax"]?>);
					hmindata.push(<?php echo $configarray["hmin"]?>);
				}
				/* console.log(timedata);
				console.log(tempdata);
				console.log(humiddata); */ 
				
				chart.data.labels = timedata;
				chart.data.datasets[0].data = tempdata;
				chart.data.datasets[1].data = humiddata;
				chart.data.datasets[2].data = tmaxdata;
				chart.data.datasets[3].data = tmindata;
				chart.data.datasets[4].data = hmaxdata;
				chart.data.datasets[5].data = hmindata;
				//console.log(chart.data.labels);
				chart.update();
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
					//console.log(time);
				date.setUTCHours(date.getUTCHours() + timeoffset);
				var roundedTime = new Date(Math.ceil(date.getTime() / (15 * 60 * 1000)) * 15 * 60 * 1000);
				var roundedTimeString = roundedTime.toISOString();
				if (roundedTimeString != chart.data.labels[chart.data.labels.length - 1]){
					console.log(roundedTimeString);
					console.log(chart.data.labels[chart.data.labels.length - 1]);
					handleInputData();
					updateChart();
				}
				//d.innerHTML = Intl.DateTimeFormat().resolvedOptions().timeZone;
				//d.innerHTML=roundedTimeString + chart.data.labels[chart.data.labels.length - 1];
			}
			
			window.onload=function(){
				handleInputData();
				setInterval(printTime,1000);
				setInterval(updateChartData,60000);
				updateChartData();
				updateChart();
				console.log("set");
				//console.log("JavaScript version: " + (typeof BigInt === "function" ? "ES2020+" : "ES5 or ES6"));
			}
			/* // Call updateChartData function every 10 seconds
				setInterval(function() {
			updateChartData();}, 60000); */ // Update every 10 seconds
			document.getElementById("reset-zoom-button").addEventListener("click", function() {
				chart.resetZoom();
			});
		</script>
	</body>
</html>
