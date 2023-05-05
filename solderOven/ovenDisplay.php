<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Solder Wave Machine</title>
    <link rel="stylesheet" href="../css/styles.css?">
    <style>
        /* 設定表格樣式 */
        svg {
            display: inline-block;
            width: 100%;
            height: 70vh;
            background-color: #32CD32;
        }

        table {
            border-collapse: collapse;
            border-spacing: 5px;
            /* border: none; */
        }

        th,
        td {
            /* border: 1px solid #ddd; */
            border: none;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            background-color: #32CD32;
        }

        th {
            /* background-color: #f2f2f2; */
            font-size: 1.5em;
            font-weight:bold;
            background-color: #00FFFF; 
        }
        thead {
            border: 1px solid #000000;
        }
        td span {
            /* display: inline-block; */
            padding: 0.5rem 0.5rem;
            background-color: #fff;
            height: 50%; 
            width: 70%;
            display: flex;
            justify-content: center;
            align-items: center;
            /* position: absolute; */
            /* top: 0;
            bottom: 0;
            left: 0;
            right: 0; */
        }
    </style>
    </style>
</head>

<body>
    <?php require "header.php"; ?>
    <?php
    $machineID = '40001';
    if (isset($_GET['machineID'])){
        $machineID=$_GET['machineID'];
    }
    $configurl = "http://10.10.2.108/Solder/api/JT_WS450/JT_WS450Config/" . $machineID;
    $json = file_get_contents($configurl);
    $obj = json_decode($json);
    if ($obj->statusCode == 200) {
        $machineConfig = json_decode(json_encode($obj->jT_WS450_Configs[0]), true);
    }
    $locationid = $machineConfig["locationID"];
    $locationurl = "http://10.10.2.108/Solder/api/JT_WS450/Location/" . $locationid;
    $json = file_get_contents($locationurl);
    $obj = json_decode($json);
    if ($obj->statusCode == 200){
        $locationname = json_decode(json_encode($obj->locationConfigs[0]), true)["locationName"];
    }
    ?>
    <!-- <h1>Solder Wave Machine</h1> -->
    <div style="display:flex; height:100%; background-color: #32CD32;">
        <table style="width:50vw; height:100vh; margin: 5px;">
            <thead>
                <tr>
                    <th>Parameter Name</th>
                    <th>SetVal</th>
                    <th>ActVal</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Preheat B1</td>
                    <td><span><?php echo $machineConfig["preheater1BSetting"]; ?></span></td>
                    <td><span id = "txtPh1bv"></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat B2</td>
                    <td><span><?php echo $machineConfig["preheater2BSetting"]; ?></span></td>
                    <td><span id = "txtPh2bv"></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat B3</td>
                    <td><span><?php echo $machineConfig["preheater3BSetting"]; ?></span></td>
                    <td><span id = "txtPh3bv"></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat T2</td>
                    <td><span><?php echo $machineConfig["preheater2TSetting"]; ?></span></td>
                    <td><span id = "txtPh2tv"></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat T3</td>
                    <td><span><?php echo $machineConfig["preheater3TSetting"]; ?></span></td>
                    <td><span id = "txtPh3tv"></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Solder Pot</td>
                    <td><span><?php echo $machineConfig["solderPotSetting"]; ?></span></td>
                    <td><span id = "txtSpv"></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Conveyor</td>
                    <td><span><?php echo $machineConfig["transportSpeedSetting"]; ?></span></td>
                    <td><span id = "txtTsv"></span></td>
                    <td>mm/min</td>
                </tr>
                <tr>
                    <td>Rail Width</td>
                    <td><span><?php echo $machineConfig["railWidthSetting"]; ?></span></td>
                    <td><span id = "txtRwv"></span></td>
                    <td>mm</td>
                </tr>
                <tr>
                    <td>Wave1</td>
                    <td><span><?php echo $machineConfig["wave1Setting"]; ?></span></td>
                    <td><span id = "txtW1v"></span></td>
                    <td>Hz</td>
                </tr>
                <tr>
                    <td>Wave2</td>
                    <td><span><?php echo $machineConfig["wave2Setting"]; ?></span></td>
                    <td><span id = "txtW2v"></span></td>
                    <td>Hz</td>
                </tr>
            </tbody>
        </table>
        <div style="width:50vw; height:100%">
            <table style="height:30vh; width:98%; margin: 5px;" >
                <thead>
                    <tr>
                        <th>Parameter Name</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Location Name</td>
                        <td><?php echo $locationname; ?></td>
                    </tr>
                    <tr>
                        <td>Oven Model</td>
                        <td><?php echo $machineConfig["machineModel"]; ?></td>
                    </tr>
                    <tr>
                        <td>Time now</td>
                        <td id='Date'>2023-04-27 07:42:13 Thursday</td>
                    </tr>
                    <tr>
                        <td>Time update</td>
                        <td  id = "txtDT"></td>
                    </tr>
                </tbody>
            </table>
            <svg viewBox="0 0 970 450">
                <!-- machine outer box -->
                <rect x="10" y="20" width="950" height="350" fill="#c7d1cc" stroke="#000" stroke-width="2" />

                <!-- machine inner box -->
                <!-- <?php if ($data["preheater1B"] == "Close") echo ' fill="gray"'; else echo ' fill="green"'?> -->
                <rect id="preheatT1_rect" x="20" y="30" width="200" height="165" fill="gray" stroke="#000" stroke-width="2" />
                <rect id="preheatB1_rect" x="20" y="195" width="200" height="165" fill="<?php if ($data["preheater1B"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="preheatT2_rect" x="230" y="30" width="200" height="165" fill="<?php if ($data["preheater2T"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="preheatB2_rect" x="230" y="195" width="200" height="165" fill="<?php if ($data["preheater2B"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="preheatT3_rect" x="440" y="30" width="200" height="165" fill="<?php if ($data["preheater3T"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="preheatB3_rect" x="440" y="195" width="200" height="165" fill="<?php if ($data["preheater3B"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="wave1_rect" x="650" y="30" width="150" height="165" fill="<?php if ($data["wave1Value"] == "0.00") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="wave2_rect" x="800" y="30" width="150" height="165" fill="<?php if ($data["wave2Value"] == "0.00") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="solderpot_rect" x="650" y="195" width="300" height="165" fill="<?php if ($data["solderPot"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />

                <rect id="unused_rect" x="100" y="380" width="80" height="30" fill="gray" stroke="#000" stroke-width="4" />
                <rect id="close_rect" x="300" y="380" width="80" height="30" fill="#e6e6e6" stroke="#000" stroke-width="4" />
                <rect id="open_rect" x="500" y="380" width="80" height="30" fill="green" stroke="#000" stroke-width="4" />

                <!-- machine section label -->
                <text class="section-label" id="preheatT1-label" x="75" y="120">Preheat T1</text>
                <text class="section-label" id="preheatT2-label" x="285" y="120">Preheat T2</text>
                <text class="section-label" id="preheatT3-label" x="495" y="120">Preheat T3</text>
                <text class="section-label" id="preheatB1-label" x="75" y="285">Preheat B1</text>
                <text class="section-label" id="preheatB2-label" x="285" y="285">Preheat B2</text>
                <text class="section-label" id="preheatB3-label" x="495" y="285">Preheat B3</text>
                <text class="section-label" id="wave1-label" x="700" y="120">Wave1</text>
                <text class="section-label" id="wave2-label" x="850" y="120">Wave2</text>
                <text class="section-label" id="solderpot-label" x="760" y="285">Solder Pot</text>

                <text class="status-label" id="unused-label" x="190" y="405" style=" font-size:1.5em; font-weight:bold;">Unused</text>
                <text class="status-label" id="unused-label" x="390" y="405" style=" font-size:1.5em; font-weight:bold;">Closed</text>
                <text class="status-label" id="unused-label" x="590" y="405" style=" font-size:1.5em; font-weight:bold;">Opened</text>

            </svg>
        </div>

</body>
<script type="text/javascript">

    var txtPh1bv=document.getElementById('txtPh1bv');
    var txtPh2bv=document.getElementById('txtPh2bv');
    var txtPh3bv=document.getElementById('txtPh3bv');
    var txtPh2tv=document.getElementById('txtPh2tv');
    var txtPh3tv=document.getElementById('txtPh3tv');
    var txtPh3tv=document.getElementById('txtPh3tv');
    var txtSpv=document.getElementById('txtSpv');
    var txtTsv=document.getElementById('txtTsv');
    var txtRwv=document.getElementById('txtRwv');
    var txtW1v=document.getElementById('txtW1v');
    var txtW2v=document.getElementById('txtW2v');
    var txtDT=document.getElementById('txtDT');
    var preheatB1_rect = document.getElementById("preheatB1_rect");
    var preheatT2_rect = document.getElementById("preheatT2_rect");
    var preheatB2_rect = document.getElementById("preheatB2_rect");
    var preheatT3_rect = document.getElementById("preheatT3_rect");
    var preheatB3_rect = document.getElementById("preheatB3_rect");
    var wave1_rect = document.getElementById("wave1_rect");
    var wave2_rect = document.getElementById("wave2_rect");
    var solderpot_rect = document.getElementById("solderpot_rect");
    // var now = new Date();
    // var secondsUntilNextMinute = 60 - now.getSeconds();
    // var millisecondsUntilNextUpdate = secondsUntilNextMinute * 1000;
    // console.log(millisecondsUntilNextUpdate)

    window.onload = function() {
        printTime();
        setInterval(printTime, 1000);
        printSensorData();
        // setInterval(printSensorData, 60000, millisecondsUntilNextUpdate);
    }

    function printTime() {
        var d = document.getElementById('Date');
        var date = new Date();
        var year = date.getFullYear();
        var mon = ("0" + (date.getMonth() + 1)).slice(-2);
        var da = ("0" + (date.getDate())).slice(-2);
        var day = date.getDay();
        var h = ("0" + (date.getHours())).slice(-2);
        var m = ("0" + (date.getMinutes())).slice(-2);
        var s = ("0" + (date.getSeconds())).slice(-2);
        var ary = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        d.innerHTML = year + '-' + mon + '-' + da + ' ' + ' ' + h + ':' + m + ':' + s + '  ' + ary[day];
        if(s === "00"){
            console.log(date)
            printSensorData()
        }
    }

    function printSensorData(){
				var url = "/php/getJTWS450Value.php?machineID=<?php echo $machineID;?>";
				console.log(url);
				
				// var txtHumid=document.getElementById('txtHumid');
				fetch(url,{
					method: "GET",
					mode: "no-cors",
				})
				.then(res => {
                    // console.log(url);
                    console.log(res);
					return res.json(); 
				})
				.then(result  => {
					console.log(result);
					txtPh1bv.innerHTML=result.preheater1BValue;
                    txtPh2bv.innerHTML=result.preheater2BValue;
                    txtPh3bv.innerHTML=result.preheater3BValue;
                    txtPh2tv.innerHTML=result.preheater2TValue;
                    txtPh3tv.innerHTML=result.preheater3TValue;
                    txtSpv.innerHTML=result.solderPotValue;
                    txtTsv.innerHTML=result.transportSpeedValue;
                    txtRwv.innerHTML=result.railWidthValue;
                    txtW1v.innerHTML=result.wave1Value;
                    txtW2v.innerHTML=result.wave2Value;
                    txtDT.innerHTML=result.dataDate;
                    if (result.preheater1B == "Close"){
                        preheatB1_rect.style.fill = "#e6e6e6";
                    }
                    else{
                        preheatB1_rect.style.fill = "green";
                    }
                    if (result.preheater2T == "Close"){
                        preheatT2_rect.style.fill = "#e6e6e6";
                    }
                    else{
                        preheatT2_rect.style.fill = "green";
                    }
                    if (result.preheater2B == "Close"){
                        preheatB2_rect.style.fill = "#e6e6e6";
                    }
                    else{
                        preheatB2_rect.style.fill = "green";
                    }
                    if (result.preheater3T == "Close"){
                        preheatT3_rect.style.fill = "#e6e6e6";
                    }
                    else{
                        preheatT3_rect.style.fill = "green";
                    }
                    if (result.preheater3B == "Close"){
                        preheatB3_rect.style.fill = "#e6e6e6";
                    }
                    else{
                        preheatB3_rect.style.fill = "green";
                    }
                    if (result.wave1Value == 0){
                        wave1_rect.style.fill = "#e6e6e6";
                    }
                    else{
                        wave1_rect.style.fill = "green";
                    }
                    if (result.wave2Value == 0){
                        wave2_rect.style.fill = "#e6e6e6";
                    }
                    else{
                        wave2_rect.style.fill = "green";
                    }
                    if (result.solderPot == "Close"){
                        solderpot_rect.style.fill = "#e6e6e6";
                    }
                    else{
                        solderpot_rect.style.fill = "green";
                    }

				}).catch(err => console.error(err));
			}
</script>

</html>