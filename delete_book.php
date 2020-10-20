<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/styles.css">
	</head>
	<body oncontextmenu="return false;">
<?php
require_once 'config.php';
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $ids_to_delete = array();
  	$given_ids = array();
  	$cnt = 0;
    foreach($_POST['delete_row'] as $selected){
        $ids_to_delete[] = $selected;
      	$chk = "SELECT given FROM books where id='$selected'";
        $res = $db->prepare($chk);
        $res->execute();
      	$val = $res->fetch(PDO::FETCH_NUM)[0];
      	if($val == 1){
        	$cnt = $cnt+1;
        	$given_ids[] = $selected;
        }
    }
 
    if(empty($ids_to_delete)){
        echo "<h2>Вы не выделили ни одной книги для удаления!</h2>";
		header('Refresh: 3; url=/');
        return;
    }
    
    if($cnt < 1){
        $sql = "DELETE FROM books WHERE id IN (" . implode(',', array_map('intval', $ids_to_delete)) . ")";
        $statement = $db->prepare($sql);
        $statement->execute();
		echo "<h2>Книги c номерами " . implode(',', array_map('intval', $ids_to_delete)) .  " успешно удалены!</h2>";
		header('Refresh: 1; url=/');
    } else {
      echo "<h2>Книги c номерами " . implode(',', array_map('intval', $given_ids)) .  " выданы читателям. Примите эти книги и повторите попытку</h2>";
		header('Refresh: 3; url=/');
    }
}
  
  catch(PDOException $e) {
    echo "<h2>Л̶̗̩̫́̀̑̂̎͘ӑ̵͇Г̵̪͎͍̗̇̉̃͊ при удалении книг в базе данных: </h2>" . $e->getMessage();
	header('Refresh: 5; url=/');
  }

$db = null;
?>
	</body>
</html>