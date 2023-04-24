<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Location DashBoard</title>
		<link rel="stylesheet" href="../css/styles.css">
	</head>
	<body>
		<?php require "header.php"?>
		<div >
			<main>
				<hr>
				<?php
					$file = fopen("../location.csv","r");
					$sensor_array = Array();
					$count = 0;
					while(! feof($file)){
						//print_r(fgetcsv($file));
						$sensor_array[] = fgetcsv($file);
						$count = $count + 1;
					}
					fclose($file);
					require "locationStatus.php";
					
				?>
				
			</main>
		</div>
		
		<footer>
			
		</footer>
		
	</body>
</html>					