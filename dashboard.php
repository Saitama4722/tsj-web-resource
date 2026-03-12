<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];

// Данные текущего пользователя
$stmt_user = mysqli_prepare($conn, "SELECT id, name, email FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt_user, 'i', $user_id);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);
$user = mysqli_fetch_assoc($result_user);
mysqli_stmt_close($stmt_user);

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Количество заявок
$stmt_req = mysqli_prepare($conn, "SELECT COUNT(*) AS total_requests FROM requests WHERE user_id = ?");
mysqli_stmt_bind_param($stmt_req, 'i', $user_id);
mysqli_stmt_execute($stmt_req);
$result_req = mysqli_stmt_get_result($stmt_req);
$row_req = mysqli_fetch_assoc($result_req);
$total_requests = (int) $row_req['total_requests'];
mysqli_stmt_close($stmt_req);

// Количество счетов
$stmt_bills = mysqli_prepare($conn, "SELECT COUNT(*) AS total_bills FROM bills WHERE user_id = ?");
mysqli_stmt_bind_param($stmt_bills, 'i', $user_id);
mysqli_stmt_execute($stmt_bills);
$result_bills = mysqli_stmt_get_result($stmt_bills);
$row_bills = mysqli_fetch_assoc($result_bills);
$total_bills = (int) $row_bills['total_bills'];
mysqli_stmt_close($stmt_bills);

// Количество неоплаченных счетов
$stmt_unpaid = mysqli_prepare($conn, "SELECT COUNT(*) AS unpaid_bills FROM bills WHERE user_id = ? AND status = 'Ожидает оплаты'");
mysqli_stmt_bind_param($stmt_unpaid, 'i', $user_id);
mysqli_stmt_execute($stmt_unpaid);
$result_unpaid = mysqli_stmt_get_result($stmt_unpaid);
$row_unpaid = mysqli_fetch_assoc($result_unpaid);
$unpaid_bills = (int) $row_unpaid['unpaid_bills'];
mysqli_stmt_close($stmt_unpaid);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет — ТСЖ Онлайн</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">ТСЖ Онлайн</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Меню">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Личный кабинет</a></li>
                    <li class="nav-item"><a class="nav-link" href="requests.php">Заявки</a></li>
                    <li class="nav-item"><a class="nav-link" href="bills.php">Счета</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Личный кабинет</h1>
        <p class="lead">Здравствуйте, <?= htmlspecialchars($user['name']) ?>!</p>
        <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Мои заявки</h5>
                        <p class="card-text display-6 text-primary"><?= $total_requests ?></p>
                        <a href="requests.php" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Мои счета</h5>
                        <p class="card-text display-6 text-primary"><?= $total_bills ?></p>
                        <a href="bills.php" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Неоплаченные счета</h5>
                        <p class="card-text display-6 text-primary"><?= $unpaid_bills ?></p>
                        <a href="bills.php" class="btn btn-primary">Оплатить</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Быстрые действия</div>
            <div class="card-body">
                <a href="requests.php" class="btn btn-outline-primary me-2">Подать заявку</a>
                <a href="bills.php" class="btn btn-outline-primary me-2">Просмотреть счета</a>
                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <a href="admin.php" class="btn btn-outline-secondary">Панель администратора</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
