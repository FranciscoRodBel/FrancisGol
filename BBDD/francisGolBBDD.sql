SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema francisgol
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema francisgol
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `francisgol` DEFAULT CHARACTER SET utf8 ;
USE `francisgol` ;

-- -----------------------------------------------------
-- Table `francisgol`.`equipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisgol`.`equipo` (
  `idEquipo` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `escudo` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`idEquipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisgol`.`competicion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisgol`.`competicion` (
  `idCompeticion` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `logo` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`idCompeticion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisgol`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisgol`.`usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(150) NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `contrasenia` VARCHAR(250) NOT NULL,
  `foto` LONGBLOB NOT NULL,
  `cookies` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisgol`.`plantilla`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisgol`.`plantilla` (
  `idPlantilla` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(200) NOT NULL,
  `anio` YEAR NOT NULL,
  `formacion` VARCHAR(45) NOT NULL,
  `datosPlantilla` JSON NOT NULL,
  `idUsuario` INT NOT NULL,
  `idEquipo` INT NOT NULL,
  PRIMARY KEY (`idPlantilla`),
  INDEX `fk_plantilla_usuario1_idx` (`idUsuario` ASC),
  INDEX `fk_plantilla_equipo1_idx` (`idEquipo` ASC),
  CONSTRAINT `fk_plantilla_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `francisgol`.`usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_plantilla_equipo1`
    FOREIGN KEY (`idEquipo`)
    REFERENCES `francisgol`.`equipo` (`idEquipo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisgol`.`jugador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisgol`.`jugador` (
  `idJugador` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `foto` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`idJugador`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisgol`.`equipo_favorito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisgol`.`equipo_favorito` (
  `idEquipo` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  PRIMARY KEY (`idEquipo`, `idUsuario`),
  INDEX `fk_equipo_has_usuario_usuario1_idx` (`idUsuario` ASC),
  INDEX `fk_equipo_has_usuario_equipo_idx` (`idEquipo` ASC),
  CONSTRAINT `fk_equipo_has_usuario_equipo`
    FOREIGN KEY (`idEquipo`)
    REFERENCES `francisgol`.`equipo` (`idEquipo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_equipo_has_usuario_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `francisgol`.`usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisgol`.`competicion_favorita`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisgol`.`competicion_favorita` (
  `idUsuario` INT NOT NULL,
  `idCompeticion` INT NOT NULL,
  PRIMARY KEY (`idUsuario`, `idCompeticion`),
  INDEX `fk_usuario_has_competicion_competicion1_idx` (`idCompeticion` ASC),
  INDEX `fk_usuario_has_competicion_usuario1_idx` (`idUsuario` ASC),
  CONSTRAINT `fk_usuario_has_competicion_usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `francisgol`.`usuario` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_has_competicion_competicion1`
    FOREIGN KEY (`idCompeticion`)
    REFERENCES `francisgol`.`competicion` (`idCompeticion`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `francisgol`.`plantilla_jugador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `francisgol`.`plantilla_jugador` (
  `idPlantilla` INT NOT NULL,
  `idJugador` INT NOT NULL,
  `posicion` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`idPlantilla`, `idJugador`),
  INDEX `fk_plantilla_has_jugador_jugador1_idx` (`idJugador` ASC),
  INDEX `fk_plantilla_has_jugador_plantilla1_idx` (`idPlantilla` ASC),
  CONSTRAINT `fk_plantilla_has_jugador_plantilla1`
    FOREIGN KEY (`idPlantilla`)
    REFERENCES `francisgol`.`plantilla` (`idPlantilla`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_plantilla_has_jugador_jugador1`
    FOREIGN KEY (`idJugador`)
    REFERENCES `francisgol`.`jugador` (`idJugador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
