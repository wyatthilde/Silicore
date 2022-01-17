/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SamplesInDateRangeGetFiltered.sql
 * Project: Silicore
 * Notes:
 * Usage example with wildcards: CALL sp_gb_qc_SamplesInDateRangeGetFiltered('2017-09-01 00:00:00','2017-10-31 00:00:00',0,50,'.*','.*','.*','00:00:00','23:59:00','.*','.*','.*','.*','.*','.*','.*','.*');
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/31/2017|mnutsch|KACE:18789 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_tl_qc_SamplesInDateRangeGetFiltered;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesInDateRangeGetFiltered`
(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT(11),
    IN  p_results_per_page INT(11),
    IN  p_is_complete VARCHAR(64),
    IN  p_test_type_ids VARCHAR(11),
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
    IN  p_void_status_codes VARCHAR(8)
)
BEGIN
    SELECT * from tl_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date AND
    is_complete REGEXP p_is_complete AND
    test_type_id REGEXP p_test_type_ids AND
    composite_type_id REGEXP p_composite_type_ids AND
    ((time >= p_min_time AND time <= p_max_time)
    OR ((time >= p_min_time OR time <= p_max_time) AND p_min_time > p_max_time)) AND
    lab_tech REGEXP p_lab_tech_ids AND
    sampler REGEXP p_sampler_ids AND
    operator REGEXP p_operator_ids AND
    site_id REGEXP p_site_ids AND
    plant_id REGEXP p_plant_ids AND
    location_id REGEXP p_sample_location_ids AND
    specific_location_id REGEXP p_specific_location_ids AND
    void_status_code REGEXP p_void_status_codes
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END$$