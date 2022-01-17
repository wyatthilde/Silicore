/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SamplesInDateRangeGetFilteredv2.sql
 * Project: Silicore
 * Notes:
 * Usage example with wildcards: CALL sp_gb_qc_SamplesInDateRangeGetFilteredv2('2017-09-01 00:00:00','2017-10-31 00:00:00',0,50,'','','','00:00:00','23:59:00','','','','','','','','');
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/31/2017|mnutsch|KACE:18789 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_SamplesInDateRangeGetFilteredv2;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SamplesInDateRangeGetFilteredv2`
(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT(11),
    IN  p_results_per_page INT(11),
    IN  p_is_complete VARCHAR(64),
    IN  p_test_type_ids VARCHAR(64),
    IN  p_composite_type_ids VARCHAR(64),
    IN  p_min_time TIME,
    IN  p_max_time TIME,
    IN  p_lab_tech_ids VARCHAR(64),
    IN  p_sampler_ids VARCHAR(64),
    IN  p_operator_ids VARCHAR(64),
    IN  p_site_ids VARCHAR(64),
    IN  p_plant_ids VARCHAR(64),
    IN  p_sample_location_ids VARCHAR(64),
    IN  p_specific_location_ids VARCHAR(64),
    IN  p_void_status_codes VARCHAR(8),
    IN  p_is_coa VARCHAR(1)
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date AND
    ((p_is_complete = '') OR (is_complete = p_is_complete)) AND
    ((p_test_type_ids = '') OR (FIND_IN_SET(test_type_id, p_test_type_ids) <> 0)) AND
    ((p_composite_type_ids = '') OR (FIND_IN_SET(composite_type_id, p_composite_type_ids) <> 0)) AND
    ((time >= p_min_time AND time <= p_max_time)
    OR ((time >= p_min_time OR time <= p_max_time) AND p_min_time > p_max_time)) AND
    ((p_lab_tech_ids = '') OR (FIND_IN_SET(lab_tech, p_lab_tech_ids) <> 0)) AND
    ((p_sampler_ids = '') OR (FIND_IN_SET(sampler, p_sampler_ids) <> 0)) AND
    ((p_operator_ids = '') OR (FIND_IN_SET(operator, p_operator_ids) <> 0)) AND
    ((p_site_ids = '') OR (FIND_IN_SET(site_id, p_site_ids) <> 0)) AND
    ((p_plant_ids = '') OR (FIND_IN_SET(plant_id, p_plant_ids) <> 0)) AND
    ((p_sample_location_ids = '') OR (FIND_IN_SET(location_id, p_sample_location_ids) <> 0)) AND
    ((p_specific_location_ids = '') OR (FIND_IN_SET(specific_location_id, p_composite_type_ids) <> 0)) AND
    ((p_void_status_codes = '') OR (FIND_IN_SET(void_status_code, p_void_status_codes) <> 0)) AND
    ((p_is_coa = '') OR (FIND_IN_SET(is_coa, p_is_coa) <> 0))
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END$$

DELIMITER ;