
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ShiftsInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:19563 - one time fill in gb_plc_shifts with data from old table
 * 12/01/2017|whildebrandt|KACE:19563 - stored procedure to insert data into shifts table
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_ShiftInsert`;
DELIMITER $$
CREATE DEFINER=`webdev`@`smashbox` PROCEDURE `sp_gb_plc_ShiftInsert`(
    IN p_Xfer_id bigint(20),
	IN p_prod_area_id int(3),
    IN p_plant_area varchar(64),
    IN p_plant_id int(3),
    IN p_date datetime,
    IN p_shift varchar(5),
    IN p_start_dt datetime,
    IN p_end_dt datetime,
    IN p_operator varchar(32),
    IN p_duration_minutes int(5),
    IN p_duration decimal(5,2),
    IN p_uptime decimal(5,2),
    IN p_uptime_percent decimal(5,4),
    IN p_downtime decimal(5,2),
    IN p_downtime_percent decimal(5,4),
    IN p_idletime decimal(5,2),
    IN p_idletime_percent decimal(5,4),
    IN p_is_removed tinyint(1)

    
)
INSERT INTO gb_plc_shifts
(
	Xfer_id,
	prod_area_id,
	prod_area,
	plant_id,
	date,
	shift,
	start_dt,
	end_dt,
	operator,
	duration_minutes,
	duration,
	uptime,
	uptime_percent,
	downtime,
	downtime_percent,
	idletime,
	idletime_percent,
	is_removed

)
VALUES
(	
    p_Xfer_id,
    p_prod_area_id,
    p_plant_area,
    p_plant_id,
    p_date,
    p_shift,
    p_start_dt,
    p_end_dt,
    p_operator,
    p_duration_minutes,
    p_duration,
    p_uptime,
    p_uptime_percent,
    p_downtime,
    p_downtime_percent,
    p_idletime,
    p_idletime_percent,
    p_is_removed

)$$
DELIMITER ;
