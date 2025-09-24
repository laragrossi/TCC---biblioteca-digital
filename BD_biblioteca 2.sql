-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS BD_biblioteca;
USE BD_biblioteca;

-- Tabela de Aluno
CREATE TABLE Aluno (
    RA VARCHAR(20) PRIMARY KEY,
    Turma VARCHAR(50),
    DadosPessoais TEXT
);

-- Tabela de Professor
CREATE TABLE Professor (
    IdentificadorProfessor VARCHAR(20) PRIMARY KEY,
    DadosPessoais TEXT
);

-- Tabela de Livro
CREATE TABLE Livro (
    IDLivro INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    Autor VARCHAR(255),
    Status ENUM('Disponível', 'Emprestado', 'Reservado') DEFAULT 'Disponível'
);

-- Tabela de Empréstimo
CREATE TABLE Emprestimo (
    IDEmprestimo INT AUTO_INCREMENT PRIMARY KEY,
    RA_Aluno VARCHAR(20),
    IDLivro INT,
    DataEmprestimo DATE NOT NULL,
    DataDevolucaoPrevista DATE NOT NULL,
    DataDevolucaoReal DATE NULL,
    Status ENUM('Ativo', 'Devolvido', 'Atrasado') DEFAULT 'Ativo',
    FOREIGN KEY (RA_Aluno) REFERENCES Aluno(RA),
    FOREIGN KEY (IDLivro) REFERENCES Livro(IDLivro)
);

-- Tabela de Reserva
CREATE TABLE Reserva (
    IDReserva INT AUTO_INCREMENT PRIMARY KEY,
    RA_Aluno VARCHAR(20) NULL,
    IdentificadorProfessor VARCHAR(20) NULL,
    IDLivro INT,
    DataReserva DATE NOT NULL,
    Status ENUM('Ativa', 'Cancelada', 'Concluída') DEFAULT 'Ativa',
    FOREIGN KEY (RA_Aluno) REFERENCES Aluno(RA),
    FOREIGN KEY (IdentificadorProfessor) REFERENCES Professor(IdentificadorProfessor),
    FOREIGN KEY (IDLivro) REFERENCES Livro(IDLivro)
);

-- Tabela de Atraso 
CREATE TABLE Atraso (
    IDAtraso INT AUTO_INCREMENT PRIMARY KEY,
    IDEmprestimo INT,
    DiasAtraso INT NOT NULL,
    Ocorrencia TEXT, -- Campo para registrar a ocorrência do atraso
    FOREIGN KEY (IDEmprestimo) REFERENCES Emprestimo(IDEmprestimo)
);

-- Tabela de Histórico de Livros Lidos
CREATE TABLE HistoricoLivrosLidos (
    IDHistorico INT AUTO_INCREMENT PRIMARY KEY,
    RA_Aluno VARCHAR(20),
    IDLivro INT,
    DataLeitura DATE,
    FOREIGN KEY (RA_Aluno) REFERENCES Aluno(RA),
    FOREIGN KEY (IDLivro) REFERENCES Livro(IDLivro)
);

-- Tabela de Login (controle de acesso)
CREATE TABLE Login (
    IDLogin INT AUTO_INCREMENT PRIMARY KEY,
    RA_Aluno VARCHAR(20) NULL,
    IdentificadorProfessor VARCHAR(20) NULL,
    Senha VARCHAR(255) NOT NULL,
    TipoUsuario ENUM('Aluno', 'Professor') NOT NULL,
    FOREIGN KEY (RA_Aluno) REFERENCES Aluno(RA),
    FOREIGN KEY (IdentificadorProfessor) REFERENCES Professor(IdentificadorProfessor)
);

-- Índices para melhor performance
CREATE INDEX idx_emprestimo_livro ON Emprestimo(IDLivro);
CREATE INDEX idx_emprestimo_aluno ON Emprestimo(RA_Aluno);
CREATE INDEX idx_reserva_livro ON Reserva(IDLivro);
CREATE INDEX idx_reserva_aluno ON Reserva(RA_Aluno);
CREATE INDEX idx_reserva_professor ON Reserva(IdentificadorProfessor);
CREATE INDEX idx_historico_aluno ON HistoricoLivrosLidos(RA_Aluno);

-- Trigger para atualizar status do livro ao ser emprestado
DELIMITER //
CREATE TRIGGER after_emprestimo_insert
AFTER INSERT ON Emprestimo
FOR EACH ROW
BEGIN
    UPDATE Livro SET Status = 'Emprestado' WHERE IDLivro = NEW.IDLivro;
END;//
DELIMITER ;

-- Trigger para atualizar status do livro ao ser devolvido
DELIMITER //
CREATE TRIGGER after_emprestimo_update
AFTER UPDATE ON Emprestimo
FOR EACH ROW
BEGIN
    IF NEW.Status = 'Devolvido' THEN
        UPDATE Livro SET Status = 'Disponível' WHERE IDLivro = NEW.IDLivro;
    END IF;
END;//
DELIMITER ;

-- Trigger para atualizar status do livro quando reservado
DELIMITER //
CREATE TRIGGER after_reserva_insert
AFTER INSERT ON Reserva
FOR EACH ROW
BEGIN
    UPDATE Livro SET Status = 'Reservado' WHERE IDLivro = NEW.IDLivro;
END;//
DELIMITER ;

-- View para listar livros disponíveis
CREATE VIEW LivrosDisponiveis AS
SELECT IDLivro, Titulo, Autor
FROM Livro
WHERE Status = 'Disponível';

-- View para listar alunos com pendências
CREATE VIEW AlunosComPendencias AS
SELECT DISTINCT A.RA, A.Turma, A.DadosPessoais
FROM Aluno A
INNER JOIN Emprestimo E ON A.RA = E.RA_Aluno
WHERE E.Status = 'Atrasado';

-- View para livros reservados
CREATE VIEW LivrosReservados AS
SELECT L.IDLivro, L.Titulo, R.DataReserva,
       COALESCE(A.RA, P.IdentificadorProfessor) AS Usuario,
       CASE
           WHEN A.RA IS NOT NULL THEN 'Aluno'
           ELSE 'Professor'
       END AS TipoUsuario
FROM Livro L
INNER JOIN Reserva R ON L.IDLivro = R.IDLivro
LEFT JOIN Aluno A ON R.RA_Aluno = A.RA
LEFT JOIN Professor P ON R.IdentificadorProfessor = P.IdentificadorProfessor
WHERE R.Status = 'Ativa';

-- View para livros emprestados no momento
CREATE VIEW LivrosEmprestados AS
SELECT L.IDLivro, L.Titulo, E.RA_Aluno, E.DataEmprestimo, E.DataDevolucaoPrevista
FROM Livro L
INNER JOIN Emprestimo E ON L.IDLivro = E.IDLivro
WHERE E.Status = 'Ativo';

-- View para devoluções atrasadas (agora com Ocorrencia)
CREATE VIEW DevolucoesAtrasadas AS
SELECT E.IDEmprestimo, L.Titulo, A.RA, A.Turma,
       E.DataDevolucaoPrevista, ATR.DiasAtraso, ATR.Ocorrencia
FROM Emprestimo E
INNER JOIN Livro L ON E.IDLivro = L.IDLivro
INNER JOIN Aluno A ON E.RA_Aluno = A.RA
INNER JOIN Atraso ATR ON E.IDEmprestimo = ATR.IDEmprestimo
WHERE E.Status = 'Atrasado';