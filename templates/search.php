<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?= $search ?></span>»</h2>
        <?php if (empty($lots)): ?>
            <p>Ничего не найдено по вашему запросу</p>
        <?php endif ?>
        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $lot["img"]; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $lot["category"]; ?></span>
                        <h3 class="lot__title">
                            <a class="text-link" href="lot.php/?id=<?= $lot["id"]; ?>"><?= $lot["name"]; ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= price($lot["price"]); ?></span>
                            </div>
                            <div
                                class="lot__timer timer <?php if (timer($lot['expiry_date']) < 1): ?> timer--finishing <?php endif ?>">
                                <?= timer($lot['expiry_date']); ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php if (!empty($lots) && count($pages) > 1): ?>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev"><a
                    href="?search=<?= $search; ?>&page=<?php if ($cur_page <= 1) : ?><?= $cur_page = 1; ?><?php else: ?><?= $cur_page - 1; ?><?php endif; ?>">Назад</a>
            </li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $cur_page): ?>pagination-item-active<?php endif; ?>">
                    <a href="?search=<?= $search; ?>&page=<?= $page; ?>"><?= $page; ?></a>
                </li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><a href="?search=<?= $search; ?>&page=<?php if ($cur_page >= $pages_limit) : ?><?= $cur_page; ?><?php else: ?><?= $cur_page + 1; ?><?php endif; ?>">Вперед</a>
            </li>
        </ul>
    <?php endif ?>
</div>
