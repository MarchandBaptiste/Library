<?php

/**
 * CE FICHIER DOIT AFFICHER UN AUTEUR ET SES LIVRES. 
 */

/**
 * On doit d'abord vérifier qu'il existe un paramètre id, sinon on affiche un message d'erreur.
 * 
 * Si le paramètre est trouvé, on va se connecter à la base de données et chercher le livre enregistrer avec cet id.
 * Si aucun livre n'est trouvé, on affiche une erreur 404
 * Sinon, on affiche le livre.
 */
// Appelle des constantes
require_once __DIR__ . '/config/constants.php';
require_once DOCUMENT_ROOT . '/helpers/db_connect.php';
$pdo = db();
/**
 * On affiche la page
 */
$title = $author['name'];
$heading = $author['name'];
include_once DOCUMENT_ROOT . '/partials/header.php';

/**
 * 1. On récupère le paramètre d'url id
 */
// on déclare la variable qui va récevoir l'id et on l'initialise avec rien.
$author_id = null;

// on vérifie l'existance d'un paramètre id, non null, de type numérique
if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    // on nettoie le paramètre pour se protéger contre les injections de code.
    $author_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
}

// s'il n'existe pas de paramètre, on affiche le message d'erreur

if (!$author_id) {
    die("Vous devez définir un paramètre id valide dans l'url");
}

/**
 * 2. On récupère l'auteur.
 */

// on utilise la méthode prepare car notre requête a pas besoin d'un paramètre envoyé par l'utilisateur.

$stmt = $pdo->prepare('SELECT * FROM `authors` WHERE `id` = ?');

// on exécute la requête en précisant la valeur du paramètre

$stmt->execute([$author_id]);

//  on extrait les données de la réponse réçue.

$author = $stmt->fetch();

/**
 * 2. On récupère les livres de l'auteur.
 */

// on utilise la méthode prepare car notre requête a pas besoin d'un paramètre envoyé par l'utilisateur.

$stmt = $pdo->prepare('SELECT * FROM `books` WHERE `books`.`author_id` = ?');

// on exécute la requête en précisant la valeur du paramètre

$stmt->execute([$author['id']]);

//  on extrait les données de la réponse réçue.

$books = $stmt->fetchAll();


?>

<section>
    <p>
        <?= $author['biography'] ?>
    </p>
    <h2>Ouvrages publiés </h2>
    <ul>
        <?php foreach ($books as $book): ?>
            <li><a href="book.php?id=<?= $book['id'] ?>">
                    <?= $book['title'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php include_once DOCUMENT_ROOT . '/partials/footer.php'; ?>
</body>

</html>