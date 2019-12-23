<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body>
<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= strip_tags($users[0]['name']); ?></p>
<?php foreach ($users as $i => $user) : ?>
    <p>Ваша ставка для лота <a href="/lot.php?id=<?= $user['id']; ?>"><?= strip_tags($user['lots_name']); ?></a> победила.
    </p>
<?php endforeach; ?>
<p>Перейдите по ссылке <a href="my-bets.php]">мои ставки</a>,
    чтобы связаться с автором объявления</p>
<small>Интернет Аукцион "YetiCave"</small>
</body>
</html>
