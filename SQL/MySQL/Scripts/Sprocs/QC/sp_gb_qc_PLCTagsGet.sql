/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_PLCTagsGet.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/09/2017|mnutsch|KACE:17957 - Initial creation
 * 11/29/2017|mnutsch|KACE:19445 - Replaced "prod_auto_plant_analog_tags" references with "gb_auto_plant_analog_tags".
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_PLCTagsGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PLCTagsGet`
(

)
BEGIN
    SELECT * FROM gb_auto_plant_analog_tags WHERE is_mir = 1 AND is_hidden = 0 AND is_removed = 0;
END$$
DELIMITER ;

