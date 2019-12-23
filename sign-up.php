<?php
require_once("function.php");
require_once("bd_connect.php");
require_once("get_category.php");
require_once("vendor/autoload.php");

$page_content = include_template('sign-up.php', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['email', 'password', 'name', 'message'];
    $errors = [];
    $rules = [
        'email' => function ($value) {
            return validateEmail($value, 2, 255);
        },
        'password' => function ($value) {
            return validateLength($value, 5, 255);
        },
        'name' => function ($value) {
            return validateLength($value, 3, 40);
        },
        'message' => function ($value) {
            return validateLength($value, 10, 3000);
        }
    ];
    $form = filter_input_array(INPUT_POST, [
        'email' => FILTER_VALIDATE_EMAIL,
        'password' => FILTER_DEFAULT,
        'name' => FILTER_DEFAULT,
        'message' => FILTER_DEFAULT
    ], true);
    $fields = [
        'email' => 'Почту',
        'password' => 'Пароль',
        'name' => 'Наименование',
        'message' => 'Описание'
    ];
    foreach ($form as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Надо заполнить $fields[$key]";
        }
    }
    $errors = array_filter($errors);
    if (empty($errors)) {
        $email = mysqli_real_escape_string($connect_db, $form['email']);
        $sql = mysqli_real_escape_string($connect_db, "SELECT id FROM users where email = '$email'");
        $res = mysqli_query($connect_db, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);
            $sql = mysqli_real_escape_string($connect_db, "INSERT INTO users (created_at, email, name, password, contacts) VALUES (NOW(),?,?,?,?)");
            $stmt = db_get_prepare_stmt($connect_db, $sql,
                [$form['email'], $form['name'], $password, $form['message']]);
            $res = mysqli_stmt_execute($stmt);
        }
        if ($res) {
            header("Location: /login.php");
            exit();
        }
    } else {
        $page_content = include_template('sign-up.php', ['form' => $form, 'errors' => $errors]);
    }
}

$layout_content = include_template('layout_lots.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Добавление лота',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
