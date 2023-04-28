<div class="sensordashboard">
		<a style="display:block; width:150px;" href="sensorStatusBoard/sensorStatusBoard.php?sensorid=">4001</a>
		<a style="display:block; width:200px">PCBA LINE 104</a>
		<a style="display:block; width:200px" >JT WS450</a>
		<a style="display:block; width:100px" class="active">Active</a>
		
		<div class="sensordashboard-right">
			<a class="modify" href="sensorStatusBoard/sensorStatusBoard.php?sensorid=<?php echo $row[0] ?>">Config</a>
			<a style="display:block; width:10px"></a>
			<a class="modify" href="../sensorDashboard/modify.php?sensorid=<?php echo $row[0] ?>">Modify</a>
		</div>
	</div>
	<hr>