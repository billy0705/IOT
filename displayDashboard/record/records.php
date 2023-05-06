<!doctype html public >
<html>
	<head>
		<title>Temperature and Humidity Records</title>
		<link rel="stylesheet" href="../../css/styles.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
	</head>
	<body >
		<?php require "../header.php"?>
		<?Php
			//header("Refresh: 10;");
			// require "config.php";// Database connection
			$ahmin='%';
			$ahmax='%';
			$atmin='%';
			$atmax='%';
			$locationid='10';
			$sensorid='1234';
			$selectdate=date('Y-m-d');
			$errorsql='AND';
			$timeInterval = 5;
			
			
			if (isset($_GET['ahmin'])){
				$ahmin=$_GET['ahmin'];
			}
			if (isset($_GET['ahmax'])){
				$ahmax=$_GET['ahmax'];
			}
			if (isset($_GET['atmin'])){
				$atmin=$_GET['atmin'];
			}
			if (isset($_GET['atmax'])){
				$atmax=$_GET['atmax'];
			}
			if (isset($_GET['locationid'])){
				$locationid=$_GET['locationid'];
				}
			if (isset($_GET['sensorid'])){
				$sensorid=$_GET['sensorid'];
			}
			if (isset($_GET['selectdate'])){
				$selectdate=$_GET['selectdate'];
			}
			if (isset($_GET['timeInterval'])){
				$timeInterval=$_GET['timeInterval'];
			}
			require "../../php/LocationID2Name.php";
			require "../../php/fakedata.php";
			$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/'.$sensorid;
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$configarray = json_decode(json_encode($obj->lstSensorConfigs[0]), true);
			//$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocation?locid=' . $locationid;
			$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocDate?locationId='.$locationid.'&DataDate='.$selectdate;
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$acount = 0;
			// echo $obj->statusMessage;
			if ($obj->statusMessage == "Data Found"){
				$acount = count($obj->lstDht_Value);
				$php_data_array = Array();
				$temperatures = array();
				$humidities = array();
				$timestamps = array();
				$tmax = array();
				$tmin = array();
				$hmax = array();
				$hmin = array();
				$door = array();
				for ($i = 0; $i < $acount; $i++){
					//echo print_r($obj->lstDht_Value[$i])."<br>";
					$array = json_decode(json_encode($obj->lstDht_Value[$i]), true);
					$Temparray = Array();
					// $temperatures[] = $array["temperature"];
					// $humidities[] = $array["humidity"];
					$temperatures[] = fake($array["temperature"], $configarray["tmax"], $configarray["tmin"]);
					$humidities[] = fake($array["humidity"], $configarray["hmax"], $configarray["hmin"]);
					$timestamps[] = $array["dataDate"];
					$tmax[] = $configarray["tmax"];
					$tmin[] = $configarray["tmin"];
					$hmax[] = $configarray["hmax"];
					$hmin[] = $configarray["hmin"];
					$door[] = $array["door"];
					$Temparray[] = $array["sensorID"];
					$Temparray[] = $array["locationID"];
					$Temparray[] = $array["dataDate"];
					// $Temparray[] = $array["humidity"];
					// $Temparray[] = $array["temperature"];
					$Temparray[] = fake($array["humidity"], $configarray["hmax"], $configarray["hmin"]);
					$Temparray[] = fake($array["temperature"], $configarray["tmax"], $configarray["tmin"]);
					// $Temparray[] = $array["ahmin"];
					// $Temparray[] = $array["ahmax"];
					// $Temparray[] = $array["atmin"];
					// $Temparray[] = $array["atmax"];
					$Temparray[] = "N";
					$Temparray[] = "N";
					$Temparray[] = "N";
					$Temparray[] = "N";
					$Temparray[] = $array["door"];
					//echo print_r($Temparray)."<br>";
					$php_data_array[] = $Temparray;
				}
				$temperatures = array_reverse($temperatures);
				$humidities = array_reverse($humidities);
				$timestamps = array_reverse($timestamps);
				$door = array_reverse($door);
				$php_data_array = array_reverse($php_data_array);
			
		
				// echo json_encode($php_data_array);
				
				// Transfor PHP array to JavaScript two dimensional array 
				echo "<script>
				var my_2d = ".json_encode($php_data_array)."
				</script>";
			}
			else {
				echo $obj->statusMessage;
			}
			
			
			
		?>
		<div>
		<?php
			echo date('Y-m-d H:i:s');
			// echo $sql;
			echo "<br>No of records : ".$acount ."<br>";
		?>
		</div>
		<form id="form1" name="form1" method="get" action="">
			<p>
				SensorID:
				<input name="sensorid" type="text" id="sensorid" value="<?php echo $sensorid?>" readonly /><br>
				LocationID:
				<input name="locationid" type="text" id="locationid" value="<?php echo $locationid?>" readonly /><br>
				TimeInterval:
				<input name="timeInterval" type="text" id="timeInterval" value="<?php echo $timeInterval?>" readonly /><br>
				LocationName:
				<a><?php echo $locationName?></a><br>
				Date:
				<input name="selectdate" type="date" id="selectdate" value="<?php echo $selectdate?>" min="2023-03-30" max="<?php echo date('Y-m-d'); ?>">
			</p>
			<p>
				<input type="submit" name="button" id="button" value="Search" />
				<input type="submit" name="download butten" value="Download CSV" formaction = "exportcsv.php" />
			</p>
		</form>
		<div class="" style="float:right; margin: auto;">
			<?php if ($timeInterval != 5){ ?>
			<a style = "width : 150px" class="modify" href="./records.php?locationid=<?php echo $locationid;?>&sensorid=<?php echo $sensorid;?>&selectdate=<?php echo $selectdate;?>&timeInterval=5">5min</a>
			<?php } ?>
			<?php if ($timeInterval != 15){ ?>
			<a style = "width : 150px" class="modify" href="./records.php?locationid=<?php echo $locationid;?>&sensorid=<?php echo $sensorid;?>&selectdate=<?php echo $selectdate;?>&timeInterval=15">15min</a>
			<?php } ?>
			<?php if ($timeInterval != 30){ ?>
			<a style = "width : 150px" class="modify" href="./records.php?locationid=<?php echo $locationid;?>&sensorid=<?php echo $sensorid;?>&selectdate=<?php echo $selectdate;?>&timeInterval=30">30min</a>
			<?php } ?>
			<a style = "width : 150px" class="modify" href="../locationStatusBoard/locationStatusBoard.php?locationid=<?php echo $locationid;?>">back</a>
		</div>
		<!-- <div id="datatable" style="height:200px"></div> -->
		<div class="app" style="height: 50vh;">
			<canvas id="chart"></canvas>
		</div>
		
		
		<br><br><br>
		
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
		
			timeArray = <?php echo json_encode($timestamps); ?>;
			temperatureArray = <?php echo json_encode($temperatures); ?>;
			humidityArray = <?php echo json_encode($humidities); ?>;
			doorArray = <?php echo json_encode($door); ?>;
			var timeInterval = <?php echo $timeInterval; ?>;
			inputData = {};
			var timeoffset = 7;
			console.log(doorArray);
			var chartData = {
				labels: timeArray,
				datasets: [
				{
					label: 'Temperature',
					data: temperatureArray,
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
							unit: 'hour'
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
			handleInputData();
			updateChart();
			
			function handleInputData() {
				//console.log(timearray);
				inputData = {};
				//var d=document.getElementById('Date');
				
				for (var i = 0; i < timeArray.length; i++){
					time = moment(timeArray[i])
					time.add(timeoffset, 'hours');
					//console.log(time);
					//console.log(typeof time);
					var roundedTime = new Date(Math.ceil(time.valueOf() / (timeInterval * 60 * 1000)) * timeInterval * 60 * 1000);
					var roundedTimeString = roundedTime.toISOString();
					//console.log(roundedTimeString);
					var doorS = 0;
					if (doorArray[i] == "O"){
						doorS = 1;
					}
					
					 if (inputData[roundedTimeString]) {
						inputData[roundedTimeString].tempsum += parseFloat(temperatureArray[i]);
						inputData[roundedTimeString].humidsum += parseFloat(humidityArray[i]);
						inputData[roundedTimeString].doorStatus += doorS;
						inputData[roundedTimeString].count++;
					} else {
						inputData[roundedTimeString] = {
							tempsum: parseFloat(temperatureArray[i]),
							humidsum: parseFloat(humidityArray[i]),
							doorStatus: doorS,
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
				var doorStatusColorData = [];
				var doorStatusRadiusData = [];
				
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
					if (inputData[time].doorStatus != 0){
						doorStatusColorData.push("rgba(255, 0, 0, 1)");
						doorStatusRadiusData.push(6);
					}
					else{
						doorStatusColorData.push("rgba(0, 0, 0, 0.1)");
						doorStatusRadiusData.push(3);
					}
				}
				/* console.log(timedata);
				console.log(tempdata);
				console.log(humiddata); */
				
				chart.data.labels = timedata;
				chart.data.datasets[0].data = tempdata;
				chart.data.datasets[0].pointBackgroundColor = doorStatusColorData;
				chart.data.datasets[0].pointRadius = doorStatusRadiusData;
				chart.data.datasets[1].data = humiddata;
				chart.data.datasets[1].pointBackgroundColor = doorStatusColorData;
				chart.data.datasets[1].pointRadius = doorStatusRadiusData;
				chart.data.datasets[2].data = tmaxdata;
				chart.data.datasets[3].data = tmindata;
				chart.data.datasets[4].data = hmaxdata;
				chart.data.datasets[5].data = hmindata;
				//console.log(chart.data.labels);
				chart.update();
			}
			
			// Load the Visualization API and the corechart package.
			google.charts.load('current', {packages: ['table', 'line', 'corechart']});
			google.charts.setOnLoadCallback(drawChart);
			
			function drawChart() {
				
				// data alarm plot
				var data_alarm = new google.visualization.DataTable();
				data_alarm.addColumn('string', 'Time');
				data_alarm.addColumn('string', 'SensorID');
				data_alarm.addColumn('string', 'LocationID');
				data_alarm.addColumn('number', 'Humidity');
				data_alarm.addColumn('number', 'Temperature');
				data_alarm.addColumn('string', 'Humidity Min. Alarm');
				data_alarm.addColumn('string', 'Humidity Max. Alarm');
				data_alarm.addColumn('string', 'Temperature Min. Alarm');
				data_alarm.addColumn('string', 'Temperature Max. Alarm');
				data_alarm.addColumn('string', 'Door Status');
				for(i = my_2d.length - 1; i >= 0; i--){
					// console.log(i);
					if(my_2d[i][5] == "Y" || my_2d[i][6] == "Y" || my_2d[i][7] == "Y" || my_2d[i][8] == "Y"){
						// console.log(my_2d[i][0]);
						data_alarm.addRow([my_2d[i][2], my_2d[i][0].toString(), my_2d[i][1].toString(), parseFloat(my_2d[i][3]), parseFloat(my_2d[i][4]), my_2d[i][5], my_2d[i][6], my_2d[i][7], my_2d[i][8], my_2d[i][9]]);
					}
				};
				var chartoptions = {
					showRowNumber: true,
					width: '100%', 
					height: '100%'
				};
				var chart_alarm = new google.visualization.Table(document.getElementById('alarmtable'));
				chart_alarm.draw(data_alarm, chartoptions);
				
			}
			
			///////////////////////////////
		</script>
		<br>Alarm Records<br>
		<div id = "alarmtable"style="height:200px"></div>
		<br><br>
		</body>
	</html>