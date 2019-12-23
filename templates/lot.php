<section class="lot-item container">
    <h2><?= strip_tags($lot['name']); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="/<?= $lot['img'] ?>" width="730" height="548" alt="<?= $lot['name'] ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category'] ?></span></p>
            <p class="lot-item__description"><?= strip_tags($lot['description']) ?></p>
        </div>
        <div class="lot-item__right">
            <?php if ($is_auth = isset($_SESSION['user'])) : ?>
            <div class="lot-item__state">
                <div
                    class="lot__timer timer <?php if (timer($lot['expiry_date']) < 1): ?> timer--finishing <?php endif ?>">
                    <?= timer($lot['expiry_date']); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= price($lot['price']); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= price($lot['step']); ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="/lot.php?id=<?= $lot_id; ?>" method="post"
                      enctype="multipart/form-data">
                    <?php $classname = isset($error) ? "form__item--invalid" : ""; ?>
                    <p class="lot-item__form-item form__item <?= $classname; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="12 000">
                        <span class="form__error"><?= $error; ?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                    <?php endif ?>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= count($bets); ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($bets AS $bet) : ?>
                        <tr class="history__item">
                            <td class="history__name"><?= strip_tags($bet['name']); ?></td>
                            <td class="history__price"><?= price($bet['price']); ?></td>
                            <td class="history__time"><?= format_bet($bet['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
