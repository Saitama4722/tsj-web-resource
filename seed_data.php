<?php
/**
 * Скрипт заполнения базы тестовыми данными для проекта "ТСЖ Онлайн"
 * Запуск: http://localhost:8080/seed_data.php
 */
require_once __DIR__ . '/db.php';

header('Content-Type: text/html; charset=utf-8');

// Проверка: если пользователей уже больше 10 — база считается заполненной
$check = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM users");
$row = mysqli_fetch_assoc($check);
if ((int) $row['cnt'] > 10) {
    echo 'База уже содержит данные.';
    exit;
}

// Пароль для всех тестовых пользователей (123456)
$passwordHash = password_hash('123456', PASSWORD_DEFAULT);

// ——— 1. Добавление 50 тестовых пользователей ———
$stmtUser = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
if (!$stmtUser) {
    die('Ошибка подготовки запроса users: ' . mysqli_error($conn));
}

for ($i = 1; $i <= 50; $i++) {
    $name = "Пользователь $i";
    $email = "user{$i}@test.local";
    mysqli_stmt_bind_param($stmtUser, "sss", $name, $email, $passwordHash);
    if (!mysqli_stmt_execute($stmtUser)) {
        die('Ошибка вставки пользователя: ' . mysqli_error($conn));
    }
}
mysqli_stmt_close($stmtUser);

// Получаем все id пользователей для заявок и счетов
$userIds = [];
$res = mysqli_query($conn, "SELECT id FROM users ORDER BY id");
while ($u = mysqli_fetch_assoc($res)) {
    $userIds[] = (int) $u['id'];
}
if (empty($userIds)) {
    die('Нет пользователей в базе.');
}

// ——— 2. Шаблоны заявок (title + description) ———
$requestTemplates = [
    ['Протечка трубы в ванной', 'Обнаружена протечка трубы в ванной комнате. Необходим срочный ремонт.'],
    ['Не работает лифт', 'Лифт не реагирует на нажатие кнопок. Требуется проверка специалистом.'],
    ['Сломан домофон', 'Домофон у подъезда не открывает дверь. Нужна замена или ремонт.'],
    ['Нет света в подъезде', 'На площадках подъезда не горит освещение. Просьба заменить лампы.'],
    ['Проблема с отоплением', 'В квартире холодные батареи. Отопление не работает должным образом.'],
    ['Разбитое окно в подъезде', 'Разбито стекло в окне на лестничной клетке. Нужна замена.'],
    ['Засор канализации', 'Засор в стояке канализации. Вода не уходит.'],
    ['Шум от соседей', 'Постоянный шум от соседей в ночное время. Требуется разбирательство.'],
    ['Не работает освещение во дворе', 'Фонари во дворе не горят. Необходим ремонт освещения.'],
    ['Проблема с парковкой', 'Неправомерная парковка на территории двора. Нужны меры.'],
];

$requestStatuses = ['Новая', 'В работе', 'Выполнена'];

$stmtRequest = mysqli_prepare($conn, "INSERT INTO requests (user_id, title, description, status) VALUES (?, ?, ?, ?)");
if (!$stmtRequest) {
    die('Ошибка подготовки запроса requests: ' . mysqli_error($conn));
}

$numRequests = 200;
for ($i = 0; $i < $numRequests; $i++) {
    $userId = $userIds[array_rand($userIds)];
    $tpl = $requestTemplates[array_rand($requestTemplates)];
    $title = $tpl[0];
    $description = $tpl[1];
    $status = $requestStatuses[array_rand($requestStatuses)];
    mysqli_stmt_bind_param($stmtRequest, "isss", $userId, $title, $description, $status);
    if (!mysqli_stmt_execute($stmtRequest)) {
        die('Ошибка вставки заявки: ' . mysqli_error($conn));
    }
}
mysqli_stmt_close($stmtRequest);

// ——— 3. Счета (bills): месяцы и статусы ———
$months = [
    'Январь 2025', 'Февраль 2025', 'Март 2025', 'Апрель 2025', 'Май 2025', 'Июнь 2025',
    'Июль 2025', 'Август 2025', 'Сентябрь 2025', 'Октябрь 2025', 'Ноябрь 2025', 'Декабрь 2025',
];
$billStatuses = ['Оплачен', 'Ожидает оплаты', 'Просрочен'];

$stmtBill = mysqli_prepare($conn, "INSERT INTO bills (user_id, month, amount, status) VALUES (?, ?, ?, ?)");
if (!$stmtBill) {
    die('Ошибка подготовки запроса bills: ' . mysqli_error($conn));
}

$numBills = 300;
for ($i = 0; $i < $numBills; $i++) {
    $userId = $userIds[array_rand($userIds)];
    $month = $months[array_rand($months)];
    $amount = (float) rand(2500, 6500);
    $status = $billStatuses[array_rand($billStatuses)];
    mysqli_stmt_bind_param($stmtBill, "isds", $userId, $month, $amount, $status);
    if (!mysqli_stmt_execute($stmtBill)) {
        die('Ошибка вставки счёта: ' . mysqli_error($conn));
    }
}
mysqli_stmt_close($stmtBill);

echo 'Тестовые данные успешно созданы';
