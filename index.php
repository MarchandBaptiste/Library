<?php

// Configuration
require_once __DIR__ . '/config/constants.php';

// Connexion à la base de données
require_once DOCUMENT_ROOT . '/helpers/db_connect.php';
$pdo = db();

// Modèles
require_once DOCUMENT_ROOT . '/models/book.php';
require_once DOCUMENT_ROOT . '/models/author.php';

// Utils
require_once DOCUMENT_ROOT . "/utils/viewsUtils.php";

// Contrôleurs
require_once DOCUMENT_ROOT . '/controllers/books.php';
require_once DOCUMENT_ROOT . '/controllers/authors.php';

// Paramètre de routage
$page = $_GET['page'] ?? '';

// Routeur
match ($page) {
    '', 'home' => list_ctrl(),
    'book' => book_ctrl(),
    'author' => author_ctrl(),
    'delete' => delete_ctrl(),
    default => list_ctrl(),
};
