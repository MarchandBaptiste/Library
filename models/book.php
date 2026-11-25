<?php

declare(strict_types=1);

class Book
{
    public function __construct(
        public private(set) ?int $id = null,
        public private(set) ?string $title = null,
        public private(set) ?string $subtitle = null,
        public private(set) ?int $author_id = null,
        public private(set) ?string $published = null,
        public private(set) ?string $publisher = null,
        public private(set) ?int $pages = null,
        public private(set) ?string $description = null,
        public private(set) ?string $website = null,
        public private(set) ?string $name = null
    ) {}
    /**
     * On récupère la liste des livres avec le nom de leur auteur
     */
    public function getListBooks(): array
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
     * @param int $id L'identifiant du livre
     */
    public function getBook(int $id): array|false
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
     * @param int $id L'identifiant du livre
     */
    public function deleteBook(int $id): bool
    {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM `books` WHERE `id` = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
