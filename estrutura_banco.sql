-- oficina_db.itens_servico definition

CREATE TABLE `itens_servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `servico_id` int DEFAULT NULL,
  `material_id` int DEFAULT NULL,
  `quantidade` int NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `servico_id` (`servico_id`),
  KEY `material_id` (`material_id`),
  CONSTRAINT `itens_servico_ibfk_1` FOREIGN KEY (`servico_id`) REFERENCES `services` (`id`),
  CONSTRAINT `itens_servico_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- oficina_db.itens_venda definition

CREATE TABLE `itens_venda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `venda_id` int NOT NULL,
  `material_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `venda_id` (`venda_id`),
  KEY `material_id` (`material_id`),
  CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `vendas` (`id`),
  CONSTRAINT `itens_venda_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- oficina_db.materials definition

CREATE TABLE `materials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `quantidade` int NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- oficina_db.mecanicos definition

CREATE TABLE `mecanicos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `mecanicos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- oficina_db.services definition

CREATE TABLE `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `mecanico_id` int DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_conclusao_estimada` date DEFAULT NULL,
  `status` enum('pendente','em_progresso','concluido') NOT NULL DEFAULT 'pendente',
  `valor_total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valor_mao_obra` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mecanico_id` (`mecanico_id`),
  CONSTRAINT `services_ibfk_1` FOREIGN KEY (`mecanico_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- oficina_db.users definition

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` enum('admin','usuario') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- oficina_db.vendas definition

CREATE TABLE `vendas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_nome` varchar(255) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  `data_venda` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `vendedor_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vendedor_id` (`vendedor_id`),
  CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`vendedor_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO materials (nome, preco, quantidade) VALUES
('Parafuso', 0.10, 1000),
('Prego', 0.05, 5000),
('Porca', 0.20, 2000),
('Amortecedor', 150.00, 50),
('Filtro de Óleo', 25.00, 150),
('Filtro de Ar', 30.00, 120),
('Pastilha de Freio', 80.00, 200),
('Disco de Freio', 120.00, 100),
('Correia Dentada', 90.00, 75),
('Velas de Ignição', 20.00, 300),
('Bateria', 300.00, 20),
('Radiador', 400.00, 15),
('Macaco Hidráulico', 250.00, 10),
('Chave de Roda', 40.00, 100),
('Kit de Ferramentas', 150.00, 25),
('Pneu', 400.00, 50),
('Filtro de Combustível', 35.00, 140),
('Correia Alternador', 70.00, 80),
('Bucha de Suspensão', 15.00, 500),
('Rolamento', 60.00, 200),
('Terminal de Direção', 80.00, 150),
('Sensor de Oxigênio', 120.00, 70),
('Cabo de Velas', 50.00, 200),
('Embreagem', 500.00, 20),
('Cilindro Mestre', 200.00, 40),
('Alinhamento de Direção', 100.00, 50),
('Balanceamento de Rodas', 80.00, 60),
('Lâmpada de Farol', 30.00, 300),
('Retrovisor', 150.00, 40),
('Pára-brisa', 600.00, 10);