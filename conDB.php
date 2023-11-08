<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 連接資料庫並取得資料</title>
</head>
<body>
<?php
header("Content-Type:text/html; charset=UTF-8");
@$btn  = $_POST['button'];

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







// 釋放記憶體
mysqli_free_result($result);

// 關閉連線
mysqli_close($con);

?>

<FORM action="table.php" method=post name=form1> 
 <!--text欄位-->  
 <!--button欄位--> 
 <INPUT name=button type=submit style="width:50px;height:50px"  value="資料">  
 <!--hidden欄位--> 
 <INPUT name=op     type=hidden value=<?php echo $op ?>  > 
 <INPUT name=opi    type=hidden value=<?php echo $opi ?> > 
 <INPUT name=answer type=hidden value=<?php echo $answer ?> > 
 <INPUT name=memory type=hidden value=<?php echo $memory ?> > 
 <INPUT name=output type=hidden value=<?php echo $output ?> > 
</FORM> 
<a href="http://127.0.0.1/register.php">register</a>
</body>
</html>