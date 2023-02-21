<?php 
    //session_start(); // htaccess global
    //echo $_SESSION['auth']; // test
    //echo $_COOKIE['login']; // test
    require_once 'include/function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header class="header">
        <menu class="header__menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="reg.php">Registration</a></li>
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

    <?php if (!isAuth()) : ?>
    <form class="auth-form" method="POST">
        <div>
            <input class="auth-form__name" type="text" name="login" placeholder="Login*" minlength="6" required>
            <p class="auth-form__error auth-form__error_hidden">User doesn't exist</p>
        </div>
        <div>
            <input class="auth-form__pass" type="password" name="pass" placeholder="Password*" minlength="6" required>
            <p class="auth-form__error auth-form__error_hidden"></p>
        </div>
        <div>
            <input class="auth-form__button" type="button" name="button" value="Send"><!-- Send with js -->
        </div>
    </form>
    <?php endif; ?>

    <?php if (isAuth()) : ?>
    <h1 style="text-align:center; margin-top:150px;">Hello <?php echo $_COOKIE['login']; ?></h1>
    <?php endif; ?>
    <h2 style="text-align:center; margin-top:50px;">Login page</h2>  

    <script src="js/script.js"></script>
</body>
</html>