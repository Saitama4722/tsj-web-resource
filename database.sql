-- База данных для учебного проекта "ТСЖ Онлайн"
-- MySQL

CREATE DATABASE IF NOT EXISTS tsj_system
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE tsj_system;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица заявок
CREATE TABLE IF NOT EXISTS requests (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'Новая',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица счетов
CREATE TABLE IF NOT EXISTS bills (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  month VARCHAR(50) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'Ожидает оплаты',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Тестовые данные: 2 пользователя + администратор
-- Обычные пользователи: пароль 123456 (хеш bcrypt)
-- Администратор: admin@tsj.local, пароль admin123 (хеш bcrypt)
INSERT INTO users (name, email, password) VALUES
('Иван Петров', 'ivan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Мария Сидорова', 'maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Администратор', 'admin@tsj.local', '$2y$12$f3DHtupoVMAfkOXTxR/l1umQNGXShIAck4C6dkfR4r97GfYKzcp2m');

-- Тестовые данные: 3 заявки
INSERT INTO requests (user_id, title, description, status) VALUES
(1, 'Протечка крана в ванной', 'В квартире 15 на 3 этаже подтекает кран в ванной комнате. Требуется замена.', 'Новая'),
(1, 'Не работает домофон', 'Домофон у подъезда 1 не открывает дверь с панели.', 'В работе'),
(2, 'Замена лампочки в подъезде', 'На площадке 2 этажа перегорела лампочка.', 'Выполнена');

-- Тестовые данные: 4 счета
INSERT INTO bills (user_id, month, amount, status) VALUES
(1, 'Январь 2025', 3500.00, 'Оплачен'),
(1, 'Февраль 2025', 3500.00, 'Ожидает оплаты'),
(2, 'Январь 2025', 3500.00, 'Оплачен'),
(2, 'Февраль 2025', 3500.00, 'Ожидает оплаты');
