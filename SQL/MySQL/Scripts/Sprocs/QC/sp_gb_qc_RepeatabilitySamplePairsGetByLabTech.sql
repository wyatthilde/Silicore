/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_RepeatabilitySamplePairsGetByLabTech.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/09/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_gb_qc_RepeatabilitySamplePairsGetByLabTech$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilitySamplePairsGetByLabTech`
(
    IN p_start_date DATE,
    IN p_end_date DATE,
    IN p_lab_tech_id INT(11)
)
BEGIN

    SELECT pairs.id, pairs.original_sample, pairs.repeated_sample, original.date, repeated.date, original.lab_tech, repeated.lab_tech, original.location_id, repeated.location_id, original.sieve_method_id, repeated.sieve_method_id, original.sieve_1_desc, original.sieve_2_desc, original.sieve_3_desc, original.sieve_4_desc, original.sieve_5_desc, original.sieve_6_desc, original.sieve_7_desc, original.sieve_8_desc, original.sieve_9_desc, original.sieve_10_desc, original.sieve_1_value, original.sieve_2_value, original.sieve_3_value, original.sieve_4_value, original.sieve_5_value, original.sieve_6_value, original.sieve_7_value, original.sieve_8_value, original.sieve_9_value, original.sieve_10_value, original.plus_70, repeated.sieve_1_desc, repeated.sieve_2_desc, repeated.sieve_3_desc, repeated.sieve_4_desc, repeated.sieve_5_desc, repeated.sieve_6_desc, repeated.sieve_7_desc, repeated.sieve_8_desc, repeated.sieve_9_desc, repeated.sieve_10_desc, repeated.sieve_1_value, repeated.sieve_2_value, repeated.sieve_3_value, repeated.sieve_4_value, repeated.sieve_5_value, repeated.sieve_6_value, repeated.sieve_7_value, repeated.sieve_8_value, repeated.sieve_9_value, repeated.sieve_10_value, repeated.plus_70 
    FROM gb_qc_repeatability_pairs AS pairs 
    LEFT JOIN gb_qc_samples AS original ON pairs.original_sample = original.id 
    LEFT JOIN gb_qc_samples AS repeated ON pairs.repeated_sample = repeated.id 
    WHERE original.date >= p_start_date
    AND original.date <= p_end_date
    AND original.lab_tech = p_lab_tech_id;
END$$
DELIMITER ;

