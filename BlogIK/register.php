<?php
    session_start();
    include('auth.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $auth = Auth::getAuthInstance();
        $auth->signUp($_POST['name'], $_POST['email'], $_POST['password']);
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

    <?php include('header.php') ?>

    <div class="va-l-container">
        <main class="va-l-page-content">
            <div class="profile">
                <header class="va-l-page-header">
                    <h1>Register</h1>
                </header>

                <form method="post">

                    <div class="va-c-form va-c-new-post">
                            <div class="va-c-form-group">
                            <label class="va-c-control-label">Name</label>
                            <input type="text" name="name" class="va-c-form-control" id="name"></input>
                        </div>

                        <div class="va-c-form-group">
                            <label class="va-c-control-label">Email</label>
                            <input type="email" name="email" class="va-c-form-control" id="email"></input>
                        </div>

                        <div class="va-c-form-group">
                            <label class="va-c-control-label">Password</label>
                            <input type="password" name="password" class="va-c-form-control" id="password"></input>
                        </div>

                        <div class="va-c-form-group">
                            <input type="submit" class="va-c-btn va-c-btn--primary" value="Sign up">
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
    
    <?php include('footer.php'); ?>

</body>
</html>