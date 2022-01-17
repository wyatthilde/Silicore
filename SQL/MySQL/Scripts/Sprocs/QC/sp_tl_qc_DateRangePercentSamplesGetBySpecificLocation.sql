/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_DateRangePercentSamplesGetBySpecificLocation.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/05/2017|mnutsch|KACE:17957 - Initial creation
 * 10/25/2017|mnutsch|KACE:19254 - Updated query.
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_tl_qc_DateRangePercentSamplesGetBySpecificLocation;

DELIMITER //

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_DateRangePercentSamplesGetBySpecificLocation
(
    IN p_specific_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT tl_qc_samples.id, DATE_FORMAT(tl_qc_samples.date, '%Y-%m-%d') as 'date',tl_qc_samples.sieve_1_value,tl_qc_samples.sieve_2_value,tl_qc_samples.sieve_3_value,tl_qc_samples.sieve_4_value,tl_qc_samples.sieve_5_value,tl_qc_samples.sieve_6_value,tl_qc_samples.sieve_7_value,tl_qc_samples.sieve_8_value,tl_qc_samples.sieve_9_value,tl_qc_samples.sieve_10_value,tl_qc_samples.sieve_11_value,tl_qc_samples.sieve_12_value,tl_qc_samples.sieve_13_value,tl_qc_samples.sieve_14_value,tl_qc_samples.sieve_15_value,tl_qc_samples.sieve_16_value,tl_qc_samples.sieve_17_value,tl_qc_samples.sieve_18_value, tl_qc_samples.plus_70, tl_qc_samples.minus_40_plus_70, tl_qc_samples.minus_70, tl_qc_samples.minus_70_plus_140, tl_qc_samples.plus_140, tl_qc_samples.minus_140
    FROM tl_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND specific_location_id = p_specific_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END//

DELIMITER ;