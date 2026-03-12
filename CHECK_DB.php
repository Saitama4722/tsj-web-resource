<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "tsj_user";
$password = "123456";
$database = "tsj_system";

$conn = @mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    echo "Ошибка подключения к базе данных: " . mysqli_connect_error();
    exit;
}

mysqli_set_charset($conn, "utf8mb4");
echo "Database connection OK";
