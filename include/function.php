<?php
    session_start();

    function isAuth() {
        if ($_SESSION['auth'] || $_COOKIE['login'])
            return true;
        
        return false;
    }