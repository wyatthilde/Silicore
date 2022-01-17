/*******************************************************************************************************************************************
 * File Name: sp_wt_qc_RepeatabilitySamplePairsGet.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * xx/xx/xxxx|mnutsch|KACE:xxxxx - Initial creation
 * 01/18/2018|mnutsch|KACE:18518 - Specific labels to the values.
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_wt_qc_RepeatabilitySamplePairsGet;
 
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilitySamplePairsGet`
(
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN

    SELECT pairs.id, pairs.original_sample, pairs.repeated_sample, original.date AS original_date, repeated.date AS repeated_date, original.lab_tech AS original_lab_tech, repeated.lab_tech AS repeated_lab_tech, original.location_id AS original_location_id, repeated.location_id AS repeated_location_id, original.sieve_method_id AS original_sieve_method_id, repeated.sieve_method_id AS repeated_sieve_method_id, original.sieve_1_desc AS original_sieve_1_desc, original.sieve_2_desc AS original_sieve_2_desc, original.sieve_3_desc AS original_sieve_3_desc, original.sieve_4_desc AS original_sieve_4_desc, original.sieve_5_desc AS original_sieve_5_desc, original.sieve_6_desc AS original_sieve_6_desc, original.sieve_7_desc AS original_sieve_7_desc, original.sieve_8_desc AS original_sieve_8_desc, original.sieve_9_desc AS original_sieve_9_desc, original.sieve_10_desc AS original_sieve_10_desc, original.sieve_1_value AS original_sieve_1_value, original.sieve_2_value AS original_sieve_2_value, original.sieve_3_value AS original_sieve_3_value, original.sieve_4_value AS original_sieve_4_value, original.sieve_5_value AS original_sieve_5_value, original.sieve_6_value AS original_sieve_6_value, original.sieve_7_value AS original_sieve_7_value, original.sieve_8_value AS original_sieve_8_value, original.sieve_9_value AS original_sieve_9_value, original.sieve_10_value AS original_sieve_10_value, original.plus_70 AS original_plus_70, repeated.sieve_1_desc AS repeated_sieve_1_desc, repeated.sieve_2_desc AS repeated_sieve_2_desc, repeated.sieve_3_desc AS repeated_sieve_3_desc, repeated.sieve_4_desc AS repeated_sieve_4_desc, repeated.sieve_5_desc AS repeated_sieve_5_desc, repeated.sieve_6_desc AS repeated_sieve_6_desc, repeated.sieve_7_desc AS repeated_sieve_7_desc, repeated.sieve_8_desc AS repeated_sieve_8_desc, repeated.sieve_9_desc AS repeated_sieve_9_desc, repeated.sieve_10_desc AS repeated_sieve_10_desc, repeated.sieve_1_value AS repeated_sieve_1_value, repeated.sieve_2_value AS repeated_sieve_2_value, repeated.sieve_3_value AS repeated_sieve_3_value, repeated.sieve_4_value AS repeated_sieve_4_value, repeated.sieve_5_value AS repeated_sieve_5_value, repeated.sieve_6_value AS repeated_sieve_6_value, repeated.sieve_7_value AS repeated_sieve_7_value, repeated.sieve_8_value AS repeated_sieve_8_value, repeated.sieve_9_value AS repeated_sieve_9_value, repeated.sieve_10_value AS repeated_sieve_10_value, repeated.plus_70 AS repeated_plus_70, original.sieve_11_desc AS original_sieve_11_desc, original.sieve_12_desc AS original_sieve_12_desc, original.sieve_13_desc AS original_sieve_13_desc, original.sieve_14_desc AS original_sieve_14_desc, original.sieve_15_desc AS original_sieve_15_desc, original.sieve_16_desc AS original_sieve_16_desc, original.sieve_17_desc AS original_sieve_17_desc, original.sieve_18_desc AS original_sieve_18_desc, original.sieve_11_value AS original_sieve_11_value, original.sieve_12_value AS original_sieve_12_value, original.sieve_13_value AS original_sieve_13_value, original.sieve_14_value AS original_sieve_14_value, original.sieve_15_value AS original_sieve_15_value, original.sieve_16_value AS original_sieve_16_value, original.sieve_17_value AS original_sieve_17_value, original.sieve_18_value AS original_sieve_18_value, repeated.sieve_11_desc AS repeated_sieve_11_desc, repeated.sieve_12_desc AS repeated_sieve_12_desc, repeated.sieve_13_desc AS repeated_sieve_13_desc, repeated.sieve_14_desc AS repeated_sieve_14_desc, repeated.sieve_15_desc AS repeated_sieve_15_desc, repeated.sieve_16_desc AS repeated_sieve_16_desc, repeated.sieve_17_desc AS repeated_sieve_17_desc, repeated.sieve_18_desc AS repeated_sieve_18_desc, repeated.sieve_11_value AS repeated_sieve_11_value, repeated.sieve_12_value AS repeated_sieve_12_value, repeated.sieve_13_value AS repeated_sieve_13_value, repeated.sieve_14_value AS repeated_sieve_14_value, repeated.sieve_15_value AS repeated_sieve_15_value, repeated.sieve_16_value AS repeated_sieve_16_value, repeated.sieve_17_value AS repeated_sieve_17_value, repeated.sieve_18_value AS repeated_sieve_18_value
    FROM wt_qc_repeatability_pairs AS pairs 
    LEFT JOIN wt_qc_samples AS original ON pairs.original_sample = original.id 
    LEFT JOIN wt_qc_samples AS repeated ON pairs.repeated_sample = repeated.id 
    WHERE original.date >= p_start_date
    AND original.date <= p_end_date;
END$$
DELIMITER ;
