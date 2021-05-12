<?php
require_once 'headers.php';
require_once '../config.php';
require_once 'functions.php';

$inputData = get_input_data();
$id = $inputData["id"];

$link = connect_db();

$sql = "DELETE FROM `". TABLE_NAME ."` WHERE `". TABLE_NAME ."`.`id` = $id";
mysqli_query($link, $sql);

echo json_encode(array("ok" => true));
