<?Php
    //header("Refresh: 10;");
    // require "config.php";// Database connection
    $statusCode = 200;
    $locationid='10';
    $sensorid='1234';
    $selectdate=date('Y-m-d');
    $errorsql='AND';
    $timeInterval = 5;
    
    if (isset($_GET['locationid'])){
        $locationid=$_GET['locationid'];
        }
    if (isset($_GET['sensorid'])){
        $sensorid=$_GET['sensorid'];
    }
    if (isset($_GET['selectdate']) && $_GET['selectdate'] !== null){
        $selectdate=$_GET['selectdate'];
        // echo $selectdate;
    }
    if (isset($_GET['timeInterval']) && $_GET['timeInterval'] !== null){
        $timeInterval=$_GET['timeInterval'];
        // echo $timeInterval;
    }
    require "GetLocationName.php";
    require "fakedata.php";
    $url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/'.$sensorid;
    $json = file_get_contents($url);
    $obj = json_decode($json);
    $configarray = json_decode(json_encode($obj->lstSensorConfigs[0]), true);
    //$url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocation?locid=' . $locationid;
    $url = 'http://10.10.2.108/fromsensor/api/DhtValue/GetDhtValueByLocDate?locationId='.$locationid.'&DataDate='.$selectdate;
    $json = file_get_contents($url);
    $obj = json_decode($json);
    $acount = 0;
    $temperatures = array();
    $humidities = array();
    $timestamps = array();
    $tmax = array();
    $tmin = array();
    $hmax = array();
    $hmin = array();
    $door = array();
    // echo $obj->statusMessage;
    if ($obj->statusMessage == "Data Found"){
        $acount = count($obj->lstDht_Value);
        $php_data_array = Array();
        
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
        // echo "<script>
        // var my_2d = ".json_encode($php_data_array)."
        // </script>";
    }
    else {
        // echo $obj->statusMessage;
    }

    echo json_encode(array(
        "statusCode" => $statusCode,
        "locationName" => $locationName,
        "configarray" => $configarray,
        "timestamps" => json_encode($timestamps),
        "temperatures" => json_encode($temperatures),
        "humidities" => json_encode($humidities),
        "door" => json_encode($door),
        "tmax" => json_encode($tmax),
        "tmin" => json_encode($tmin),
        "hmax" => json_encode($hmax),
        "hmin" => json_encode($hmin),
        "data_array" => json_encode($php_data_array)
    ));
?>