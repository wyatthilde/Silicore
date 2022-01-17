
/*******************************************************************************************************************************************
 * File Name: gb_plc_production_FuelView.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/07/2017|whildebrandt|KACE:19536 - Created a view that shows only fuel for production
 *
 ******************************************************************************************************************************************/

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gb_plc_production_fuel_view` AS 
(
SELECT
	`p`.`id` AS `id`,
	`p`.`shift_id` AS `shift_id`,
  `p`.`tons` AS `tons`,
  `p`.`product` AS `product`,
  (CASE WHEN (`p`.`tag_id` IN (275,276,277)) THEN `p`.`tons` END) AS `fuel`,
  `r`.`create_dt` AS `Date` 
FROM 
(
	`gb_plc_production` `p` 
   JOIN `gb_plc_runtime` `r` ON((`r`.`shift_id` = `p`.`shift_id`))) 
   ORDER BY `p`.`shift_id`
);



