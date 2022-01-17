/*******************************************************************************************************************************************
 * File Name: sp_analytics_GetPageLoads.sql
 * Project: WebAnalytics
 * Description: This stored procedure gets Page Loads from the web analytics page loads table.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/22/2018|mnutsch|KACE:18518 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_analytics_GetPageLoads;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_GetPageLoads`
(
    # no input parameters
)
BEGIN
    SELECT url AS "URL", COUNT(*) AS "Calls", MAX(time_called) AS "Last_Called" 
    FROM main_analytics_page_loads 
    GROUP BY url 
    ORDER BY Calls DESC;
END$$

DELIMITER ;


