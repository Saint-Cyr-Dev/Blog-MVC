<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+zr/4wlQqE3Y+oPTZ2jRn0qmxqQC2JssxFxOrjB" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        // Connexion à la base de données et récupération de l'article sélectionné
        $pdo = new PDO('mysql:host=localhost;dbname=blogdb', 'root', '1234');
        $articleId = $_GET['id'];


        // Requête pour récupérer l'article depuis la base de données en fonction de l'ID
        $query = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $query->execute([$articleId]);
        $article = $query->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'article existe
        if ($article) {
        ?>
            <h1><?= $article['titles']; ?></h1>
            <p><?= $article['content']; ?></p>
            <p>Date de création : <?= $article['created_at']; ?></p>
        <?php
        } else {
            echo "<p>L'article demandé n'existe pas.</p>";
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

</html>
