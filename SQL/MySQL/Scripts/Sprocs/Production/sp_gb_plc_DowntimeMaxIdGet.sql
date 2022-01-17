
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_DowntimeMaxIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/29/2017|whildebrandt|KACE:19563 - Created procedure to get max id from downtime
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_DowntimeMaxIdGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DowntimeMaxIdGet`()
SELECT MAX(Xfer_id) As maxId
FROM gb_plc_downtime$$
DELIMITER ;




