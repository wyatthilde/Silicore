/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_SampleGroupInsert.sql
 * Project: Silicore
 * Description: This stored procedure will insert a new record into the sample groups table.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/29/2018|mnutsch|KACE:18968 - Initial creation
 * 
 ******************************************************************************************************************************************/

use silicore_site;

DROP PROCEDURE IF EXISTS sp_tl_qc_SampleGroupInsert;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleGroupInsert`
(
  IN p_group_id INT(11),
  IN p_sample_id INT(11)
)
BEGIN
  INSERT INTO tl_qc_sample_groups 
    (group_id, sample_id) 
  VALUES 
    (p_group_id, p_sample_id);

END$$
