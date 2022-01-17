
/*******************************************************************************************************************************************
 * File Name: gb_plc_production_fuel_view_sum.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/07/2017|whildebrandt|KACE:19536 - View that shows fuels grouped together with shifts and tonnage
 *
 ******************************************************************************************************************************************/
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gb_plc_production_fuel_view_Sum` AS 
(
	SELECT DISTINCT 
		`gb_plc_production_fuel_view`.`id` AS `id`,
        `gb_plc_production_fuel_view`.`shift_id` AS `shift_id`,
        `gb_plc_production_fuel_view`.`fuel` AS `fuel` 
	FROM 
		`gb_plc_production_fuel_view` 
    GROUP BY 
		`gb_plc_production_fuel_view`.`id`,
		`gb_plc_production_fuel_view`.`shift_id`,
		`gb_plc_production_fuel_view`.`tons`,
		`gb_plc_production_fuel_view`.`fuel`
);




