<?php
require_once 'headers.php';
require_once '../config.php';
require_once 'functions.php';

$link = connect_db();

create_table_items($link);

$resultSet = mysqli_query($link, "SELECT * from `" . TABLE_NAME . "`");
$json_result = [];

while ($row = mysqli_fetch_assoc($resultSet)){
    $json_result['items'][] = ['id' => $row['id'], 'text' => $row['text'], 'checked' => boolval($row['checked'])];
}

echo json_encode($json_result);
