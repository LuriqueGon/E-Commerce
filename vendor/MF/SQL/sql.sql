create database ecommerce;
use ecommerce;
create table users (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(120)NOT NULL,
    `password` VARCHAR(200) NOT NULL,
    perm INT DEFAULT 0,
    ativo BOOLEAN DEFAULT 1,
    DataRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)