
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_AutomatedTagInsert.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/28/2018|whildebrandt|KACE:20499 - Added ehouse to automated tag insert.
 *
 ******************************************************************************************************************************************/
USE `silicore_site`;
DROP procedure IF EXISTS `sp_gb_plc_AutomatedTagInsert`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_AutomatedTagInsert`(

    p_tag varchar(50),
    p_tag_plc varchar(50),
    p_ehouse varchar(4)
    
)
BEGIN
	INSERT INTO `silicore_site`.`gb_plc_analog_tags`
		(
        `device`,
		`classification`,
		`tag`,
		`tag_plc`,
		`units`,
		`plant_id`,
        `create_user_id`,
        `create_date`,
        `ehouse`
        )
	VALUES
		(
        'Needs Definition',
		'Needs Definition',
		p_tag,
		p_tag_plc,
		'Needs Definition',
		31,
        25,
        now(),
        p_ehouse
        );
		
END$$

DELIMITER ;



