<?php
require_once 'headers.php';
require_once '../config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputData = get_input_data();
    $text = $inputData["text"];

    $link = connect_db();

    $sql = "INSERT INTO `" . TABLE_NAME . "` (text, checked) VALUES ('$text', '0')";
    mysqli_query($link, $sql);


    $sql = "SELECT MAX(`id`) FROM ". TABLE_NAME;
    $id =  mysqli_query($link, $sql);

    echo json_encode(array("id" => $id));
}
