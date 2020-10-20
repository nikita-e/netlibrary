<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>NetLibrary</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body oncontextmenu="return false;">
<?php
require_once 'config.php';
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql_books = "SELECT * FROM books";
    $statement_books = $db->prepare($sql_books);
    $statement_books->execute();
    $result_array_books = $statement_books->fetchAll();
	$stmt_books = $db->query("SELECT COUNT(*) FROM books");
	$box_counter_books = 0;
	$count_books = $stmt_books->fetch(PDO::FETCH_NUM)[0];
	$boxes_books = $db->query("SELECT id FROM books");
	$i = 1;
	$id_book = 0;
	foreach($boxes_books as $box_book) {
		if ($box_book["id"] != $i) {
			$id_book = $i;
			$box_counter_books = $box_counter_books + 1;
			break;
		}
		if ($i == $count_books && $box_counter_books == 0) {
			$id_book = $count_books + 1;
			break;
		}
		$i = $i + 1;
	}
	if ($count_books == 0) {
		$id_book = 1;
	}
	file_put_contents("book", $id_book);
	
	$sql_readers = "SELECT * FROM readers";
    $statement_readers = $db->prepare($sql_readers);
    $statement_readers->execute();
    $result_array_readers = $statement_readers->fetchAll();
	$stmt_readers = $db->query("SELECT COUNT(*) FROM readers");
	$box_counter_readers = 0;
	$count_readers = $stmt_readers->fetch(PDO::FETCH_NUM)[0];
	$boxes_readers = $db->query("SELECT id FROM readers");
	$j = 1;
	$id_reader = 0;
	foreach($boxes_readers as $box_reader) {
		if ($box_reader["id"] != $j) {
			$id_reader = $j;
			$box_counter_readers = $box_counter_readers + 1;
			break;
		}
		if ($j == $count_readers && $box_counter_readers == 0) {
			$id_reader = $count_readers + 1;
			break;
		}
		$j = $j + 1;
	}
	if ($count_readers == 0) {
		$id_reader = 1;
	}
	file_put_contents("reader", $id_reader);
	
	$sql_given = "SELECT * FROM given";
    $statement_given = $db->prepare($sql_given);
    $statement_given->execute();
    $result_array_given = $statement_given->fetchAll();
	$stmt_given = $db->query("SELECT COUNT(*) FROM given");
	$count_given = $stmt_given->fetch(PDO::FETCH_NUM)[0];
  	/*
    // Эта часть скрипта раньше генерировала свободный id для выдачи книг
  	$box_counter_given = 0;
	$boxes_given = $db->query("SELECT id FROM given");
	$p = 1;
	$id_given = 0;
	foreach($boxes_given as $box_given) {
		if ($box_given["id"] != $p) {
			$id_given = $p;
			$box_counter_given = $box_counter_given + 1;
			break;
		}
		if ($p == $count_given && $box_counter_given == 0) {
			$id_given = $count_given + 1;
			break;
		}
		$p = $p + 1;
	}
	if ($count_given == 0) {
		$id_given = 1;
	}
	file_put_contents("given", $id_given);
    
    // Это было в форме выдачи книги
    <input type="hidden" name="id" value="$id_given">
    */
	$today = date("Y-m-d");
	echo <<<_END
	<h1 align="center">NetLibrary</h1>
	<button class="btn open-modal" id="op_add_book">Добавить книгу</button><button class="btn open-modal" id="op_add_reader">Добавить читателя</button><button class="btn open-modal" id="op_give_book">Выдать книгу</button>
	<div class="modal" id="add_book">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close-modal" id="cl_add_book">&times;</span>
				<h3>Добавление книги</h3>
			</div>
			<div class="modal-body">
				<br>
				<form action="add_book.php" method="post">
					<input type="text" name="id" placeholder="Номер" value="$id_book" readonly>
					<br>
					<input type="text" name="author" placeholder="Автор">
					<br>
					<input type="text" name="title" placeholder="Название">
					<br>
					<input type="text" name="place" placeholder="Место">
					<br>
					<input type="number" name="year" placeholder="Год">
					<br>
					<input type="submit" class="btn" value="Добавить книгу">
					<br>
					<br>
				</form>
			</div>
		</div>
	</div>
	<div class="modal" id="add_reader">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close-modal" id="cl_add_reader">&times;</span>
				<h3>Добавление читателя</h3>
			</div>
			<div class="modal-body">
				<br>
				<form action="add_reader.php" method="post">
					<input type="text" name="id" placeholder="Номер" value="$id_reader" readonly>
					<br>
					<input type="text" name="name" placeholder="Имя">
					<br>
					<input type="tel" name="phone" placeholder="Телефон">
                    <br>
					<input type="text" name="adress" placeholder="Адрес (доп.)">
					<br>
					<input type="submit" class="btn" value="Добавить читателя">
				</form>
				<br>
				<br>
			</div>
		</div>
	</div>
	<div class="modal" id="give_book">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close-modal" id="cl_give_book">&times;</span>
				<h3>Выдача книги читателю</h3>
			</div>
			<div class="modal-body">
				<br>
				<br>
				<form action="give_book.php" method="post">
					<select name="book" size="10">
					<option disabled>Выберите книгу</option>
