<?php
	
	require('calendar.php');
	require "config.php";// Database connection
	
	date_default_timezone_set('UTC');
	setlocale(LC_ALL, 'en_US');
	
	// get the year and number of week from the query string and sanitize it
	$year  = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
	$month = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT);
	
	// initialize the calendar object
	$calendar = new calendar();
	
	// get the current month object by year and number of month
	$currentMonth = $calendar->month($year, $month);
	
	// get the previous and next month for pagination
	$prevMonth = $currentMonth->prev();
	$nextMonth = $currentMonth->next();
	
	// generate the URLs for pagination
	$prevMonthURL = sprintf('?year=%s&month=%s', $prevMonth->year()->int(), $prevMonth->int());
	$nextMonthURL = sprintf('?year=%s&month=%s', $nextMonth->year()->int(), $nextMonth->int());
	
	// set the active tab for the header
	$activeTab = 'month';
	
	require('header.php'); 
	
?>
<style>
	table, th, td {
		border: 1px solid black;
	}
	td {
		vertical-align:middle;
	}
	td.safe {
		background-color:#00FF00
	}
	td.unsafe {
		background-color:#FF0000
	}
</style>

<section class="month">
	
	<h1>
		<a class="arrow" href="<?php echo $prevMonthURL ?>">&larr;</a> 
		<?php echo $currentMonth->name() ?> <a href="year.php?year=<?php echo $currentMonth->year()->int() ?>"><?php echo $currentMonth->year()->int() ?></a>
		<a class="arrow" href="<?php echo $nextMonthURL ?>">&rarr;</a>
	</h1>
	
	<table>
		<tr>
			<th style="width: 200px;">week</th>
			<?php foreach($currentMonth->weeks()->first()->days() as $weekDay): ?>
			<th style="width: 100px;"><?php echo $weekDay->shortname() ?></th>
			<?php endforeach ?>
		</tr>
		<?php foreach($currentMonth->weeks(6) as $week): ?>
		<tr>
			<td >
				<a href="week.php?year=<?php echo $week->year()->int() ?>&week=<?php echo $week->int() ?>"><?php echo $week ?></a>
			</td>
			<?php foreach($week->days() as $day): ?>
			<?php
				//$date = "" . $day->year()->int() . "-" . $day->month()->int() . "-" . $day;
				$sql = "SELECT DataDate FROM dht_value where DataDate like '%$day%' AND (Ahmin = 1 OR Ahmax = 1 OR Atmin = 1 OR Atmax = 1)";
				$stmt = $connection->query($sql);
				$safeflag = 0;
				if($stmt){
					if ($stmt->num_rows > 0){
						// echo "<br>No of records : ".$stmt->num_rows."<br>";
						$safeflag = 1;
					}
					
				}
			?>
			<td <?php if ($safeflag) echo ' class="unsafe"'; else echo ' class = "safe"'?>>
				<a href="../plottest/records.php?locationid=L1&selectdate=<?php echo $day ?>&button=Search">
					<?php echo ($day->isToday()) ? '<strong>' . $day->int() . '</strong>' : $day->int() ?>
				</a>
			</td>
			<?php endforeach ?>  
		</tr>
		<?php endforeach ?>
	</table>
	
</section>

<?php 
	require('footer.php');
	mysqli_close($connection);	
?>
