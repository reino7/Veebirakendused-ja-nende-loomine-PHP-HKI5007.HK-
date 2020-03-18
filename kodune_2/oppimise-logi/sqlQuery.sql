CREATE TABLE `reinoristissaar`.`vr20_studylog`
( `id` INT
(11) NOT NULL AUTO_INCREMENT , `course` INT
(5) NOT NULL , `activity` INT
(3) NOT NULL , `time` DECIMAL
(5) NOT NULL , `day` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY
(`id`)) ENGINE = InnoDB;