<?php
require_once 'headers.php';

$inputData = get_input_data();
$id = $inputData["id"];

$items = get_items_data();
$items = $items["items"];

for ($i = 0; $i < count($items); $i++) {
    if ($items[$i]["id"] == $id) {
        array_splice($items, $i, 1);
        break;
    }
}

$itemToWrite = json_encode(array("items" => $items));
file_put_contents('items.json', $itemToWrite);

echo json_encode(array("ok" => true));
