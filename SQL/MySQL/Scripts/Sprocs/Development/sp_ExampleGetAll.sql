/*******************************************************************************************************************************************
 * File Name: sp_ExampleGetAll.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/20/2017|kkuehn|KACE:17642 - Initial creation
 * 
 ******************************************************************************************************************************************/

USE `silicore_site`;
DROP procedure IF EXISTS `sp_ExampleGetAll`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ExampleGetAll`()
BEGIN

  SELECT 
      id,
      fname,
      lname,
      create_date,
      create_user_id,
      edit_date,
      edit_user_id,
      is_active
  FROM dev_Test123
  ORDER BY id desc; 

END$$

DELIMITER ;

CALL `sp_ExampleGetAll`();