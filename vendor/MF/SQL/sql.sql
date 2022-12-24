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
);

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
);

CREATE TABLE categorias(
	cate_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cate_nome VARCHAR(200) NOT NULL,
    cate_slug VARCHAR(60) NOT NULL
);

CREATE TABLE produtos (
    pro_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	pro_categoria INT NOT NULL,
    pro_nome VARCHAR(200) NOT NULL,
    pro_desc TEXT NOT NULL,
    pro_peso FLOAT(8,2) NOT NULL,
    pro_valor FLOAT(8,2) NOT NULL,
    pro_altura INT NOT NULL,
    pro_larguta INT NOT NULL,
    pro_comprimento INT NOT NULL,
    pro_img VARCHAR(200) NOT NULL,
    pro_slug VARCHAR(200) NOT NULL,
    pro_estoque INT NOT NULL,
    pro_modelo VARCHAR(200) NOT NULL,
    pro_ref VARCHAR(20) NOT NULL,
    pro_fabricante INT NOT NULL,
    pro_ativo BOOLEAN NOT NULL DEFAULT 1,
    pro_frete_free VARCHAR(200) NOT NULL,
    FOREIGN KEY(pro_categoria) REFERENCES categorias(cate_id)
);

CREATE TABLE message (
	
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(200) NOT NULL,
    emailSend VARCHAR(200) NOT NULL,
    numberContact VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    protocol VARCHAR(200) NOT NULL UNIQUE,
    sendDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    responseDate TIMESTAMP,
    seen BOOLEAN DEFAULT 0,
    answered BOOLEAN DEFAULT 0,
    replyEmail VARCHAR(200),
    id_user INT NOT NULL
);