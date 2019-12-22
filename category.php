<?php
require_once("function.php");
require_once("bd_connect.php");
require_once("get_category.php");
require_once("vendor/autoload.php");

$error = [];
$lots = [];
$cur_page = $_GET['page'] ?? 1;
$limit = 3;

$url = parse_url($_SERVER['REQUEST_URI']);
$parse_str = parse_str($url['query'], $query);
$category_id = $query['id'];

if ($category_id) {

    $data_count_sql = mysqli_real_escape_string($connect_db, "SELECT COUNT(*) AS cnt, categories.id "
        . "FROM categories "
        . "LEFT JOIN lots ON lots.category_id = categories.id "
        . "WHERE lots.category_id = '$category_id'; ");
    $result_count = mysqli_query($connect_db, $data_count_sql);
    $count = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
    $items_count = $count['cnt'];

    $pages_limit = ceil($items_count / $limit);
    $offset = ($cur_page - 1) * $limit;
    $pages = range(1, $pages_limit);

    if ($count['id'] == $category_id && count($pages) >= $cur_page) {

        $sql = mysqli_real_escape_string($connect_db, "SELECT lots.id, lots.name, lots.description, lots.img, categories.name AS category, expiry_date, count(bets.price) AS price, "
            . " IF (count(bets.price) > 0, MAX(bets.price), lots.first_price) AS price "
            . " FROM lots "
            . " LEFT JOIN bets ON lots.id = bets.lot_id "
            . " LEFT JOIN categories ON lots.category_id = categories.id "
            . " WHERE lots.category_id = '$category_id'"
            . " GROUP BY lots.id ORDER BY lots.expiry_date DESC LIMIT " . $limit . " OFFSET " . $offset);
        $stmt = db_get_prepare_stmt_oneoff($connect_db, $sql, [$category_id]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $sql_cat = mysqli_real_escape_string($connect_db, "SELECT categories.name FROM categories WHERE categories.id = '$category_id'");
        $stmt = db_get_prepare_stmt_oneoff($connect_db, $sql_cat, [$category_id]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $cat = mysqli_fetch_all($result, MYSQLI_ASSOC);


        $page_content = include_template('category.php', [
            'cat' => $cat,
            'lots' => $lots,
            'category_id' => $category_id,
            'pages_limit' => $pages_limit,
            'pages' => $pages,
            'cur_page' => $cur_page
        ]);
    } else {
        header("Location: /yeticave/category.php?id=1&page=1");
        exit();
    }
}

$layout_content = include_template('layout_lots.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Результаты поиска: ',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print($layout_content);
