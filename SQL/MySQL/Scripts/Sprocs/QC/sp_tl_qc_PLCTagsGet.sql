/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_PLCTagsGet.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/09/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_tl_qc_PLCTagsGet$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PLCTagsGet`
(

)
BEGIN
    SELECT * FROM tl_auto_plant_analog_tags WHERE is_mir = 1 AND is_hidden = 0 AND is_removed = 0;
END$$
DELIMITER ;

