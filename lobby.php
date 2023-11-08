<?php
$searchtext = $_POST['searchtext'];
$btn = $_POST['button'];
$row = $_POST['row'];
// 定義資料庫資訊
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

// 取得資料
$sql = "
SELECT Title, AuthorName,BranchName,No_Of_Copies,book.BookId
FROM book, library_branch, borrower, book_authors, book_copies, book_loans
WHERE  book_authors.BookId= book.BookId
AND book_copies.BookId= book.BookId
AND book_copies.BranchId= library_branch.BranchId 
AND book_loans.BookId= book.BookId
AND book_loans.BranchId= library_branch.BranchId 
AND book_loans.CardNo= borrower.CardNo 
AND Title LIKE '%$searchtext%'
GROUP BY Title, BranchName";

$result = mysqli_query($con, $sql);
//echo "$searchtext";


?>
<form action="lobby.php" method="post">
<table width="400" border="0">
<?php echo "Key Word: ";?>
<label for="textfield"></label>
<input type="text" name="searchtext"/>
<input type="submit" name="button" id="button" value="search" />
<INPUT name="row" type=hidden value=<?php echo $row ?> >

</table>
<br>
<table width="400" border="0">
<tr>
<?php
switch($btn){  //各按鈕
	case 'search':
			// 獲得資料筆數
		if ($result) {
			$num = mysqli_num_rows($result);
			//$col = mysqli_num_fields($result);
		   echo "有 " . $num . " 筆資料<br>";
		}
		//$result = mysqli_query($con, $sql);
		echo "<table border=1>"; //使用表格格式化数据
		//echo "<tr align='center'><td>id</td><td>text</td></tr>";
			echo "<tr>";
			echo "<td>Titile</td>";
			echo "<td>AuthorName</td>";
			echo "<td>BranchName</td>";
			echo "<td>No_Of_Copies</td>";
			echo "<td>BookId</td>";
			echo "<td>No_Of_Borrowing</td>";
			echo "</tr>";
			$count = 0;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) 
		{
			$i = 0;
			//echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";

			echo "<tr>";	
			while($row[$i]){
				echo "<td>$row[$i]</td>";
				$i++;
			}
			$sql1 = "SELECT count(*)
			FROM book, library_branch,book_loans,borrower
			WHERE book_loans.BookId= book.BookId
			AND book_loans.BranchId= library_branch.BranchId
			AND book_loans.CardNo= borrower.CardNo
			AND Title='$row[0]'
			AND BranchName='$row[2]'";
			$result1 = mysqli_query($con, $sql1);
			$row1 = mysqli_fetch_array($result1, MYSQLI_NUM);
			echo "<td>$row1[0]</td>";
			echo "<td><input name='button'  type='submit' value='borrow' /></td>";
			echo "</tr>";
			//echo "$count";
			$GLOBALS['count']++;
		}
		echo "</table>";
		break;
	case 'borrow':
		header("Location: http://127.0.0.1/borrow.php");
	default:
}


?>
</tr>
</table>
</form>
