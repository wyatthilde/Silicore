
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RuntimeGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/22/2017|whildebrandt|KACE:19535 - Created sproc that shows real runtime for each tag specified on runtimeCorrection.php
 *
 ******************************************************************************************************************************************/

DELIMITER $$
CREATE DEFINER=`root`@`loclahost` PROCEDURE `sp_gb_plc_runtimeGet`(IN p_tag varchar(32), p_startDate datetime, IN p_endDate datetime)
BEGIN

SELECT
    id,
    PR.shift_id,
    PR.duration_minutes,
    PR.duration,
    PR.device,
    PR.tag_id,
    @tag = p_tag,
    PR.create_dt,
    if(@shift_id := PR.shift_id, PR.duration_minutes - @duration_minutes, 0) as real_runtime,
    @shift_id := PR.shift_id,
    @duration_minutes := PR.duration_minutes,
    @startDate := p_startDate,
    @endDate := p_endDate


FROM
	gb_plc_runtime PR,
    (SELECT @shift_id := 0,
			@duration_minutes := 0) SQLVars
WHERE 
	tag = p_tag
	AND create_dt > p_startDate 
	AND create_dt < p_endDate
  AND duration_minutes > 2000


ORDER BY 
    PR.shift_id,
    PR.tag,
    PR.create_dt ASC;
    END$$
DELIMITER ;




