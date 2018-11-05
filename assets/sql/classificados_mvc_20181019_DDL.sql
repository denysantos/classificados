/* 
*  DB Script Tool
*  MySQL - 2018-10-19 22:52:24
*  
*/ 
CREATE DATABASE IF NOT EXISTS `classificados_mvc`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE `classificados_mvc`;



/* 
*  usuarios
*  2018-10-19 00:15:40
*/ 
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `senha` VARCHAR(32) COLLATE utf8_general_ci NOT NULL,
    `email` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `telefone` VARCHAR(30) COLLATE utf8_general_ci,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;



/* 
*  categoria
*  2018-10-19 00:15:50
*/ 
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;



/* 
*  anuncios
*  2018-10-19 00:15:57
*/ 
DROP TABLE IF EXISTS `anuncios`;
CREATE TABLE IF NOT EXISTS `anuncios` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_usuario` INTEGER(10),
    `id_categoria` INTEGER(10),
    `titulo` VARCHAR(100) COLLATE utf8_general_ci,
    `descricao` TEXT(10),
    `valor` NUMERIC(10,0),
    `estado` INTEGER(10),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;




ALTER TABLE `anuncios` ADD  CONSTRAINT fk_anuncioUsuario FOREIGN KEY (`id_usuario`) REFERENCES usuarios(`id`);
ALTER TABLE `anuncios` ADD  CONSTRAINT fk_anuncioCategoria FOREIGN KEY (`id_categoria`) REFERENCES categoria(`id`);