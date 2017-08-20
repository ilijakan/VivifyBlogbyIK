<?php

    $servername = "127.0.0.1";
    $username = "root";
    $password = "vivify";
    $dbname = "blogik";

    try {
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="favicon.ico">
    <title>Vivify Academy Blog - Homepage</title>

    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="va-l-page va-l-page--homepage">

    <?php include('header.php') ?>

    <div class="va-l-container">
        <main class="va-l-page-content">

            <?php

                // pripremamo upit
                $sql = "SELECT posts.id, posts.title, posts.created_at, posts.content, profiles.name, posts.created_by FROM posts 
                INNER JOIN users ON users.id = posts.created_by 
                INNER JOIN profiles ON profiles.user_id = users.id
                ORDER BY created_at DESC LIMIT 3";
                $statement = $connection->prepare($sql);

                // izvrsavamo upit
                $statement->execute();

                // zelimo da se rezultat vrati kao asocijativni niz.
                // ukoliko izostavimo ovu liniju, vratice nam se obican, numerisan niz
                $statement->setFetchMode(PDO::FETCH_ASSOC);

                // punimo promenjivu sa rezultatom upita
                $posts = $statement->fetchAll();

                // koristite var_dump kada god treba da proverite sadrzaj neke promenjive
                   // echo '<pre>';
                   // var_dump($posts);
                   // echo '</pre>';



            // iteriramo kroz niz post-ova
            foreach ($posts as $post) { ?>

                <article class="va-c-article">
                    <header>
                        <h1><a href="single-post.php?post_id=<?php echo($post['id']) ?>"><?php echo($post['title']) ?></a></h1>
                        <div class="va-c-article__meta"><?php echo($post['created_at']) ?> by 
                            <?php echo($post['name']) ?></div>
                    </header>

                    <div>
                        <p><?php echo($post['content']) ?></p>
                    </div>
                </article>

            <?php } ?>

           <div class="va-c-paginator">
                <a href="index.php" title="Older">Older</a>
                <a href="index.php" title="Newer">Newer</a>
            </div>
        </main>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>