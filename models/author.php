<?php

declare(strict_types=1);
class Author
{
    public function __construct(
        public private(set) ?int $id = null,
        public private(set) ?string $name = null,
        public private(set) ?string $biography = null
    ) {}

    /**
     * On récupère un auteur par son id
     * @param int $id L'identifiant du l'auteur
     */
    public function getAuthor(int $id): array|false
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM `authors` WHERE `id` = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * On récupère les livres d'un auteur
     * @param int $authorId L'identifiant de l'auteur
     */
    public function getBooksAuthor(int $authorId): array
    {
        global $pdo;
        $stmt = $pdo->prepare(
            'SELECT * FROM `books` WHERE `author_id` = ? ORDER BY `title` ASC'
        );
        $stmt->execute([$authorId]);
        return $stmt->fetchAll();
    }
    public function __call(string $method, array $args): string
    {
        return "la mathode $method n'existe pas";
    }
}
