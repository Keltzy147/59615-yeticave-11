<?php 
function price(int $price = null) : string {
	if (ceil($price) < 1000) {
		return $price . " ₽";
	}
	else{
		return number_format($price, 0, ',', ' ') . " ₽";
	}
}

function include_template($name, array $data = []) {
	$name = 'templates/' . $name;
	$result = '';

	if (!is_readable($name)) {
		return $result;
	}

	ob_start();
	extract($data);
	require $name;

	$result = ob_get_clean();

	return $result;
}

function timer($time){
	$diff = strtotime($time) - time();

    $hours = floor($diff / 60 / 60); //  перевод в часы с округлением вниз
    $hours = str_pad ($hours, 2, "0", STR_PAD_LEFT); // добавляем 0 перед числом, если число меньше 2 знаков

    $minutes = floor(($diff - ($hours * 60 * 60)) / 60); // получаем минуты
    $minutes = str_pad ($minutes, 2, "0", STR_PAD_LEFT); // добавляем 0 перед числом, если число меньше 2 знаков

    $timer = $hours . ':' . $minutes;

    return $timer;
}
?>