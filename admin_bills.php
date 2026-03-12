<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit;
}

$show_success = isset($_GET['success']) && $_GET['success'] === '1';
$error = '';

// Добавление нового счёта
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['month'], $_POST['amount'], $_POST['status'])) {
    $user_id = (int) $_POST['user_id'];
    $month = trim($_POST['month']);
    $amount = (float) str_replace(',', '.', $_POST['amount']);
    $status = trim($_POST['status']);

    if ($user_id > 0 && $month !== '' && $amount > 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO bills (user_id, month, amount, status) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'isds', $user_id, $month, $amount, $status);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header('Location: admin_bills.php?success=1');
            exit;
        }
        mysqli_stmt_close($stmt);
    }
    $error = 'Ошибка при добавлении счёта. Проверьте данные.';
}

// Обычные пользователи (кроме admin@tsj.local) для select
$stmt_users = mysqli_prepare($conn, "SELECT id, name, email FROM users WHERE email != 'admin@tsj.local' ORDER BY name");
mysqli_stmt_execute($stmt_users);
$result_users = mysqli_stmt_get_result($stmt_users);
$users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);
mysqli_stmt_close($stmt_users);

// Все счета с данными пользователей
$sql = "SELECT bills.id, users.name, users.email, bills.month, bills.amount, bills.status
        FROM bills
        JOIN users ON bills.user_id = users.id
        ORDER BY bills.id DESC";
$result = mysqli_query($conn, $sql);
$bills = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление счетами — ТСЖ Онлайн</title>
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
                    <li class="nav-item"><a class="nav-link" href="admin.php">Панель администратора</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_requests.php">Заявки</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_bills.php">Счета</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <h1>Управление счетами</h1>

        <?php if ($show_success): ?>
            <div class="alert alert-success">Счёт успешно добавлен</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">Добавить новый счёт</div>
            <div class="card-body">
                <form method="post" action="admin_bills.php" class="row g-3">
                    <div class="col-md-4">
                        <label for="user_id" class="form-label">Пользователь</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">Выберите пользователя</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= (int) $u['id'] ?>"><?= htmlspecialchars($u['name']) ?> (<?= htmlspecialchars($u['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="month" class="form-label">Месяц</label>
                        <input type="text" class="form-control" id="month" name="month" required placeholder="Например: Март 2025">
                    </div>
                    <div class="col-md-2">
                        <label for="amount" class="form-label">Сумма</label>
                        <input type="text" class="form-control" id="amount" name="amount" required placeholder="3500">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Статус</label>
                        <select name="status" id="status" class="form-select">
                            <option value="Ожидает оплаты" selected>Ожидает оплаты</option>
                            <option value="Оплачен">Оплачен</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Добавить</button>
                    </div>
                </form>
            </div>
        </div>

        <h2 class="h5 mb-3">Список счетов</h2>
        <?php if (count($bills) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>№</th>
                            <th>Пользователь</th>
                            <th>Email</th>
                            <th>Месяц</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bills as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['month']) ?></td>
                                <td><?= number_format((float) $row['amount'], 2, '.', '') ?> ₽</td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">Счетов пока нет</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
