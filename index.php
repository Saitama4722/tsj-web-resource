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
    <title>ТСЖ Онлайн — Главная</title>
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Главная</a></li>
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

    <div class="container">
        <section class="py-5">
            <div class="text-center py-4 px-3 rounded-3 bg-light border">
                <?php if ($is_logged_in): ?>
                    <h1 class="display-5 fw-bold mb-3">Добро пожаловать, <?= htmlspecialchars($user_name) ?>!</h1>
                    <p class="lead text-muted mb-4">Вы можете перейти в личный кабинет, просмотреть счета и отправить заявку</p>
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center flex-wrap">
                        <a href="dashboard.php" class="btn btn-primary">Личный кабинет</a>
                        <a href="requests.php" class="btn btn-outline-primary">Мои заявки</a>
                        <?php if (!empty($_SESSION['is_admin'])): ?>
                            <a href="admin.php" class="btn btn-outline-secondary">Панель администратора</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <h1 class="display-5 fw-bold mb-3">ТСЖ Онлайн</h1>
                    <p class="lead text-muted mb-2">Удобный веб-ресурс для оплаты счетов и подачи заявок в ТСЖ/ЖКХ</p>
                    <p class="mb-4">Здесь вы можете просматривать начисления за коммунальные услуги, оплачивать счета и отправлять заявки в управляющую организацию без визита в офис.</p>
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                        <a href="login.php" class="btn btn-primary">Войти</a>
                        <a href="register.php" class="btn btn-outline-primary">Зарегистрироваться</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="mb-5">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Оплата счетов</h5>
                            <p class="card-text">Просмотр начислений и контроль оплаты коммунальных услуг</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Подача заявок</h5>
                            <p class="card-text">Отправка обращений в управляющую организацию в удобной форме</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Личный кабинет</h5>
                            <p class="card-text">Быстрый доступ к заявкам, счетам и персональной информации</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title h4 mb-4">Преимущества системы</h2>
                    <ul class="mb-0">
                        <li>доступ с компьютера и телефона</li>
                        <li>простой и понятный интерфейс</li>
                        <li>быстрый доступ к основным функциям</li>
                        <li>централизованное взаимодействие с ТСЖ/ЖКХ</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
