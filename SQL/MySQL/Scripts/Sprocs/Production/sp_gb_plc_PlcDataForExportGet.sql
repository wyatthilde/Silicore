
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_DataForExportGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/22/2017|whildebrandt|KACE:19536 - sproc that pulls selected date range from plc data
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS sp_gb_plc_DataForExportGet;
CREATE PROCEDURE sp_gb_plc_DataForExportGet( IN startDate datetime, IN endDate datetime)
(
SELECT
	pz.shift_id,
	s.operator AS 'Operator',
    s.prod_area AS 'Plant',
	pz.tons,
	round((pz.tons/r.duration), 2) AS 'Tons Per Hours',
	round((pz.tons/r.duration), 2) AS 'Tons Per Minute',
    round((pz.tons/r.duration)/60, 3) AS 'Tons Per Second',
	r.duration AS 'Runtime',
    s.uptime AS 'Uptime',
	s.downtime AS 'Downtime',
    s.idletime AS 'Idletime',
    #r.device AS 'Device',
    #r.tag AS 'Tag',
    r.create_dt AS 'Date',
	pz.product AS 'Product',
	pa.fuel
FROM gb_plc_production_fuel_view_Sum pa
JOIN gb_plc_production pz ON pz.shift_id = pa.shift_id
JOIN (SELECT Xfer_id, operator, prod_area, uptime, downtime, idletime FROM gb_plc_shifts) s ON s.Xfer_id = pa.shift_id
JOIN (SELECT DISTINCT shift_id, duration, create_dt FROM gb_plc_runtime) r ON r.shift_id = pa.shift_id
WHERE fuel IS NOT NULL AND r.create_dt BETWEEN @startDate AND @endDate
ORDER BY pz.shift_id
);
