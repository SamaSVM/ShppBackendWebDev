<?php
require_once '../config.php';

/**
 * A function that connects to a database.
 *
 * @return object of connection to the database.
 */
function connect_db()
{
    $link = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()){
        print("Error " . mysqli_connect_error());
        exit();
    }
    return $link;
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

/**
 * A function that creates a table if it does not exist in the database.
 *
 * @param $link connection to the database.
 */
function create_table($link)
{
    $sql = "CREATE TABLE IF NOT EXISTS `" . TABLE_NAME . "` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
        `text` VARCHAR(255) NOT NULL, 
        `checked` TINYINT(1) NOT NULL DEFAULT '0',
        UNIQUE KEY (`id`)
    )";
    mysqli_query($link, $sql);
}
