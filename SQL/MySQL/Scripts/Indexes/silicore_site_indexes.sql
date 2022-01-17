/*******************************************************************************************************************************************
 * File Name: silicore_site_indexes.sql
 * Project: Silicore
 * Description: General script to add/maintain indexes for the silicore_site database
 * Notes:
 *        To add multi-column indexes, use ADD INDEX [index name](`[col 1]`,`[col 2]`,`[etc.]`)
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/16/2017|kkuehn|KACE:10499 - Initial creation
 * 
 ******************************************************************************************************************************************/

ALTER TABLE gb_qc_samples DROP INDEX index_date;
ALTER TABLE gb_qc_samples ADD INDEX index_date(`date`);