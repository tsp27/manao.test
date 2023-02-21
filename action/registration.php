<?php
    $_POST = json_decode(file_get_contents("php://input"), true);

    // to avoid direct file access if not ajax
    if (!$_POST['reg']) {
        exit('Access is denied');
    }
    
    require_once '../include/option.php';
    require_once '../class/User.php';
    require_once '../class/Register.php';
    
    $login = addslashes($_POST['login']);
    $pass = addslashes($_POST['pass']);
    $confirm_pass = addslashes($_POST['confirmPass']);
    $email = addslashes($_POST['email']);
    $name = addslashes($_POST['name']);

    $new_user = [
        'login' => $login,
        'pass' => md5($pass . 'SomethingSalt'), // static salt, if need dynamic we can store it in db
        'email' => $email,
        'name' => $name,
    ];
    
    $status = 'error';
    $postErrors = [];
    
    // check post data from form
    $reg = new Register($_POST);
    $reg->checkLogin();
    $reg->checkPass();
    $reg->checkConfirmPass();
    $reg->checkEmail();
    $reg->checkName();
    $postErrors = $reg->errors;

    // create new user if not exists
    if (!$postErrors) {
        $user = new User($db);
        $user->create($new_user);
        $userErrors = $user->errors;

        if (!$userErrors) {
            $status = 'success';
            $_SESSION['reg'] = $status;
        }   
    }
    
    $errors = ($postErrors) ? $postErrors : $userErrors; // errors if post data not correct or user exists (login or email)
    echo(json_encode(['status' => $status, 'errors' => $errors]));
    