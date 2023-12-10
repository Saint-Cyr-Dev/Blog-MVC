<?php

//Db con
require 'conDB.php';

$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

$pdo->exec("DROP TABLE posts_comments");
$pdo->exec("TRUNCATE TABLE posts_categories");
$pdo->exec("TRUNCATE TABLE users_posts");
$pdo->exec("TRUNCATE TABLE users");
$pdo->exec("TRUNCATE TABLE posts");
$pdo->exec("TRUNCATE TABLE comments");
$pdo->exec("TRUNCATE TABLE categories");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
echo 'Database TABLES deleted successfuly! ';

echo 'Database TABLES were clean successfuly! ';


?>