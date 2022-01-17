
/*******************************************************************************************************************************************
 * File Name: gb_plc_plant_thresholds.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/22/2018|whildebrandt|KACE:20499 - Added table gb_plc_plant_thresholds
 *
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `gb_plc_plant_thresholds`;
CREATE TABLE `gb_plc_plant_thresholds` (
  `id` int(11),
  `tag_id` int(11),
  `user_id` int(11),
  `threshold` int(11),
  `send_alert` int(1) DEFAULT NULL,
  `create_date` datetime, 
  `create_user_id` int(11), 
  `modify_date` datetime,
  `modify_user_id` int(11), 
  `is_active` int(1) DEFAULT '1',
  PRIMARY KEY (id),
  FOREIGN KEY (tag_id) REFERENCES gb_plc_analog_tags (id),
  FOREIGN KEY (user_id) REFERENCES main_users (id),
  FOREIGN KEY (create_user_id) REFERENCES main_users(id),
  FOREIGN KEY (modify_user_id) REFERENCES main_users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



