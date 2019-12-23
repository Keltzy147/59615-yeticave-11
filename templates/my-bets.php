<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($rates as $rate) : ?>
            <tr class="rates__item <?= $rate['rate_class'] ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="/<?= $rate['img']; ?>" width="54" height="40" alt="<?= strip_tags($rate['name']); ?>">
                    </div>
                    <h3 class="rates__title"><a
                            href="/lot.php?id=<?= $rate['lot_id']; ?>"><?= strip_tags($rate['name']); ?></a></h3>
                </td>
                <td class="rates__category"><?= $rate['category']; ?></td>
                <td class="rates__timer">
                    <div class="timer <?= $rate['timer_class'] ?>"><?= $rate['timer_message'] ?></div>
                </td>
                <td class="rates__price"><?= price($rate['price']); ?></td>
                <td class="rates__time"><?= format_bet($rate['created_at']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
