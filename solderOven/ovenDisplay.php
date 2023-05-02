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
            height: 70%;
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
        body {
            background-color: #32CD32;
        }
        td span {
            display: inline-block;
            padding: 2px 5px;
            background-color: #fff;
            height: 50%; 
            width: 70%;
        }
    </style>
    </style>
</head>

<body>
    <?php require "header.php"; ?>
    <?php
    $machineID = '40001';
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
    $url = 'http://10.10.2.108/Solder/api/JT_WS450/JT_WS450Values';
    $json = file_get_contents($url);
    $obj = json_decode($json);
    if ($obj->statusCode == 200) {
        $data = json_decode(json_encode($obj->jT_WS450_Values[0]), true);
        $tsv = $data["transportSpeedValue"];
        $rwv = $data["railWidthValue"];
        $ph1bv = $data["preheater1BValue"];
        $ph2bv = $data["preheater2BValue"];
        $ph3bv = $data["preheater3BValue"];
        $ph1tv = $data["preheater1TValue"];
        $ph2tv = $data["preheater2TValue"];
        $ph3tv = $data["preheater3TValue"];
        $spv = $data["solderPotValue"];
        $w1v = $data["wave1Value"];
        $w2v = $data["wave2Value"];
    }

    ?>
    <!-- <h1>Solder Wave Machine</h1> -->
    <div style="display:flex; height:100vh">
        <table style="width:50vw; height:100%; margin: 5px;">
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
                    <td><span><?php echo $ph1bv; ?></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat B2</td>
                    <td><span><?php echo $machineConfig["preheater2BSetting"]; ?></span></td>
                    <td><span><?php echo $ph2bv; ?></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat B3</td>
                    <td><span><?php echo $machineConfig["preheater3BSetting"]; ?></span></td>
                    <td><span><?php echo $ph3bv; ?></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat T2</td>
                    <td><span><?php echo $machineConfig["preheater2TSetting"]; ?></span></td>
                    <td><span><?php echo $ph2tv; ?></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat T3</td>
                    <td><span><?php echo $machineConfig["preheater3TSetting"]; ?></span></td>
                    <td><span><?php echo $ph3tv; ?></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Solder Pot</td>
                    <td><span><?php echo $machineConfig["solderPotSetting"]; ?></span></td>
                    <td><span><?php echo $spv; ?></span></td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Conveyor</td>
                    <td><span><?php echo $machineConfig["transportSpeedSetting"]; ?></span></td>
                    <td><span><?php echo $tsv; ?></span></td>
                    <td>mm/min</td>
                </tr>
                <tr>
                    <td>Rail Width</td>
                    <td><span><?php echo $machineConfig["railWidthSetting"]; ?></span></td>
                    <td><span><?php echo $rwv; ?></span></td>
                    <td>mm</td>
                </tr>
                <tr>
                    <td>Wave1</td>
                    <td><span><?php echo $machineConfig["wave1Setting"]; ?></span></td>
                    <td><span><?php echo $w1v; ?></span></td>
                    <td>Hz</td>
                </tr>
                <tr>
                    <td>Wave2</td>
                    <td><span><?php echo $machineConfig["wave2Setting"]; ?></span></td>
                    <td><span><?php echo $w2v; ?></span></td>
                    <td>Hz</td>
                </tr>
            </tbody>
        </table>
        <div style="width:50vw; height:100%">
            <table style="height:30%; width:98%; margin: 5px;" >
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
                    <!-- <tr>
                        <td>PCB in Count</td>
                        <td>349</td>
                    </tr> -->
                </tbody>
            </table>
            <svg viewBox="0 0 970 450">
                <!-- machine outer box -->
                <rect x="10" y="20" width="950" height="350" fill="#c7d1cc" stroke="#000" stroke-width="2" />

                <!-- machine inner box -->
                <!-- <?php if ($data["preheater1B"] == "Close") echo ' fill="gray"'; else echo ' fill="green"'?> -->
                <rect id="preheatT1-rect" x="20" y="30" width="200" height="165" fill="gray" stroke="#000" stroke-width="2" />
                <rect id="preheatB1-rect" x="20" y="195" width="200" height="165" fill="<?php if ($data["preheater1B"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="preheatT2-rect" x="230" y="30" width="200" height="165" fill="<?php if ($data["preheater2T"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="preheatB2-rect" x="230" y="195" width="200" height="165" fill="<?php if ($data["preheater2B"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="preheatT3-rect" x="440" y="30" width="200" height="165" fill="<?php if ($data["preheater3T"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="preheatB3-rect" x="440" y="195" width="200" height="165" fill="<?php if ($data["preheater3B"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="wave1-rect" x="650" y="30" width="150" height="165" fill="<?php if ($data["wave1Value"] == "0.00") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="wave2-rect" x="800" y="30" width="150" height="165" fill="<?php if ($data["wave2Value"] == "0.00") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />
                <rect id="solderpot-rect" x="650" y="195" width="300" height="165" fill="<?php if ($data["solderPot"] == "Close") echo '#e6e6e6'; else echo 'green'?>" stroke="#000" stroke-width="2" />

                <rect id="unused-rect" x="100" y="380" width="80" height="30" fill="gray" stroke="#000" stroke-width="4" />
                <rect id="close-rect" x="300" y="380" width="80" height="30" fill="#e6e6e6" stroke="#000" stroke-width="4" />
                <rect id="open-rect" x="500" y="380" width="80" height="30" fill="green" stroke="#000" stroke-width="4" />

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
    window.onload = function() {
        printTime();
        setInterval(printTime, 1000);
        // printSensorData();
        // setInterval(printSensorData, 120000);
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
    }
</script>

</html>