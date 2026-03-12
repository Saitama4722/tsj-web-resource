<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора — ТСЖ Онлайн</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">ТСЖ Онлайн</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Меню">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin.php">Панель администратора</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_requests.php">Заявки</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_bills.php">Счета</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-fill">
    <div class="container py-4">
        <h1>Панель администратора</h1>
        <p class="lead text-muted">Управление заявками и счетами</p>

        <div class="row g-4 mt-2">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Управление заявками</h5>
                        <p class="card-text">Просмотр всех заявок пользователей и смена статуса.</p>
                        <a href="admin_requests.php" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Управление счетами</h5>
                        <p class="card-text">Просмотр счетов и добавление новых.</p>
                        <a href="admin_bills.php" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>

    <?php require_once 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
