
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RuntimeInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/27/2017|whildebrandt|KACE:19563 - Created stored procedure that inserts into gb_plc_runtime
 * 12/11/2017|whildebrandt|KACE:19563 - Updated table to include Xfer_id
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_RuntimeInsert;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RuntimeInsert`(   
	IN p_Xfer_id bigint(20),
	IN p_shift_id bigint(20), 
	IN p_duration_minutes int, 
	IN p_duration decimal(5,2), 
  IN p_device varchar(64), 
  IN p_tag_id bigint(20), 
  IN p_tag varchar(32), 
  IN p_create_dt datetime
)
INSERT INTO gb_plc_runtime 
(
	Xfer_id,
	shift_id, 
	duration_minutes, 
	duration, 
  device, 
  tag_id, 
  tag, 
  create_dt
)
VALUES 
(
  p_Xfer_id,
	p_shift_id, 
	p_duration_minutes,	
	p_duration, 
  p_device, 
  p_tag_id, 
	p_tag, 
  p_create_dt
)
ON DUPLICATE KEY UPDATE shift_id = p_shift_id$$
DELIMITER ;