<?php

/**
 * CE FICHIER EST LA PAGE D'ACCUEIL DU SITE. ELLE DOIT AFFICHER LA LISTE DES LIVRES DISPONIBLES DANS NOTRE BIBLIOTHEQUE.
 * 
 * On devra se connecter à la base de données et récupérer une liste de livres triés par ordre alphabétique de titre. On va boucler sur la liste pour afficher chaque item de la liste.
 */

// Appelle des constantes
require_once __DIR__ . '/config/constants.php';
/**
 * On affiche la page
 */
$title = 'Accueil';
$heading = 'Catalogue des livres';
include_once DOCUMENT_ROOT . '/partials/header.php';

/**
 * 2. On récupère la liste des livres.
 */

// on utilise la méthode query car notre requête n'a pas besoin de paramètre.

$stmt = $pdo->query('SELECT * FROM `books` INNER JOIN `authors` ON `books`.`author_id` = `authors`.`id`');

//  on extrait les données de la réponse réçue.

$books = $stmt->fetchAll();
?>

<?php foreach ($books as $book): ?>
    <div class="book-card">
        <h2 class="book-card__heading">
            <?= $book['title'] ?>
        </h2>
        <!-- on crée un lien vers la page d'un auteur -->
        <div class="book-card__body">
            <h3 class="book-card__subheading"><a href="author.php?id=<?= $book['author_id'] ?>">
                    <i>
                        <?= $book['name'] ?>
                    </i>
                </a>
            </h3>
            <p class="book-card__description">
                <?= $book['description'] ?>
            </p>
        </div>
        <div class="book-card__footer">
            <a href="book.php?id=<?= $book['id'] ?>">En savoir plus</a>
            <form action="utils/delete-book.php" method="post"> <input type="hidden" name="id" value="<?= $book['id'] ?>">
                <button>Supprimer</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
<?php include_once DOCUMENT_ROOT . '/partials/footer.php'; ?>
</body>

</html>