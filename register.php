<?php
//登入資料庫
$DB_NAME = "library"; // 資料庫名稱
$DB_USER = "library"; // 資料庫管理帳號
$DB_PASS = "123"; // 資料庫管理密碼
$DB_HOST = "localhost"; // 資料庫位址
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
mysqli_query($con, "SET NAMES 'utf8mb4'");
//把密碼用md5加密
$login = $_POST['login'];
$account = $_POST['account'];
$password = $_POST['password'];

//把帳號密碼分別寫入資料庫的account和password欄位
if($login == 1){
	if($account!="" && $password!=""){
		$sqlCheck = "SELECT * FROM client WHERE Account = '$_POST[account]' AND Password = '$_POST[password]'";
		$resultCheck = mysqli_query($con,$sqlCheck);
		$nums = mysqli_num_rows($resultCheck);
		if($nums > 0){
			echo "Repeated!";
		}
		else{
			$sql = "INSERT INTO client (Account,Password) VALUES ('$_POST[account]','$_POST[password]')";
			$result = mysqli_query($con, $sql);
			$ans = "Register Success";
			header("Location: http://127.0.0.1/login.php?ans=".$ans);
			exit();		
		}
	}
	else
		echo "Input Not Completed!";
}



$login = 1;
?>

<center>
<font size="5">Register</font>
<form action="register.php" method="post">
<table width="400" border="0">
<tr>
<td align='right'>Account</td>
<td><label for="textfield"></label>
<input type="text" name="account"/></td>
</tr>
<tr>
<td align='right'>Password</td>
<td><label for="textfield"></label>
<input type="text" name="password"/></td>
</tr>
<tr>
<td> </td>
<td><input type="submit" name="button" id="button" value="submit" /></td>
</tr>
<td> </td>
<td><a href="http://127.0.0.1/login.php">login</a></td>
</table>
<INPUT name=login   type=hidden value=<?php echo $login ?>  > 
</form>
</center>