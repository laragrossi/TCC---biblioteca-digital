-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/10/2025 às 18:40
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`id`, `email`, `senha`) VALUES
(1, 'admin@biblioteca.com', '12345');

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `ra` varchar(20) NOT NULL,
  `turma` varchar(50) DEFAULT NULL,
  `nome` varchar(256) NOT NULL,
  `digito` char(1) NOT NULL,
  `senha` varchar(10) NOT NULL,
  `escola` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`ra`, `turma`, `nome`, `digito`, `senha`, `escola`) VALUES
('00011006565', NULL, 'amanda ', '3', '1234', 'joaquim de moura candelaria '),
('00087952', NULL, 'Gildarcio Gonçalves     ', '7', '123', 'JMC'),
('0009887', NULL, 'daiane', '7', 'dejwfhy', 'joaquim de moura candelaria '),
('009898', NULL, 'lara', '4', '1234567', 'joaquim de moura candelaria '),
('1100545345', NULL, 'giovana rosa greco', '9', '12345', 'Jmc'),
('110961736', NULL, 'daiane Karine ', '7', '898989', 'joaquim de moura candelaria '),
('112079475', NULL, 'lara lima grossi', '4', '12345', 'jmc'),
('123', NULL, 'teste', '1', '123', 'jmc'),
('1234', NULL, 'teste', '1', '123', 'jmc'),
('12345', NULL, 'teste', '1', '123', 'jmc'),
('123456', NULL, 'teste', '1', '123', 'jmc'),
('1234567', NULL, 'teste', '1', '123', 'jmc'),
('239897', NULL, 'Jamilly', '2', 'Jmc1234@', 'joaquim de moura candelaria '),
('ehfrbvrt', NULL, 'wjdhjew', '0', 'efwr', 'regfr'),
('escola ', NULL, 'pequeno principe ', 'j', '2007', ''),
('nnb', NULL, 'nbbv', 'n', 'mnmbh', 'nmbnv'),
('vtry6r', NULL, 'ygyty', 'x', 'sadsa', 'xsa'),
('zzzzzz', NULL, 'iiiiiiiiii', 'a', 'zzzzzzzz', 'aaaaa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `atraso`
--

CREATE TABLE `atraso` (
  `IDAtraso` int(11) NOT NULL,
  `IDEmprestimo` int(11) DEFAULT NULL,
  `DiasAtraso` int(11) NOT NULL,
  `Ocorrencia` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `emprestimo`
--

CREATE TABLE `emprestimo` (
  `IDEmprestimo` int(11) NOT NULL,
  `RA_Aluno` varchar(20) DEFAULT NULL,
  `IDLivro` int(11) DEFAULT NULL,
  `DataEmprestimo` date NOT NULL,
  `DataDevolucaoPrevista` date NOT NULL,
  `DataDevolucaoReal` date DEFAULT NULL,
  `Status` enum('Ativo','Devolvido','Atrasado') DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Acionadores `emprestimo`
--
DELIMITER $$
CREATE TRIGGER `after_emprestimo_insert` AFTER INSERT ON `emprestimo` FOR EACH ROW BEGIN
    UPDATE Livro SET Status = 'Emprestado' WHERE IDLivro = NEW.IDLivro;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_emprestimo_update` AFTER UPDATE ON `emprestimo` FOR EACH ROW BEGIN
    IF NEW.Status = 'Devolvido' THEN
        UPDATE Livro SET Status = 'Disponível' WHERE IDLivro = NEW.IDLivro;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historicolivroslidos`
--

CREATE TABLE `historicolivroslidos` (
  `IDHistorico` int(11) NOT NULL,
  `RA_Aluno` varchar(20) DEFAULT NULL,
  `IDLivro` int(11) DEFAULT NULL,
  `DataLeitura` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `numero_tombo` int(11) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `autor` varchar(255) NOT NULL,
  `editora` varchar(255) NOT NULL,
  `ano_publicacao` int(11) DEFAULT NULL,
  `numero_paginas` int(11) DEFAULT NULL,
  `idioma` varchar(50) DEFAULT 'Português',
  `genero` varchar(100) DEFAULT NULL,
  `area_conhecimento` varchar(100) DEFAULT NULL,
  `subtitulo` varchar(500) DEFAULT NULL,
  `sinopse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `login`
--

CREATE TABLE `login` (
  `IDLogin` int(11) NOT NULL,
  `RA_Aluno` varchar(20) DEFAULT NULL,
  `IdentificadorProfessor` varchar(20) DEFAULT NULL,
  `Senha` varchar(255) NOT NULL,
  `TipoUsuario` enum('Aluno','Professor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

CREATE TABLE `professor` (
  `id` int(20) NOT NULL,
  `nome` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `senha` varchar(10) NOT NULL,
  `escola` varchar(256) NOT NULL,
  `cidade` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`id`, `nome`, `email`, `senha`, `escola`, `cidade`) VALUES
(1, 'teste', 'a@a.a', '123', 'jmc', 'sjc'),
(2, 'teste', 'a@a.a', '123', 'jmc', 'sjc'),
(3, 'Lara Lima Grossi', 'laratecaher@mail.com', 'larinha123', 'jmc', 'Sao jose dos campos '),
(4, 'jamilly ramos de brito', 'jamilly98@gmail.com', '0909jamill', 'JMC', 'sao jose dos campos '),
(5, 'rgyt', 'ewfgtr', 'ewrgfr', 'ewfr', 'ewrgftr'),
(6, 'giovana rosa greco', 'giovana@oi', '1234', 'joaquim de moura candelaria ', 'sjc'),
(7, 'jh', 'jhyu', 'jhyg', 'jhhyf', 'jhyt'),
(8, 'hbhgft', 'thry', 'y53yu', '54u', '5y4uw'),
(9, 'lara lima grossi', 'lara@lima', '$2y$10$7q1', 'jmc', 'São josé dos campos ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

CREATE TABLE `reserva` (
  `IDReserva` int(11) NOT NULL,
  `RA_Aluno` varchar(20) DEFAULT NULL,
  `IdentificadorProfessor` varchar(20) DEFAULT NULL,
  `IDLivro` int(11) DEFAULT NULL,
  `DataReserva` date NOT NULL,
  `Status` enum('Ativa','Cancelada','Concluída') DEFAULT 'Ativa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Acionadores `reserva`
--
DELIMITER $$
CREATE TRIGGER `after_reserva_insert` AFTER INSERT ON `reserva` FOR EACH ROW BEGIN
    UPDATE Livro SET Status = 'Reservado' WHERE IDLivro = NEW.IDLivro;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `reservation_date_time` datetime NOT NULL,
  `withdrawal_date` datetime DEFAULT NULL,
  `user_code` int(11) DEFAULT NULL,
  `work_code` int(11) DEFAULT NULL,
  `employee_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`ra`);

--
-- Índices de tabela `atraso`
--
ALTER TABLE `atraso`
  ADD PRIMARY KEY (`IDAtraso`),
  ADD KEY `IDEmprestimo` (`IDEmprestimo`);

--
-- Índices de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD PRIMARY KEY (`IDEmprestimo`),
  ADD KEY `idx_emprestimo_livro` (`IDLivro`),
  ADD KEY `idx_emprestimo_aluno` (`RA_Aluno`);

--
-- Índices de tabela `historicolivroslidos`
--
ALTER TABLE `historicolivroslidos`
  ADD PRIMARY KEY (`IDHistorico`),
  ADD KEY `IDLivro` (`IDLivro`),
  ADD KEY `idx_historico_aluno` (`RA_Aluno`);

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`numero_tombo`);

--
-- Índices de tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`IDLogin`),
  ADD KEY `RA_Aluno` (`RA_Aluno`);

--
-- Índices de tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`IDReserva`),
  ADD KEY `idx_reserva_livro` (`IDLivro`),
  ADD KEY `idx_reserva_aluno` (`RA_Aluno`);

--
-- Índices de tabela `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_code` (`user_code`),
  ADD KEY `work_code` (`work_code`),
  ADD KEY `employee_code` (`employee_code`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `atraso`
--
ALTER TABLE `atraso`
  MODIFY `IDAtraso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `IDEmprestimo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historicolivroslidos`
--
ALTER TABLE `historicolivroslidos`
  MODIFY `IDHistorico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `numero_tombo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `IDLogin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `IDReserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atraso`
--
ALTER TABLE `atraso`
  ADD CONSTRAINT `atraso_ibfk_1` FOREIGN KEY (`IDEmprestimo`) REFERENCES `emprestimo` (`IDEmprestimo`);

--
-- Restrições para tabelas `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_code`) REFERENCES `users` (`user_code`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`work_code`) REFERENCES `works` (`work_code`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`employee_code`) REFERENCES `employees` (`employee_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
