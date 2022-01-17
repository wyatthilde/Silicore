/*******************************************************************************************************************************************
 * File Name: gb_qc_samples.sql
 * Project: Silicore
 * Description: This table holds QC sample data.
 * Notes: Copied from the existing BackOffice table per Karl Keughn's request.
 *        the database table should be prefixed with the plant abbreviation: gb_ = granbury, etc.
 * 
 * Additional Notes and Explanation:
 * We were forced to use the previous developer's database table to ensure compatability. There are many aspects 
 * of that database which are poorly designed and do not conform to conventional database development standards.
 * For example, "sieve weight" information is squished together into individual columns, where that same information should
 * have been stored in separate tables with 10+ columns.
 * 
 * The following is my interpretation of the previous developer's method of squishing values together into a single database column.
 * It is applicable to the columns: start_weights_raw, end_weights_raw, and sieves_raw

    Field:
    start_weights_raw

    Example:
    a:10:{i:40;s:5:"256.2";i:50;s:5:"250.8";i:60;s:5:"239.5";i:70;s:5:"244.8";i:80;s:3:"236";i:100;s:3:"229";i:120;s:5:"232.5";i:140;s:5:"221.2";i:200;s:5:"218.4";s:3:"PAN";s:5:"271.7";}

    Formula:
    'a:' + number of values stored +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 1 + '";' +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 2 + '";' +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 3 + '";' +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 4 + '";' +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 5 + '";' +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 6 + '";' +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 7 + '";' +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 8 + '";' +
    ':{i:"' + screensize + '";' +
    's:' + length of value as a string + ':"' + Start Weight for screen 9 + '";' +
    ":{s:3:"PAN";" +
    "s:" + length of value as a string + ":"" + Start Weight for screen 10 + "";" +
    "";}"
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/14/2017|mnutsch|KACE:xxxxx - Initial creation.
 * 08/07/2017|mnutsch|KACE:17803 - added new Sieve fields.
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `gb_qc_samples`;

CREATE TABLE `gb_qc_samples` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `repeatability_id` bigint(20) DEFAULT NULL,
  `test_type_id` int(11) DEFAULT NULL,
  `composite_type_id` int(11) DEFAULT NULL,
  `sieve_method_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `plant_id` int(11) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `specific_location_id` int(4) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `date_short` bigint(8) NOT NULL,
  `time` time NOT NULL,
  `group_time` time DEFAULT NULL,
  `group_start_dt` datetime DEFAULT NULL,
  `finish_dt` datetime DEFAULT NULL,
  `duration_minutes` decimal(5,1) DEFAULT NULL,
  `duration` decimal(5,2) DEFAULT NULL,
  `dt` datetime NOT NULL,
  `dt_short` bigint(11) NOT NULL,
  `shift_date` date NOT NULL,
  `shift` varchar(5) NOT NULL,
  `sampler` varchar(32) DEFAULT NULL,
  `lab_tech` varchar(32) DEFAULT NULL,
  `operator` varchar(32) DEFAULT NULL,
  `rail_car_id` varchar(20) DEFAULT NULL,
  `rail_car_product_id` int(11) DEFAULT NULL,
  `rail_car_available_dt` datetime DEFAULT NULL,
  `starting_weight` decimal(4,1) DEFAULT NULL,
  `ending_weight` decimal(4,1) DEFAULT NULL,
  `moisture_rate` decimal(6,4) DEFAULT NULL,
  `drillhole_no` varchar(50) DEFAULT NULL,
  `depth_from` decimal(5,1) DEFAULT NULL,
  `depth_to` decimal(5,1) DEFAULT NULL,
  `beginning_wet_weight` decimal(5,1) DEFAULT NULL,
  `prewash_dry_weight` decimal(5,1) DEFAULT NULL,
  `postwash_dry_weight` decimal(5,1) DEFAULT NULL,
  `oversize_weight` decimal(5,1) DEFAULT NULL,
  `split_sample_weight` decimal(5,1) DEFAULT NULL,
  `split_sample_weight_delta` decimal(5,1) DEFAULT NULL,
  `oversize_percent` decimal(5,4) DEFAULT NULL,
  `slimes_percent` decimal(5,4) DEFAULT NULL,
  `ore_percent` decimal(5,4) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `review_notes` varchar(255) DEFAULT NULL,
  `turbidity` int(11) DEFAULT NULL,
  `container_slurry_weight` decimal(5,1) DEFAULT NULL,
  `container_water_weight` decimal(5,1) DEFAULT NULL,
  `container_empty_weight` decimal(5,1) DEFAULT NULL,
  `k_value` int(11) DEFAULT NULL,
  `k_pan_1` decimal(7,4) DEFAULT NULL,
  `k_pan_2` decimal(7,4) DEFAULT NULL,
  `k_pan_3` decimal(7,4) DEFAULT NULL,
  `k_percent_fines` decimal(5,4) DEFAULT NULL,
  `k_value_fail` int(11) DEFAULT NULL,
  `k_pan_1_fail` decimal(7,4) DEFAULT NULL,
  `k_pan_2_fail` decimal(7,4) DEFAULT NULL,
  `k_pan_3_fail` decimal(7,4) DEFAULT NULL,
  `k_percent_fines_fail` decimal(5,4) DEFAULT NULL,
  `roundness` decimal(5,1) DEFAULT NULL,
  `sphericity` decimal(5,1) DEFAULT NULL,
  `sieve_1_desc` char(3) DEFAULT NULL,
  `sieve_1_value` decimal(7,4) DEFAULT NULL,
  `sieve_1_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_1_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_2_desc` char(3) DEFAULT NULL,
  `sieve_2_value` decimal(7,4) DEFAULT NULL,
  `sieve_2_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_2_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_3_desc` char(3) DEFAULT NULL,
  `sieve_3_value` decimal(7,4) DEFAULT NULL,
  `sieve_3_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_3_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_4_desc` char(3) DEFAULT NULL,
  `sieve_4_value` decimal(7,4) DEFAULT NULL,
  `sieve_4_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_4_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_5_desc` char(3) DEFAULT NULL,
  `sieve_5_value` decimal(7,4) DEFAULT NULL,
  `sieve_5_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_5_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_6_desc` char(3) DEFAULT NULL,
  `sieve_6_value` decimal(7,4) DEFAULT NULL,
  `sieve_6_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_6_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_7_desc` char(3) DEFAULT NULL,
  `sieve_7_value` decimal(7,4) DEFAULT NULL,
  `sieve_7_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_7_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_8_desc` char(3) DEFAULT NULL,
  `sieve_8_value` decimal(7,4) DEFAULT NULL,
  `sieve_8_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_8_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_9_desc` char(3) DEFAULT NULL,
  `sieve_9_value` decimal(7,4) DEFAULT NULL,
  `sieve_9_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_9_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_10_desc` char(3) DEFAULT NULL,
  `sieve_10_value` decimal(7,4) DEFAULT NULL,
  `sieve_10_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_10_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieves_total` decimal(5,1) DEFAULT NULL,
  `start_weights_raw` text,
  `end_weights_raw` text,
  `sieves_raw` text,
  `feed_row_no` int(2) DEFAULT NULL,
  `plus_70` decimal(5,4) DEFAULT NULL,
  `minus_40_plus_70` decimal(5,4) DEFAULT NULL,
  `minus_70` decimal(5,4) DEFAULT NULL,
  `minus_70_plus_140` decimal(5,4) DEFAULT NULL,
  `plus_140` decimal(5,4) DEFAULT NULL,
  `minus_140` decimal(5,4) DEFAULT NULL,
  `near_size` decimal(5,4) DEFAULT NULL,
  `cut_ratio` decimal(5,4) DEFAULT NULL,
  `wp_moisture_rate` decimal(3,1) DEFAULT NULL,
  `percent_solids` decimal(5,4) DEFAULT NULL,
  `stph` decimal(5,1) DEFAULT NULL,
  `tons_represented` int(11) DEFAULT NULL,
  `tph_represented` decimal(5,1) DEFAULT NULL,
  `recovery_plus_70` decimal(5,4) DEFAULT NULL,
  `recovery_plus_140` decimal(5,4) DEFAULT NULL,
  `is_removed` tinyint(1) NOT NULL DEFAULT '1',
  `void_status_code` varchar(1) DEFAULT 'A',
  `create_dt` datetime DEFAULT NULL,
  `create_user_id` bigint(20) DEFAULT NULL,
  `edit_dt` datetime DEFAULT NULL,
  `edit_user_id` bigint(20) DEFAULT NULL,
  `sieve_11_desc` char(3) DEFAULT NULL,
  `sieve_11_value` decimal(7,4) DEFAULT NULL,
  `sieve_11_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_11_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_12_desc` char(3) DEFAULT NULL,
  `sieve_12_value` decimal(7,4) DEFAULT NULL,
  `sieve_12_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_12_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_13_desc` char(3) DEFAULT NULL,
  `sieve_13_value` decimal(7,4) DEFAULT NULL,
  `sieve_13_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_13_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_14_desc` char(3) DEFAULT NULL,
  `sieve_14_value` decimal(7,4) DEFAULT NULL,
  `sieve_14_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_14_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_15_desc` char(3) DEFAULT NULL,
  `sieve_15_value` decimal(7,4) DEFAULT NULL,
  `sieve_15_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_15_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_16_desc` char(3) DEFAULT NULL,
  `sieve_16_value` decimal(7,4) DEFAULT NULL,
  `sieve_16_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_16_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_17_desc` char(3) DEFAULT NULL,
  `sieve_17_value` decimal(7,4) DEFAULT NULL,
  `sieve_17_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_17_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  `sieve_18_desc` char(3) DEFAULT NULL,
  `sieve_18_value` decimal(7,4) DEFAULT NULL,
  `sieve_18_value_cumulative` decimal(7,4) DEFAULT NULL,
  `sieve_18_value_cumulative_passing` decimal(7,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=300000 DEFAULT CHARSET=latin1;