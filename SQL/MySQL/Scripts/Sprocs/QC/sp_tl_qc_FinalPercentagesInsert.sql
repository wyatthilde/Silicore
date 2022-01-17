/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_FinalPercentagesInsert.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/06/2017|mnutsch|KACE:17959 - Initial creation
 * 10/09/2017|mnutsch|KACE:17957 - Modified. Added last insert ID output.
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_tl_qc_FinalPercentagesInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_FinalPercentagesInsert
(
    IN p_sample_id INT(11),
    IN p_finalpercent1 DOUBLE,
    IN p_finalpercent2 DOUBLE,
    IN p_finalpercent3 DOUBLE,
    IN p_finalpercent4 DOUBLE,
    IN p_finalpercent5 DOUBLE,
    IN p_finalpercent6 DOUBLE,
    IN p_finalpercent7 DOUBLE,
    IN p_finalpercent8 DOUBLE,
    IN p_finalpercent9 DOUBLE,
    IN p_finalpercent10 DOUBLE,
    IN p_finalpercent11 DOUBLE,
    IN p_finalpercent12 DOUBLE,
    IN p_finalpercent13 DOUBLE,
    IN p_finalpercent14 DOUBLE,
    IN p_finalpercent15 DOUBLE,
    IN p_finalpercent16 DOUBLE,
    IN p_finalpercent17 DOUBLE,
    IN p_finalpercent18 DOUBLE,
    IN p_finalpercenttotal DOUBLE,
    OUT p_insert_id int
)
BEGIN
INSERT INTO tl_qc_finalpercentages 
(
    sample_id, 
    finalpercent1, 
    finalpercent2, 
    finalpercent3, 
    finalpercent4, 
    finalpercent5, 
    finalpercent6, 
    finalpercent7, 
    finalpercent8, 
    finalpercent9, 
    finalpercent10, 
    finalpercent11, 
    finalpercent12, 
    finalpercent13, 
    finalpercent14, 
    finalpercent15, 
    finalpercent16, 
    finalpercent17, 
    finalpercent18, 
    finalpercenttotal
) 
VALUES 
(
    p_sample_id, 
    p_finalpercent1, 
    p_finalpercent2, 
    p_finalpercent3, 
    p_finalpercent4, 
    p_finalpercent5, 
    p_finalpercent6, 
    p_finalpercent7, 
    p_finalpercent8, 
    p_finalpercent9, 
    p_finalpercent10, 
    p_finalpercent11, 
    p_finalpercent12, 
    p_finalpercent13, 
    p_finalpercent14, 
    p_finalpercent15, 
    p_finalpercent16, 
    p_finalpercent17, 
    p_finalpercent18, 
    p_finalpercenttotal
);
select last_insert_id() into p_insert_id;
END//

DELIMITER ;




