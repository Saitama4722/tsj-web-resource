<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$stmt = mysqli_prepare($conn, "SELECT id, month, amount, status FROM bills WHERE user_id = ? ORDER BY id DESC");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bills = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Счета ЖКХ — ТСЖ Онлайн</title>
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
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Личный кабинет</a></li>
                    <li class="nav-item"><a class="nav-link" href="requests.php">Заявки</a></li>
                    <li class="nav-item"><a class="nav-link active" href="bills.php">Счета</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-fill">
    <div class="container">
        <h1>Счета ЖКХ</h1>

        <?php if (isset($_GET['paid']) && $_GET['paid'] === '1'): ?>
            <div class="alert alert-success">Счёт успешно оплачен</div>
        <?php endif; ?>

        <?php if (count($bills) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>№</th>
                            <th>Месяц</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bills as $index => $row): ?>
                            <?php
                            $amountFormatted = number_format((float) $row['amount'], 2, '.', '') . ' ₽';
                            if ($row['status'] === 'Оплачен') {
                                $badgeClass = 'badge bg-success';
                            } elseif ($row['status'] === 'Ожидает оплаты') {
                                $badgeClass = 'badge bg-warning text-dark';
                            } else {
                                $badgeClass = 'badge bg-secondary';
                            }
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['month']) ?></td>
                                <td><?= htmlspecialchars($amountFormatted) ?></td>
                                <td><span class="<?= $badgeClass ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                                <td>
                                    <?php if ($row['status'] === 'Ожидает оплаты'): ?>
                                        <form method="post" action="pay_bill.php">
                                            <input type="hidden" name="bill_id" value="<?= (int) $row['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-success">Оплатить</button>
                                        </form>
                                    <?php elseif ($row['status'] === 'Оплачен'): ?>
                                        <span class="text-success">Оплачено</span>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">У вас пока нет выставленных счетов</p>
        <?php endif; ?>
    </div>
    </main>

    <?php require_once 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
