<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 連接資料庫並取得資料</title>
</head>
<body>
<center>
<?php
header("Content-Type:text/html; charset=UTF-8");
@$btn    = $_POST['button'];

// 定義資料庫資訊
$DB_NAME = "mytest"; // 資料庫名稱
$DB_USER = "root"; // 資料庫管理帳號
$DB_PASS = "usbw"; // 資料庫管理密碼
$DB_HOST = "localhost"; // 資料庫位址

// 連接 MySQL 資料庫伺服器
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
if (empty($con)) {
    print mysqli_error($con);
    die("資料庫連接失敗！");
    exit;
}

// 選取資料庫
if (!mysqli_select_db($con, $DB_NAME)) {
    die("選取資料庫失敗！");
} else {
    
}

// 設定連線編碼
mysqli_query($con, "SET NAMES 'utf8mb4'");

// 取得資料
$sql = "SELECT * FROM condb";
$result = mysqli_query($con, $sql);

// 獲得資料筆數
if ($result) {
    $num = mysqli_num_rows($result);
    echo "condb 資料表有 " . $num . " 筆資料<br>";
}

// --- 顯示資料 --- //
switch($btn){  //各按鈕
	case '資料':   
		echo "<br>顯示資料（MYSQLI_NUM，欄位數）：<br>";
		$result = mysqli_query($con, $sql);
		echo "<table border=1>"; //使用表格格式化数据
		echo "<tr align='center'><td>id</td><td>text</td></tr>";
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) 
		{
			//echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";
			echo "<tr>";
			echo "<td>$row[0]</td>"; 
			echo "<td>$row[1]</td>"; 
			echo "</tr>";
		}
		echo "</table>";
		break;
	default:
}






// 釋放記憶體
mysqli_free_result($result);

// 關閉連線
mysqli_close($con);

?>

</center>
</body>
</html>