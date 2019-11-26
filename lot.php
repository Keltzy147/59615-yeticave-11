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
     http_response_code(404);
     $page_content = include_template('error.php', ['error' => 'Лот № ' . $lot_id . ' не найден']);
     $page_title = "Лот № " . $lot_id . " не найден";
     print("Ошибка подключения" . mysqli_connect_error());;
 }
 $lot_id = filter_input(INPUT_GET, 'id');
 $sql_lot = "SELECT lots.id, lots.name, lots.img, categories.name AS category, lots.description, lots.step, lots.expiry_date, count(bets.price) AS price, "
 . "IF (count(bets.price) > 0, MAX(bets.price), lots.first_price) AS price "
 . "FROM lots "
 . "LEFT JOIN bets ON lots.id = bets.lot_id "
 . "LEFT JOIN categories ON lots.category_id = categories.id "
 . "WHERE lots.id = '%s' GROUP BY lots.id; ";
 $sql_lot = sprintf($sql_lot, $lot_id);
 $result = mysqli_query($connect_db, $sql_lot);
 if ($result) {
    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    $page_content = include_template('lots.php', [
        'categories' => $categories,
        'lot' => $lot,
        'expiry_date' => $lot['expiry_date']
    ]);
    $page_title = $lot['name'];
}
}

$layout_page = include_template('layout_lots.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
strip_tags(print($layout_page));
?>