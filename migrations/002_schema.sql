-- Migration 002: expand lotes, add roles, fornecedores, movimentacoes
USE `lotesmart`;

-- add columns to lotes
ALTER TABLE `lotes`
  ADD COLUMN `data_fabricacao` DATE NULL,
  ADD COLUMN `data_validade` DATE NULL,
  ADD COLUMN `fornecedor_id` INT NULL,
  ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'ativo';

-- enforce unique code
ALTER TABLE `lotes` ADD UNIQUE KEY `uniq_codigo` (`codigo`);

-- fornecedores
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `contato` VARCHAR(200),
  `telefone` VARCHAR(50),
  `email` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- user_roles
CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` INT NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- movimentacoes
CREATE TABLE IF NOT EXISTS `movimentacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lote_id` INT NOT NULL,
  `tipo` ENUM('entrada','saida') NOT NULL,
  `quantidade` INT NOT NULL,
  `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NULL,
  `observacao` TEXT,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`lote_id`) REFERENCES `lotes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- seed basic roles
INSERT IGNORE INTO `roles` (`name`) VALUES ('admin'), ('operador');
