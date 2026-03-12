<?php
/**
 * Подключение к базе данных MySQL (учебный проект "ТСЖ Онлайн")
 */
$host = "localhost";
$user = "root";
$password = "";
$database = "tsj_system";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
