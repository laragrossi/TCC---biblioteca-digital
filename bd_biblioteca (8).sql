-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/11/2025 às 19:11
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
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ra` varchar(20) NOT NULL,
  `digito` varchar(5) NOT NULL,
  `ra_completo` varchar(25) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `escola` varchar(100) NOT NULL,
  `serie` varchar(20) DEFAULT NULL,
  `turma` varchar(10) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`id`, `nome`, `ra`, `digito`, `ra_completo`, `senha`, `escola`, `serie`, `turma`, `ativo`, `created_at`) VALUES
(1, 'lara lima ', '11204728', '4', '11204728-4', '$2y$10$I2/wVnW/dEKupB2lkToXA.c8TzPo0IFQw1ANgPd427/SdZedY26Sm', 'Joaquim de moura Candelaria ', NULL, NULL, 1, '2025-11-18 17:40:15'),
(2, 'Giovana Rosa Greco', '110054535', '9', '110054535-9', '$2y$10$l1gNHswIokRr56XfqU.ggO/MnFgRx/2p.CpjZfiV7VOqMVzgBWF5i', 'Joaquim de moura Candelaria ', NULL, NULL, 1, '2025-11-18 17:45:55'),
(4, 'Matheus rosa ', '342789', '7', '342789-7', '$2y$10$L8F6WFUKY1feq8Wf4KzYa.8OcySyDeuR0XX3W8jWexlyjbnWJEwVW', 'Joaquim de Moura Candelária ', NULL, NULL, 1, '2025-11-19 21:46:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `ra_completo` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `serie` varchar(20) NOT NULL,
  `turma` varchar(10) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` int(11) NOT NULL,
  `numero_tombo` varchar(50) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `titulo` varchar(200) NOT NULL,
  `subtitulo` varchar(200) DEFAULT NULL,
  `sinopse` text DEFAULT NULL,
  `autor` varchar(100) NOT NULL,
  `editora` varchar(100) DEFAULT NULL,
  `ano_publicacao` int(11) DEFAULT NULL,
  `numero_paginas` int(11) DEFAULT NULL,
  `idioma` varchar(30) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `area_conhecimento` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `quantidade_total` int(11) DEFAULT 1,
  `quantidade_disponivel` int(11) DEFAULT 1,
  `disponivel` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `numero_tombo`, `isbn`, `titulo`, `subtitulo`, `sinopse`, `autor`, `editora`, `ano_publicacao`, `numero_paginas`, `idioma`, `genero`, `area_conhecimento`, `foto`, `quantidade_total`, `quantidade_disponivel`, `disponivel`, `created_at`) VALUES
(1, '974552233', '232446', 'Perto do coração selvagem ', 'Clarice ', 'Perto do Coração Selvagem é uma obra escrita por Clarice Lispector em 1944. O livro mostra o cotidiano de Joana, menina criada pelo pai, já que a mãe, Elza, morrera muito cedo. O pai passado alguns anos também morre, então ela vai morar com a irmã de seu pai. A tia não gostava de Joana, pois a presença da menina a sufocava e a enviou para um internato, lá ocorre uma paixão avassaladora por seu professor um pouco mais velho. Um ponto culminante que a enviou para o internato foi dias antes acompanhando à tia as compras, como um teste para si mesma e causa espanto aos outros, Joana roubou um livro, trazendo mais dificuldades a sua convivência com a família da tia.\r\n\r\nFora do internato casa-se com Otávio. Joana fica grávida, para a maioria das mulheres a gravidez é uma felicidade, mas para ela não foi assim. Descobre que o marido tem uma amante, Lívia, sua ex-noiva que estava também grávida. Com o tempo ocorre a separação entre Joana e o marido.', 'Clarice Lispector ', 'Brasil ', 1943, 200, 'Português', 'Romance ', 'auto conhecimento ', 'fotos_livros/691e3d8668315_Perto do Coração Selvagem.jpg', 1, 1, 1, '2025-11-19 21:58:30'),
(2, '1234', '7658', 'Como eu era antes de você ', 'Como eu era antes de você ', 'Como eu era antes de você conta a história de Louisa Clark, uma mulher de 26 anos que mora com a sua família em uma cidade na Inglaterra. Para ajudar com as despesas da casa, Lou trabalha em um café da região, mas, posteriormente, acaba perdendo esse emprego.\r\n\r\nPor conta desse acontecimento, Lou decide procurar um novo trabalho em um Centro de Desempregados. Lá, ela encontra apenas um cargo temporário de cuidadora, que contava com uma duração de seis meses. Sem opções, acaba se candidatando para a vaga.\r\n\r\nSeguidamente, a protagonista é convidada para fazer uma entrevista em uma mansão e, por conta da sua energia encantadora, acaba sendo aceita para assumir o cargo. Assim, Lou fica encarregada de cuidar de um homem de 35 anos, Will Traynor, que sofreu um acidente e ficou tetraplégico.', 'Jojo Moyes.', 'moop', 2017, 222, 'Português', 'Romance ', 'auto conhecimento ', 'fotos_livros/691e597cd86e4_Como eu era antes de você.jpg', 1, 1, 1, '2025-11-19 23:57:48');

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
(10, 'Fabricia Gonsavlves ', 'professor@biblioteca.com', 'prof123', 'Joaquim de moura Candelaria ', 'São josé dos campos ');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ra_completo` (`ra_completo`);

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ra_completo` (`ra_completo`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_tombo` (`numero_tombo`);

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
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `IDLogin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
