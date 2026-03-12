<?php
session_start();
require_once 'db.php';

$message = '';
$error = '';
$saved_name = '';
$saved_email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Валидация
    if ($name === '') {
        $error = 'Имя не должно быть пустым.';
    } elseif ($email === '') {
        $error = 'Email не должен быть пустым.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Введите корректный email.';
    } elseif ($password === '') {
        $error = 'Пароль не должен быть пустым.';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен быть не меньше 6 символов.';
    }

    if ($error === '') {
        // Проверка: есть ли уже такой email
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = 'Такой email уже зарегистрирован.';
            $saved_name = $name;
            $saved_email = $email;
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hash);
            if (mysqli_stmt_execute($stmt)) {
                $message = 'Регистрация успешна';
            } else {
                $error = 'Ошибка при регистрации. Попробуйте снова.';
                $saved_name = $name;
                $saved_email = $email;
            }
        }
    } else {
        $saved_name = $name;
        $saved_email = $email;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация — ТСЖ Онлайн</title>
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Личный кабинет</a></li>
                        <li class="nav-item"><a class="nav-link" href="requests.php">Заявки</a></li>
                        <li class="nav-item"><a class="nav-link" href="bills.php">Счета</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                        <li class="nav-item"><a class="nav-link active" href="register.php">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-fill">
    <div class="container">
        <h1>Регистрация</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <div class="form-section">
            <form method="post" action="register.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($saved_name) ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($saved_email) ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
            </form>
        </div>
    </div>
    </main>

    <?php require_once 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
