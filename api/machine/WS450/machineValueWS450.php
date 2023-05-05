<?php
	if (isset($_GET['machineID'])){
		$machineID=$_GET['machineID'];
	}
	$date = date('Y-m-d');
    $tomorrow = strtotime('+1 day');
    $tomorrow = date('Y-m-d', $tomorrow);
    $url = 'http://10.10.2.108/Solder/api/jt_ws450/JT_WS450ValuesMachineDate?MachineID='.$machineID.'&Fdate='.$date.'&Edate='.$tomorrow;
    // echo $url;
    $json = file_get_contents($url);
    $obj = json_decode($json);
    if ($obj->statusCode == 200) {
        // $data = json_decode(json_encode($obj->jT_WS450_Values[0]), true);
        echo json_encode($obj->jT_WS450_Values[0]);
    }
?>