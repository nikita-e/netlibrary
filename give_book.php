<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body oncontextmenu="return false;">
<?php
require_once 'config.php';
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $today = date("Y-m-d");
  	$book = htmlspecialchars($_POST["book"]);
    $reader = htmlspecialchars($_POST["reader"]);
    $begin = htmlspecialchars($_POST["begin"]);
    $end = htmlspecialchars($_POST["end"]);
  	/*
    //Эта часть скрипта раньше получала сгенерированный файлом index.php id для выдачи книги и проверяла его на подлинность
    $id = htmlspecialchars($_POST["id"]);
	$id_given = file_get_contents("given");
	if(empty($id)){
        echo "<h2>Внутренняя ошибка 1</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if($id <= 0){
        echo "<h2>Внутренняя ошибка 2</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if($id != $id_given){
        echo "<h2>Внутренняя ошибка 3</h2>";
		header('Refresh: 3; url=/');
        return;
    }
    */
	if(empty($book)){
        echo "<h2>Вы не выбрали книгу для выдачи!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if(empty($reader)){
        echo "<h2>Вы не выбрали чиитателя!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
    if(empty($begin)){
        echo "<h2>Внутренняя ошибка 4</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if($begin != $today){
        echo "<h2>Внутренняя ошибка 5</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if(empty($end)){
        echo "<h2>Вы не выбрали срок сдачи книги!</h2>";
		header('Refresh: 3; url=/');
        return;
    }

        $sql = "INSERT INTO given VALUES ('$book', '$reader', '$begin', '$end')";
        $statement = $db->prepare($sql);
        $statement->execute();
        $sql_bk = "UPDATE books SET given='1' WHERE id='$book'";
        $statement_bk = $db->prepare($sql_bk);
        $statement_bk->execute();
  		$sql_rd = "UPDATE readers SET took='1' WHERE id='$reader'";
        $statement_rd = $db->prepare($sql_rd);
        $statement_rd->execute();

		echo "<h2>Книга с номером $book успешно выдана читателю $reader!</h2>";
		header('Refresh: 1; url=/');
	}


 
catch(PDOException $e) {
    echo "<h2>Л̶̗̩̫́̀̑̂̎͘ӑ̵͇Г̵̪͎͍̗̇̉̃͊ при выдаче книг в базе данных: </h2>" . $e->getMessage();
	header('Refresh: 5; url=/');
}
$db = null;
?>
	</body>
</html>