-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 08/12/2025 às 23:06
-- Versão do servidor: 8.4.7
-- Versão do PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fitway`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alimentos`
--

DROP TABLE IF EXISTS `alimentos`;
CREATE TABLE IF NOT EXISTS `alimentos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nome_alimento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kcal` int DEFAULT NULL,
  `proteinas` decimal(5,2) DEFAULT NULL,
  `carboidratos` decimal(5,2) DEFAULT NULL,
  `gorduras` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `alimentos`
--

INSERT INTO `alimentos` (`ID`, `nome_alimento`, `kcal`, `proteinas`, `carboidratos`, `gorduras`) VALUES
(1, 'Arroz Branco 100g', 130, 2.50, 28.00, 0.30),
(2, 'Arroz Integral 100g', 124, 2.60, 25.80, 1.00),
(3, 'Feijão Carioca 100g', 76, 4.80, 13.60, 0.50),
(4, 'Peito de Frango 100g', 165, 31.00, 0.00, 3.60),
(5, 'Carne Moída 100g', 215, 26.00, 0.00, 12.00),
(6, 'Ovo Inteiro 1 unidade', 72, 6.00, 0.40, 5.00),
(7, 'Batata Doce 100g', 86, 1.60, 20.00, 0.10),
(8, 'Batata Inglesa 100g', 77, 2.00, 17.00, 0.10),
(9, 'Brócolis 100g', 32, 2.80, 7.00, 0.40),
(10, 'Cenoura 100g', 41, 0.90, 10.00, 0.20),
(11, 'Banana 1 unidade média', 89, 1.10, 23.00, 0.30),
(12, 'Maçã 1 unidade média', 95, 0.30, 25.00, 0.30),
(13, 'Aveia 30g', 117, 5.00, 20.00, 2.00),
(14, 'Pão Integral 1 fatia', 69, 3.60, 12.00, 1.10),
(15, 'Queijo Cottage 100g', 98, 11.00, 3.40, 4.30),
(16, 'Iogurte Natural 170g', 100, 5.50, 7.00, 4.00),
(17, 'Atum em Lata (água) 100g', 85, 19.00, 0.00, 0.60),
(18, 'Salmão Grelhado 100g', 208, 22.00, 0.00, 13.00),
(19, 'Amêndoas 30g', 173, 6.00, 6.00, 15.00),
(20, 'Pasta de Amendoim 1 colher (16g)', 94, 4.00, 3.00, 8.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dieta`
--

DROP TABLE IF EXISTS `dieta`;
CREATE TABLE IF NOT EXISTS `dieta` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `usuario_idD` int DEFAULT NULL,
  `nome_dieta` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `objetivos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `usuario_idD` (`usuario_idD`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `dieta`
--

INSERT INTO `dieta` (`ID`, `usuario_idD`, `nome_dieta`, `data_inicio`, `data_fim`, `objetivos`) VALUES
(1, 29, 'Dieta Cutting', '2025-12-01', '2026-01-01', 'Perda de gordura'),
(4, 29, 'Dieta', NULL, NULL, '123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dieta_alimento`
--

DROP TABLE IF EXISTS `dieta_alimento`;
CREATE TABLE IF NOT EXISTS `dieta_alimento` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `dieta_id` int DEFAULT NULL,
  `alimento_id` int DEFAULT NULL,
  `quantidade_gramas` int DEFAULT NULL,
  `horario` time DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `dieta_id` (`dieta_id`),
  KEY `alimento_id` (`alimento_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `dieta_alimento`
--

INSERT INTO `dieta_alimento` (`ID`, `dieta_id`, `alimento_id`, `quantidade_gramas`, `horario`) VALUES
(1, 1, 1, 150, '12:00:00'),
(2, 1, 4, 120, '12:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `exercicios`
--

DROP TABLE IF EXISTS `exercicios`;
CREATE TABLE IF NOT EXISTS `exercicios` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nome_exercicio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grupo_muscular` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `exercicios`
--

INSERT INTO `exercicios` (`ID`, `nome_exercicio`, `grupo_muscular`, `descricao`) VALUES
(1, 'Supino Reto', 'Peito', 'Supino na barra no banco reto'),
(2, 'Supino Inclinado', 'Peito', 'Supino inclinado com barra ou halteres'),
(3, 'Crucifixo no Banco Reto', 'Peito', 'Abertura com halteres no banco reto'),
(4, 'Puxada na Barra Frente', 'Costas', 'Puxada com pegada aberta'),
(5, 'Remada Baixa', 'Costas', 'Remada baixa na polia'),
(6, 'Remada Curvada', 'Costas', 'Remada com barra curvada'),
(7, 'Agachamento Livre', 'Pernas', 'Agachamento com barra nas costas'),
(8, 'Leg Press 45º', 'Pernas', 'Leg press inclinado'),
(9, 'Cadeira Extensora', 'Pernas', 'Extensão de quadríceps na máquina'),
(10, 'Mesa Flexora', 'Pernas', 'Flexão de joelhos deitado'),
(11, 'Levantamento Terra', 'Posterior / Costas', 'Levantamento terra convencional'),
(12, 'Desenvolvimento Militar', 'Ombros', 'Desenvolvimento com barra em pé'),
(13, 'Elevação Lateral', 'Ombros', 'Elevação lateral com halteres'),
(14, 'Elevação Frontal', 'Ombros', 'Elevação frontal com halteres'),
(15, 'Rosca Direta', 'Bíceps', 'Rosca direta com barra'),
(16, 'Rosca Alternada', 'Bíceps', 'Rosca alternada com halteres'),
(17, 'Tríceps Testa', 'Tríceps', 'Tríceps francês com barra W'),
(18, 'Tríceps na Polia', 'Tríceps', 'Tríceps na barra ou corda'),
(19, 'Panturrilha em Pé', 'Panturrilha', 'Elevação de panturrilha em pé'),
(20, 'Panturrilha Sentado', 'Panturrilha', 'Elevação de panturrilha sentado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `treinos`
--

DROP TABLE IF EXISTS `treinos`;
CREATE TABLE IF NOT EXISTS `treinos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `usuario_idT` int DEFAULT NULL,
  `nome_treino` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `objetivos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `usuario_idT` (`usuario_idT`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `treinos`
--

INSERT INTO `treinos` (`ID`, `usuario_idT`, `nome_treino`, `data_inicio`, `data_fim`, `objetivos`) VALUES
(2, 29, 'Braco 2', '2025-12-06', NULL, NULL),
(3, 29, 'Pernas', '2025-12-06', '2026-03-06', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `treino_exercicio`
--

DROP TABLE IF EXISTS `treino_exercicio`;
CREATE TABLE IF NOT EXISTS `treino_exercicio` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `treino_id` int DEFAULT NULL,
  `exercicio_id` int DEFAULT NULL,
  `series` int DEFAULT NULL,
  `repeticoes` int DEFAULT NULL,
  `carga_kg` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `treino_id` (`treino_id`),
  KEY `exercicio_id` (`exercicio_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `treino_exercicio`
--

INSERT INTO `treino_exercicio` (`ID`, `treino_id`, `exercicio_id`, `series`, `repeticoes`, `carga_kg`) VALUES
(3, 3, 8, 4, 12, 40.00),
(4, 3, 9, 4, 12, 36.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`ID`, `nome`, `email`, `senha`, `data_nascimento`, `telefone`, `data_cadastro`) VALUES
(29, 'henrique', 'henrique@gmail.com', '$2y$10$Zq6NEIss7H0LXZ/9G9YbkesHJmpqPV3S8YFQJyvwryOUyHnAig1Yy', '2007-07-04', '11987654321', '2025-12-04'),
(32, 'teste', 'teste@gmail.com', '$2y$10$3psOKEU4Ewvlwyumr6E8weFXuWuIXzyQg5z4SXqhGQtf14g5Uw57a', '2008-02-05', '11987654322', '2025-12-08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
