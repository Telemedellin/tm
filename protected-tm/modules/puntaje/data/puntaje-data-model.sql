SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `telemede_tm`.`app`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`app` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(100) NOT NULL ,
  `modulo` VARCHAR(100) NOT NULL ,
  `estado` TINYINT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `telemede_tm`.`puntaje`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `telemede_tm`.`puntaje` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `usuario_id` INT UNSIGNED NOT NULL ,
  `app_id` INT UNSIGNED NOT NULL ,
  `referencia` VARCHAR(45) NOT NULL ,
  `fecha` TIMESTAMP NOT NULL ,
  `dispositivo` VARCHAR(45) NULL ,
  `puntos` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `p_app_id_idx` (`app_id` ASC) ,
  CONSTRAINT `p_app_id`
    FOREIGN KEY (`app_id` )
    REFERENCES `telemede_tm`.`app` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
