<?php 
    session_start(); // htaccess global in htaccess error on server
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
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <header class="header">
        <menu class="header__menu">
            <ul>
                <li><a href="index.php">Home</a></li>
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

    <?php if (!isAuth()) : ?>
    <form class="reg-form" action="" method="POST">
        <div>
            <input class="reg-form__login" type="text" name="login" required placeholder="Login*" minlength="6">
            <p class="reg-form__error reg-form__error_hidden"></p>
        </div>
        <div>
            <input class="reg-form__pass" type="password" name="pass" required placeholder="Password*" minlength="6">
            <p class="reg-form__error reg-form__error_hidden"></p>
        </div>
        <div>
            <input class="reg-form__confirm-pass" type="password" name="confirm-pass" required placeholder="Confirm password*" minlength="6" disabled>
            <p class="reg-form__error reg-form__error_hidden"></p>
        </div>
        <div>
            <input class="reg-form__email" type="text" name="email" required placeholder="Email*" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$">
            <p class="reg-form__error reg-form__error_hidden"></p>
        </div>
        <div>
            <input class="reg-form__name"type="text" name="name" required placeholder="Name*" minlength="2" pattern="[A-Za-zА-Яа-яЁё]{2,}">
            <p class="reg-form__error reg-form__error_hidden"></p>
        </div>
        <div>
            <input class="reg-form__button" type="button" name="reg" value="Registration">
        </div>
    </form>
    <?php endif; ?>

    <?php if ($_SESSION['reg']) : ?>
        <div class="reg-success">
            Registration successful. Now you can <a href="auth.php">Login</a>
        </div>
    <?php endif; unset($_SESSION['reg']); ?>

    <?php if (isAuth()) : ?>
    <h1 style="text-align:center; margin-top:150px;">Hello <?php echo $_COOKIE['login']; ?></h1>
    <?php endif; ?>
    <h2 style="text-align:center; margin-top:50px;">Registration page</h2>

    <script src="js/script.js"></script>
</body>
</html>
