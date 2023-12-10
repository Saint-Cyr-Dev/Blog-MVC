<?php
//Db Connection
require 'conDB.php';
//create user table
$pdo->exec("CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username VARCHAR(225) NOT NULL,
    password CHAR(225) NOT NULL,
    slug VARCHAR(225) NOT NULL,
    ft_image VARCHAR(225) NOT NULL,
    content TEXT NOT NULL,
    email VARCHAR(225) NOT NULL,
    phone VARCHAR(225) NOT NULL,
    role ENUM('Author', 'Admin', 'Subscriber') NULL DEFAULT 'Subscriber',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'Tables : USERS, ';


//create posts table
$pdo->exec("CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_id int DEFAULT NULL,
    titles VARCHAR(225) NOT NULL,
    slug VARCHAR(225) NOT NULL,
    ft_image VARCHAR(225) NOT NULL,
    content text NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published TINYINT  NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'Tables : POSTS, ';

//create comments table
$pdo->exec("CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    email VARCHAR(225) NOT NULL,    
    pseudo VARCHAR(225) NOT NULL,
    title VARCHAR(225) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published TINYINT NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'Tables : comments, ';


//create categories table
$pdo->exec("CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(225) NOT NULL,
    slug VARCHAR(225) NOT NULL,
    ft_image VARCHAR(225) NOT NULL,
    content text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'Tables : CATEGORIES, ';

//create post comment table
$pdo->exec("CREATE TABLE posts_comments (
    post_id INT NOT NULL,
    comment_id INT NOT NULL,
    PRIMARY KEY (post_id, comment_id),
    CONSTRAINT fk_post
        FOREIGN KEY (post_id)
        REFERENCES posts (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_comment
        FOREIGN KEY (comment_id)
        REFERENCES comments (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'POST_COMMENTS, ';

//create users_posts table
$pdo->exec("CREATE TABLE users_posts (
    users_id INT NOT NULL,
    posts_id INT NOT NULL,
    PRIMARY KEY (users_id, posts_id),
    CONSTRAINT fk_user
        FOREIGN KEY (users_id)
        REFERENCES users (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_posts
        FOREIGN KEY (posts_id)
        REFERENCES posts (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'USERS_POSTS, ';


//create POST CATEGOORIES table
$pdo->exec("CREATE TABLE posts_categories (
    posts_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (posts_id, category_id),
    CONSTRAINT fk_posts_categories
        FOREIGN KEY (posts_id)
        REFERENCES posts (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_categories_posts
        FOREIGN KEY (category_id)
        REFERENCES categories (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");


echo 'POSTS_CATEGORIES were created successfuly!';