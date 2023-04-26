<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Solder Wave Machine</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* 設定表格樣式 */
        svg {
            width: 100%;
            max-width: 800px;
        }

        .section {
            fill: #ddd;
            stroke: #999;
            stroke-width: 2;
        }

        .label {
            font-size: 12px;
            text-anchor: middle;
            fill: #333;
        }

        .temp {
            font-size: 10px;
            text-anchor: middle;
            fill: #333;
        }
    </style>
    </style>
</head>

<body>
    <?php require "header.php"; ?>
    <h1>Solder Wave Machine 監控</h1>
    <svg viewBox="0 0 400 200">
        <rect class="section" x="20" y="20" width="150" height="80" />
        <text class="label" x="95" y="55">預熱區 1</text>
        <text class="temp" x="95" y="75">預設溫度值:100°C</text>
        <text class="temp" x="95" y="90">實際溫度值:98°C</text>
        <rect class="section" x="230" y="20" width="150" height="80" />
        <text class="label" x="305" y="55">預熱區 2</text>
        <text class="temp" x="305" y="75">預設溫度值:120°C</text>
        <text class="temp" x="305" y="90">實際溫度值:119°C</text>
        <rect class="section" x="20" y="100" width="150" height="80" />
        <text class="label" x="95" y="135">波峰區</text>
        <text class="temp" x="95" y="155">預設溫度值:250°C</text>
        <text class="temp" x="95" y="170">實際溫度值:251°C</text>
        <rect class="section" x="230" y="100" width="150" height="80" />
        <text class="label" x="305" y="135">清洗區</text>
        <text class="temp" x="305" y="155">預設溫度值：60°C</text>
        <text class="temp" x="305" y="170">實際溫度值：59°C</text>
    </svg>
</body>

</html>