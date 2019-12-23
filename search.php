<?php
require_once("function.php");
require_once("bd_connect.php");
require_once("get_category.php");
require_once("vendor/autoload.php");

$lots = [];
$search = trim($_GET['search']) ?? '';
$cur_page = $_GET['page'] ?? 1;
$limit = 3;

if ($search) {
    $data_count_sql = mysqli_real_escape_string($connect_db, "SELECT COUNT(*) AS cnt FROM lots WHERE MATCH (lots.name,lots.description) AGAINST(?)");
    $db_prep_count = db_get_prepare_stmt($connect_db, $data_count_sql, [$search]);
    mysqli_stmt_execute($db_prep_count);
    $result_count = mysqli_stmt_get_result($db_prep_count);
    $count = mysqli_fetch_array($result_count, MYSQLI_NUM);
    $items_count = $count[0];

    $pages_limit = ceil($items_count / $limit);
    $offset = ($cur_page - 1) * $limit;
    $pages = range(1, $pages_limit);

    $sql = "SELECT lots.id, lots.name, lots.description, lots.img, categories.name AS category, expiry_date, count(bets.price) AS price, "
        . " IF (count(bets.price) > 0, MAX(bets.price), lots.first_price) AS price "
        . " FROM lots "
        . " LEFT JOIN bets ON lots.id = bets.lot_id "
        . " LEFT JOIN categories ON lots.category_id = categories.id "
        . " WHERE MATCH(lots.NAME,lots.description) AGAINST(?) "
        . " GROUP BY lots.id ORDER BY lots.expiry_date DESC LIMIT " . $limit . " OFFSET " . $offset;
    $stmt = db_get_prepare_stmt($connect_db, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

if ($cur_page > count($pages)) {
    header("Location: /yeticave/search.php?search=" . $search);
    exit();
}

$page_content = include_template('search.php', [
    'pages_limit' => $pages_limit,
    'search' => $search,
    'lots' => $lots,
    'pages' => $pages,
    'cur_page' => $cur_page
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Результаты поиска: ' . $search,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print($layout_content);
