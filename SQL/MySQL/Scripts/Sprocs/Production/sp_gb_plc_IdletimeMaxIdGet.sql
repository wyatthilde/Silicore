
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_IdletimeMaxIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/30/2017|whildebrandt|KACE:19563 - gets max Id from gb_plc_idletime
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_IdletimeMaxIdGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_IdletimeMaxIdGet`()
SELECT MAX(Xfer_id) As maxId
FROM gb_plc_idletime$$
DELIMITER ;




