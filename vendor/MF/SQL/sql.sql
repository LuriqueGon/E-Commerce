create database ecommerce;
use ecommerce;

create table users (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(120)NOT NULL,
    `password` VARCHAR(200) NOT NULL,
    perm INT DEFAULT 0,
    ativo BOOLEAN DEFAULT 1,
    perfil VARCHAR(200),
    DataRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    localeMainId INT,
    credit FLOAT(15,2)
)

CREATE TABLE locale (

    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cep VARCHAR(15) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    logadouro VARCHAR(200) NOT NULL,
    rua VARCHAR(20) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    complemento VARCHAR(30) NOT NULL,
    obs TEXT,
    id_user INT NOT NULL,
    FOREIGN KEY(id_user) REFERENCES users(id)
)