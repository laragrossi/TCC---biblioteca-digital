-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2025 às 01:39
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
  `serie` enum('1º Ano','2º Ano','3º Ano') DEFAULT NULL,
  `turma` enum('A','B','C','D') DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`id`, `nome`, `ra`, `digito`, `ra_completo`, `senha`, `escola`, `serie`, `turma`, `ativo`, `created_at`) VALUES
(1, 'lara lima ', '11204728', '4', '11204728-4', '$2y$10$I2/wVnW/dEKupB2lkToXA.c8TzPo0IFQw1ANgPd427/SdZedY26Sm', 'Joaquim de moura Candelaria ', NULL, NULL, 1, '2025-11-18 17:40:15'),
(5, 'Matheus Rosa Greco ', '22009876', '6', '22009876-6', '$2y$10$/Cvfj0mTqgyCnL.K/SvvveccgBfHA1RH4GORhBhqSAXwJpBUr6/NK', 'Joaquim de moura Candelaria ', NULL, NULL, 1, '2025-11-24 17:01:57'),
(6, 'Giovana Rosa Greco', '110054535', '9', '110054535-9', '$2y$10$dTgQZlWH36Cd7VrAp6SLN.2QOZ6Je5Z7mOHgbdNDd0y.1s4eCJB5i', 'Joaquim de moura Candelaria ', NULL, NULL, 1, '2025-11-24 18:44:31');

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
-- Despejando dados para a tabela `emprestimo`
--

INSERT INTO `emprestimo` (`IDEmprestimo`, `RA_Aluno`, `IDLivro`, `DataEmprestimo`, `DataDevolucaoPrevista`, `DataDevolucaoReal`, `Status`) VALUES
(6, '22009876-6', 2, '2025-11-24', '2025-12-09', NULL, 'Ativo'),
(7, '22009876-6', 1, '2025-11-24', '2025-12-09', NULL, 'Ativo'),
(8, '22009876-6', 5, '2025-11-24', '2025-12-09', NULL, 'Ativo');

