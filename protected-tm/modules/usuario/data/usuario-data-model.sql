SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `telemede_tm` DEFAULT CHARACTER SET latin1 ;
USE `telemede_tm` ;

-- -----------------------------------------------------
-- Table `telemede_tm`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`usuario` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `cruge_user_id` INT UNSIGNED NOT NULL ,
  `nombres` VARCHAR(100) NULL ,
  `apellidos` VARCHAR(100) NULL ,
  `sexo` VARCHAR(1) NULL ,
  `tipo_documento` TINYINT NULL ,
  `documento` VARCHAR(10) NULL ,
  `nacimiento` TIMESTAMP NULL ,
  `nivel_educacion_id` INT NULL ,
  `ocupacion_id` INT NULL ,
  `telefono_fijo` VARCHAR(15) NULL ,
  `celular` VARCHAR(10) NULL ,
  `pais_id` INT NULL ,
  `region_id` INT NULL ,
  `ciudad_id` INT NULL ,
  `barrio_id` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `telemede_tm`.`bajas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`bajas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `fecha` TIMESTAMP NOT NULL ,
  `motivo` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

USE `telemede_tm` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
