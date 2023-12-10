<?php
require __DIR__ . '/../../vendor/autoload.php';
$faker = Faker\Factory::create('fr_FR');
require 'conDB.php';

$posts = [];
$categories = [];
$users = [];

// Nettoyer la base de données
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE TABLE posts_categories");
$pdo->exec("TRUNCATE TABLE posts_comments");
$pdo->exec("TRUNCATE TABLE users_posts");
$pdo->exec("TRUNCATE TABLE users");
$pdo->exec("TRUNCATE TABLE posts");
$pdo->exec("TRUNCATE TABLE categories");
$pdo->exec("TRUNCATE TABLE comments");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

echo 'Les tables de la base de données ont été nettoyées avec succès';

// CRÉATION DES UTILISATEURS
$hashpassword = null;
for ($i = 0; $i < 13; $i++) {
    $hashpassword = password_hash($faker->password, PASSWORD_BCRYPT);
    $pdo->exec("INSERT INTO users
                SET username='{$faker->userName}',
                    password='{$hashpassword}',
                    slug= '{$faker->slug}',
                    ft_image='image{$faker->numberBetween($min = 1, $max = 5)}.jpg',
                    content='{$faker->paragraphs(rand(3, 15), true)}',
                    email='{$faker->email}',
                    phone='{$faker->e164PhoneNumber}',
                    role ='Subscriber',
                    created_at = '{$faker->date} {$faker->time}'
                    ");
    $users[] = $pdo->lastInsertID();
}

echo 'Utilisateurs créés avec succès !';

// Création de l'administrateur
$hashpassword = password_hash('test', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO users
            SET username='juniorthd',
                password='{$hashpassword}',
                slug= 'junior-thd',
                ft_image='image{$faker->numberBetween($min = 1, $max = 5)}.jpg',
                content='{$faker->paragraphs(rand(3, 15), true)}',
                email='{$faker->email}',
                phone='{$faker->e164PhoneNumber}',
                role ='Admin',
                created_at = '{$faker->date} {$faker->time}'
                ");

echo 'ADMIN créé avec succès,';

// Création de messages
for ($i = 0; $i < 72; $i++) {
    $pdo->exec("INSERT INTO posts
                SET user_id='14',
                    titles ='{$faker->sentence(2)}',
                    slug= '{$faker->slug}',
                    ft_image='image{$faker->numberBetween($min = 1, $max = 5)}.jpg',
                    content='{$faker->paragraphs(rand(3, 15), true)}',
                    created_at = '{$faker->date} {$faker->time}',
                    published='1'
                    ");
    $posts[] = $pdo->lastInsertID();
}

echo 'POST créés avec succès,';

// Création de commentaires
for ($i = 0; $i < 144; $i++) {
    $pdo->exec("INSERT INTO comments
        SET pseudo='{$faker->userName}',
            email='{$faker->email}',
            title='{$faker->sentence}',
            content='{$faker->paragraphs(rand(3, 15), true)}',
            created_at = '{$faker->date} {$faker->time}',
            published='1'
            ");
    $users[] = $pdo->lastInsertID();
}

echo 'COMMENTAIRES créés avec succès, ';

// Création des catégories
for ($i = 0; $i < 144; $i++) {
    $pdo->exec("INSERT INTO categories
        SET title='{$faker->sentence(2)}',
            slug= '{$faker->slug}',
            content='{$faker->paragraphs(rand(3, 15), true)}',
            ft_image='image{$faker->numberBetween($min = 1, $max = 5)}.jpg'
            ");
    $categories[] = $pdo->lastInsertID();
}

echo 'CATEGORIES,';

// Lier les messages avec les catégories
foreach ($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(1, 1));
    foreach ($randomCategories as $category) {
        $pdo->exec("INSERT INTO posts_categories (posts_id, category_id) VALUES ($post, $category)");
    }
}


echo 'POST_CATEGORIES, ';

// Lier les messages avec les commentaires
foreach ($posts as $post) {
    $randomComments = $faker->randomElements($categories, rand(2, 2));
    foreach ($randomComments as $comment) {
        $pdo->exec("INSERT INTO posts_comments (post_id, comment_id) VALUES ('$post', '$comment')");
    }
}

echo 'POST_COMMENTS, ';

// Lier les messages avec l'utilisateur Admin
foreach ($posts as $post) {
    $pdo->exec("INSERT INTO users_posts SET users_id='14', posts_id=$post");
}

echo 'USERS_POST, ont été créés avec succès ! ';
?>
