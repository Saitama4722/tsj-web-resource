<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Счета ЖКХ — ТСЖ Онлайн</title>
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
                    <li class="nav-item"><a class="nav-link" href="requests.php">Заявки</a></li>
                    <li class="nav-item"><a class="nav-link active" href="bills.php">Счета</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Регистрация</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Счета ЖКХ</h1>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>№</th>
                        <th>Месяц</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Январь 2025</td>
                        <td>3 500 ₽</td>
                        <td><span class="badge bg-success">Оплачен</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Февраль 2025</td>
                        <td>3 720 ₽</td>
                        <td><span class="badge bg-success">Оплачен</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Март 2025</td>
                        <td>3 650 ₽</td>
                        <td><span class="badge bg-warning text-dark">Ожидает оплаты</span></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Апрель 2025</td>
                        <td>—</td>
                        <td><span class="badge bg-secondary">Не выставлен</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
