<?php
require_once 'headers.php';
require_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $inputData = get_input_data();
    $login = $inputData['login'];
    $pass = $inputData['pass'];

    $link = connect_db();

    create_table_users($link);

    if(check_login($link, $login)){
        echo json_encode(array('ok' => false));
        die('A user with such a login is already registered!');
    }

    $sql = "INSERT INTO `users` (`login`, `pass`) VALUES ('$login', '" . md5($pass) . "')";
    $link->query($sql);

    echo json_encode(array('ok' => true));
}
