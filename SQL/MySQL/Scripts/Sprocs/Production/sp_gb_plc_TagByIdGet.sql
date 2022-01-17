
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_TagByIdGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/31/2018|whildebrandt|KACE:20499 - Created stored procedure to retrieve tags by id from gb_plc_analog_tags (5 minutes)
 *
 ******************************************************************************************************************************************/
drop procedure if exists sp_gb_plc_TagByIdGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagByIdGet`(IN p_id int(11))
(
select device, tag, tag_plc
from gb_plc_analog_tags
where id = p_id
)$$
DELIMITER ;




