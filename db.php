<?php
/**
 * Подключение к базе данных MySQL (учебный проект "ТСЖ Онлайн")
 * Диагностика: при ошибке подключения выводится сообщение.
 */
$host = "localhost";
$user = "tsj_user";
$password = "123456";
$database = "tsj_system";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
