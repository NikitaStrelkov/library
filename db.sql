DROP DATABASE IF EXISTS `library`;
CREATE DATABASE `library`;
USE `library`;
CREATE TABLE books (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title TEXT,
  author TEXT,
  numberOfPages INT,
  owner INT NULL
)  ENGINE=InnoDB CHARACTER SET=UTF8;
INSERT INTO `books` SET `title`='Adventure time', `author`='Ivan', `numberOfPages`='1', owner='1';
INSERT INTO `books` SET `title`='Lets find some treasures', `author`='Andrey', `numberOfPages`='233', owner='1';
INSERT INTO `books` SET `title`='It', `author`='Stephen King', `numberOfPages`='251';
INSERT INTO `books` SET `title`='Onegin', `author`='Alexander Pushkin', `numberOfPages`='43', owner='2';
CREATE TABLE owners (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name TEXT,
  lastName TEXT,
  job TEXT
)  ENGINE=InnoDB CHARACTER SET=UTF8;

INSERT INTO `owners` SET `name`='Nikita', `lastName`='Strelkov', `job`='president';
INSERT INTO `owners` SET `name`='Ivan', `lastName`='Ivanov', `job`='king';
