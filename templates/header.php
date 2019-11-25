<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<link href="/yeticave/css/normalize.min.css" rel="stylesheet">
	<link href="/yeticave/css/style.css" rel="stylesheet">
	<link href="/yeticave/css/flatpickr.min.css" rel="stylesheet">
</head>
<body>
	<div class="page-wrapper">
		<header class="main-header">
			<div class="main-header__container container">
				<h1 class="visually-hidden">YetiCave</h1>
				<a class="main-header__logo" href="index.html">
					<img src="/yeticave/img/logo.svg" width="160" height="39" alt="Логотип компании YetiCave">
				</a>
				<form class="main-header__search" method="get" action="https://echo.htmlacademy.ru" autocomplete="off">
					<input type="search" name="search" placeholder="Поиск лота">
					<input class="main-header__search-btn" type="submit" name="find" value="Найти">
				</form>
				<a class="main-header__add-lot button" href="/test/add.php">Добавить лот</a>
				<nav class="user-menu">
					<div class="user-menu__logged">
						<p><?= $user_name ;?></p>
						<a class="user-menu__bets" href="my-bets.html">Мои ставки</a>
						<a class="user-menu__logout" href="#">Выход</a>
					</div>
				</nav>
			</div>
		</header>