<?php

/**
 * Toutes les requêtes SQL de l'application sont centralisées ici.
 */

define('SQL_LIST_BOOKS', 'SELECT * FROM `books` INNER JOIN `authors` ON `books`.`author_id` = `authors`.`id` ORDER BY `books`.`title` ASC');
define('SQL_GET_BOOK', 'SELECT * FROM `books` INNER JOIN `authors` ON `books`.`author_id` = `authors`.`id` WHERE `books`.`id` = ?');
define('SQL_GET_AUTHOR', 'SELECT * FROM `authors` WHERE `id` = ?');
define('SQL_GET_AUTHOR_BOOKS', 'SELECT * FROM `books` WHERE `books`.`author_id` = ?');
define('SQL_CHECK_BOOK_EXISTS', 'SELECT id FROM `books` WHERE `id` = ?');
define('SQL_DELETE_BOOK', 'DELETE FROM `books` WHERE `id` = ?');
