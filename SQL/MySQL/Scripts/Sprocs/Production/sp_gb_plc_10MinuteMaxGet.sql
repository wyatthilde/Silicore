
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_10MinuteMaxGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/29/2017|whildebrandt|KACE:17349 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP procedure IF EXISTS 'sp_gb_plc_10MinuteMaxGet';
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteMaxGet`()
BEGIN
SELECT MAX(Id)
FROM gb_plc_TS_10minute;
END$$
DELIMITER ;




