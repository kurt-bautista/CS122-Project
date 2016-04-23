DROP DATABASE IF EXISTS realpagetest;

CREATE DATABASE realpagetest;
USE realpagetest;

CREATE TABLE login (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	remaining_leaves INT NOT NULL
);

INSERT INTO login (username,password,first_name,last_name,remaining_leaves) VALUES (
    'antonsuba', '420blazeit', 'Anton', 'Suba', 69
);