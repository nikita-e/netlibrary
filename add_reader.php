<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body oncontextmenu="return false;">
<?php
require_once 'config.php';
try {
	$id_free = file_get_contents("reader");
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = htmlspecialchars($_POST["id"]);
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $adress = htmlspecialchars($_POST["adress"]);
	$fst_name = substr($name, 0, 1);
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
	if(empty($name)){
        echo "<h2>Вы не ввели имя читателя!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if (is_numeric($fst_name) || $fst_name == ' ') {
		echo "<h2>Имя не может начинаться с цифры или пробела!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if (preg_match('/![\'"^£$%&*()}{@#~?><>,>.|=_+¬-]/', $name)) {
		echo "<h2>Имя не может содержать специальные символы!</h2>";
		header('Refresh: 3; url=/');
        return;
	}
	
	if(empty($phone)){
        echo "<h2>Вы не ввели телефон читателя!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
	if (preg_match('/! [\'^£$%&*()}{@#~?><>,|=_¬-]/', $phone)) {
		echo "<h2>Телефон не может содержать специальные символы!</h2>";
		header('Refresh: 3; url=/');
        return;
	}
	if(empty($adress)){
        $adress = "-";
    }
	$query_name = "SELECT COUNT(*) FROM readers WHERE name='$name'";
    $result_name = $db->prepare($query_name);
    $result_name->execute();
	$count_name = $result_name->fetch(PDO::FETCH_NUM)[0];
	if ($count_name != 0) {
	echo "<h2>В базе данных уже имеется читатель с аналогичными ФИО!</h2>";
		header('Refresh: 3; url=/');
        return;
    }

        $sql = "INSERT INTO readers VALUES ('$id', '$name', '$phone', '$adress', '0', '0')";
        // echo $sql;
        $statement = $db->prepare($sql);
        $statement->execute();
		echo "<h2>Читатель c номером $id успешно добавлен!</h2>";
		header('Refresh: 1; url=/');
    }

 
catch(PDOException $e) {
    echo "<h2>Л̶̗̩̫́̀̑̂̎͘ӑ̵͇Г̵̪͎͍̗̇̉̃͊ при добавлении читателя в базе данных: </h2>" . $e->getMessage();
	header('Refresh: 5; url=/');
}
$db = null;
?>
	</body>
</html>