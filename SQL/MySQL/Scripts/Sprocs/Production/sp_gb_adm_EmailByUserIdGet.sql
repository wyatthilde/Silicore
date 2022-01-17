
/*******************************************************************************************************************************************
 * File Name: sp_gb_adm_EmailByUserIdGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/07/2018|whildebrandt|KACE:20499 - Sproc that gets email for a user by their user_id
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_adm_EmailByUserIdGet;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_adm_EmailByUserIdGet`(IN p_user_id int(11))
(
SELECT
	email
FROM
	main_users
WHERE
	user_id = p_user_id
)$$
DELIMITER ;




