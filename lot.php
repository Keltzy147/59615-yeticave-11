<?php
require_once("function.php");
require_once("bd_connect.php");
require_once("sql_category.php");

 $lot_id = filter_input(INPUT_GET, 'id');
 $sql_lot = "SELECT lots.id, lots.name, lots.img, categories.name AS category, lots.description, lots.step, lots.expiry_date, count(bets.price) AS price, "
 . "IF (count(bets.price) > 0, MAX(bets.price), lots.first_price) AS price "
 . "FROM lots "
 . "LEFT JOIN bets ON lots.id = bets.lot_id "
 . "LEFT JOIN categories ON lots.category_id = categories.id "
 . "WHERE lots.id = '%s' GROUP BY lots.id; ";
 $sql_lot = sprintf($sql_lot, $lot_id);
 $result = mysqli_query($connect_db, $sql_lot);
 if (mysqli_num_rows($result)){
    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    $page_content = include_template('lots.php', [
        'categories' => $categories,
        'lot' => $lot,
        'expiry_date' => $lot['expiry_date']
    ]);
    $page_title = $lot['name'];
}
else {
    $page_content = include_template('error.php', ['error' => 'Лот № ' . $lot_id . ' не найден']);
    $page_title = "Лот № " . $lot_id . " не найден";
}

$layout_page = include_template('layout_lots.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print($layout_page);
?>