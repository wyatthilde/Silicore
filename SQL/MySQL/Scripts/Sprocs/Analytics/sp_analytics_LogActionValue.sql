/*******************************************************************************************************************************************
 * File Name: sp_analytics_LogActionValue.sql
 * Project: WebAnalytics
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/23/2018|mnutsch|KACE:18575 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_analytics_LogActionValue;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_LogActionValue`
(
    IN p_action_id INT(11),
    IN p_label VARCHAR(64),
    IN p_value VARCHAR(64),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO main_analytics_action_values 
      (action_id, label, item_value) 
    VALUES 
      (p_action_id, p_label, p_value);
    SELECT last_insert_id() INTO p_insert_id;
END$$

DELIMITER ;