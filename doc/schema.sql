CREATE TABLE IF NOT EXISTS `hsh`.`sistema` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(45) NOT NULL,
    `link` VARCHAR(255) NOT NULL,
    `descricao` VARCHAR(255) NOT NULL,
    `status` TINYINT NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
)
