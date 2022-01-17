/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SampleInsert.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 6/05/2017|mnutsch|KACE:17957 - Initial creation 
 * 10/05/2017|mnutsch|KACE:17957 - Renamed file and sproc to fit proper coding convention.
 * 10/09/2017|mnutsch|KACE:17957 - Modified. Added last insert ID output.
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_gb_qc_SampleInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_SampleInsert
(
    IN  p_create_dt DATETIME,
    IN  p_user_id BIGINT(20),
    IN  p_test_type_id INT(11),
    IN  p_composite_type_id INT(11),
    IN  p_site_id INT(11),
    IN  p_plant_id INT(11),
    IN  p_location_id INT(11),
    IN  p_dt DATETIME,
    IN  p_date DATE,
    IN  p_date_short BIGINT(8),
    IN  p_dt_short BIGINT(11),
    IN  p_time TIME,
    IN  p_group_time TIME,
    IN  p_shift_date DATE,
    IN  p_lab_Tech VARCHAR(32),
    IN  p_sampler VARCHAR(32),
    IN  p_operator VARCHAR(32),
    IN  p_shift VARCHAR(5),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO gb_qc_samples
    (
        create_dt,
        create_user_id,
        test_type_id,
        composite_type_id, 
        site_id, 
        plant_id, 
        location_id, 
        dt, 
        date, 
        date_short, 
        dt_short,
        time,
        group_time,
        shift_date,
        lab_tech,
        sampler,
        operator,
        shift
    )
    VALUES 
    (
        p_create_dt,
        p_user_id,
        p_test_type_id,
        p_composite_type_id, 
        p_site_id, 
        p_plant_id, 
        p_location_id, 
        p_dt, 
        p_date, 
        p_date_short, 
        p_dt_short,
        p_time,
        p_group_time,
        p_shift_date,
        p_lab_tech,
        p_sampler,
        p_operator,
        p_shift
    ) ; 
    select last_insert_id() into p_insert_id;
END//


