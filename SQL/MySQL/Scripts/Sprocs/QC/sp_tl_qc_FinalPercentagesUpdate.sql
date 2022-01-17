/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_FinalPercentagesUpdate.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/06/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //
DROP PROCEDURE IF EXISTS sp_tl_qc_FinalPercentagesUpdate//
CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_FinalPercentagesUpdate
(
    IN p_final_percent_1 INT(11),
    IN p_final_percent_2 INT(11),
    IN p_final_percent_3 INT(11),
    IN p_final_percent_4 INT(11),
    IN p_final_percent_5 INT(11),
    IN p_final_percent_6 INT(11),
    IN p_final_percent_7 INT(11),
    IN p_final_percent_8 INT(11),
    IN p_final_percent_9 INT(11),
    IN p_final_percent_10 INT(11),
    IN p_final_percent_11 INT(11),
    IN p_final_percent_12 INT(11),
    IN p_final_percent_13 INT(11),
    IN p_final_percent_14 INT(11),
    IN p_final_percent_15 INT(11),
    IN p_final_percent_16 INT(11),
    IN p_final_percent_17 INT(11),
    IN p_final_percent_18 INT(11),
    IN p_final_percent_total INT(11),
    IN p_sample_id INT(11)
)
BEGIN
UPDATE 
tl_qc_finalpercentages 
    SET 
        finalpercent1 = p_final_percent_1,
        finalpercent2 = p_final_percent_2,
        finalpercent3 = p_final_percent_3,
        finalpercent4 = p_final_percent_4,
        finalpercent5 = p_final_percent_5,
        finalpercent6 = p_final_percent_6,
        finalpercent7 = p_final_percent_7,
        finalpercent8 = p_final_percent_8,
        finalpercent9 = p_final_percent_9,
        finalpercent10 = p_final_percent_10,
        finalpercent11 = p_final_percent_11,
        finalpercent12 = p_final_percent_12,
        finalpercent13 = p_final_percent_13,
        finalpercent14 = p_final_percent_14,
        finalpercent15 = p_final_percent_15,
        finalpercent16 = p_final_percent_16,
        finalpercent17 = p_final_percent_17,
        finalpercent18 = p_final_percent_18,
        finalpercenttotal = p_final_percent_total
    WHERE sample_id = p_sample_id;
END//
DELIMITER ;

