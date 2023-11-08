<?php
$title = $_POST['title'];
$branchname = $_POST['branchname'];
$cardno = $_POST['cardno'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$dateout = $_POST['dateout'];
$duedate = $_POST['duedate'];
$btn = $_POST['button'];
$login = $_POST['login'];
$DB_NAME = "library"; // 資料庫名稱
$DB_USER = "library"; // 資料庫管理帳號
$DB_PASS = "123"; // 資料庫管理密碼
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

$sql = "
SELECT No_Of_Copies,book_copies.BookId,book_copies.BranchId
FROM book, library_branch, book_copies
WHERE  book_copies.BookId= book.BookId
AND book_copies.BranchId= library_branch.BranchId 
AND Title = '$title'
AND BranchName = '$branchname'";

$sql1 = "SELECT count(*)
FROM book, library_branch,book_loans,borrower
WHERE book_loans.BookId= book.BookId
AND book_loans.BranchId= library_branch.BranchId
AND book_loans.CardNo= borrower.CardNo
AND Title ='$title'
AND BranchName ='$branchname'";
$result = mysqli_query($con, $sql);
$result1 = mysqli_query($con, $sql1);
if($login == 1){
	switch($btn){
		case 'submit':
			if($title!="" && $branchname!="" && $cardno!="" && $name!="" && $address!="" && $phone!=""){
				$row = mysqli_fetch_array($result, MYSQLI_NUM);
				$row1 = mysqli_fetch_array($result1, MYSQLI_NUM);
				if($row[0]>$row1[0]){
					$sql = "INSERT INTO borrower VALUES ('$cardno','$name','$address','$phone')";
					$result = mysqli_query($con, $sql);
					$sql1 = "INSERT INTO book_loans VALUES ('$row[1]','$row[2]','$cardno','$dateout','$duedate')";
					$result1 = mysqli_query($con, $sql1);
					echo "borrow success!";
				}
				else{
					echo "Can not borrow!";
				}
			}
			else{
				echo "Input Not Complete!";
			}
		default:

	}
}
$login = 1;
?>



<form action="borrow.php" method="post">
<table width="400" border="0">
<tr>
<td align='right'>Title</td>
<td><label for="textfield"></label>
<input type="text" name="title"/></td>
</tr>
<tr>
<td align='right'>BranchName</td>
<td><label for="textfield"></label>
<input type="text" name="branchname"/></td>
</tr>
<tr>
<td align='right'>CardNo</td>
<td><label for="textfield"></label>
<input type="text" name="cardno"/></td>
</tr>
<tr>
<td align='right'>Name</td>
<td><label for="textfield"></label>
<input type="text" name="name"/></td>
</tr>
<tr>
<td align='right'>Address</td>
<td><label for="textfield"></label>
<input type="text" name="address"/></td>
</tr>
<tr>
<td align='right'>Phone</td>
<td><label for="textfield"></label>
<input type="text" name="phone"/></td>
</tr>
<tr>
<td align='right'>DateOut</td>
<td><label for="textfield"></label>
<input type="text" name="dateout"/></td>
</tr>
<tr>
<td align='right'>DueDate</td>
<td><label for="textfield"></label>
<input type="text" name="duedate"/></td>
</tr>
<tr>
<td> </td>
<td><input type="submit" name="button" id="button" value="submit" /></td>
</tr>
</table>
<INPUT name=login   type=hidden value=<?php echo $login ?>  >
</form>

