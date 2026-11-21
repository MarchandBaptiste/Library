<?php

/**
 * CE FICHIER DOIT AFFICHER UN LIVRE. 
 */

/**
 * On doit d'abord vérifier qu'il existe un paramètre id, sinon on affiche un message d'erreur.
 * 
 * Si le paramètre est trouvé, on va se connecter à la base de données et chercher le livre enregistrer avec cet id.
 * Si aucun livre n'est trouvé, on affiche une erreur 404
 * Sinon, on affiche le livre.
 */

// Appelle des constantes et connexion a la BDD
require_once __DIR__ . '/config/constants.php';
require_once DOCUMENT_ROOT . '/helpers/db_connect.php';
$pdo = db();

/**
 * 1. On récupère le paramètre d'url id
 */

// on déclare la variable qui va récevoir l'id et on l'initialise avec rien.
$book_id = null;

// on vérifie l'existance d'un paramètre id, non null, de type numérique
if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    // on nettoie le paramètre pour se protéger contre les injections de code.
    $book_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
}

// s'il n'existe pas de paramètre, on affiche le message d'erreur
if (!$book_id) {
    die("Vous devez définir un paramètre id valide dans l'url");
}

/**
 * 2. On récupère le livre.
 */

// on utilise la méthode prepare car notre requête a pas besoin d'un paramètre envoyé par l'utilisateur.
$stmt = $pdo->prepare(SQL_GET_BOOK);

// on exécute la requête en précisant la valeur du paramètre
$stmt->execute([$book_id]);

//  on extrait les données de la réponse réçue.
$book = $stmt->fetch();

if (!$book) {
    http_response_code(404);
    die("Aucun livre trouvé avec cet id.");
}

/**
 * On affiche la page
 */
$title = $book['title'];
$heading = $book['title'];
include_once DOCUMENT_ROOT . '/partials/header.php';

?>

<section>
    <h2><?= $book['subtitle'] ?></h2>
    <h3><a href="author.php?id=<?= $book['author_id'] ?>"><i><?= $book['name'] ?></i></a></h3>
    <p><?= $book['description'] ?></p>
    <p>Édition <?= $book['publisher'] ?> | date <?= $book['published'] ?> | p. <?= $book['pages'] ?></p>
    <a href="<?= $book['website'] ?>">site internet</a>
</section>
<?php include_once DOCUMENT_ROOT . '/partials/footer.php'; ?>
</body>

</html>