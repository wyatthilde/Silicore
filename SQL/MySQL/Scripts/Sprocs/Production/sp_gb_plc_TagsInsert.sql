
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_TagsInsert.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/23/2018|whildebrandt|KACE:20499 - Added procedure to insert into gb_plc_analog_tags
 * 02/28/2018|whildebrandt|KACE:20499 - Adjusted sp_gb_plc_TagInsert, added ehouse field.
 ******************************************************************************************************************************************/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagInsert`(
	  p_device varchar(50),
    p_classification varchar(50),
    p_tag varchar(50),
    p_tag_plc varchar(50),
    p_units varchar(50),
    p_plant_id int(11),
    p_user_id int(11)
    
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
    `create_date`
        )
	VALUES
		(
    p_device,
		p_classification,
		p_tag,
		p_tag_plc,
		p_units,
		p_plant_id,
    p_user_id,
    now()
        )
	
    ON DUPLICATE KEY UPDATE
	
		device = p_device,
		classification = p_classification,
		tag = p_tag,
		tag_plc = p_tag_plc,
		units = p_units,
		plant_id = p_plant_id,
		modify_date = now(),
    modify_user_id = p_user_id;
		
END$$
DELIMITER ;



