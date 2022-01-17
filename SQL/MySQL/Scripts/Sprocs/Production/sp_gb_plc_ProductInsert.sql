
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ProductInsert.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/24/2017|whildebrandt|KACE:16787 - Insert for prod_products table
 *
 ******************************************************************************************************************************************/


INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('1', '1', NULL, NULL, NULL, 'Feed', NULL, '1', '0', '1');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('2', '2', NULL, NULL, NULL, 'Feed', NULL, '1', '10', '1');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('3', '3', '29', 'C01_SCL_TOTAL', NULL, 'Feed', NULL, '1', '20', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('4', '3', '107', 'C04_SCL_TOTAL', NULL, 'Coarse', NULL, '1', '30', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('5', '3', '109', 'C07_SCL_TOTAL', NULL, 'Fine', NULL, '1', '40', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('6', '4', NULL, NULL, NULL, 'Feed', NULL, '1', '50', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('7', '4', NULL, NULL, NULL, 'Coarse', NULL, '1', '60', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('8', '4', NULL, NULL, NULL, 'Fine', NULL, '1', '70', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('9', '5', '164', 'ROT_SCALE_TOTAL', NULL, 'Feed Fine', NULL, '1', '80', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('10', '5', '165', 'BCV55_SCL_TOTAL', '1', '100 Mesh', NULL, '1', '90', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('11', '6', '167', 'BCV100_1_SCL_TOTAL', NULL, 'Feed Coarse', NULL, '1', '100', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('12', '6', '166', 'BCV100_SCL_TOTAL', NULL, 'Feed Fine', NULL, '1', '110', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('13', '6', '170', 'CAR4070_SCL_TOTAL', '2', '40/70 Mesh', NULL, '1', '120', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('14', '6', '171', 'CAR100_SCL_TOTAL', '1', '100 Mesh', NULL, '1', '130', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('15', '3', '175', 'CYCLONE_CALC_TOTAL', NULL, 'Tails', NULL, '0', '45', '1');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('16', '7', '179', 'C16_SCL_TOTAL', NULL, 'Feed Fine', NULL, '1', '91', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('17', '7', '183', 'C19_SCL_TOTAL', '1', '100 Mesh', NULL, '1', '92', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('18', '7', '218', 'BCV55_SCL_TOTAL2', NULL, '100 Mesh', NULL, '0', '90', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('19', '6', NULL, 'CARRIER_OLD_COARSE', NULL, 'Feed Coarse', NULL, '0', '105', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('20', '6', NULL, 'CARRIER_OLD_FINE', NULL, 'Feed Fine', NULL, '0', '115', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('21', '3', '235', 'C21_SCL_TOTAL', NULL, 'UFR', NULL, '1', '45', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('22', '8', NULL, NULL, '1', '100 Mesh', NULL, '1', '200', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('23', '8', '278', 'C24_SCL_TOTAL', NULL, '100 Mesh', NULL, '1', '201', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('24', '8', '279', 'C25_SCL_TOTAL', NULL, '100 Mesh', NULL, '1', '202', '0');
INSERT INTO `silicore_site`.`prod_products` (`id`, `plant_id`, `tag_id`, `tag`, `product_final_id`, `description`, `classification`, `is_target`, `sort_order`, `is_removed`) VALUES ('25', '8', '280', 'C28_SCL_TOTAL', NULL, '100 Mesh', NULL, '1', '203', '0');



