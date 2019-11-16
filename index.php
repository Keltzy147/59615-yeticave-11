<?php
$is_auth = rand(0, 1);
$user_name = "Марат"; // укажите здесь ваше имя
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
        print("Ошибка подключения " . mysqli_connect_error());
    }
    $sql_products = <<<SQL
SELECT lots.name, lots.first_price, lots.img, bets.price AS price, categories.name AS category
       FROM lots
              LEFT JOIN bets ON lots.id = bets.lot_id
              LEFT JOIN categories ON lots.category_id = categories.id
       WHERE lots.expiry_date > CURDATE() ORDER BY lots.expiry_date DESC;
SQL;
    $products_result = mysqli_query($connect_db, $sql_products);
    if ($products_result) {
        $products = mysqli_fetch_all($products_result, MYSQLI_ASSOC);
    } else {
        return null;
    }
}
function price(int $price) : string {
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
    $hours = floor($diff / 60 / 60); // перевод в часы с округлением вниз
    $hours = str_pad ($hours, 2, "0", STR_PAD_LEFT); // добавляем 0 перед числом, если число меньше 2 знаков
    $minutes = floor(($diff - ($hours * 60 * 60)) / 60); // получаем минуты
    $minutes = str_pad ($minutes, 2, "0", STR_PAD_LEFT); // добавляем 0 перед числом, если число меньше 2 знаков
    $timer = $hours . ':' . $minutes;
    return $timer;
}
$page_content = include_template('main.php',[
    'categories' => $categories,
    'products' => $products
]);
$layout_page = include_template('layout.php',[
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'YetiCave - Главная страница'
]);
strip_tags(print($layout_page));
?><?php
$is_auth = rand(0, 1);
$user_name = "Марат"; // укажите здесь ваше имя
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
        print("Ошибка подключения " . mysqli_connect_error());
    }
    $sql_products = <<<SQL
SELECT lots.name, lots.first_price, lots.img, bets.price AS price, categories.name AS category
       FROM lots
              LEFT JOIN bets ON lots.id = bets.lot_id
              LEFT JOIN categories ON lots.category_id = categories.id
       WHERE lots.expiry_date > CURDATE() ORDER BY lots.expiry_date DESC;
SQL;
    $products_result = mysqli_query($connect_db, $sql_products);
    if ($products_result) {
        $products = mysqli_fetch_all($products_result, MYSQLI_ASSOC);
    } else {
        return null;
    }
}
function price(int $price) : string {
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
    $hours = str_pad ($hours, 2, "0", STR_PAD_LEFT); //  добавляем 0 перед числом, если число меньше 2 знаков
    $minutes = floor(($diff - ($hours * 60 * 60)) / 60); //  получаем минуты
    $minutes = str_pad ($minutes, 2, "0", STR_PAD_LEFT); // добавляем 0 перед числом, если число меньше 2 знаков
    $timer = $hours . ':' . $minutes;
    return $timer;
}
$page_content = include_template('main.php',[
    'categories' => $categories,
    'products' => $products
]);
$layout_page = include_template('layout.php',[
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'YetiCave - Главная страница'
]);
strip_tags(print($layout_page));
?>