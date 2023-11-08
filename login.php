<?php
//登入資料庫
$DB_NAME = "library"; // 資料庫名稱
$DB_USER = "library"; // 資料庫管理帳號
$DB_PASS = "123"; // 資料庫管理密碼
$DB_HOST = "localhost"; // 資料庫位址
$login = $_POST['login'];
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
$account = $_POST['account'];
$password = $_POST['password'];

//把帳號密碼分別寫入資料庫的account和password欄位

//如果帳號不是空白就顯示＂歡迎你進來xxx＂，否則就顯示＂帳號密碼有問題＂
if($login == 1){
	if($account != "" && $password != ""){
		$sql = "SELECT * FROM client WHERE Account = '$_POST[account]' AND Password = '$_POST[password]'";
		$result = mysqli_query($con, $sql);
		$nums = mysqli_num_rows($result);
		if($nums == 1){
			$login = 0;
			header("Location: http://127.0.0.1/lobby.php?login=".$login);
		}
		else{
			echo "Register First!";		
		}
	}else{
		echo "Input Not Completed!";
	}
}
$login = 1;
if($_GET){
	echo $_GET['ans']; // print_r($_GET);       
    }
else{
	echo "";
    }
?>
<center>
<font size="5">Login</font>
<form action="login.php" method="post">
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
<td><a href="http://127.0.0.1/register.php">register</a></td>
</table>
<INPUT name=login   type=hidden value=<?php echo $login ?>  > 
</form>
</center>