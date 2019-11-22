<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
    горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--<?= $category["link"]; ?>">
            <a class="promo__link" href="lot.php"><?= $category["name"];  ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($products as $product): ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?= $product["img"]; ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?= $product["category"]; ?></span>
                <h3 class="lot__title">
                <a class="text-link" href="lot.php/?id=<?= $product["id"]; ?>"><?= $product["name"]; ?>
                </a>
                </h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?= price($product["price"]); ?></span>
                    </div>
                    <div class="lot__timer timer <?php if (timer($product['expiry_date']) < 1): ?> timer--finishing <?php endif ?>">
                        <?=timer($product['expiry_date']);?>
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</section>