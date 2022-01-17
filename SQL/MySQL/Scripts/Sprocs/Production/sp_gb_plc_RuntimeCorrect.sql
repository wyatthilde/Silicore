
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RuntimeCorrect.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/22/2017|whildebrandt|KACE:19535 - Corrects runtime data specified by tag on runtimeCorrection.php
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_runtimeCorrect`;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_runtimeCorrect`(
		IN  p_id bigint(20),
		IN  p_duration_minutes int(5),
		IN  p_duration decimal(5,2)
)
BEGIN
	UPDATE gb_plc_runtime
		SET duration_minutes = p_duration_minutes,
			duration = p_duration
		WHERE id = p_id;

END$$
DELIMITER ;



