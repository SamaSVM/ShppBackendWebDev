<?php
require_once 'headers.php';
require_once '../config.php';
require_once 'functions.php';

$link = connect_db();
create_table_items($link);
$items = get_table_data($link);

echo json_encode(array('items' => $items));
