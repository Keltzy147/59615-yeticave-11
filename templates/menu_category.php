<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="category.php?id=<?= $category['id']; ?>&page=1"><?= $category["name"]; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
