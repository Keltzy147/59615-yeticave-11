<?php
require_once("function.php");
require_once("bd_connect.php");
require_once("get_category.php");
require_once("vendor/autoload.php");

if ($is_auth = isset($_SESSION['user'])) {
    $cats_ids = [];
    $cats_ids = array_column($categories, 'id');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['lot-name', 'category', 'message', 'lot-img', 'lot-rate', 'lot-step', 'lot-date'];
        $errors = [];
        $rules = [
            'category' => function ($value) use ($cats_ids) {
                return validateCategory($value, $cats_ids);
            },
            'lot-name' => function ($value) {
                return validateLength($value, 10, 255);
            },
            'message' => function ($value) {
                return validateLength($value, 10, 3000);
            },
            'lot-date' => function ($value) {
                return is_date_valid($value);
            },
            'lot-rate' => function ($value) {
                return validatePrice($value);
            },
            'lot-step' => function ($value) {
                return validateStep($value);
            }
        ];
        $lot = filter_input_array(INPUT_POST, [
            'lot-name' => FILTER_DEFAULT,
            'message' => FILTER_DEFAULT,
            'category' => FILTER_DEFAULT,
            'lot-date' => FILTER_DEFAULT,
            'lot-rate' => FILTER_DEFAULT,
            'lot-step' => FILTER_DEFAULT
        ], true);
        $fields = [
            'lot-name' => 'Наименование',
            'message' => 'Описание',
            'category' => 'Категория',
            'lot-date' => 'Дата окончания торгов ',
            'lot-rate' => 'Начальная цена',
            'lot-step' => 'Шаг ставки',
        ];
        foreach ($lot as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $errors[$key] = $rule($value);
            }
            if (in_array($key, $required) && empty($value)) {
                $errors[$key] = "$fields[$key] надо заполнить";
            }
        }
        $errors = array_filter($errors);
        if (!empty($_FILES['lot-img']['name'])) {
            $tmp_name = $_FILES['lot-img']['tmp_name'];
            $path = $_FILES['lot-img']['name'];
            $extract = pathinfo($path, PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extract;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            if ($file_type !== "image/jpeg" && $file_type !== "image/png") {
                $errors['file'] = 'Загрузите картинку в форматах jpg, jpeg, png';
            } else {
                if (!count($errors)) {
                    move_uploaded_file($tmp_name, 'uploads/' . $filename);
                    $lot['path'] = $filename;
                }
            }
        } else {
            $errors['file'] = 'Вы не загрузили файл';
        }
        if (count($errors)) {
            $page_content = include_template('add_lot.php',
                ['lot' => $lot, 'errors' => $errors, 'categories' => $categories]);
        } else {
            $sql = mysqli_real_escape_string($connect_db, 'INSERT INTO lots (name, description, category_id, expiry_date, first_price, step, img, created_at, user_id, winner_id) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 1, 2)');
            $stmt = db_get_prepare_stmt($connect_db, $sql, $lot);
            $res = mysqli_stmt_execute($stmt);
            if ($res) {
                $lot_id = mysqli_insert_id($connect_db);
                header("Location: lot.php?id=" . $lot_id);
            };
        }
    } else {
        $page_content = include_template('add_lot.php', ['categories' => $categories]);
    }
    $layout_content = include_template('layout_lots.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => 'Добавление лота',
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);
    print($layout_content);
} else {
    http_response_code(403);
}
