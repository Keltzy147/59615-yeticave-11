<?php
require_once("bd_connect.php");
require_once("function.php");
require_once("vendor/autoload.php");


$yandexSmtpHost = 'smtp.yandex.com';
$yandexEmail = 'it@ie-pro.ru';
$yandexPassword = '12345678q';
$yandexSmtpPort = 465;
$yandexEncryption = 'SSL';


$transport = (new Swift_SmtpTransport($yandexSmtpHost, $yandexSmtpPort))
    ->setUsername($yandexEmail)
    ->setPassword($yandexPassword)
    ->setEncryption('SSL');

$mailer = new Swift_Mailer($transport);


$sql = "SELECT lots.id, users.name AS name, users.email AS email, lots.name AS lots_name, lots.description, lots.img, lots.expiry_date, count(bets.price) AS count, "
    . "IF (count(bets.price) > 0, MAX(bets.price), lots.first_price) AS price "
    . "FROM lots "
    . "LEFT JOIN bets ON lots.id = bets.lot_id "
    . "LEFT JOIN users ON lots.winner_id = users.id "
    . "WHERE lots.expiry_date <= NOW() AND users.name IS NOT null "
    . "GROUP BY lots.id ";

$res = mysqli_query($connect_db, $sql);

if ($res && mysqli_num_rows($res)) {
    $users = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $recipients = [];

    foreach ($users as $user) {
        $recipients[$user['email']] = $user['name'];
    }

    $msq_content = include_template('getwinner.php', ['users' => $users]);

    $targetEmail = $user['email'];
    $message = (new Swift_Message('Вы выиграли в аукционе'))
        ->setFrom([$yandexEmail => 'Yeticave'])
        ->setTo([$targetEmail])
        ->setBody($msq_content, 'text/html');

    $result = $mailer->send($message);
    if ($result) {
        print("Успешно отправлено");
    } else {
        print("Что-то пошло не так");
    }
}




