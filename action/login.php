<?php
$_POST = json_decode(file_get_contents("php://input"), true);

// to avoid direct file access if not ajax
if (!$_POST['button']) {
    exit('Access is denied');
}

require_once '../include/option.php';
require_once '../class/Login.php';

$status = 'error';
$errors = [];

$current_login = addslashes($_POST['login']);

$login = new Login($_POST);
$login->checkLogin();
$errors = $login->errors;

if (!$errors['login']) {
    $login->checkPass();
    $errors = $login->errors;

    if (!$errors['pass']) {
        $status = 1;
        $_SESSION['auth'] = 1;
        setcookie('login', $current_login, strtotime("+14 days"), '/');
    }
}

echo(json_encode(['status' => $status, 'errors' => $errors]));
