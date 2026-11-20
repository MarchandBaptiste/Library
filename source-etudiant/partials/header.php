<?php
require_once DOCUMENT_ROOT . '/helpers/db_connect.php';
$pdo = db();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./assets/style/css/style.css">
    <script src="./assets/js/script.js" defer></script>
    <script defer src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="./assets/img/open-book.svg" />
</head>

<body>
    <header class="header">
        <div class="header__container">
            <a href="index.php"><img src="./assets/img/open-book.svg" alt="logo livre"></a>
            <h1><?= $heading ?></h1>
        </div>
    </header>
    <main>