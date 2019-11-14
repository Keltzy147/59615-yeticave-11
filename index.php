<?php
$is_auth = rand(0, 1);
$user_name = "Марат"; // укажите здесь ваше имя

function price(int $price) : string {
if (ceil($price) < 1000) {
    return $price . " ₽";
}
else{
    return number_format($price, 0, ',', ' ') . " ₽";
    }
}

function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function timer($time){
    $diff = strtotime($time) - time();

    $hours = floor($diff / 60 / 60); //  перевод в часы с округлением вниз
    $hours = str_pad ($hours, 2, "0", STR_PAD_LEFT); // добавляем 0 перед числом, если число меньше 2 знаков

    $minutes = floor(($diff - ($hours * 60 * 60)) / 60); // получаем минуты
    $minutes = str_pad ($minutes, 2, "0", STR_PAD_LEFT); // добавляем 0 перед числом, если число меньше 2 знаков

    $timer = $hours . ':' . $minutes;

    return $timer;
}

$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$products = [
    [
    "name" => "2014 Rossignol District Snowboard",
    "category" => "Доски и лыжи",
    "price" => 10999,
    "url" => "img/lot-1.jpg",
    "date" =>'2019-11-01' 
    ],
    [
    "name" => "DC Ply Mens 2016/2017 Snowboard",
    "category" => "Доски и лыжи",
    "price" => 159999,
    "url" => "img/lot-2.jpg",
    "date" =>'2019-11-02' 
    ],
    [
    "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
    "category" => "Крепления",
    "price" => 8000,
    "url" => "img/lot-3.jpg",
    "date" =>'2019-11-03' 
    ],
    [
    "name" => "Ботинки для сноуборда DC Mutiny Charocal",
    "category" => "Ботинки",
    "price" => 10999,
    "url" => "img/lot-4.jpg",
    "date" =>'2019-11-04' 
    ],
    [
    "name" => "Куртка для сноуборда DC Mutiny Charocal",
    "category" => "Одежда",
    "price" => 7500,
    "url" => "img/lot-5.jpg",
    "date" =>'2019-11-05' 
    ],
    [
    "name" => "Маска Oakley Canopy",
    "category" => "Разное",
    "price" => 5400,
    "url" => "img/lot-6.jpg",
    "date" =>'2019-11-06' 
    ]
];

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