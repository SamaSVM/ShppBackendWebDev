<?php
require_once '../config.php';

/**
 * A function that reads data from a file and returns it.
 *
 * @return array data.
 */
function get_items_data()
{
    $itemsData = file_get_contents('items.json');
    $items = json_decode($itemsData, true);
    return $items;
}


/**
 * A function that takes input, forms an array, and returns it.
 *
 * @return array with input data.
 */
function get_input_data()
{
    $inputData = file_get_contents('php://input');
    $inputData = json_decode($inputData, true);
    return $inputData;
}
