<?php
require_once '../config.php';
header('Access-Control-Allow-Origin:' . FRONTEND_HOSTNAME);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');