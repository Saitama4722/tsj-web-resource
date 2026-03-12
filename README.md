# ТСЖ Онлайн

Веб-платформа для взаимодействия жильцов с управляющей организацией, позволяющая просматривать счета, оплачивать коммунальные услуги, отправлять заявки и отслеживать их статус.

---

# Русская версия

## Описание

Система «ТСЖ Онлайн» — веб-приложение для управления коммунальными услугами и взаимодействия жильцов с управляющей организацией. Платформа предоставляет пользователям возможность работать с коммунальными услугами через веб-интерфейс.

**Основные функции:**

- просмотр счетов ЖКХ
- оплата счетов
- подача заявок
- отслеживание статуса заявок
- личный кабинет пользователя
- панель администратора
- управление счетами
- управление заявками

## Основные возможности

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

## Архитектура системы

| Компонент | Технологии |
|-----------|------------|
| **Frontend** | HTML, Bootstrap |
| **Backend** | PHP (procedural) |
| **Database** | MySQL |

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
| `database.sql` | Структура базы данных |
| `db.php` | Подключение к БД |
| `style.css` | Стили интерфейса |

## База данных

Используется СУБД MySQL. База данных `tsj_system` содержит следующие таблицы:

| Таблица | Описание |
|---------|----------|
| **users** | Пользователи системы (имя, email, пароль, дата регистрации) |
| **requests** | Заявки пользователей (заголовок, описание, статус, связь с пользователем) |
| **bills** | Счета ЖКХ (месяц, сумма, статус оплаты, связь с пользователем) |

## Доступы для входа

После импорта `database.sql` в системе доступны следующие учётные записи:

### Пользователь 1
- **Email:** ivan@example.com  
- **Password:** 123456  

### Пользователь 2
- **Email:** maria@example.com  
- **Password:** 123456  

### Администратор
- **Email:** admin@tsj.local  
- **Password:** admin123  

## Установка и запуск

1. **Установить PHP** (рекомендуется версия 7.4 или выше).
2. **Установить MySQL** и создать базу данных.
3. **Импортировать структуру и данные:** выполнить скрипт `database.sql` в MySQL (через phpMyAdmin, консоль или другой клиент).
4. **Настроить подключение к БД:** в файле `db.php` указать корректные значения `$host`, `$user`, `$password`, `$database` под ваше окружение.
5. **Запустить проект:** разместить файлы в корне веб-сервера (Apache, Nginx с PHP) или использовать встроенный сервер PHP:  
   `php -S localhost:8000`  
   Затем открыть в браузере: `http://localhost:8000`.

## Интерфейс

- Интерфейс построен на **Bootstrap** для единообразного и современного оформления.
- Реализован **адаптивный дизайн** для удобной работы с компьютеров и мобильных устройств.
- Единая **навигация** и **footer** (`footer.php`) используются на основных страницах.
- Для несуществующих страниц отображается отдельная **страница 404** (`404.php`).

---

# English Version

## Description

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

## Features

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

## System Architecture

| Component | Technologies |
|-----------|--------------|
| **Frontend** | HTML, Bootstrap |
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
| `database.sql` | Database structure |
| `db.php` | Database connection |
| `style.css` | Interface styles |

## Database

The application uses MySQL. The `tsj_system` database includes the following tables:

| Table | Description |
|-------|-------------|
| **users** | System users (name, email, password, registration date) |
| **requests** | User requests (title, description, status, user reference) |
| **bills** | Utility bills (month, amount, payment status, user reference) |

## Demo Accounts

After importing `database.sql`, the following accounts are available:

### User 1
- **Email:** ivan@example.com  
- **Password:** 123456  

### User 2
- **Email:** maria@example.com  
- **Password:** 123456  

### Administrator
- **Email:** admin@tsj.local  
- **Password:** admin123  

## Installation

1. **Install PHP** (version 7.4 or higher recommended).
2. **Install MySQL** and create a database.
3. **Import structure and data:** run the `database.sql` script in MySQL (via phpMyAdmin, console, or another client).
4. **Configure database connection:** in `db.php`, set the correct `$host`, `$user`, `$password`, and `$database` for your environment.
5. **Run the project:** place the files in the web server root (Apache, Nginx with PHP) or use the built-in PHP server:  
   `php -S localhost:8000`  
   Then open in a browser: `http://localhost:8000`.

## Interface

- The interface is built with **Bootstrap** for consistent, modern styling.
- **Responsive design** is implemented for comfortable use on desktop and mobile devices.
- Shared **navigation** and **footer** (`footer.php`) are used across main pages.
- A dedicated **404 page** (`404.php`) is shown for non-existent URLs.
