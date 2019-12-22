<?php
require_once("function.php");
require_once("bd_connect.php");
require_once("get_category.php");
require_once("vendor/autoload.php");

if ($_SESSION) {
    $user_id = $_SESSION['user']['id'];
    $sql_bets = mysqli_real_escape_string($connect_db, "SELECT lots.winner_id, bets.user_id, lots.id as lot_id, lots.img, lots.name, categories.name AS category, lots.expiry_date,bets.created_at, bets.price AS price "
        . "FROM bets "
        . "LEFT JOIN lots ON lots.id = bets.lot_id "
        . "LEFT JOIN categories ON lots.category_id = categories.id "
        . "WHERE bets.user_id = '$user_id' ORDER BY bets.created_at DESC");

    $result = mysqli_query($connect_db, $sql_bets);
    if ($result) {
        $rates = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($rates as $lot => $rate) {
            $expiryTime = timer($rate['expiry_date']);
            $rates[$lot]['timer_class'] = '';
            $rates[$lot]['timer_message'] = $expiryTime;
            if ((int)$expiryTime[0] === 0 && !empty($expiryTime)) {
                $rates[$lot]['timer_class'] = 'timer--finishing';
                $rates[$lot]['timer_message'] = $expiryTime;
            }
            if (date_create("now") > date_create($rate['expiry_date'])) {
                $rates[$lot]['timer_class'] = 'timer--end';
                $rates[$lot]['timer_message'] = 'Торги окончены';
                $rates[$lot]['rate_class'] = 'rates__item--end';
            }
            if ($rate['winner_id']) {
                $rates[$lot]['timer_class'] = 'timer--win';
                $rates[$lot]['timer_message'] = 'Ставка выиграла';
                $rates[$lot]['rate_class'] = 'rates__item--win';
            }
        }
    } else {
        return null;
    }
} else {
    header("Location: /yeticave/login.php");
    exit();
}
$page_content = include_template('my-bets.php', ['rates' => $rates]);
$page_title = "Мои ставки";

$layout_page = include_template('layout_lots.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print($layout_page);
?>
