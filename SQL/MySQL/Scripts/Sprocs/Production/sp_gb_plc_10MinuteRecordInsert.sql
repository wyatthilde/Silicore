
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_10MinuteRecordInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/29/2017|whildebrandt|KACE:17349 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_10MinuteRecordInsert`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteRecordInsert`(
	IN p_id int,
    IN p_timestamp datetime,
    IN p_tag_id int(11),
    IN p_value float,
    IN p_quality int
)
BEGIN
INSERT INTO gb_plc_TS_10minute 
(
	id,
	timestamp, 
	tag_id,
	value,
	quality
)
VALUES 
(
	p_id,
    p_timestamp,
    p_tag_id,
    p_value,
    p_quality
);
 
END$$
DELIMITER ;


