<?php
    $_POST = json_decode(file_get_contents("php://input"), true);

    // to avoid direct file access if not ajax
    if (!$_POST['logout']) {
        exit('Access is denied');
    }

    setcookie('login', null, -1, '/');
    unset($_SESSION['auth']);
     
    echo(json_encode(['status'=>1]));