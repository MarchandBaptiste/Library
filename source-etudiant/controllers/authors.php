<?php

/**
 * Page d'un auteur et de ses livres
 */
function author_ctrl(): void
{
    $author_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$author_id || $author_id < 1) {
        http_response_code(400);
        die("Vous devez définir un paramètre id valide dans l'url");
    }

    $author = getAuthor($author_id);

    if (!$author) {
        http_response_code(404);
        die('Aucun auteur trouvé avec cet id.');
    }

    $books = getBooksAuthor($author_id);

    $title = $author['name'];
    $heading = $author['name'];

    require DOCUMENT_ROOT . '/templates/authors/author.php';
}
