<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit;
}

$show_success = isset($_GET['success']) && $_GET['success'] === '1';

// Обновление статуса заявки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['status'])) {
    $request_id = (int) $_POST['request_id'];
    $status = trim($_POST['status']);
    $allowed = ['Новая', 'В работе', 'Выполнена'];
    if ($request_id > 0 && in_array($status, $allowed, true)) {
        $stmt = mysqli_prepare($conn, "UPDATE requests SET status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'si', $status, $request_id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header('Location: admin_requests.php?success=1');
            exit;
        }
        mysqli_stmt_close($stmt);
    }
}

// Все заявки с данными пользователей
$sql = "SELECT requests.id, users.name, users.email, requests.title, requests.description, requests.status, requests.created_at
        FROM requests
        JOIN users ON requests.user_id = users.id
        ORDER BY requests.created_at DESC";
$result = mysqli_query($conn, $sql);
$requests = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление заявками — ТСЖ Онлайн</title>
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
                    <li class="nav-item"><a class="nav-link" href="admin.php">Панель администратора</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_requests.php">Заявки</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_bills.php">Счета</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-fill">
    <div class="container py-4">
        <h1>Управление заявками</h1>

        <?php if ($show_success): ?>
            <div class="alert alert-success">Статус заявки обновлён</div>
        <?php endif; ?>

        <?php if (count($requests) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>№</th>
                            <th>Пользователь</th>
                            <th>Email</th>
                            <th>Тема</th>
                            <th>Описание</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($row['created_at']))) ?></td>
                                <td>
                                    <form method="post" action="admin_requests.php" class="d-flex flex-wrap gap-1 align-items-center">
                                        <input type="hidden" name="request_id" value="<?= (int) $row['id'] ?>">
                                        <select name="status" class="form-select form-select-sm" style="width: auto;">
                                            <option value="Новая" <?= $row['status'] === 'Новая' ? 'selected' : '' ?>>Новая</option>
                                            <option value="В работе" <?= $row['status'] === 'В работе' ? 'selected' : '' ?>>В работе</option>
                                            <option value="Выполнена" <?= $row['status'] === 'Выполнена' ? 'selected' : '' ?>>Выполнена</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Обновить</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">Заявок пока нет</p>
        <?php endif; ?>
    </div>
    </main>

    <?php require_once 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
