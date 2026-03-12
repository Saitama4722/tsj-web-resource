# ТСЖ Онлайн / HOA Online

> Веб-платформа для взаимодействия жильцов с управляющей организацией, позволяющая просматривать счета, оплачивать коммунальные услуги, отправлять заявки и отслеживать их статус.

---

## Содержание / Table of Contents

- [Русская версия](#-русская-версия)
  - [Описание проекта](#описание-проекта)
  - [Функциональность системы](#функциональность-системы)
  - [Технологии](#технологии)
  - [Структура проекта](#структура-проекта)
  - [Установка проекта](#установка-проекта)
  - [Запуск проекта](#запуск-проекта)
  - [Структура базы данных](#структура-базы-данных)
  - [Скриншоты](#скриншоты)
  - [Автор](#автор)
- [English Version](#-english-version)
  - [Project Description](#project-description)
  - [System Functionality](#system-functionality)
  - [Technologies](#technologies)
  - [Project Structure](#project-structure)
  - [Installation](#installation)
  - [Running the Project](#running-the-project)
  - [Database Structure](#database-structure)
  - [Screenshots](#screenshots-1)
  - [Author](#author-1)
- [License](#-license)

---

# 🇷🇺 Русская версия

## Описание проекта

Система **«ТСЖ Онлайн»** — веб-приложение для управления коммунальными услугами и взаимодействия жильцов с управляющей организацией. Платформа предоставляет пользователям возможность работать с коммунальными услугами через веб-интерфейс.

**Основные функции:**

- просмотр счетов ЖКХ
- оплата счетов
- подача заявок
- отслеживание статуса заявок
- личный кабинет пользователя
- панель администратора
- управление счетами
- управление заявками

## Функциональность системы

### Пользователь

- регистрация
- авторизация
- личный кабинет
- просмотр счетов
- оплата счетов
- подача заявок
- просмотр статуса заявок

### Администратор

- панель администратора
- просмотр всех заявок
- изменение статусов заявок
- добавление счетов пользователям
- просмотр всех счетов

## Технологии

| Компонент | Технологии |
|-----------|------------|
| **Frontend** | HTML, Bootstrap, CSS |
| **Backend** | PHP (procedural) |
| **База данных** | MySQL |

## Структура проекта

| Файл | Описание |
|------|----------|
| `index.php` | Главная страница |
| `login.php` | Страница входа |
| `register.php` | Регистрация пользователя |
| `dashboard.php` | Личный кабинет |
| `requests.php` | Заявки пользователя |
| `bills.php` | Счета пользователя |
| `pay_bill.php` | Обработка оплаты счета |
| `admin.php` | Панель администратора |
| `admin_requests.php` | Управление заявками |
| `admin_bills.php` | Управление счетами |
| `logout.php` | Выход из системы |
| `404.php` | Страница ошибки |
| `footer.php` | Общий footer сайта |
| `database.sql` | Структура и данные базы данных |
| `db.php` | Подключение к БД |
| `style.css` | Стили интерфейса |
| `run_project.bat` | Запуск встроенного сервера PHP (Windows) |
| `stop_project.bat` | Остановка сервера |

## Установка проекта

1. **Установите PHP** (рекомендуется версия 7.4 или выше). PHP обязателен для работы проекта.
2. **Установите MySQL** и убедитесь, что сервер БД запущен. MySQL обязателен для хранения данных.
3. **Создайте базу данных** `tsj_system` и импортируйте в неё скрипт `database.sql` (через phpMyAdmin, консоль MySQL или другой клиент).
4. **Настройте подключение к БД** в файле `db.php`: укажите корректные значения `$host`, `$user`, `$password`, `$database` под ваше окружение.

## Запуск проекта

После установки запустите проект с помощью скрипта:

```batch
run_project.bat
```

Скрипт проверяет наличие PHP, запускает встроенный веб-сервер PHP и открывает приложение по адресу **http://localhost:8080**. Не закрывайте окно консоли во время работы. Для остановки сервера закройте окно или используйте `stop_project.bat`.

Альтернатива (без bat-файла):

```bash
php -S localhost:8080
```

Затем откройте в браузере: **http://localhost:8080** или **http://localhost:8080/index.php**.

## Структура базы данных

Используется СУБД MySQL. База данных **`tsj_system`** содержит следующие таблицы:

### Таблица `users`

Хранит учётные записи пользователей системы.

| Поле | Тип | Описание |
|------|-----|----------|
| `id` | INT, PK, AUTO_INCREMENT | Уникальный идентификатор |
| `name` | VARCHAR(100) | Имя пользователя |
| `email` | VARCHAR(100), UNIQUE | Email (логин) |
| `password` | VARCHAR(255) | Хеш пароля (bcrypt) |
| `created_at` | TIMESTAMP | Дата регистрации |

### Таблица `requests`

Заявки пользователей (обращения в управляющую организацию).

| Поле | Тип | Описание |
|------|-----|----------|
| `id` | INT, PK, AUTO_INCREMENT | Уникальный идентификатор |
| `user_id` | INT, FK → users(id) | Автор заявки |
| `title` | VARCHAR(255) | Заголовок заявки |
| `description` | TEXT | Описание |
| `status` | VARCHAR(50) | Статус (Новая, В работе, Выполнена и т.д.) |
| `created_at` | TIMESTAMP | Дата создания |

### Таблица `bills`

Счета за коммунальные услуги.

| Поле | Тип | Описание |
|------|-----|----------|
| `id` | INT, PK, AUTO_INCREMENT | Уникальный идентификатор |
| `user_id` | INT, FK → users(id) | Владелец счёта |
| `month` | VARCHAR(50) | Период (например, «Январь 2025») |
| `amount` | DECIMAL(10,2) | Сумма к оплате |
| `status` | VARCHAR(50) | Статус (Ожидает оплаты, Оплачен и т.д.) |

### Доступы для входа

После импорта `database.sql` в системе доступны следующие учётные записи:

| Роль | Email | Пароль |
|------|-------|--------|
| Пользователь 1 | ivan@example.com | 123456 |
| Пользователь 2 | maria@example.com | 123456 |
| Администратор | admin@tsj.local | admin123 |

## Скриншоты

- **Главная страница** (`index.php`) — приветствие и ссылки на вход/регистрацию.
- **Личный кабинет** (`dashboard.php`) — сводка по заявкам и счетам пользователя после входа.
- **Заявки** (`requests.php`) — список заявок пользователя с возможностью создания новой и просмотра статуса.
- **Счета** (`bills.php`) — список счетов с отображением суммы, периода и статуса оплаты; доступна кнопка оплаты.
- **Панель администратора** (`admin.php`) — переходы к управлению заявками и счетами для всех пользователей.

*(Для актуального вида интерфейса откройте приложение в браузере после запуска через `run_project.bat`.)*

## Интерфейс

- Интерфейс построен на **Bootstrap** для единообразного и современного оформления.
- Реализован **адаптивный дизайн** для удобной работы с компьютеров и мобильных устройств.
- Единая **навигация** и **footer** (`footer.php`) используются на основных страницах.
- Для несуществующих страниц отображается отдельная **страница 404** (`404.php`).

## Автор

Проект «ТСЖ Онлайн» разработан в учебных целях.

---

# 🇬🇧 English Version

## Project Description

**ТСЖ Онлайн** (HOA Online) is a web application for managing utilities and interaction between residents and the management company. The platform allows users to work with housing and communal services through a web interface.

**Main functions:**

- View utility bills
- Pay bills
- Submit requests
- Track request status
- Personal user account
- Administrator panel
- Bill management
- Request management

## System Functionality

### User Features

- Registration
- Authorization
- Personal account
- View bills
- Pay bills
- Submit requests
- View request status

### Administrator Features

- Administrator panel
- View all requests
- Change request statuses
- Add bills for users
- View all bills

## Technologies

| Component | Technologies |
|-----------|--------------|
| **Frontend** | HTML, Bootstrap, CSS |
| **Backend** | PHP (procedural) |
| **Database** | MySQL |

## Project Structure

| File | Description |
|------|-------------|
| `index.php` | Main page |
| `login.php` | Login page |
| `register.php` | User registration |
| `dashboard.php` | Personal account |
| `requests.php` | User requests |
| `bills.php` | User bills |
| `pay_bill.php` | Bill payment processing |
| `admin.php` | Administrator panel |
| `admin_requests.php` | Request management |
| `admin_bills.php` | Bill management |
| `logout.php` | Logout |
| `404.php` | Error page |
| `footer.php` | Shared site footer |
| `database.sql` | Database structure and seed data |
| `db.php` | Database connection |
| `style.css` | Interface styles |
| `run_project.bat` | Start built-in PHP server (Windows) |
| `stop_project.bat` | Stop server |

## Installation

1. **Install PHP** (version 7.4 or higher recommended). PHP is required to run the project.
2. **Install MySQL** and ensure the database server is running. MySQL is required for data storage.
3. **Create the database** `tsj_system` and import the `database.sql` script (via phpMyAdmin, MySQL console, or another client).
4. **Configure the database connection** in `db.php`: set the correct `$host`, `$user`, `$password`, and `$database` for your environment.

## Running the Project

After installation, start the project using the script:

```batch
run_project.bat
```

The script checks for PHP, starts the built-in PHP web server, and serves the application at **http://localhost:8080**. Do not close the console window while using the app. To stop the server, close the window or run `stop_project.bat`.

Alternative (without the batch file):

```bash
php -S localhost:8080
```

Then open in a browser: **http://localhost:8080** or **http://localhost:8080/index.php**.

## Database Structure

The application uses MySQL. The **`tsj_system`** database contains the following tables:

### Table `users`

Stores user accounts.

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT, PK, AUTO_INCREMENT | Unique identifier |
| `name` | VARCHAR(100) | User name |
| `email` | VARCHAR(100), UNIQUE | Email (login) |
| `password` | VARCHAR(255) | Password hash (bcrypt) |
| `created_at` | TIMESTAMP | Registration date |

### Table `requests`

User requests (complaints and requests to the management company).

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT, PK, AUTO_INCREMENT | Unique identifier |
| `user_id` | INT, FK → users(id) | Request author |
| `title` | VARCHAR(255) | Request title |
| `description` | TEXT | Description |
| `status` | VARCHAR(50) | Status (New, In progress, Completed, etc.) |
| `created_at` | TIMESTAMP | Creation date |

### Table `bills`

Utility bills.

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT, PK, AUTO_INCREMENT | Unique identifier |
| `user_id` | INT, FK → users(id) | Bill owner |
| `month` | VARCHAR(50) | Billing period (e.g. "January 2025") |
| `amount` | DECIMAL(10,2) | Amount due |
| `status` | VARCHAR(50) | Status (Pending, Paid, etc.) |

### Demo Accounts

After importing `database.sql`, the following accounts are available:

| Role | Email | Password |
|------|-------|----------|
| User 1 | ivan@example.com | 123456 |
| User 2 | maria@example.com | 123456 |
| Administrator | admin@tsj.local | admin123 |

## Screenshots

- **Main page** (`index.php`) — welcome screen and links to login/register.
- **Personal account** (`dashboard.php`) — overview of the user's requests and bills after login.
- **Requests** (`requests.php`) — list of user requests with option to create new ones and view status.
- **Bills** (`bills.php`) — list of bills with amount, period, and payment status; pay button available.
- **Administrator panel** (`admin.php`) — links to manage all requests and bills.

*(For the actual look of the interface, open the application in a browser after starting it with `run_project.bat`.)*

## Interface

- The interface is built with **Bootstrap** for consistent, modern styling.
- **Responsive design** is implemented for comfortable use on desktop and mobile devices.
- Shared **navigation** and **footer** (`footer.php`) are used across main pages.
- A dedicated **404 page** (`404.php`) is shown for non-existent URLs.

## Author

The «ТСЖ Онлайн» project was developed for educational purposes.

---

# 📄 License

This project is provided for educational use. You may use, modify, and distribute it in accordance with your course or institution guidelines. No warranty is provided.

---

*ТСЖ Онлайн / HOA Online — веб-платформа для управления ЖКХ и взаимодействия жильцов с УК.*
