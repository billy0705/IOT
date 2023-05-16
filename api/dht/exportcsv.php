<?php 
	
	// Load the database configuration file 
	//require "config.php";// Database connection
			
	$locationid='11';
	$selectdate=date('Y-m-d');
	if (isset($_GET['locationid'])){
		$locationid=$_GET['locationid'];
	}
	if (isset($_GET['selectdate'])){
		$selectdate=$_GET['selectdate'];
	}
	$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocDate?locationId='.$locationid.'&DataDate='.$selectdate;
	$json = file_get_contents($url);
	$obj = json_decode($json);
	$acount = 0;
	// echo $obj->statusMessage;
	if ($obj->statusMessage == "Data Found"){
		$acount = count($obj->lstDht_Value);
		
		$delimiter = ","; 
		$filename = "Location(".$locationid.")_data_" . $selectdate . ".csv"; 
		
		// Create a file pointer 
		$f = fopen('php://memory', 'w'); 
		
		// Set column headers 
		$fields = array('SensorID', 'LocationID', 'DataDate', 'Humidity', 'Temperature', 'Ahmin', 'Ahmax', 'Atmin', 'Atmax', 'door'); 
		fputcsv($f, $fields, $delimiter);
		
		for ($i = 0; $i < $acount; $i++){
			//echo print_r($obj->lstDht_Value[$i])."<br>";
			$array = json_decode(json_encode($obj->lstDht_Value[$i]), true);
			$lineData = array($array['sensorID'], $array['locationID'], $array['dataDate'], $array['humidity'], $array['temperature'], $array['ahmin'], $array['ahmax'], $array['atmin'], $array['atmax'], $array['door']); 
			fputcsv($f, $lineData, $delimiter);
		}
		fseek($f, 0); 
		
		// Set headers to download file rather than displayed 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		
		//output all remaining data on a file pointer 
		fpassthru($f); 
	}
	else {
		echo $obj->statusMessage;
	}
	exit; 
	
?>