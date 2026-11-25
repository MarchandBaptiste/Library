<section>
    <h2><?= htmlspecialchars($book->subtitle ?? '') ?></h2>
    <h3>
        <a href="index.php?page=author&id=<?= (int) $book->author_id ?>">
            <i><?= htmlspecialchars($book->name) ?></i>
        </a>
    </h3>
    <p><?= htmlspecialchars($book->description ?? '') ?></p>
    <p>
        Édition <?= htmlspecialchars($book->publisher ?? '') ?>
        | date <?= htmlspecialchars($book->published ?? '') ?>
        | p. <?= (int) $book->pages ?>
    </p>
    <a href="<?= htmlspecialchars($book->website ?? '') ?>">site internet</a>
</section>
</body>

</html>