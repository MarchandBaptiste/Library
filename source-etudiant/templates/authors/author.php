<?php

/**
 * Vue d'un auteur et de ses livres
 * $author, $books
 */
require DOCUMENT_ROOT . '/templates/partials/header.php';
?>

<section>
    <p>
        <?= htmlspecialchars($author['biography'] ?? '') ?>
    </p>
    <h2>Ouvrages publiés</h2>
    <ul>
        <?php foreach ($books as $book): ?>
            <li>
                <a href="index.php?page=book&id=<?= (int) $book['id'] ?>">
                    <?= htmlspecialchars($book['title']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php require DOCUMENT_ROOT . '/templates/partials/footer.php'; ?>
</body>

</html>