<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body oncontextmenu="return false;">
<?php
require_once 'config.php';
try {
	$id_free = file_get_contents("book");
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = htmlspecialchars($_POST["id"]);
    $author = htmlspecialchars($_POST["author"]);
    $title = htmlspecialchars($_POST["title"]);
    $place = htmlspecialchars($_POST["place"]);
    $year = htmlspecialchars($_POST["year"]);
	if(empty($id)){
        echo "<h2>Внутренняя ошибка 1</h2>";
		header('Refresh: 3; url=/');
        return;
    }
  	if($id != $id_free){
        echo "<h2>Внутренняя ошибка 2</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if($id < 1){
        echo "<h2>Внутренняя ошибка 3</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if(empty($author)){
        echo "<h2>Вы не ввели автора книги!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if(empty($title)){
        echo "<h2>Вы не ввели название книги!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
    if(empty($place)){
        echo "<h2>Вы не ввели место книги!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if(empty($year)){
        echo "<h2>Вы не ввели год издания книги!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
        $sql = "INSERT INTO books VALUES ('$id', '$author', '$title', '$place', '$year', '0', '0')";
        $statement = $db->prepare($sql);
        $statement->execute();
		echo "<h2>Книга c номером $id успешно добавлена!</h2>";
		header('Refresh: 1; url=/');
    }

 
catch(PDOException $e) {
    echo "<h2>Л̶̗̩̫́̀̑̂̎͘ӑ̵͇Г̵̪͎͍̗̇̉̃͊ при добавлении книги в базе данных: </h2>" . $e->getMessage();
	header('Refresh: 5; url=/');
}
$db = null;
?>
	</body>
</html>