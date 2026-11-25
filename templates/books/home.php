<?php foreach ($books as $book): ?>
    <div class="book-card">
        <h2 class="book-card__heading">
            <?= htmlspecialchars($book->title) ?>
        </h2>
        <!-- on crée un lien vers la page d'un auteur -->
        <div class="book-card__body">
            <h3 class="book-card__subheading">
                <a href="index.php?page=author&id=<?= (int) $book->author_id ?>">
                    <i>
                        <?= htmlspecialchars($book->name) ?>
                    </i>
                </a>
            </h3>
            <p class="book-card__description">
                <?= htmlspecialchars($book->description ?? '') ?>
            </p>
        </div>
        <div class="book-card__footer">
            <a href="index.php?page=book&id=<?= (int) $book->id ?>">En savoir plus</a>
            <form action="index.php?page=delete" method="post">
                <input type="hidden" name="id" value="<?= (int) $book->id ?>">
                <button>Supprimer</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
</body>

</html>