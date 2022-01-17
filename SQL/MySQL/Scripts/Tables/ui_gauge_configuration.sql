
/*******************************************************************************************************************************************
 * File Name: ui_gauge_configuration.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/19/2017|whildebrandt|KACE:19170 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `ui_gauge_configuration`

CREATE TABLE `ui_gauge_configuration` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `color_red` VARCHAR(6) NOT NULL DEFAULT 'FF0000',
    `color_green` VARCHAR(6) NOT NULL DEFAULT '00FF00',
    `color_yellow` VARCHAR(6) NOT NULL DEFAULT 'FFFF00',
    `color_blue` VARCHAR(6) NOT NULL DEFAULT '0000FF',
    `color_gray01` VARCHAR(6) NOT NULL DEFAULT 'CCCCCC',
    `color_gray02` VARCHAR(6) NOT NULL DEFAULT '888888',
    `color_gray03` VARCHAR(6) NOT NULL DEFAULT '333333',
    PRIMARY KEY (`id`)
)  ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=LATIN1;





