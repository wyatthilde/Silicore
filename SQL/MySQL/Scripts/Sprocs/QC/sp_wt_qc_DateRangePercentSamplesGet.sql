/*******************************************************************************************************************************************
 * File Name: sp_wt_qc_DateRangePercentSamplesGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 02/12/2018|mnutsch|KACE:20683 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_wt_qc_DateRangePercentSamplesGet;

DELIMITER //

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_wt_qc_DateRangePercentSamplesGet
(
    IN p_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT wt_qc_samples.id, DATE_FORMAT(wt_qc_samples.date, '%Y-%m-%d') as 'date',wt_qc_samples.sieve_1_value,wt_qc_samples.sieve_2_value,wt_qc_samples.sieve_3_value,wt_qc_samples.sieve_4_value,wt_qc_samples.sieve_5_value,wt_qc_samples.sieve_6_value,wt_qc_samples.sieve_7_value,wt_qc_samples.sieve_8_value,wt_qc_samples.sieve_9_value,wt_qc_samples.sieve_10_value,wt_qc_samples.sieve_11_value,wt_qc_samples.sieve_12_value,wt_qc_samples.sieve_13_value,wt_qc_samples.sieve_14_value,wt_qc_samples.sieve_15_value,wt_qc_samples.sieve_16_value,wt_qc_samples.sieve_17_value,wt_qc_samples.sieve_18_value, wt_qc_samples.plus_70, wt_qc_samples.minus_40_plus_70, wt_qc_samples.minus_70, wt_qc_samples.minus_70_plus_140, wt_qc_samples.plus_140, wt_qc_samples.minus_140
    FROM wt_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND location_id = p_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END//

DELIMITER ;





