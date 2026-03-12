<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$bill_id = isset($_POST['bill_id']) ? (int) $_POST['bill_id'] : 0;

if ($bill_id <= 0) {
    header('Location: bills.php');
    exit;
}

// Проверка: счёт существует, принадлежит пользователю, статус "Ожидает оплаты"
$stmt = mysqli_prepare($conn, "SELECT id FROM bills WHERE id = ? AND user_id = ? AND status = 'Ожидает оплаты'");
mysqli_stmt_bind_param($stmt, 'ii', $bill_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bill = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$bill) {
    header('Location: bills.php');
    exit;
}

// Обновление статуса на "Оплачен"
$stmt = mysqli_prepare($conn, "UPDATE bills SET status = 'Оплачен' WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $bill_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header('Location: bills.php?paid=1');
exit;