_END;

	foreach($result_array_books as $result_row_book) {
		$id_book_curr = $result_row_book["id"];
      	$title_book_curr = $result_row_book["title"];
      	$author_book_curr = $result_row_book["author"];
		$given_book_curr = $result_row_book["given"];
		if ($given_book_curr == 0) {
		echo <<<_END
		<option value="$id_book_curr">№ $id_book_curr: $author_book_curr "$title_book_curr"</option>
_END; } }
	echo <<<_END
					</select>
					<br>
					<select name="reader" size="10">
					<option disabled>Выберите читателя</option>
_END;

	foreach($result_array_readers as $result_row_reader) {
		$id_reader_curr = $result_row_reader["id"];
      	$name_reader_curr = $result_row_reader["name"];
		echo <<<_END
      	<option value="$id_reader_curr">№ $id_reader_curr: $name_reader_curr</option>";
_END;
	}
	echo <<<_END
					</select>
					<br>
					<input type="input" name="begin" placeholder="С" value="$today" readonly>
					<br>
					<input type="date" name="end" placeholder="До" min="$today">
					<br>
					<input type="submit" class="btn" value="Выдать книгу">
					<br>
					<br>
				</form>
			</div>
		</div>
	</div>
	<script src="modal.js"></script> 
	<h3>В Вашей библиотеке имеется:</h3>
    <div>$count_given выданных книг</div>
	<div>$count_books книг</div>
	<div>$count_readers читателей</div>
	<p>Информация о них представлена в таблицах ниже:<p>
_END;

	echo "<form action='take_book.php' method='POST'><table>";
    echo "<tr><th>Книга</th><th>Читатель</th><th>С</th><th>До</th><th>Приём</th></tr>";
	echo "<h3>Выданные книги</h3>";
    foreach ($result_array_given as $result_row_given) {
      $book = $result_row_given["book"];
      $reader = $result_row_given["reader"];
      if (($today > $result_row_given["end"]) && ($result_row_given["debt"] == 0)) {
        echo '<tr bgcolor="#ff7575">';
        $bk_debt = $db->query("UPDATE books set debt='1' where id='$book'");
        $rd_debt = $db->query("UPDATE readers set debter='1' where id='$reader'");
      } elseif ($today = $result_row_given["end"]) {
      	echo '<tr bgcolor="#ffd466">';
      } else {
        echo "<tr>";
      }
        echo "<td>" . $result_row_given["book"] . "</td>";
        echo "<td>" . $result_row_given["reader"] . "</td>";
        echo "<td>" . $result_row_given["begin"] . "</td>";
        echo "<td>" . $result_row_given["end"] . "</td>";
        echo "<td><input type='checkbox' name='delete_row[]' value='" . $result_row_given["book"] . "'></td>";
        echo "</tr>";
    }
    echo "</table><br><input type='submit' class='btn' value='Принять выделенные книги'></form>";
	echo "<br>";
    echo "<form action='delete_book.php' method='POST'><table>";
    echo "<tr><th>№</th><th>Автор</th><th>Название</th><th>Место</th><th>Год</th><th>Удаление</th></tr>";
	echo "<h3>Книги</h3>";
    foreach ($result_array_books as $result_row_book) {
      if (($result_row_book["given"] == 1) && ($result_row_book["debt"] == 0)) {
        echo '<tr bgcolor="#d6d3cb">';
      } elseif (($result_row_book["given"] == 1) && ($result_row_book["debt"] == 1)) {
        echo '<tr bgcolor="#ff7575">';
      } else {
        echo "<tr>";
      }
        echo "<td>" . $result_row_book["id"] . "</td>";
        echo "<td>" . $result_row_book["author"] . "</td>";
        echo "<td>" . $result_row_book["title"] . "</td>";
        echo "<td>" . $result_row_book["place"] . "</td>";
        echo "<td>" . $result_row_book["year"] . "</td>";
        echo "<td><input type='checkbox' name='delete_row[]' value='" . $result_row_book["id"] . "'></td>";
        echo "</tr>";
    }
    echo "</table><br><input type='submit' class='btn' value='Удалить выделенные книги'></form>";
	echo "<br>";
	
	echo "<h3>Читатели</h3>";
	echo "<form action='delete_reader.php' method='POST'><table>";
    echo "<tr><th>№</th><th>Имя</th><th>Телефон</th><th>Адрес</th><th>Удаление</th></tr>";
	foreach ($result_array_readers as $result_row_reader) {
      if ($result_row_reader["debter"] == 1) {
        echo '<tr bgcolor="#ff7575">';
      } else {
        echo "<tr>";
      }
        echo "<td>" . $result_row_reader["id"] . "</td>";
        echo "<td>" . $result_row_reader["name"] . "</td>";
        echo "<td>" . $result_row_reader["phone"] . "</td>";
        echo "<td>" . $result_row_reader["adress"] . "</td>";
        echo "<td><input type='checkbox' name='delete_row[]' value='" . $result_row_reader["id"] . "'></td>";
        echo "</tr>";
    }
    echo "</table><br><input type='submit' class='btn' value='Удалить выделенных читателей'></form>";
	echo "<br>";
	
}
 
catch(PDOException $e) {
    echo "Л̶̗̩̫́̀̑̂̎͘ӑ̵͇Г̵̪͎͍̗̇̉̃͊ при получении информации из базы данных: " . $e->getMessage();
}
$db = null;
?>
</body>
</html>