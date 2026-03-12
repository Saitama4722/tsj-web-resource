<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$saved_title = '';
$saved_description = '';
$show_success = isset($_GET['success']) && $_GET['success'] === '1';

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $user_id = (int) $_SESSION['user_id'];
    $status = 'Новая';

    // Валидация
    if ($title === '') {
        $error = 'Тема заявки не должна быть пустой.';
        $saved_title = $title;
        $saved_description = $description;
    } elseif (strlen($title) > 255) {
        $error = 'Тема заявки не должна быть длиннее 255 символов.';
        $saved_title = $title;
        $saved_description = $description;
    } elseif ($description === '') {
        $error = 'Описание не должно быть пустым.';
        $saved_title = $title;
        $saved_description = $description;
    }

    if ($error === '') {
        $stmt_ins = mysqli_prepare($conn, "INSERT INTO requests (user_id, title, description, status) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_ins, 'isss', $user_id, $title, $description, $status);
        if (mysqli_stmt_execute($stmt_ins)) {
            mysqli_stmt_close($stmt_ins);
            header('Location: requests.php?success=1');
            exit;
        }
        mysqli_stmt_close($stmt_ins);
        $error = 'Ошибка при создании заявки. Попробуйте снова.';
        $saved_title = $title;
        $saved_description = $description;
    }
}

// Получение заявок текущего пользователя
$user_id = (int) $_SESSION['user_id'];
$stmt = mysqli_prepare($conn, "SELECT id, title, description, status, created_at FROM requests WHERE user_id = ? ORDER BY created_at DESC");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$requests = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);
?>
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
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Мои заявки</h1>

        <?php if ($show_success): ?>
            <div class="alert alert-success">Заявка успешно отправлена</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="form-section mb-4">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="title" class="form-label">Тема заявки</label>
                    <input type="text" class="form-control" id="title" name="title" maxlength="255" value="<?= htmlspecialchars($saved_title) ?>" placeholder="Например: Протечка крыши">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Опишите проблему подробнее..."><?= htmlspecialchars($saved_description) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>

        <?php if (count($requests) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>№</th>
                            <th>Тема</th>
                            <th>Описание</th>
                            <th>Статус</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($row['created_at']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">У вас пока нет заявок</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
