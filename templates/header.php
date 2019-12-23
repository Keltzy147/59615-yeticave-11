<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="/yeticave/css/normalize.min.css" rel="stylesheet">
    <link href="/yeticave/css/style.css" rel="stylesheet">
    <link href="/yeticave/css/flatpickr.min.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">
    <header class="main-header">
        <div class="main-header__container container">
            <h1 class="visually-hidden">YetiCave</h1>
            <a class="main-header__logo" href="/yeticave/index.php">
                <img src="img/logo.svg" width="160" height="39" alt="Логотип компании YetiCave">
            </a>
            <form class="main-header__search" action="search.php" method="get" enctype="multipart/form-data">
                <input type="search" name="search" placeholder="Поиск лота"
                       value="<?= $search = $_GET['search'] ?? ''; ?>">
                <input class="main-header__search-btn" type="submit">
            </form>
            <a class="main-header__add-lot button" href="/yeticave/add.php">Добавить лот</a>
            <nav class="user-menu">
                <?php if ($is_auth): ?>
                    <div class="user-menu__logged">
                        <p><?= strip_tags($user_name); ?></p>
                        <a class="user-menu__bets" href="/yeticave/my-bets.php">Мои ставки</a>
                        <a class="user-menu__logout" href="/yeticave/logout.php">Выход</a>
                    </div>
                <?php else: ?>
                    <ul class="user-menu__list">
                        <li class="user-menu__item">
                            <a href="/yeticave/sign-up.php">Регистрация</a>
                        </li>
                        <li class="user-menu__item">
                            <a href="/yeticave/login.php">Вход</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>
    </header>
