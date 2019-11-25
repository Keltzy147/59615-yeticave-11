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
        print("Ошибка подключения " . mysqli_connect_error());
    }

    $sql_products = "SELECT lots.id, lots.name, lots.img, categories.name AS category, expiry_date, count(bets.price) AS price, "
    . "IF (count(bets.price) > 0, MAX(bets.price), lots.first_price) AS price "
    . "FROM lots "
    . "LEFT JOIN bets ON lots.id = bets.lot_id "
    . "LEFT JOIN categories ON lots.category_id = categories.id "
    . "WHERE lots.expiry_date > CURDATE() GROUP BY lots.id ORDER BY lots.expiry_date DESC ";

    $products_result = mysqli_query($connect_db, $sql_products);
    if ($products_result) {
        $products = mysqli_fetch_all($products_result, MYSQLI_ASSOC);
    } else {
        return null;
    }
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