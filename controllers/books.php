<?php

/**
 * Page d'accueil liste de tous les livres
 */
function list_ctrl(): void
{
    $booksModel = new Book();
    $books = $booksModel->getListBooks();
    $title = 'Catalogue';
    $heading = 'Catalogue des livres';
    renderViews("books/home", compact('title', 'books', 'heading'));
}

/**
 * Page d'un livre
 */
function book_ctrl(): void
{
    $book_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$book_id || $book_id < 1) {
        http_response_code(400);
        die("Vous devez définir un paramètre id valide dans l'url");
    }
    $booksModel = new Book();
    $book = $booksModel->getBook($book_id);
    if (!$book) {
        http_response_code(404);
        die('Aucun livre trouvé avec cet id.');
    }
    $title = $book->title;
    $heading = $book->title;
    renderViews("books/book", compact('title', 'book_id', 'heading', 'book'));
}

/**
 * Suppression d'un livre
 */
function delete_ctrl(): void
{
    $booksModel = new Book();
    $book_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$book_id || $book_id < 1) {
        http_response_code(400);
        die('Vous devez renseigner un id valide.');
    }
    if (!$booksModel->deleteBook($book_id)) {
        http_response_code(404);
        die('Aucun livre trouvé avec cet id.');
    }
    header('Location: index.php');
    exit;
}
