<?php
require_once 'headers.php';

$inputData = get_input_data();

$id = $inputData["id"];
$text = $inputData["text"];
$checked = $inputData["checked"];

$items = get_items_data();
$items = $items["items"];

for ($i = 0; $i < count($items); $i++) {
    if ($items[$i]["id"] == $id) {
        $items[$i]["text"] = $text;
        $items[$i]["checked"] = $checked;
        break;
    }
}

$itemToWrite = json_encode(array("items" => $items));
file_put_contents('items.json', $itemToWrite);

echo json_encode(array("ok" => true));
