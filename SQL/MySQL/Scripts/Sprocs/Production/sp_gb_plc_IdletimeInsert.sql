
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_IdletimeInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - One time insert of old table data into new table
 * 11/30/2017|whildebrandt|KACE:19563 - Replaced one time code with stored procedure to insert data into idletime table with Xfer_id
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_IdletimeInsert`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_IdletimeInsert`(
    IN p_Xfer_id bigint(20),
    IN p_shift_id bigint(20), 
    IN p_start_dt datetime, 
    IN p_end_dt datetime, 
    IN p_duration_minutes int, 
    IN p_duration decimal(5,2), 
    IN p_reason varchar(64), 
    IN p_comments varchar(255), 
    IN p_is_scheduled tinyint(1)	
)
insert into gb_plc_idletime
(
    Xfer_id,
    shift_id, 
    start_dt, 
    end_dt, 
    duration_minutes, 
    duration, 
    reason, 
    comments, 
    is_scheduled
)
values 
(
    p_Xfer_id,
    p_shift_id, 
    p_start_dt, 
    p_end_dt, 
    p_duration_minutes, 
    p_duration, 
    p_reason, 
    p_comments, 
    p_is_scheduled
)
ON DUPLICATE KEY UPDATE 
    Xfer_id = p_Xfer_id,
    shift_id = p_shift_id, 
    start_dt = p_start_dt, 
    end_dt = p_end_dt, 
    duration_minutes = p_duration_minutes, 
    duration = p_duration, 
    reason = p_reason, 
    comments = p_comments,
    is_scheduled = p_is_scheduled$$
DELIMITER ;