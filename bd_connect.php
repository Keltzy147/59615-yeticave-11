<?php
session_start();

$connect_db = mysqli_connect("localhost","root","","yeticave");
	if(!$connect_db){
		print("Ошибка подключения " . mysqli_connect_error());
	}
$is_auth = isset($_SESSION['user']);
$user_name = (isset($_SESSION['user'])) ? $_SESSION['user']['name'] : '';
?>
