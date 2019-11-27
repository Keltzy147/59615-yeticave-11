<?php
$is_auth = rand(0, 1);
$user_name = "Марат"; // укажите здесь ваше имя

$connect_db = mysqli_connect("localhost","root","","yeticave");
	if(!$connect_db){
		print("Ошибка подключения " . mysqli_connect_error());
	}
?>