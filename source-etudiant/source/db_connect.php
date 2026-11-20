<?php
function db()
{
    try {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $error) {
        var_dump($error);
        die;
    }
}
