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
<body class="va-l-page va-l-page--single">

<?php include('header.php'); ?>

    <div class="va-l-container">
        <main class="va-l-page-content">


            <?php

                if (isset($_GET['post_id'])) {

                    $postId = $_GET['post_id'];

                    // pripremamo upit
                    $sql = "SELECT posts.id, posts.title, posts.created_at, posts.content, profiles.name, posts.created_by FROM posts 
                    INNER JOIN users ON users.id = posts.created_by 
                    INNER JOIN profiles ON profiles.user_id = users.id
                    WHERE posts.id = {$postId}";
                    $statement = $connection->prepare($sql);

                    // izvrsavamo upit
                    $statement->execute();

                    // zelimo da se rezultat vrati kao asocijativni niz.
                    // ukoliko izostavimo ovu liniju, vratice nam se obican, numerisan niz
                    $statement->setFetchMode(PDO::FETCH_ASSOC);

                    // punimo promenjivu sa rezultatom upita
                    $singlePost = $statement->fetch();

                    // koristite var_dump kada god treba da proverite sadrzaj neke promenjive
                               // echo '<pre>';
                               // var_dump($singlePost);
                               // echo '</pre>';
                    

                    $sql = "SELECT comments.id, comments.content, comments.created_at, comments.author, profiles.name
                                     FROM comments 
                    INNER JOIN users ON users.id = comments.author 
                    INNER JOIN profiles ON  profiles.user_id = users.id
                    ORDER BY created_at DESC LIMIT 3";
                    $statement = $connection->prepare($sql);

                    // izvrsavamo upit
                    $statement->execute();

                    // zelimo da se rezultat vrati kao asocijativni niz.
                    // ukoliko izostavimo ovu liniju, vratice nam se obican, numerisan niz
                    $statement->setFetchMode(PDO::FETCH_ASSOC);

                    // punimo promenjivu sa rezultatom upita
                    $comments = $statement->fetchAll();

                    // echo '<pre>';
                    // var_dump($comments);
                    //  echo '</pre>';



                            $sqlTags = "SELECT comments.id, comments.content, comments.created_at, comments.author, profiles.name FROM comments 
                    INNER JOIN users ON users.id = comments.author 
                    INNER JOIN profiles ON  profiles.user_id = users.id
                    ORDER BY created_at DESC LIMIT 3";
                    $statement = $connection->prepare($sqlTags);

                    // izvrsavamo upit
                    $statement->execute();

                    // zelimo da se rezultat vrati kao asocijativni niz.
                    // ukoliko izostavimo ovu liniju, vratice nam se obican, numerisan niz
                    $statement->setFetchMode(PDO::FETCH_ASSOC);

                    // punimo promenjivu sa rezultatom upita
                    $tags = $statement->fetchAll();

                    // echo '<pre>';
                    // var_dump($comments);
                    //  echo '</pre>';


            ?>


            <article class="va-c-article">

                <header>
                    <h1><a href="single-post.php?post_id=<?php echo($singlePost['id']) ?>"><?php 
                    echo($singlePost['title']) ?></a></h1>
                        <div class="va-c-article__meta"><?php echo($singlePost['created_at']) ?> by 
                            <?php echo($singlePost['name']) ?></div>
                </header>
              
            </article>

                <div>
                    <p> <?php echo ($singlePost['content']) ?></p>
                </div>
                <br>
                <footer>
                    <div class="va-c-form-group">
                    <label class="va-c-control-label">Post new comment</label>
                    <textarea rows="10" class="va-c-form-control"></textarea>
                </div>

                <div class="va-c-form-group">
                    <button class="va-c-btn va-c-btn--primary">Send</button>
                </div> 
                </footer>
                <br>

                <div class="comments">
                    <h3>comments</h3>

                    <?php foreach ($comments as $comment) { ?>
                    <div class="single-comment">
                        <div>posted by: <strong><?php echo($comment['name']) ?></strong> 
                        <?php echo($comment['created_at']) ?></div>
                        <div><?php echo($comment['content']) ?></div>
                    </div>
                    
                     <?php } ?>

                </div>
            
            

                <?php

                    } else {
                        echo('post_id parameter was not sent through $_GET.');
                    }
                ?>

            </article>
        </main>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>