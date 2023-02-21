<?php 
    //session_start(); // задано в htaccess глобально, поэтому так не надо уже
    //echo $_SESSION['auth']; // тест
    //echo $_COOKIE['login']; // тест
    require_once 'include/function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <header class="header">
        <menu class="header__menu">
            <ul>
                <li><a href="reg.php">Registration</a></li>
                <li><a href="auth.php">Login</a></li>
            </ul>
        </menu>
        <div class="header__info">
            <?php if (isAuth()) : ?>
            <div>Hello: <?php echo $_COOKIE['login']; ?></div>
            <a class="header__logout logout">Logout</a>
            <?php else : ?>
            <a class="header__login login" href="auth.php">Login</a>
            <?php endif; ?>
        </div>  
    </header>

    <?php if (isAuth()) : ?>
    <h1 style="text-align:center; margin-top:150px;">Hello <?php echo $_COOKIE['login']; ?></h1>
    <?php endif; ?>
    <h2 style="text-align:center; margin-top:50px;">Home page</h2>

    <script src="js/script.js"></script>
</body>
</html>