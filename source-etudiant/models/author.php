<?php

/**
 * On récupère un auteur par son id
 */
function getAuthor(int $id): array|false
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM `authors` WHERE `id` = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * On récupère les livres d'un auteur
 */
function getBooksAuthor(int $authorId): array
{
    global $pdo;
    $stmt = $pdo->prepare(
        'SELECT * FROM `books` WHERE `author_id` = ? ORDER BY `title` ASC'
    );
    $stmt->execute([$authorId]);
    return $stmt->fetchAll();
}
