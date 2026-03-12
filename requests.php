<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявки — ТСЖ Онлайн</title>
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
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Личный кабинет</a></li>
                    <li class="nav-item"><a class="nav-link active" href="requests.php">Заявки</a></li>
                    <li class="nav-item"><a class="nav-link" href="bills.php">Счета</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Регистрация</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Подать заявку</h1>
        <div class="form-section">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="subject" class="form-label">Тема заявки</label>
                    <input type="text" class="form-control" id="subject" name="subject" required placeholder="Например: Протечка крыши">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Опишите проблему подробнее..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Отправить</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
