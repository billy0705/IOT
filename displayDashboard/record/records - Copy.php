<!doctype html public >
<html>
	<head>
		<title>Temperature and Humidity Records</title>
		<link rel="stylesheet" href="../../css/styles.css">
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
			$locationid='11';
			$selectdate=date('Y-m-d');
			$errorsql='AND';
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
			if (isset($_GET['selectdate'])){
				$selectdate=$_GET['selectdate'];
			}
			//$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocation?locid=' . $locationid;
			$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocDate?locationId='.$locationid.'&DataDate='.$selectdate;
			$json = file_get_contents($url);
			$obj = json_decode($json);
			$acount = 0;
			// echo $obj->statusMessage;
			if ($obj->statusMessage == "Data Found"){
				$acount = count($obj->lstDht_Value);
				$php_data_array = Array();
				for ($i = 0; $i < $acount; $i++){
					//echo print_r($obj->lstDht_Value[$i])."<br>";
					$array = json_decode(json_encode($obj->lstDht_Value[$i]), true);
					$Temparray = Array();
					$Temparray[] = $array["sensorID"];
					$Temparray[] = $array["locationID"];
					$Temparray[] = $array["dataDate"];
					$Temparray[] = $array["humidity"];
					$Temparray[] = $array["temperature"];
					$Temparray[] = $array["ahmin"];
					$Temparray[] = $array["ahmax"];
					$Temparray[] = $array["atmin"];
					$Temparray[] = $array["atmax"];
					//echo print_r($Temparray)."<br>";
					$php_data_array[] = $Temparray;
				}
			}
			else {
				echo $obj->statusMessage;
			}
			$php_data_array = array_reverse($php_data_array);
			
		
			// echo json_encode($php_data_array);
			
			// Transfor PHP array to JavaScript two dimensional array 
			echo "<script>
			var my_2d = ".json_encode($php_data_array)."
			</script>";
			
			
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
				LocationID：
				<input name="locationid" type="text" id="locationid" value="<?php echo $locationid?>" />
				Date：
				<input name="selectdate" type="date" id="selectdate" value="<?php echo $selectdate?>" min="2023-03-30" max="<?php echo date('Y-m-d'); ?>">
			</p>
			<p>
				<input type="submit" name="button" id="button" value="Search" />
				<input type="submit" name="download butten" value="Download CSV" formaction = "exportcsv.php" />
			</p>
		</form>
		<div class="" style="display:inline-block; float:right; margin: auto;">
			<a style = "width : 150px" class="modify" href="./locationStatusBoard/locationStatusBoard.php?locationid=<?php echo $locationid;?>">Back</a>
		</div>
		<!-- <div id="datatable" style="height:200px"></div> -->
		<div class="app">
			
			<div id="curve_chart" style="display:inline-block;background:#f00;"></div>
			<div id="curve_chart2" style="display:inline-block;background:#0f0;margin-left:10px;"></div>
			
		</div>
		
		
		<br><br><br>
		
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			
			// Load the Visualization API and the corechart package.
			google.charts.load('current', {packages: ['table', 'line', 'corechart']});
			google.charts.setOnLoadCallback(drawChart);
			
			function drawChart() {
				
				chartDiv = document.getElementById('curve_chart');
				chartDiv2 = document.getElementById('curve_chart2');
				
				// Create the data table.
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Time');
				data.addColumn('number', 'Temperature');
				data.addColumn('number', 'Humidity');
				var data_T = new google.visualization.DataTable();
				data_T.addColumn('string', 'Time');
				data_T.addColumn('number', 'Temperature');
				data_T.addColumn('number', 'Upper limit');
				data_T.addColumn('number', 'Lower limit');
				var data_H = new google.visualization.DataTable();
				data_H.addColumn('string', 'Time');
				data_H.addColumn('number', 'Humidity');
				data_H.addColumn('number', 'Upper limit');
				data_H.addColumn('number', 'Lower limit');
				for(i = 0; i < my_2d.length; i++){
					data.addRow([my_2d[i][2], parseFloat(my_2d[i][3]), parseFloat(my_2d[i][4])]);
					data_T.addRow([my_2d[i][2], parseFloat(my_2d[i][4]), 28, 23]);
					data_H.addRow([my_2d[i][2], parseFloat(my_2d[i][3]), 30, 60]);
				};
				
				// plot table1
				/* var chartoptions = {
					showRowNumber: true,
					width: '100%', 
					height: '100%'
				};
				var chart = new google.visualization.Table(document.getElementById('datatable'));
				chart.draw(data, chartoptions); */
				
				var materialOptions = {
					chart: {
						title: 'Temperatures and Humidity'
					},
					width: 700,
					height: 500,
					series: {
						// Gives each series an axis name that matches the Y-axis below.
						0: {axis: 'Temps'},
						1: {axis: 'Humidity'}
					},
					axes: {
						// Adds labels to each axis; they don't have to match the axis names.
						y: {
							Temps: {label: 'Temps (Celsius)'},
							Humidity: {label: 'Humidity'}
						},
					}
				};
				var options_T = {
					title: 'Temperature Chart',
					curveType: 'function',
					width: 700,
					height: 500,
					hAxis: {
						title: 'Time'
					},
					vAxis: {
						title: 'Temps (Celsius)',
						ticks: [20, 22, 24, 26, 28, 30]
					},
					series: {
						0: { color: 'blue' },
						1: { color: 'red' },
						2: { color: 'red' }
					}
				};
				var options_H = {
					title : 'Humidity Chart',
					curveType: 'function',
					titleTextStyle: {
						color: 'black'
					},
					width: 700,
					height: 500,
					hAxis: {
						title: 'Time'
					},
					vAxis: {
						title: 'Humidity',
						ticks: [0, 25, 50, 75, 100]
					},
					series: {
						0: { color: 'blue' },
						1: { color: 'red' },
						2: { color: 'red' },
						3: { color: 'red' }
					}
				};
				
				/* var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
				chart.draw(data, materialOptions); */
				/* var materialChart = new google.charts.Line(chartDiv);
				materialChart.draw(data, materialOptions); */
				var materialChart = new google.visualization.LineChart(chartDiv);
				materialChart.draw(data_T, options_T);
				var materialChart2 = new google.visualization.LineChart(chartDiv2);
				materialChart2.draw(data_H, options_H);
				/* var materialChart = new google.charts.Line(document.getElementById('curve_chart'));
				materialChart.draw(data, materialOptions); */
				/* var csv = google.visualization.dataTableToCsv(data);
				console.log(csv); */
				
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
				for(i = my_2d.length - 1; i >= 0; i--){
					// console.log(i);
					if(my_2d[i][5] == "Y" || my_2d[i][6] == "Y" || my_2d[i][7] == "Y" || my_2d[i][8] == "Y"){
						// console.log(my_2d[i][0]);
						data_alarm.addRow([my_2d[i][2], my_2d[i][0].toString(), my_2d[i][1].toString(), parseFloat(my_2d[i][3]), parseFloat(my_2d[i][4]), my_2d[i][5], my_2d[i][6], my_2d[i][7], my_2d[i][8]]);
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
	
	
	
	
	
	
	
