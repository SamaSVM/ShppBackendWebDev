<?php
require_once 'headers.php';
require_once '../config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputData = get_input_data();
    $text = $inputData["text"];

    $id = file_get_contents('lastId.txt');
    $checked = false;

    $items = get_items_data();
    $items = $items["items"];

    $items[] = array(
        "id" => $id,
        "text" => $text,
        "checked" => $checked
    );

    $itemToWrite = json_encode(array("items" => $items));
    file_put_contents('items.json', $itemToWrite);

    echo json_encode(array("id" => $id));
    file_put_contents('lastId.txt', ++$id);
}
