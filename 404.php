<?php
session_start();
require_once 'db.php';

$is_logged_in = isset($_SESSION['user_id']);
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Страница не найдена — ТСЖ Онлайн</title>
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
                    <?php if ($is_logged_in): ?>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Личный кабинет</a></li>
                        <li class="nav-item"><a class="nav-link" href="requests.php">Заявки</a></li>
                        <li class="nav-item"><a class="nav-link" href="bills.php">Счета</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-fill">
        <div class="container py-5">
            <div class="text-center py-5">
                <h1 class="display-1 fw-bold text-primary">404</h1>
                <h2 class="h3 text-muted mb-3">Страница не найдена</h2>
                <p class="text-muted mb-4">Запрашиваемая страница не существует или была перемещена.</p>
                <a href="index.php" class="btn btn-primary">Вернуться на главную</a>
            </div>
        </div>
    </main>

    <?php require_once 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
