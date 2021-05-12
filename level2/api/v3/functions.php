<?php
require_once '../config.php';

/**
 * A function that connects to a database using a PDO
 *
 * @return PDO object with database connection.
 */
function connect_db()
{
    try {
        $dsn = "mysql:host=" . HOSTNAME . ";dbname=" . DATABASE . ";charset=" . CHARSET;
        $link = new PDO ($dsn, USERNAME, PASSWORD);
        return $link;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array('error' => $e->getMessage()));
    }
}

/**
 * A function that retrieves all data from a table, forms an array from it, and returns it.
 *
 * @param $link PDO object with database connection.
 * @return array with all table data.
 */
function get_table_data($link)
{
    $tableData = $link->query('SELECT * from ' . TABLE_NAME);

    $items = $tableData->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($items); $i++) {
        $items[$i]['checked'] = boolval($items[$i]['checked']);
    }
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

/**
 * A function that creates a table if it does not exist in the database.
 *
 * @param $link PDO connection to the database.
 */
function create_table_items($link)
{
    $sql = "CREATE TABLE IF NOT EXISTS `" . TABLE_NAME . "` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
        `text` VARCHAR(255) NOT NULL, 
        `checked` TINYINT(1) NOT NULL DEFAULT '0',
        UNIQUE KEY (`id`)
    )";
    $link->query($sql);
}

/**
 * @param $link
 */
function create_table_users($link)
{
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
        `login` VARCHAR(255) NOT NULL, 
        `pass` VARCHAR(255) NOT NULL,
        UNIQUE KEY (`id`)
    )";
    $link->query($sql);
}

/**
 * @param $link
 * @param $login
 * @param $pass
 * @return false|mixed
 */
function check_login_and_password($link, $login, $pass)
{
    $tableData = $link->query('SELECT * from `users`');

    $users = $tableData->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($users); $i++) {
        if ($users[$i]['login'] == $login && $users[$i]['pass'] == md5($pass)) {
            return $users[$i]['id'];
        }
    }
    return false;
}

function check_login($link, $login)
{
    $tableData = $link->query('SELECT * from `users`');

    $users = $tableData->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($users); $i++) {
        if ($users[$i]['login'] == $login) {
            return true;
        }
    }
    return false;
}
