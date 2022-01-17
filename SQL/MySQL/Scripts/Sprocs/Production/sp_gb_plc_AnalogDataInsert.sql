
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_AnalogDataInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - Initial creation
 * 12/11/2017|whildebrandt|KACE:16787 - Created sproc to insert data into analog data
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_AnalogDataInsert;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_AnalogDataInsert`(
    IN p_Xfer_id bigint(20),
    IN p_tag_id bigint(20), 
    IN p_tag_plc varchar(50), 
    IN p_value decimal(16,4), 
    IN p_dt datetime, 
    IN p_interval_seconds int(7)

)
insert into gb_plc_analog_data
(
	Xfer_id, 
	tag_id,
	tag_plc,
	value,
	dt, 
	interval_seconds
)
values 
(
	p_Xfer_id, 
	p_tag_id,
	p_tag_plc,
	p_value,
	p_dt, 
	p_interval_seconds
) 
ON DUPLICATE KEY UPDATE
	Xfer_id = p_Xfer_id, 
	tag_id = p_tag_id,
	tag_plc = p_tag_plc,
	value = p_value,
	dt = p_dt, 
	interval_seconds = p_interval_seconds
$$
DELIMITER ;