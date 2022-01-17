/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_DateRangePercentSamplesGet.sql
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

DROP PROCEDURE IF EXISTS sp_gb_qc_DateRangePercentSamplesGet;

DELIMITER //

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_DateRangePercentSamplesGet
(
    IN p_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT gb_qc_samples.id, DATE_FORMAT(gb_qc_samples.date, '%Y-%m-%d') as 'date',gb_qc_samples.sieve_1_value,gb_qc_samples.sieve_2_value,gb_qc_samples.sieve_3_value,gb_qc_samples.sieve_4_value,gb_qc_samples.sieve_5_value,gb_qc_samples.sieve_6_value,gb_qc_samples.sieve_7_value,gb_qc_samples.sieve_8_value,gb_qc_samples.sieve_9_value,gb_qc_samples.sieve_10_value,gb_qc_samples.sieve_11_value,gb_qc_samples.sieve_12_value,gb_qc_samples.sieve_13_value,gb_qc_samples.sieve_14_value,gb_qc_samples.sieve_15_value,gb_qc_samples.sieve_16_value,gb_qc_samples.sieve_17_value,gb_qc_samples.sieve_18_value, gb_qc_samples.plus_70, gb_qc_samples.minus_40_plus_70, gb_qc_samples.minus_70, gb_qc_samples.minus_70_plus_140, gb_qc_samples.plus_140, gb_qc_samples.minus_140
    FROM gb_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND location_id = p_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END//

DELIMITER ;




