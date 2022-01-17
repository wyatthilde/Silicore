
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ConveyerTagsGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/22/2017|whildebrandt|KACE:16787 - Createed sproc that returns the conveyor tags from gb_plc_production
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_ConveyerTagsGet;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ConveyorTagsGet`()
(
SELECT DISTINCT tag FROM silicore_site.gb_plc_production 
WHERE tag LIKE 'C___SCL_TOTAL'
OR tag LIKE 'a__Cv___Scl_Total')$$
DELIMITER ;



