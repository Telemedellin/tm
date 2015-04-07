SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `telemede_tm` DEFAULT CHARACTER SET latin1 ;
USE `telemede_tm` ;

-- -----------------------------------------------------
-- Table `telemede_tm`.`pregunta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`pregunta` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `pregunta` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `telemede_tm`.`respuesta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`respuesta` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `pregunta_id` INT NOT NULL ,
  `respuesta` VARCHAR(255) NOT NULL ,
  `es_correcta` TINYINT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `pregunta_id_idx` (`pregunta_id` ASC) ,
  CONSTRAINT `pregunta_id`
    FOREIGN KEY (`pregunta_id` )
    REFERENCES `telemede_tm`.`pregunta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `telemede_tm`.`ronda`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`ronda` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `fecha_inicio` TIMESTAMP NOT NULL ,
  `fecha_fin` TIMESTAMP NOT NULL ,
  `puntos` INT NOT NULL ,
  `estado` TINYINT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `telemede_tm`.`ronda_x_pregunta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`ronda_x_pregunta` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ronda_id` INT UNSIGNED NOT NULL ,
  `pregunta_id` INT UNSIGNED NOT NULL ,
  `estado` TINYINT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `rxp_ronda_id_idx` (`ronda_id` ASC) ,
  INDEX `rxp_pregunta_id_idx` (`pregunta_id` ASC) ,
  CONSTRAINT `rxp_ronda_id`
    FOREIGN KEY (`ronda_id` )
    REFERENCES `telemede_tm`.`ronda` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `rxp_pregunta_id`
    FOREIGN KEY (`pregunta_id` )
    REFERENCES `telemede_tm`.`pregunta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `telemede_tm`.`ronda_x_respuesta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`ronda_x_respuesta` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ronda_id` INT UNSIGNED NOT NULL ,
  `respuesta_id` INT UNSIGNED NOT NULL ,
  `usuario_id` INT UNSIGNED NOT NULL ,
  `fecha` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `rxr_ronda_id_idx` (`ronda_id` ASC) ,
  INDEX `rxr_respuesta_id_idx` (`respuesta_id` ASC) ,
  CONSTRAINT `rxr_ronda_id`
    FOREIGN KEY (`ronda_id` )
    REFERENCES `telemede_tm`.`ronda` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `rxr_respuesta_id`
    FOREIGN KEY (`respuesta_id` )
    REFERENCES `telemede_tm`.`respuesta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `telemede_tm` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
