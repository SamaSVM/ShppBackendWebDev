<?php
require_once 'headers.php';
require_once '../config.php';
require_once 'functions.php';

$inputData = get_input_data();
$id = $inputData["id"];
$text = $inputData["text"];
$checked = (int) $inputData["checked"];

$link = connect_db();

$sql = "UPDATE `" . TABLE_NAME . "` SET `text` = '$text', `checked` = '$checked' WHERE `" . TABLE_NAME . "`.`id` = $id";
mysqli_query($link, $sql);

echo json_encode(array("ok" => true));
