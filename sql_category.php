<?php
mysqli_set_charset($connect_db, "utf8");
mysqli_options(mysqli_init(), MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$sql = 'SELECT  `name`,`link` FROM categories';
$result = mysqli_query($connect_db, $sql);
if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    http_response_code(404);
    print("Ошибка подключения" . mysqli_connect_error());;
}
?>
