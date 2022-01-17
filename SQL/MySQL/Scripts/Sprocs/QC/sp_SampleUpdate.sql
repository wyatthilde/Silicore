/* * *****************************************************************************
 * File Name: sp_UpdateSample.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-5-2017
 * Description: This file contains the stored procedures for UpdateSample.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_UpdateSample//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_UpdateSample
(
    IN p_id INT(11),
    IN p_edit_dt DATETIME,
    IN p_edit_user_id BIGINT(20), 
    IN p_site_id INT(11),
    IN p_plant_id INT(11),
    IN p_dt DATETIME,
    IN p_test_type_id INT(11),
    IN p_composite_type_id INT(11),
    IN p_sieve_method_id INT(11),
    IN p_location_id INT(11),
    IN p_date DATE,
    IN p_time TIME,
    IN p_date_short BIGINT(8),
    IN p_dt_short DATETIME,
    IN p_drillhole_no VARCHAR(50),
    IN p_description VARCHAR(50),
    IN p_sampler VARCHAR(32),
    IN p_lab_tech VARCHAR(32),
    IN p_operator VARCHAR(32),
    IN p_beginning_wet_weight DECIMAL(5, 1),
    IN p_prewash_dry_weight DECIMAL(5, 1),
    IN p_postwash_dry_weight DECIMAL(5, 1),
    IN p_split_sample_weight DECIMAL(5, 1),
    IN p_moisture_rate DECIMAL(6, 4),
    IN p_notes VARCHAR(255),
    IN p_turbidity INT(11),
    IN p_k_value INT(11),
    IN p_k_pan_1 DECIMAL(7, 4),
    IN p_k_pan_2 DECIMAL(7, 4),
    IN p_k_pan_3 DECIMAL(7, 4),
    IN p_roundness DECIMAL(5, 1),
    IN p_sphericity DECIMAL(5, 1),
    IN p_group_time TIME,
    IN p_start_weights_raw TEXT,
    IN p_end_weights_raw TEXT,
    IN p_sieves_raw TEXT
)
BEGIN
UPDATE gb_qc_samples
    SET 
        edit_dt = p_edit_dt,
        edit_user_id = p_edit_user_id, 
        site_id = p_site_id,
        plant_id = p_plant_id,
        dt = p_dt,
        test_type_id = p_test_type_id,
        composite_type_id = p_composite_type_id,
        sieve_method_id = p_sieve_method_id,
        location_id = p_location_id,
        date = p_date,
        time = p_time,
        date_short = p_date_short,
        dt_short = p_dt_short,
        drillhole_no = p_drillhole_no,
        description = p_description,
        sampler = p_sampler,
        lab_tech = p_lab_tech,
        operator = p_operator,
        beginning_wet_weight = p_beginning_wet_weight,
        prewash_dry_weight = p_prewash_dry_weight,
        postwash_dry_weight = p_postwash_dry_weight,
        split_sample_weight = p_split_sample_weight,
        moisture_rate = p_moisture_rate,
        notes = p_notes,
        turbidity = p_turbidity,
        k_value = p_k_value,
        k_pan_1 = p_k_pan_1,
        k_pan_2 = p_k_pan_2,
        k_pan_3 = p_k_pan_3,
        roundness = p_roundness,
        sphericity = p_sphericity,
        group_time = p_group_time,
        start_weights_raw = p_start_weights_raw,
        end_weights_raw = p_end_weights_raw,
        sieves_raw = p_sieves_raw
    WHERE id = p_id;
END//

DELIMITER ;