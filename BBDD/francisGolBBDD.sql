-- MySQL Script generated by MySQL Workbench
-- Thu Apr 25 19:17:51 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema francisGol
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema francisGol
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `francisGol` DEFAULT CHARACTER SET utf8 ;
USE `francisGol` ;

-- -----------------------------------------------------
-- Table `francisGol`.`equipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisGol`.`equipo` (
  `idEquipo` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `escudo` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`idEquipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisGol`.`competicion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisGol`.`competicion` (
  `idCompeticion` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `logo` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`idCompeticion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisGol`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisGol`.`usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(200) NOT NULL,
  `nombre` VARCHAR(40) NOT NULL,
  `contrasenia` VARCHAR(500) NOT NULL,
  `foto` LONGBLOB NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisGol`.`plantilla`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisGol`.`plantilla` (
  `idPlantilla` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(200) NOT NULL,
  `anio` YEAR NOT NULL,
  `formacion` VARCHAR(45) NOT NULL,
  `idEquipo` INT NOT NULL,
  `escudo` VARCHAR(500) NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idPlantilla`),
  INDEX `fk_plantilla_usuario1_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_plantilla_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `francisGol`.`usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisGol`.`jugador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisGol`.`jugador` (
  `idJugador` INT NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `foto` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`idJugador`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisGol`.`equipoFavorito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisGol`.`equipoFavorito` (
  `idEquipo` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idEquipo`, `idUsuario`),
  INDEX `fk_equipo_has_usuario_usuario1_idx` (`idUsuario` ASC) ,
  INDEX `fk_equipo_has_usuario_equipo_idx` (`idEquipo` ASC) ,
  CONSTRAINT `fk_equipo_has_usuario_equipo`
    FOREIGN KEY (`idEquipo`)
    REFERENCES `francisGol`.`equipo` (`idEquipo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_equipo_has_usuario_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `francisGol`.`usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisGol`.`competicionFavorita`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisGol`.`competicionFavorita` (
  `idUsuario` INT NOT NULL,
  `idCompeticion` INT NOT NULL,
  PRIMARY KEY (`idUsuario`, `idCompeticion`),
  INDEX `fk_usuario_has_competicion_competicion1_idx` (`idCompeticion` ASC) ,
  INDEX `fk_usuario_has_competicion_usuario1_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_usuario_has_competicion_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `francisGol`.`usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_has_competicion_competicion1`
    FOREIGN KEY (`idCompeticion`)
    REFERENCES `francisGol`.`competicion` (`idCompeticion`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisGol`.`plantillaJugador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisGol`.`plantillaJugador` (
  `idPlantilla` INT NOT NULL,
  `idJugador` INT NOT NULL,
  `posicion` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`idPlantilla`, `idJugador`),
  INDEX `fk_plantilla_has_jugador_jugador1_idx` (`idJugador` ASC) ,
  INDEX `fk_plantilla_has_jugador_plantilla1_idx` (`idPlantilla` ASC) ,
  CONSTRAINT `fk_plantilla_has_jugador_plantilla1`
    FOREIGN KEY (`idPlantilla`)
    REFERENCES `francisGol`.`plantilla` (`idPlantilla`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_plantilla_has_jugador_jugador1`
    FOREIGN KEY (`idJugador`)
    REFERENCES `francisGol`.`jugador` (`idJugador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;