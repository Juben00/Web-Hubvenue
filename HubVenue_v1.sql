CREATE DATABASE hub_venue;

USE hub_venue;

CREATE TABLE gender_sub (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);

INSERT INTO gender_sub (name) VALUES ('Male'), ('Female'), ('Other');

CREATE TABLE user_types_sub (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);

INSERT INTO user_types_sub (name) VALUES ('Host'), ('Guest');

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    middlename VARCHAR(50),
    gender_id INT NOT NULL,
    user_type_id INT NOT NULL,
    birthdate DATE NOT NULL,
    contact_number VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (gender_id) REFERENCES gender_sub(id),
    FOREIGN KEY (user_type_id) REFERENCES user_types_sub(id)
);
