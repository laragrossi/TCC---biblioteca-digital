-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/10/2025 às 18:07
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
('00087952', NULL, 'Gildarcio Gonçalves     ', '7', '123', 'JMC'),
('1100545345', NULL, 'giovana rosa greco', '9', '12345', 'Jmc'),
('112079475', NULL, 'lara lima grossi', '4', '12345', 'jmc'),
('123', NULL, 'teste', '1', '123', 'jmc'),
('1234', NULL, 'teste', '1', '123', 'jmc'),
('12345', NULL, 'teste', '1', '123', 'jmc'),
('123456', NULL, 'teste', '1', '123', 'jmc'),
('1234567', NULL, 'teste', '1', '123', 'jmc'),
('nnb', NULL, 'nbbv', 'n', 'mnmbh', 'nmbnv'),
('vtry6r', NULL, 'ygyty', 'x', 'sadsa', 'xsa'),
('zzzzzz', NULL, 'iiiiiiiiii', 'a', 'zzzzzzzz', 'aaaaa');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `alunoscompendencias`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `alunoscompendencias` (
);

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
-- Estrutura stand-in para view `devolucoesatrasadas`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `devolucoesatrasadas` (
);

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
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `editora` varchar(100) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `livrosdisponiveis`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `livrosdisponiveis` (
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `livrosemprestados`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `livrosemprestados` (
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `livrosreservados`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `livrosreservados` (
);

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
(4, 'jamilly ramos de brito', 'jamilly98@gmail.com', '0909jamill', 'JMC', 'sao jose dos campos ');

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
-- Estrutura para view `alunoscompendencias`
--
DROP TABLE IF EXISTS `alunoscompendencias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `alunoscompendencias`  AS SELECT DISTINCT `a`.`ra` AS `RA`, `a`.`turma` AS `Turma`, `a`.`DadosPessoais` AS `DadosPessoais` FROM (`aluno` `a` join `emprestimo` `e` on(`a`.`RA` = `e`.`RA_Aluno`)) WHERE `e`.`Status` = 'Atrasado' ;

-- --------------------------------------------------------

--
-- Estrutura para view `devolucoesatrasadas`
--
DROP TABLE IF EXISTS `devolucoesatrasadas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `devolucoesatrasadas`  AS SELECT `e`.`IDEmprestimo` AS `IDEmprestimo`, `l`.`Titulo` AS `Titulo`, `a`.`RA` AS `RA`, `a`.`Turma` AS `Turma`, `e`.`DataDevolucaoPrevista` AS `DataDevolucaoPrevista`, `atr`.`DiasAtraso` AS `DiasAtraso`, `atr`.`Ocorrencia` AS `Ocorrencia` FROM (((`emprestimo` `e` join `livro` `l` on(`e`.`IDLivro` = `l`.`IDLivro`)) join `aluno` `a` on(`e`.`RA_Aluno` = `a`.`RA`)) join `atraso` `atr` on(`e`.`IDEmprestimo` = `atr`.`IDEmprestimo`)) WHERE `e`.`Status` = 'Atrasado' ;

-- --------------------------------------------------------

--
-- Estrutura para view `livrosdisponiveis`
--
DROP TABLE IF EXISTS `livrosdisponiveis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `livrosdisponiveis`  AS SELECT `livro`.`IDLivro` AS `IDLivro`, `livro`.`Titulo` AS `Titulo`, `livro`.`Autor` AS `Autor` FROM `livro` WHERE `livro`.`Status` = 'Disponível' ;

-- --------------------------------------------------------

--
-- Estrutura para view `livrosemprestados`
--
DROP TABLE IF EXISTS `livrosemprestados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `livrosemprestados`  AS SELECT `l`.`IDLivro` AS `IDLivro`, `l`.`Titulo` AS `Titulo`, `e`.`RA_Aluno` AS `RA_Aluno`, `e`.`DataEmprestimo` AS `DataEmprestimo`, `e`.`DataDevolucaoPrevista` AS `DataDevolucaoPrevista` FROM (`livro` `l` join `emprestimo` `e` on(`l`.`IDLivro` = `e`.`IDLivro`)) WHERE `e`.`Status` = 'Ativo' ;

-- --------------------------------------------------------

--
-- Estrutura para view `livrosreservados`
--
DROP TABLE IF EXISTS `livrosreservados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `livrosreservados`  AS SELECT `l`.`IDLivro` AS `IDLivro`, `l`.`Titulo` AS `Titulo`, `r`.`DataReserva` AS `DataReserva`, coalesce(`a`.`RA`,`p`.`IdentificadorProfessor`) AS `Usuario`, CASE WHEN `a`.`RA` is not null THEN 'Aluno' ELSE 'Professor' END AS `TipoUsuario` FROM (((`livro` `l` join `reserva` `r` on(`l`.`IDLivro` = `r`.`IDLivro`)) left join `aluno` `a` on(`r`.`RA_Aluno` = `a`.`RA`)) left join `professor` `p` on(`r`.`IdentificadorProfessor` = `p`.`IdentificadorProfessor`)) WHERE `r`.`Status` = 'Ativa' ;

--
-- Índices para tabelas despejadas
--

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
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT para tabelas despejadas
--

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `IDLogin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `IDReserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atraso`
--
ALTER TABLE `atraso`
  ADD CONSTRAINT `atraso_ibfk_1` FOREIGN KEY (`IDEmprestimo`) REFERENCES `emprestimo` (`IDEmprestimo`);

--
-- Restrições para tabelas `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD CONSTRAINT `emprestimo_ibfk_1` FOREIGN KEY (`RA_Aluno`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `emprestimo_ibfk_2` FOREIGN KEY (`IDLivro`) REFERENCES `livro` (`IDLivro`);

--
-- Restrições para tabelas `historicolivroslidos`
--
ALTER TABLE `historicolivroslidos`
  ADD CONSTRAINT `historicolivroslidos_ibfk_1` FOREIGN KEY (`RA_Aluno`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `historicolivroslidos_ibfk_2` FOREIGN KEY (`IDLivro`) REFERENCES `livro` (`IDLivro`);

--
-- Restrições para tabelas `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`RA_Aluno`) REFERENCES `aluno` (`ra`);

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`RA_Aluno`) REFERENCES `aluno` (`ra`),
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`IDLivro`) REFERENCES `livro` (`IDLivro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; 21/10/25 3432 jamilly
