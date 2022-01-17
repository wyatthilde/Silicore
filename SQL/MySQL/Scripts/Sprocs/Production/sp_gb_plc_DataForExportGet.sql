
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_DataForExportGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/22/2017|whildebrandt|KACE:19536 - sproc that pulls selected date range from plc data
 * 12/22/2017|whildebrandt|KACE:19536 - updated sproc to corrected math on tons per minute and tons per second
 * 03/26/2018|whildebrandt|KACE:19536 - updated sproc to correct math for runtime.
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_DataForExportGet`;
DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DataForExportGet`( IN p_startDate datetime, IN p_endDate datetime)
(
SELECT
	pz.shift_id AS 'Shift ID',
	s.operator AS 'Operator',
  s.prod_area AS 'Plant',
	pz.product AS 'Product',
	pa.fuel AS 'Fuel',
	pz.tons 'Tons',
	round((pz.tons / CASE WHEN s.uptime + s.downtime = 0 THEN r.duration ELSE s.uptime + s.downtime END), 2) AS 'Tons Per Hour',
	round(((pz.tons / CASE WHEN s.uptime + s.downtime = 0 THEN r.duration ELSE s.uptime + s.downtime END) / 60), 2) AS 'Tons Per Minute',
  round((((pz.tons / CASE WHEN s.uptime + s.downtime = 0 THEN r.duration ELSE s.uptime + s.downtime END) / 60) /60), 3) AS 'Tons Per Second',
	CASE WHEN s.uptime + s.downtime = 0 THEN r.duration ELSE s.uptime + s.downtime END AS 'Runtime',
  s.uptime AS 'Uptime',
	s.downtime AS 'Downtime',
  s.idletime AS 'Idletime',
 #r.device AS 'Device',
 #r.tag AS 'Tag',
  r.create_dt AS 'Date'
FROM gb_plc_production_fuel_view_Sum pa
JOIN gb_plc_production pz ON pz.shift_id = pa.shift_id
JOIN (SELECT id, operator, prod_area, uptime, downtime, idletime FROM gb_plc_shifts) s ON s.id = pa.shift_id
JOIN (SELECT DISTINCT shift_id, duration, create_dt FROM gb_plc_runtime) r ON r.shift_id = pa.shift_id
WHERE fuel IS NOT NULL AND r.create_dt BETWEEN p_startDate AND p_endDate
ORDER BY pz.shift_id
)$$

DELIMITER ;

