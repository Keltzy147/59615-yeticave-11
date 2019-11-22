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

    $sql_products = <<<SQL
SELECT lots.id, lots.name, lots.first_price, lots.img, lots.expiry_date, categories.name AS category,
       CASE
            WHEN (SELECT MAX(price) FROM bets WHERE bets.lot_id = lots.id) != 0 THEN (SELECT MAX(price) FROM bets WHERE bets.lot_id = lots.id)
            ELSE lots.first_price
       END AS price
       FROM lots JOIN categories ON lots.category_id = categories.id
       WHERE lots.expiry_date > CURDATE() ORDER BY lots.expiry_date DESC;
SQL;

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