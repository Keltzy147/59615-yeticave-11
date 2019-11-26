<?php
require_once("bd_connect.php");
require_once("sql_category.php");

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