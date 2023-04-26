<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Solder Wave Machine</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* 設定表格樣式 */
        svg {
            display: inline-block;
            width: 50vw;
            height: 50vh;
        }

        table {
            border-collapse: collapse;
            width: 50vw;
            max-width: 800px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    </style>
</head>

<body>
    <?php require "header.php"; ?>
    <!-- <h1>Solder Wave Machine 監控</h1> -->
    <div style="display:flex">
        <table>
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
                    <td>100</td>
                    <td>98</td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat B2</td>
                    <td>120</td>
                    <td>119</td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat B3</td>
                    <td>120</td>
                    <td>119</td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat T2</td>
                    <td>120</td>
                    <td>119</td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Preheat T3</td>
                    <td>120</td>
                    <td>119</td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Solder Pot</td>
                    <td>250</td>
                    <td>251</td>
                    <td>Deg C</td>
                </tr>
                <tr>
                    <td>Conveyor</td>
                    <td>1200</td>
                    <td>1200</td>
                    <td>mm/min</td>
                </tr>
                <tr>
                    <td>Rail Width</td>
                    <td>347</td>
                    <td>346.5</td>
                    <td>mm</td>
                </tr>
                <tr>
                    <td>Wave1</td>
                    <td>12</td>
                    <td>12</td>
                    <td>Hz</td>
                </tr>
                <tr>
                    <td>Wave2</td>
                    <td>24</td>
                    <td>24.5</td>
                    <td>Hz</td>
                </tr>
            </tbody>
        </table>
        <svg viewBox="0 0 970 400">
            <!-- 機器外框 -->
            <rect x="10" y="20" width="950" height="350" fill="#c7d1cc" stroke="#000" stroke-width="2" />

            <!-- 機器內部區塊 -->
            <rect x="20" y="30" width="200" height="330" fill="#e6e6e6" stroke="#000" stroke-width="2" />
            <rect x="230" y="30" width="200" height="330" fill="#e6e6e6" stroke="#000" stroke-width="2" />
            <rect x="440" y="30" width="200" height="330" fill="#e6e6e6" stroke="#000" stroke-width="2" />
            <rect x="650" y="30" width="300" height="330" fill="#e6e6e6" stroke="#000" stroke-width="2" />
            <line x1="20" y1="195" x2="220" y2="195" stroke="black" stroke-width="2" />
            <line x1="230" y1="195" x2="430" y2="195" stroke="black" stroke-width="2" />
            <line x1="440" y1="195" x2="640" y2="195" stroke="black" stroke-width="2" />
            <line x1="650" y1="195" x2="950" y2="195" stroke="black" stroke-width="2" />
            <line x1="800" y1="30" x2="800" y2="195" stroke="black" stroke-width="2" />

            <!-- 機器各段標籤 -->
            <text class="section-label" id="preheat-label" x="75" y="120">Preheat T1</text>
            <text class="section-label" id="preheat-label" x="285" y="120">Preheat T2</text>
            <text class="section-label" id="preheat-label" x="495" y="120">Preheat T3</text>
            <text class="section-label" id="preheat-label" x="75" y="285">Preheat B1</text>
            <text class="section-label" id="preheat-label" x="285" y="285">Preheat B2</text>
            <text class="section-label" id="preheat-label" x="495" y="285">Preheat B3</text>
            <text class="section-label" id="preheat-label" x="700" y="120">Wave1</text>
            <text class="section-label" id="preheat-label" x="850" y="120">Wave2</text>
            <text class="section-label" id="preheat-label" x="760" y="285">Solder Pot</text>

        </svg>
    </div>
</body>

</html>