--
-- Acionadores `emprestimo`
--
DELIMITER $$
CREATE TRIGGER `after_emprestimo_insert` AFTER INSERT ON `emprestimo` FOR EACH ROW BEGIN
    UPDATE livros SET quantidade_disponivel = quantidade_disponivel - 1 
    WHERE id = NEW.IDLivro;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_emprestimo_update` AFTER UPDATE ON `emprestimo` FOR EACH ROW BEGIN
    IF NEW.Status = 'Devolvido' THEN
        UPDATE livros SET quantidade_disponivel = quantidade_disponivel + 1 
        WHERE id = NEW.IDLivro;
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
(1, '090908', '8787', 'Como eu era Antes de você ', 'Como eu era antes', '\"Como Eu Era Antes de Você\" é um romance da autora Jojo Moyes sobre a relação entre Louisa Clark, uma jovem que perde o emprego e se torna cuidadora, e Will Traynor, um homem rico e ativo que ficou tetraplégico após um acidente de moto. O livro explora temas como deficiência, qualidade de vida e o direito à eutanásia, provocando reflexões sobre o que torna a vida digna de ser vivida, com a narrativa focando em como a chegada de Lou muda a perspectiva de Will e, por sua vez, a dele para Lou. ', ' Jojo Moyes ', ' Intrínseca        ', 2017, 322, 'Português ', 'Romance ', 'Romance ', 'fotos_livros/691df7f56a6a7_691df5811d1ce_Como eu era antes de você.jpg', 1, -1, 1, '2025-11-19 17:01:41'),
(2, '65432322', '2231', 'O cortiço ', 'O cortiço ', '\"O Cortiço\" é um romance naturalista de Aluísio Azevedo que retrata a vida em uma habitação coletiva no Rio de Janeiro do final do século XIX, mostrando a influência do meio, da raça e do momento histórico sobre os moradores. A trama acompanha a ascensão do imigrante português João Romão e o ambiente degradado e promíscuo do cortiço, que se torna um personagem vivo e pulsante, palco de paixões, brigas e a luta pela sobrevivência', 'Aluísio Azevedo ', 'Melhoramentos ', 1890, 354, 'Português ', 'Romance naturalista', 'Literatura ', 'fotos_livros/692496b9dfc5d_o_cortiço_2.jpg', 1, -1, 1, '2025-11-24 17:32:41'),
(3, '55676', '09864', 'Dom Casmurro', 'Dom Casmurro', 'A história foca em sua infância e no seu grande amor por Capitolina, a Capitu. Eles crescem juntos, mas a mãe de Bentinho, Dona Glória, havia feito uma promessa a Deus: se engravidasse de um filho homem, ele seria padre. Com a ajuda do agregado da família, José Dias, e de seu amigo Escobar, Bentinho consegue se livrar do destino sacerdotal, casa-se com Capitu e forma-se em Direito. O casal tem um filho, Ezequiel. No entanto, a felicidade conjugal é abalada pelo ciúme doentio de Bentinho, que começa a suspeitar que Capitu o trai com seu melhor amigo, Escobar, principalmente devido à semelhança física entre Ezequiel e o amigo falecido. A narrativa, enviesada pelo ponto de vista de Bentinho, deixa a dúvida da traição em aberto, sendo o grande enigma da literatura brasileira. ', 'Machado de Assis', 'Nemo', 1899, 230, 'Português ', ' Romance, Narrativa longa em prosa.', 'Realismo', 'fotos_livros/69249aafe96c2_dom_casmurro.webp', 1, 1, 1, '2025-11-24 17:49:35'),
(4, '64455374', '8324', 'O alienista', 'O alienista', '\"O Alienista\" é uma novela de Machado de Assis que narra a história do Dr. Simão Bacamarte, um médico renomado que retorna à cidade de Itaguaí para estudar a loucura, construindo um hospício chamado Casa Verde. Inicialmente, ele interna pessoas com desvios claros de comportamento, mas, com o tempo, amplia seus critérios para incluir até mesmo pessoas que agem de forma \"perfeitamente normal\" ou que têm dúvidas. A trama se torna irônica e crítica, culminando na auto-conclusão de Bacamarte de que ele próprio é o único louco, levando-o a se trancar na Casa Verde, onde morre 17 meses depois.', 'Machado de Assis', 'Sabedoria portatil ', 1882, 100, 'Português ', 'Conto longo', 'literatura brasileira', 'fotos_livros/69249bbe70338_o_alienista.jpg', 1, 1, 1, '2025-11-24 17:54:06'),
(5, '9887545', '86532', 'O pequeno Príncipe ', 'O pequeno Príncipe ', 'Um piloto de avião cai no deserto do Saara e lá encontra um pequeno príncipe vindo de um asteroide distante (o B-612). Enquanto o piloto tenta consertar seu avião, o príncipe compartilha histórias de sua viagem por vários planetas, cada um habitado por um adulto solitário e com falhas (um rei, um vaidoso, um bêbado, um homem de negócios, um acendedor de lampiões e um geógrafo). Através dessas narrativas e de suas interações na Terra (especialmente com uma raposa e uma rosa), o livro explora temas profundos como a solidão, a amizade, o amor, a perda e o sentido da vida, criticando a superficialidade do mundo adulto. A mensagem central é que \"o essencial é invisível aos olhos\". ', 'Antoine de Saint-Exupéry. ', 'Agir ', 1943, 117, 'Português ', ' fábula', 'literatura infantojuvenil', 'fotos_livros/69249cbfb4022_O-pequeno-príncipe.jpg', 1, -1, 1, '2025-11-24 17:58:23'),
(6, '4575e6', '326457', 'Perto do coração selvagem', 'Perto do coração selvagem ', '\"Perto do Coração Selvagem\" é o romance de estreia de Clarice Lispector que acompanha a vida da protagonista Joana, desde a infância até a vida adulta, através de um fluxo de consciência que mistura passado e presente. O livro explora a complexidade de se entender como indivíduo, especialmente como mulher, em busca de autoconhecimento, questionando a si mesma e as convenções sociais. A narrativa se aprofunda na geografia interior de Joana, marcada por uma inquietude existencial e uma necessidade de encontrar um sentido para a vida que vai além do cotidiano. ', 'Clarice Lispector ', 'Grupo Rocco', 1943, 208, 'Português ', 'Ficção', 'Literatura', 'fotos_livros/6924ae05bfc88_perto-coracao-selvagem-clarice-lispector_large.webp', 1, 1, 1, '2025-11-24 19:12:05');

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
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `escola` varchar(100) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`id`, `nome`, `email`, `senha`, `escola`, `cidade`, `ativo`, `created_at`) VALUES
(1, 'Fabricia Gonsavlves', 'professor@biblioteca.com', '12345', 'Joaquim de moura Candelaria', 'São josé dos campos', 1, '2025-11-24 16:44:28');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT de tabela `atraso`
--
ALTER TABLE `atraso`
  MODIFY `IDAtraso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `IDEmprestimo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `historicolivroslidos`
--
ALTER TABLE `historicolivroslidos`
  MODIFY `IDHistorico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `IDLogin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
