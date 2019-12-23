<?php
require_once("function.php");
require_once("bd_connect.php");
require_once("get_category.php");
require_once("vendor/autoload.php");

$error = "Укажите ставку";
$lot_id = filter_input(INPUT_GET, 'id');
$sql_lot = "SELECT lots.id, lots.name, lots.img, categories.name AS category, lots.description, lots.step, lots.expiry_date, count(bets.price) AS price, "
    . "IF (count(bets.price) > 0, MAX(bets.price), lots.first_price) AS price "
    . "FROM lots "
    . "LEFT JOIN bets ON lots.id = bets.lot_id "
    . "LEFT JOIN categories ON lots.category_id = categories.id "
    . "WHERE lots.id = '%s' GROUP BY lots.id; ";
$sql_lot = sprintf($sql_lot, $lot_id);
$result = mysqli_query($connect_db, $sql_lot);
$form = filter_input_array(INPUT_POST, ['cost' => FILTER_DEFAULT], true);

if ($_SESSION && $error) {
    $user_id = $_SESSION['user']['id'];
    $sql = $connect_db, "INSERT INTO bets (created_at, lot_id, user_id, price) VALUES (NOW(),?,?,?)";
    $stmt = db_get_prepare_stmt($connect_db, $sql, [$lot_id, $user_id, $form['cost']]);
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
        header("Location: my-bets.php");
    }
}
$sql_bets = "SELECT users.name, bets.price, bets.created_at "
    . "FROM bets "
    . "LEFT JOIN users ON bets.user_id = users.id "
    . "LEFT JOIN lots ON bets.lot_id = lots.id "
    . "WHERE lots.id = '$lot_id' ORDER BY bets.created_at DESC; ";
$result_bet = mysqli_query($connect_db, $sql_bets);
$bets = mysqli_fetch_all($result_bet, MYSQLI_ASSOC);

if (mysqli_num_rows($result)) {
    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    $page_content = include_template('lot.php', [
        'lot_id' => $lot_id,
        'error' => $error,
        'categories' => $categories,
        'lot' => $lot,
        'bets' => $bets,
        'expiry_date' => $lot['expiry_date']
    ]);
    $page_title = $lot['name'];
} else {
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
