<?php
require_once 'headers.php';
if ($_SERVER['REQUEST_METHOD'] != 'OPTIONS'){
require_once $_GET['action'] . ".php";
}