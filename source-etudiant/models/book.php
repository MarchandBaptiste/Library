<?php

/**
 * On récupère la liste des livres avec le nom de leur auteur
 */
function getListBooks(): array
{
    global $pdo;
    $stmt = $pdo->query(
        'SELECT `books`.*, `authors`.`name`
         FROM `books`
         INNER JOIN `authors` ON `books`.`author_id` = `authors`.`id`
         ORDER BY `books`.`title` ASC'
    );
    return $stmt->fetchAll();
}

/**
 * On récupère un livre par son id avec le nom de son auteur
 */
function getBook(int $id): array|false
{
    global $pdo;
    $stmt = $pdo->prepare(
        'SELECT `books`.*, `authors`.`name`
         FROM `books`
         INNER JOIN `authors` ON `books`.`author_id` = `authors`.`id`
         WHERE `books`.`id` = ?'
    );
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * On supprime un livre et on indique si une ligne a bien été supprimée
 */
function deleteBook(int $id): bool
{
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM `books` WHERE `id` = ?');
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}
