/*******************************************************************************************************************************************
 * File Name: sp_analytics_GetWebsiteID.sql
 * Project: WebAnalytics
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/22/2018|mnutsch|KACE:18575 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_analytics_GetWebsiteID;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_GetWebsiteID`
(
    IN p_token INT(11)
)
BEGIN
    SELECT * 
    FROM main_analytics_websites 
    WHERE access_token = p_token 
    LIMIT 1;

END$$

DELIMITER ;

