-- Full schema for LoteSmart
-- Creates database, tables, constraints and seeds basic roles and admin user.
-- IMPORTANT: change the seeded admin password after import.

CREATE DATABASE IF NOT EXISTS `lotesmart` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lotesmart`;

-- ROLES (create first so we can assign roles later)
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- USERS
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- FORNECEDORES
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `contato` VARCHAR(200),
  `telefone` VARCHAR(50),
  `email` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- LOTES (core table)
CREATE TABLE IF NOT EXISTS `lotes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(100) NOT NULL,
  `descricao` VARCHAR(255),
  `quantidade` INT DEFAULT 0,
  `data_fabricacao` DATE NULL,
  `data_validade` DATE NULL,
  `fornecedor_id` INT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'ativo',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_codigo` (`codigo`),
  INDEX `idx_fornecedor` (`fornecedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- MOVIMENTAÇÕES (stock movements)
CREATE TABLE IF NOT EXISTS `movimentacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lote_id` INT NOT NULL,
  `tipo` ENUM('entrada','saida') NOT NULL,
  `quantidade` INT NOT NULL,
  `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NULL,
  `observacao` TEXT,
  PRIMARY KEY (`id`),
  INDEX `idx_lote` (`lote_id`),
  INDEX `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- USER_ROLES (many-to-many)
CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` INT NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  INDEX `ur_role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Foreign keys (added after tables exist)
ALTER TABLE `lotes`
  ADD CONSTRAINT `fk_lotes_fornecedor` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `movimentacoes`
  ADD CONSTRAINT `fk_mov_lote` FOREIGN KEY (`lote_id`) REFERENCES `lotes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mov_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_ur_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ur_role` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Seed basic roles
INSERT INTO `roles` (`name`) VALUES ('admin') ON DUPLICATE KEY UPDATE `name` = `name`;
INSERT INTO `roles` (`name`) VALUES ('operador') ON DUPLICATE KEY UPDATE `name` = `name`;

-- Optional: seed an admin user (email=admin@example.com, password='password')
-- Change this password after import or remove the user and create via register.
INSERT INTO `users` (`name`, `email`, `password`) 
VALUES ('Administrador', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi') 
ON DUPLICATE KEY UPDATE `email` = `email`;

-- grant admin role to seeded admin user (if exists)
INSERT INTO `user_roles` (`user_id`, `role_id`)
SELECT u.id, r.id FROM users u JOIN roles r ON r.name = 'admin' WHERE u.email = 'admin@example.com'
ON DUPLICATE KEY UPDATE `user_id` = `user_id`;

-- Sample index optimizations
CREATE INDEX IF NOT EXISTS `idx_lotes_validade` ON `lotes` (`data_validade`);

-- Done. Use this file to create a full DB in one step:
-- mysql -u <user> -p < migrations/full_schema.sql
