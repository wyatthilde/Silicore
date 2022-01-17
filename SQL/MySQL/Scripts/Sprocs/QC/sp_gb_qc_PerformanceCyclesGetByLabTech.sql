/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_PerformanceCyclesGetByLabTech.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/22/2018|mnutsch|KACE:18518 - Initial creation
 * 02/12/2018|mnutsch|KACE:20683 - Updated to include new test types.
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_PerformanceCyclesGetByLabTech;

DELIMITER //

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_PerformanceCyclesGetByLabTech
(
    IN p_plant_id INT(11),
    IN p_lab_tech INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT lab_tech, 
        sum(case when test_type_id = 1 then 1 else 0 end) as test_type_1_count, 
        sum(case when test_type_id = 2 then 1 else 0 end) as test_type_2_count, 
        sum(case when test_type_id = 3 then 1 else 0 end) as test_type_3_count, 
        sum(case when test_type_id = 4 then 1 else 0 end) as test_type_4_count, 
        sum(case when test_type_id = 5 then 1 else 0 end) as test_type_5_count, 
        sum(case when test_type_id = 6 then 1 else 0 end) as test_type_6_count,    
        sum(case when test_type_id = 7 then 1 else 0 end) as test_type_7_count,
        sum(case when test_type_id = 8 then 1 else 0 end) as test_type_8_count,
        avg(duration) as duration 
    FROM gb_qc_samples 
    WHERE dt >= p_start_date 
        AND dt <= p_end_date 
        AND plant_id = p_plant_id 
        AND lab_tech = p_lab_tech 
        GROUP by lab_tech;
END//

DELIMITER ;


