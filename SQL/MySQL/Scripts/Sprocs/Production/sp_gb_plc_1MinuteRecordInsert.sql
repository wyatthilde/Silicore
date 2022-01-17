
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RecordInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/29/2017|whildebrandt|KACE:17349 - Initial creation
 *
 ******************************************************************************************************************************************/

USE `silicore_site`;
DROP procedure IF EXISTS `sp_gb_plc_1MinuteRecordInsert`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_1MinuteRecordInsert`(
	IN p_Id int,
    IN p_Timestamp datetime,
    IN p_Name varchar(50),
    IN p_Value float,
    IN p_Quality int
)
BEGIN
INSERT INTO gb_plc_TS_1minute 
(
	Id,
	Timestamp,
    Name,
    Value,
    Quality
)
VALUES 
(
	p_Id,
    p_Timestamp,
    p_Name,
    p_Value,
    p_Quality
);
 
END$$

DELIMITER ;




