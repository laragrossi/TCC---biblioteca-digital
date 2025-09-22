-- Remove o banco de dados se ele já existir para evitar erros
DROP DATABASE IF EXISTS BD_Biblioteca;

-- Cria o banco de dados BD_Biblioteca
CREATE DATABASE BD_Biblioteca;
USE BD_Biblioteca;

-- Cria a tabela para Departamentos
CREATE TABLE Departments (
    department_code INT PRIMARY KEY,
    department_name VARCHAR(255) NOT NULL,
    head_employee_code INT
);

-- Cria a tabela para Funcionários
CREATE TABLE Employees (
    employee_code INT PRIMARY KEY,
    employee_name VARCHAR(255) NOT NULL,
    start_date DATE,
    department_code INT,
    FOREIGN KEY (department_code) REFERENCES Departments(department_code)
);

-- Adiciona a chave estrangeira para o chefe do departamento
ALTER TABLE Departments
ADD FOREIGN KEY (head_employee_code) REFERENCES Employees(employee_code);

-- Cria a tabela para Editoras
CREATE TABLE Publishers (
    publisher_code INT PRIMARY KEY,
    publisher_name VARCHAR(255) NOT NULL,
    city VARCHAR(255)
);

-- Cria a tabela para Obras (livros, periódicos)
CREATE TABLE Works (
    work_code INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    publication_year INT,
    status ENUM('available', 'borrowed') NOT NULL,
    publisher_code INT,
    FOREIGN KEY (publisher_code) REFERENCES Publishers(publisher_code)
);

-- Cria a tabela para Usuários
CREATE TABLE Users (
    user_code INT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    birth_date DATE
);

-- Cria a tabela para Empréstimos
CREATE TABLE Loans (
    loan_id INT PRIMARY KEY AUTO_INCREMENT,
    loan_date_time DATETIME NOT NULL,
    return_date_time DATETIME,
    user_code INT,
    employee_code INT,
    FOREIGN KEY (user_code) REFERENCES Users(user_code),
    FOREIGN KEY (employee_code) REFERENCES Employees(employee_code)
);

-- Cria a tabela de junção para os itens de um empréstimo
CREATE TABLE Loan_Works (
    loan_id INT,
    work_code INT,
    PRIMARY KEY (loan_id, work_code),
    FOREIGN KEY (loan_id) REFERENCES Loans(loan_id),
    FOREIGN KEY (work_code) REFERENCES Works(work_code)
);

-- Cria a tabela para Reservas
CREATE TABLE Reservations (
    reservation_id INT PRIMARY KEY AUTO_INCREMENT,
    reservation_date_time DATETIME NOT NULL,
    withdrawal_date DATETIME,
    user_code INT,
    work_code INT,
    employee_code INT,
    FOREIGN KEY (user_code) REFERENCES Users(user_code),
    FOREIGN KEY (work_code) REFERENCES Works(work_code),
    FOREIGN KEY (employee_code) REFERENCES Employees(employee_code)
);