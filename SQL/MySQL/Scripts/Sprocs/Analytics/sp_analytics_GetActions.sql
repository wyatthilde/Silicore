/*******************************************************************************************************************************************
 * File Name: sp_analytics_GetActions.sql
 * Project: WebAnalytics
 * Description: This stored procedure gets Actions from the web analytics actions table.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/22/2018|mnutsch|KACE:18518 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_analytics_GetActions;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_GetActions`
(
    # no input parameters
)
BEGIN
    SELECT name AS "Name", COUNT(*) AS "Calls", MAX(time_called) AS "Last_Called" 
    FROM main_analytics_actions 
    GROUP BY name 
    ORDER BY Calls DESC;
END$$

DELIMITER ;


