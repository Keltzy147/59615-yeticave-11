<?php
require_once("function.php");
require_once("bd_connect.php");
require_once("get_category.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $form = $_POST;

   $required =['email','password'];
   $errors = [];
   foreach ($required as $field){
       if(empty($form[$field])){
           $errors[$field] = 'Это поле надо заполнить';
       }
   }

   $email = mysqli_real_escape_string($connect_db,$form['email']);
   $sql = "SELECT * FROM users WHERE email = '$email'";
   $res = mysqli_query($connect_db,$sql);

   $user = $res ? mysqli_fetch_array($res,MYSQLI_ASSOC) : null;

   if (!count($errors) and $user){
       if(password_verify($form['password'], $user['password'])){
           $_SESSION['user'] = $user;
       }
       else{
           $errors['password'] = "Неверный пароль";
       }
   }
   else{
       $errors['email'] = "Такой пользователь не найден";
   }

   if(count($errors)){
       $page_content = include_template('login.php',['form' => $form,'errors' => $errors]);
   }
   else{
       header("Location: /yeticave/index.php");
       exit();
   }
}
else {
    $page_content = include_template("login.php",[]);

    if(isset($_SESSION['user'])){
        header("Location: /yeticave/index.php");
        exit();
    }
}


$page_content = include_template('login.php',[]);
$layout_content = include_template('layout_lots.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Аутентификация',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
