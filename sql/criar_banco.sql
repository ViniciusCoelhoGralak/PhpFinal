DROP DATABASE IF EXISTS `bd_veiculos`;

CREATE DATABASE IF NOT EXISTS `bd_veiculos` DEFAULT CHARACTER SET utf8mb4;
USE `bd_veiculos`;

CREATE TABLE `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `login` VARCHAR(50) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE `veiculos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT NOT NULL,
  `placa` VARCHAR(50) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,  
  `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`)
);

-- INSERINDO O USUÁRIO DE TESTE
INSERT INTO `usuarios` (`login`, `senha`, `email`) VALUES
('teste', '$2y$10$b7dh5PPPYYGdJf//Xk35WugIpJSDRUOwCGvEXFBnxyt1Wj1SJKRfe', 'teste@teste.com');

-- senha de teste "123456"


INSERT INTO `veiculos` (`usuario_id`, `placa`, `modelo`) VALUES
((SELECT id FROM usuarios WHERE login = 'teste'), 'AAA1234', 'Veiculo de Teste');
