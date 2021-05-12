<?php
require_once 'headers.php';
require_once 'functions.php';
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] != 'OPTIONS') {
    session_start();

    $inputData = get_input_data();
    $login = $inputData['login'];
    $pass = $inputData['pass'];

    $link = connect_db();

    $userId = check_login_and_password($link, $login, $pass);

        $sessionId = session_id();
        setcookie('sessionID', $sessionId.':'.$userId, time() + COOKIE_TIME);
        echo json_encode(array('ok' => true));
}