
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_TagAutomatedInsert.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/09/2018|whildebrandt|KACE:20499 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_TagAutomatedInsert`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagAutomatedInsert`(

    p_tag varchar(50),
    p_tag_plc varchar(50),
    p_ehouse varchar(50)
    
)
BEGIN
	INSERT INTO `silicore_site`.`gb_plc_analog_tags`
		(
        `device`,
		`classification`,
        `ehouse`,
		`tag`,
		`tag_plc`,
		`units`,
		`plant_id`,
        `create_user_id`,
        `create_date`
        )
	VALUES
		(
        'Needs Definition',
		'Needs Definition',
        p_ehouse,
		p_tag,
		p_tag_plc,
		'ND',
		31,
        25,
        now()
        );
		
        SELECT id FROM gb_plc_analog_tags 
        WHERE tag like p_tag
        Limit 1;
END$$
DELIMITER ;


