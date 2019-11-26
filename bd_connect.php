<?php
$is_auth = rand(0, 1);
$user_name = "Марат"; // укажите здесь ваше имя

require_once("function.php");

$connect_db = mysqli_connect("localhost","root","","yeticave");
	if(!$connect_db){
		print("Ошибка подключения " . mysqli_connect_error());
	}
	else{
		mysqli_set_charset($connect_db, "utf8");
		mysqli_options(mysqli_init(), MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
		$sql = 'SELECT  `name`,`link` FROM categories';
		$result = mysqli_query($connect_db, $sql);

		if($result){
			$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
		}
		else{
			http_response_code(404);
			$page_content = include_template('error.php', ['error' => 'Лот № ' . $lot_id . ' не найден']);
			$page_title = "Лот № " . $lot_id . " не найден";
			print("Ошибка подключения" . mysqli_connect_error());;
		}
	}
?>