<?php
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

function format_bet($dt) {
    $formattedDate = date_create($dt);
    $dt_now = date_create("now");
    $dt_diff = date_diff($dt_now, $formattedDate);
    $days_count = date_interval_format($dt_diff, "%a"); // дни
    $hours_count = date_interval_format($dt_diff, "%h"); // часы
    $min_count = date_interval_format($dt_diff, "%i"); // минуты
    $lastMinWord = get_noun_plural_form((int) $min_count,'минуту','минуты','минут');
    $lastHoursWord = get_noun_plural_form((int) $hours_count,'час','часа','часов');
    if ($days_count === "0") {
        if ($hours_count === "0") {
            return ($min_count > 1) ? $min_count . " $lastMinWord назад": "только что" ;
        } else {
            return  "$hours_count $lastHoursWord назад";
        }
    }
    return date_format($formattedDate,'d.m.Y в H:i');
}

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
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values); 

        
        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

function db_get_prepare_stmt_oneoff($link, $sql, $data) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }
        $values = array_merge([$stmt], $data);

        $func = 'mysqli_stmt_bind_param';
        
        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }

    return $stmt;
}

$postdata = file_get_contents("php://input");
function getPostVal($name){
    return $_POST[$name] ?? "";
}
/**
 * Функция валидации категории
 *
 * @param string $id id переданной категории
 * @param string $allowed_list массив, из которого будут выбираться категории
 *
 * @return string текст ошибки валидации
 */
function validateCategory($id, $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
    return null;
}
/**
 * Функция валидации длиный поля
 *
 * @param string $value значения поля
 * @param int $min минимальная длина поля
 * @param int $max максимальная длина поля
 *
 * @return string текст ошибки валидации
 */
function validateLength($value, $min, $max) {
    if ($value) {
        $len = strlen($value);
        if ($len < $min || $len > $max) {
            return "Значение должно быть от $min до $max символов";
        }
    }
    return null;
}
/**
 * Функция валидации цены лота
 *
 * @param string $value значения поля
 *
 * @return string текст ошибки валидации
 */
function validatePrice($value){
    if ((int)$value > 0) {
        return null;
    }
   return "Значение должно быть больше 0";
}
/**
 * Функция валидации шага лота
 *
 * @param string $value значения поля
 *
 * @return string текст ошибки валидации
 */
function validateStep($value) {
    if ((int)$value > 0) {
        return null;
    }
   return "Значение должно быть больше 0";
}
/**
 * Функция валидации даты истечения лота
 *
 * @param string $value значения поля
 *
 * @return string текст ошибки валидации
 */
function is_date_valid($value) {
    $future_dt = date('Y-m-d', strtotime("+1 days"));
    if ($value < $future_dt) {
        return "Дата должна быть на один день больше текущей даты, а также должна быть в формате ГГГГ-ММ-ДД";
    }
    return null;
}

function validateEmail($value, $min, $max) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "Некорректно написан email адрес";
        }
    return null;
}
?>
