/*******************************************************************************************************************************************
 * File Name: sp_analytics_LogPageLoad.sql
 * Project: WebAnalytics
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/23/2018|mnutsch|KACE:18575 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_analytics_LogPageLoad;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_logPageLoad`
(
    IN p_url VARCHAR(64),
    IN p_website_id INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO main_analytics_page_loads 
      (url, website_id) 
    VALUES 
      (p_url, p_website_id);
    SELECT last_insert_id() INTO p_insert_id;
END$$

DELIMITER ;