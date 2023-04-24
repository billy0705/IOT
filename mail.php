<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	
	$locationid = "10";
	$sensorid = "1234";
	$temperature = "22.4";
	$humidity = "64.1";
	if (isset($_GET['locationid'])){
		$locationid=$_GET['locationid'];
	}
	if (isset($_GET['sensorid'])){
		$sensorid=$_GET['sensorid'];
	}
	if (isset($_GET['temperature'])){
		$temperature=$_GET['temperature'];
	}
	if (isset($_GET['humidity'])){
		$humidity=$_GET['humidity'];
	}
	$file = fopen("location.csv","r");
	while(! feof($file)){
		$array = fgetcsv($file);
		if ($array[0] == $locationid){
			$locationName = $array[1];
			break;
		}
	}
	fclose($file);
	$time = date("Y-m-d H:i:s", time());
	
	$url = 'http://10.10.2.108/fromsensor/api/SensorConfig/GetSensorByID/'.$sensorid;
	$json = file_get_contents($url);
	$obj = json_decode($json);
	$configarray = json_decode(json_encode($obj->lstSensorConfigs[0]), true);
	$message = '';
	if ($humidity > $configarray["hmax"]){
		$message .= "\nHumidity is too high!";
	}
	if ($humidity < $configarray["hmin"]){
		$message .= "\nHumidity is too low!";
	}
	if ($temperature > $configarray["tmax"]){
		$message .= "\nTemperature is too high!";
	}
	if ($temperature < $configarray["tmin"]){
		$message .= "\nTemperature is too low!";
	}
	$message .= "\nTemperature : ". $temperature ."℃";
	$message .= "\nHumidity : ". $humidity ."";
	$message .= "\nLocation Name : ". $locationName . "\nCurrent Time : " . $time . "\n";
	
	// 收件人 email
	$file = fopen("mailto.csv","r");
	$to_email_array = Array();
	$count = 0;
	while(! feof($file)){
		//print_r(fgetcsv($file));
		$to_email_array[] = fgetcsv($file);
		$count = $count + 1;
	}
	fclose($file);
	
	// 主旨
	$subject = "Dht alarm Test";
	
	// 寄件人 email
	$from_email = "billyg123@gmail.com";
	
	// 寄件人名稱
	$from_name = "Test";
	
	// 設定 SMTP 伺服器
	$smtp_host = "smtp.gmail.com"; // Gmail SMTP 伺服器
	$smtp_port = 587; // Gmail SMTP 伺服器埠號
	$smtp_username = "billyg123@gmail.com"; // Gmail 帳號
	$smtp_password = "cniadlzkkppszdvk"; // Gmail 密碼
	
	// 設定郵件頭
	$headers = array(
    "From: $from_name <$from_email>",
    "Reply-To: $from_email",
    "Content-Type: text/html; charset=utf-8",
    "X-Mailer: PHP/" . phpversion()
	);
	
	// 設定 SMTP 連線選項
	$smtp_conn_options = array(
    "ssl" => array(
	"verify_peer" => false,
	"verify_peer_name" => false,
	"allow_self_signed" => true
    )
	);
	
	// 建立 PHPMailer 物件
	$mail = new PHPMailer;
	
	// 設定郵件主旨和內容
	$mail->Subject = $subject;
	$mail->Body = $message;
	
	// 設定 SMTP 認證資訊
	$mail->isSMTP();
	$mail->Host = $smtp_host;
	$mail->Port = $smtp_port;
	$mail->SMTPAuth = true;
	$mail->Username = $smtp_username;
	$mail->Password = $smtp_password;
	
	// 設定 SMTP 連線選項
	$mail->SMTPSecure = "tls";
	$mail->SMTPOptions = $smtp_conn_options;
	
	$mail->setFrom($from_email, $from_name);
	
	foreach ($to_email_array as $to_email){
		echo $to_email[0]."<br>";
		// 設定寄件人和收件人
		$mail->addAddress($to_email[0]);
	}
	// 寄出郵件
	if(!$mail->send()) {
			echo "Sent Error： " . $mail->ErrorInfo . "<br>";
		} else {
			echo "Sent Success。" . "<br>";
		}
	
	// Line Notify API URL
	$url = "https://notify-api.line.me/api/notify";

	// 權杖(Token)
	$token = "8t0tGac6IZR1V6Gd4dmS3cgQOfpBkTcEqlvD3h2UkOD";
	echo $message;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$message");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $token"));

	// 執行 cURL 請求
	$response = curl_exec($ch);

	// 關閉 cURL 連線
	curl_close($ch);

	// 輸出回應結果
	var_dump($response);
?>