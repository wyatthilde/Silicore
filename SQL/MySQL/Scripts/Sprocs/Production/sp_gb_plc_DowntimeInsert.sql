
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_DowntimeInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - insert for gb_plc_downtime
 * 11/29/2017|whildebrandt|KACE:19563 - Replaced insert with stored procedure to insert into downtime with Xfer_id
 * 03/08/2018|whildebrandt|KACE:20499 - Removed Xfer_id
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS`sp_gb_plc_DowntimeInsert`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DowntimeInsert`(
    IN p_id int(11),
    IN p_shift_id int(11), 
    IN p_start_dt datetime, 
    IN p_end_dt datetime, 
    IN p_duration_minutes int, 
    IN p_duration decimal(5,2), 
    IN p_reason varchar(64), 
    IN p_device_name varchar(255), 
    IN p_comments varchar(255), 
    IN p_is_scheduled tinyint(1)	
)
insert into gb_plc_downtime
(
    id,
    shift_id, 
    start_dt, 
    end_dt, 
    duration_minutes, 
    duration, 
    reason, 
    device_name, 
    comments, 
    is_scheduled
)
values 
(
    p_id,
    p_shift_id, 
    p_start_dt, 
    p_end_dt, 
    p_duration_minutes, 
    p_duration, 
    p_reason, 
    p_device_name, 
    p_comments, 
    p_is_scheduled
)
ON DUPLICATE KEY UPDATE 
    id = p_id,
    shift_id = p_shift_id, 
    start_dt = p_start_dt, 
    end_dt = p_end_dt, 
    duration_minutes = p_duration_minutes, 
    duration = p_duration, 
    reason = p_reason, 
    device_name = p_device_name, 
    comments = p_comments,
    is_scheduled = p_is_scheduled$$
DELIMITER ;