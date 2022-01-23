-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: localhost    Database: silicore_site
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping routines for database 'silicore_site'
--
/*!50003 DROP FUNCTION IF EXISTS `proper` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` FUNCTION `proper`( str VARCHAR(128) ) RETURNS varchar(128) CHARSET latin1
BEGIN
DECLARE c CHAR(1);
DECLARE s VARCHAR(128);
DECLARE i INT DEFAULT 1;
DECLARE bool INT DEFAULT 1;
DECLARE punct CHAR(17) DEFAULT ' ()[]{},.-_!@;:?/';
SET s = LCASE( str );
WHILE i <= LENGTH( str ) DO   
    BEGIN
SET c = SUBSTRING( s, i, 1 );
IF LOCATE( c, punct ) > 0 THEN
SET bool = 1;
ELSEIF bool=1 THEN
BEGIN
IF c >= 'a' AND c <= 'z' THEN
BEGIN
SET s = CONCAT(LEFT(s,i-1),UCASE(c),SUBSTRING(s,i+1));
SET bool = 0;
END;
ELSEIF c >= '0' AND c <= '9' THEN
SET bool = 0;
END IF;
END;
END IF;
SET i = i+1;
END;
END WHILE;
RETURN s;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_account_request` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_account_request`(IN p_employee_id int(11), IN p_fname varchar(32), IN p_lname varchar(32), IN p_type varchar(32), 
IN p_model varchar(128), IN p_requested_user_id varchar(32), in p_is_approved tinyint(1), in p_approved_date datetime, in p_approved_by int(11))
insert into account_requests 
(
employee_id, first_name, last_name, type, model, request_date, requested_by, is_approved, approved_date, approved_by
) 
values 
(
p_employee_id, p_fname, p_lname, p_type, p_model, now(), p_requested_user_id, p_is_approved, p_approved_date, p_approved_by
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_CategoriesByDepartmentGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_CategoriesByDepartmentGet`(p_dept_id int(11))
BEGIN

SELECT 
id, cat_name, dept_id, permission_level, permission from main_document_category
where dept_id = p_dept_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_CategoryByPermissionGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_CategoryByPermissionGet`(
p_department varchar(45),
p_level int(11)
)
BEGIN

SELECT 
id, cat_name, dept_id from main_document_category
where permission = p_department
AND
permission_level <= p_level;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DepartmentsGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DepartmentsGetAll`()
BEGIN
	SELECT id, name FROM main_departments
		WHERE is_active = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DepartmentsGetAllv2` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_adm_DepartmentsGetAllv2`()
BEGIN
	SELECT * FROM hr_departments;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DocumentCategoryInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DocumentCategoryInsert`(
	p_cat_name varchar(45),
    p_dept_id int(11),
    p_permission varchar(24),
    p_permission_level int(11),
    p_user_id int(11)
)
BEGIN

INSERT INTO main_document_category (cat_name, dept_id, permission_level, permission, create_user_id, create_date)
VALUES (p_cat_name, p_dept_id, p_permission_level, p_permission, p_user_id, now());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DocumentChangeLogInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DocumentChangeLogInsert`(p_user_id int(11),p_doc_id int(11), p_description varchar(45))
BEGIN
INSERT INTO main_documents_change_log
(
timestamp,
user_id,
document_id,
description
)
values
(
now(),
p_user_id,
p_doc_id,
p_description
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DocumentIncrimentUses` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DocumentIncrimentUses`(p_id INT(11))
BEGIN
UPDATE main_documents
SET uses = uses +1, last_access = now()
WHERE id = p_id;

SELECT 
    uses
FROM
    main_documents
WHERE
    id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DocumentInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DocumentInsert`(
p_doc_name VARCHAR(64),
p_doc_ext VARCHAR(4),
p_doc_type VARCHAR(45),
p_doc_description VARCHAR(1024),
p_doc_size INT(11),
p_doc_path VARCHAR(128),
p_doc_dept_id INT(11),
p_doc_category INT(11),
p_user_id INT(11),
p_is_active INT(11)
)
BEGIN
INSERT INTO `silicore_site`.`main_documents`
(
`doc_name`,
`doc_ext`,
`doc_type`,
`doc_description`,
`doc_size`,
`doc_path`,
`dept_id`,
`category_id`,
`is_active`,
`create_date`,
`create_user_id`
)
VALUES
(
p_doc_name,
p_doc_ext,
p_doc_type,
p_doc_description,
p_doc_size,
p_doc_path,
p_doc_dept_id,
p_doc_category,
p_is_active,
now(),
p_user_id
);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DocumentReplaceFile` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DocumentReplaceFile`(
p_id INT(11),
p_doc_name VARCHAR(64),
p_doc_ext VARCHAR(4),
p_doc_type VARCHAR(45),
p_doc_size INT(11),
p_doc_path VARCHAR(128),
p_user_id INT(11)
)
BEGIN
Update main_documents
set
doc_name = p_doc_name,
doc_ext = p_doc_ext,
doc_type = p_doc_type,
doc_size = p_doc_size,
doc_path = p_doc_path,
modify_date = now(),
modify_user_id = p_user_id
where id = p_id;

SELECT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DocumentSetInactive` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DocumentSetInactive`(
p_id int(11),
p_doc_path VARCHAR(128),
p_user_id INT(11))
BEGIN

UPDATE main_documents
SET 
	doc_path = p_doc_path,
    modify_user_id = p_user_id,
    modify_date = now(),
    is_active = 0
WHERE id = p_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DocumentUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DocumentUpdate`(
p_id int(11),
p_description varchar(64),
p_category int(11),
p_department int(11),
p_user_id int(11)

)
BEGIN

UPDATE main_documents
SET 
	doc_description = p_description,
    category_id = p_category,
    dept_id = p_department,
    modify_user_id = p_user_id,
    modify_date = now()
WHERE id = p_id;


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_DocumentUploadSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_DocumentUploadSumGet`(p_user_id int(11))
BEGIN

SELECT sum(doc_size) as upload_sum from main_documents
where (create_user_id = p_user_id OR modify_user_id = p_user_id)
AND (DATE(create_date) = CURDATE() OR DATE(modify_date) = CURDATE());


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_FilesByCategoryGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_FilesByCategoryGet`(p_cat_id int(11))
BEGIN
SELECT 
    dm.id,
    doc_name,
    doc_ext,
    doc_type,
    doc_description,
    doc_size,
    doc_path,
    dm.dept_id,
    category_id,
    dc.cat_name,
    uses,
    dm.is_active,
    last_access,
    dm.create_date,
    dm.create_user_id,
    dp.name as dept_name,
    username
FROM
    main_documents dm
        JOIN
    main_departments dp ON dm.dept_id = dp.id
		JOIN 
    main_users mu ON dm.create_user_id = mu.id
		JOIN 
	main_document_category dc ON dm.category_id = dc.id
WHERE
     dm.category_id = p_cat_id
    AND
    dm.is_active = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_FilesByDepartmentGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_FilesByDepartmentGet`(p_dept_id int(11))
BEGIN

SELECT 
    dm.id,
    doc_name,
    doc_ext,
    doc_type,
    doc_description,
    doc_size,
    doc_path,
    dm.dept_id,
    category_id,
    dc.cat_name,
    uses,
    dm.is_active,
    last_access,
    dm.create_date,
    dm.create_user_id,
    dp.name as dept_name,
    username
FROM
    main_documents dm
        JOIN
    main_departments dp ON dm.dept_id = dp.id
		JOIN 
    main_users mu ON dm.create_user_id = mu.id
		JOIN 
	main_document_category dc ON dm.category_id = dc.id
WHERE
    dm.dept_id = p_dept_id
    AND
    dm.is_active = 1;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_JobTitleByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_JobTitleByIdGet`(IN p_id int(11))
(
select * from main_hr_job_titles 
where id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_JobTitlesGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_JobTitlesGetAll`()
BEGIN
	SELECT  jt.id,
			jt.name,
			jt.site_id,
            s.description as site_name,
            jt.description,
            jt.department_id,
            d.name as department_name,
            jt.user_type_id,
            ut.name as user_type,
            jt.create_date,
            jt.create_user_id,
            jt.edit_date,
            jt.edit_user_id,
            jt.is_active
    FROM  main_hr_job_titles jt
    JOIN main_sites s on s.id = jt.site_id
        JOIN main_departments d on d.id = jt.department_id
        join main_user_types ut on ut.id = jt.user_type_id
    order by id desc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_LocationsQCGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_LocationsQCGet`()
BEGIN
	SELECT description FROM main_sites
		WHERE is_active = 1 AND is_qc_samples_site = 1 AND is_vista_site = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_MainPlantsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_MainPlantsInsert`(
IN p_main_site_id int(11),
IN p_name varchar(255),
IN p_create_user_id int(11)
)
BEGIN
set @sort = (select max(sort_order)+10 from main_plants);
INSERT INTO main_plants
(
main_site_id,
name, 
description, 
sort_order, 
create_date, 
create_user_id
)
VALUES
(
p_main_site_id,
p_name, 
p_name, 
@sort, 
now(), 
p_create_user_id
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_MainPlantsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_MainPlantsUpdate`(
IN p_id int(11),
IN p_main_site_id int(11),
IN p_name varchar(255),
IN p_sort_order int(11),
IN p_modify_user_id int(11),
IN p_is_active tinyint(1)
)
UPDATE main_plants
SET
main_site_id = p_main_site_id,
name = p_name,
description = p_name,
sort_order = p_sort_order,
modify_date = now(),
modify_user_id = p_modify_user_id,
is_active = p_is_active
WHERE 
id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_MainSitesInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_MainSitesInsert`(
IN s_name varchar(255),
IN s_create_user_id int(11)
)
BEGIN
set @id = (select max(id)+1 from main_sites);
set @sort = (select max(sort_order)+10 from main_sites);
INSERT INTO main_sites
(
id,
description, 
is_vista_site, 
is_qc_samples_site,
sort_order,
is_active, 
create_date, 
create_user_id
)
VALUES
(
@id,
s_name, 
'1', 
'1',
@sort, 
'1',
now(), 
s_create_user_id
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_PasswordReset` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_adm_PasswordReset`(in p_pwd varchar(64), in p_pwd_reset tinyint(1), in p_user_id int(11), in p_user int(11))
update main_users set password = p_pwd, require_password_reset = p_pwd_reset, modify_date = now(), modify_user_id = p_user_id where id = p_user ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_PlantsNamesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_PlantsNamesGet`()
(
select 
	p.id AS id, p.main_site_id AS site_id, s.description AS site, p.name AS plant, p.sort_order, p.is_active
from
	main_plants p
join
	main_sites s ON p.main_site_id = s.id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_RoleCheckInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_RoleCheckInsert`(
	IN p_user_id int(11),
    IN p_site_id int(11),
    IN p_role_id int(11)
)
BEGIN
	INSERT INTO main_users_roles_check
	(
		user_id,
		site_id,
		role_id
	)
	VALUES
	(
        p_user_id,
        p_site_id,
        p_role_id
	)
	on duplicate key update site_id = p_site_id, role_id = p_role_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_RoleDelete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_RoleDelete`(
	IN p_id int(11), IN p_role_id int(11)
)
DELETE FROM main_users_roles_check WHERE p_id = user_id  AND p_role_id = role_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserDeptGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserDeptGet`( IN p_id int(11))
(
	SELECT 
		main_department_id
    FROM
		main_users
	WHERE 
		id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_adm_UserGet`(
	IN  p_id int(11)
)
BEGIN
SELECT  mu.id, 
		mu.username,
		mu.first_name,
		mu.last_name,
		mu.display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.is_active,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		MAX(case when rc.role_id = 1 then 1 else 0 end) as qc_operator,
		MAX(case when rc.role_id = 2 then 1 else 0 end) as qc_sampler,
		MAX(case when rc.role_id = 3 then 1 else 0 end) as qc_labtech,
		mu.user_type_id,   
		mu.manager_id
FROM main_users as mu
JOIN main_users_roles_check as rc on mu.id = rc.user_id	
WHERE mu.id = p_id
GROUP BY mu.id, rc.user_id
UNION 
SELECT  
		mu.id,
		mu.username,
		mu.first_name,
		mu.last_name,
		mu.display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.is_active,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		0 as qc_operator,
    0 as qc_sampler,
    0 as qc_labtech,
		mu.user_type_id,   
		mu.manager_id
FROM main_users as mu
LEFT JOIN main_users_roles_check as rc on rc.user_id = mu.id	
WHERE mu.id NOT IN (SELECT user_id FROM main_users_roles_check) AND mu.id = p_id
ORDER BY id ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserGetAll`()
BEGIN
SELECT  mu.id, 
		mu.username,
		mu.first_name,
		mu.last_name,
		mu.display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.is_active,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		MAX(case when rc.role_id = 1 then 1 else 0 end) as qc_operator,
		MAX(case when rc.role_id = 2 then 1 else 0 end) as qc_sampler,
		MAX(case when rc.role_id = 3 then 1 else 0 end) as qc_labtech,
		mu.user_type_id,   
		mu.manager_id
FROM main_users as mu
JOIN main_users_roles_check as rc on mu.id = rc.user_id	
GROUP BY mu.id, rc.user_id
UNION 
SELECT  
		mu.id,
		mu.username,
		mu.first_name,
		mu.last_name,
		mu.display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.is_active,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		0 as qc_operator,
    0 as qc_sampler,
    0 as qc_labtech,
		mu.user_type_id,   
		mu.manager_id
FROM main_users as mu
LEFT JOIN main_users_roles_check as rc on rc.user_id = mu.id	
WHERE mu.id NOT IN (SELECT user_id FROM main_users_roles_check)
ORDER BY id ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserPermissionDelete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserPermissionDelete`(
    IN 	p_id INT(11),
    IN 	p_department VARCHAR(32),
    in 	p_site VARCHAR(32)
)
BEGIN
	DELETE FROM main_user_permissions
		WHERE user_id = p_id AND permission = p_department AND site = p_site
	LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserPermissionsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserPermissionsGet`(
	IN p_id INT(11)
)
BEGIN
	SELECT user_id, permission, site, permission_level FROM main_user_permissions
    WHERE user_id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserTypesGet`(
)
BEGIN
	SELECT id, name, value, is_active FROM main_user_types;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserUpdate`(
    IN  p_id int(11),
    IN  p_first_name VARCHAR(32),
    IN  p_last_name VARCHAR(32),
    IN  p_display_name VARCHAR(64),
    IN  p_email VARCHAR(128),
    IN  p_company VARCHAR(32),
    IN  p_main_department_id INT(11),
    IN  p_start_date DATE,
    IN 	p_separation_date DATE,
    IN  p_is_active TINYINT(1),
    IN 	p_qc_labtech TINYINT(1),
    IN 	p_qc_sampler TINYINT(1),
    IN 	p_qc_operator TINYINT(1),
    IN 	p_user_type_id TINYINT(1),
    IN 	p_manager_id INT(11),
    IN 	p_user_id INT(11),
    IN 	p_permission VARCHAR(32),
    IN  p_permission_level INT(11)
)
BEGIN
	UPDATE main_users
		SET 
			first_name = p_first_name, 
			last_name = p_last_name, 
			display_name = p_display_name, 
			email = p_email, 
			company = p_company, 
			main_department_id = p_main_department_id, 
			start_date = p_start_date,
			separation_date = p_separation_date,
			is_active = p_is_active,
			user_type_id = p_user_type_id,
			manager_id = p_manager_id
		WHERE id = p_id;
 
	IF p_qc_operator = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 1); 
    ELSEIF p_qc_operator = 0 THEN CALL sp_adm_RoleDelete(p_id, 1);
		END IF;
	IF p_qc_sampler = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 2);
    ELSEIF p_qc_sampler = 0 THEN CALL sp_adm_RoleDelete(p_id, 2);
    		END IF;
	IF p_qc_labtech = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 3);
    ELSEIF p_qc_labtech = 0 THEN CALL sp_adm_RoleDelete(p_id, 3);
		END IF;
 
	INSERT INTO main_user_permissions (
		user_id,
		permission,
		permission_level,
		site,
		created_datetime,
		modified_datetime,
		created_by,
		modified_by,
		company
		)
	VALUES(
		p_id,
		'general',
		p_permission_level,
		'granbury',
		now(),
		NULL,
		p_user_id,
		NULL,
		'vista')
	ON DUPLICATE KEY UPDATE permission_level = p_permission_level, modified_by = p_user_id, modified_datetime=now();
    
    
	 INSERT INTO main_user_permissions 
	 (
		user_id,
		permission,
		permission_level,
		site,
		created_datetime,
		modified_datetime,
		created_by,
		modified_by,
		company
	)
	VALUES
	(
		p_id,
		p_permission,
		p_permission_level,
		'granbury',
		now(),
		NULL,
		p_user_id,
		NULL,
		'vista'
	)
	ON DUPLICATE KEY UPDATE permission_level = p_permission_level, modified_by = p_user_id, modified_datetime = now();
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserUpdatePermission` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_adm_UserUpdatePermission`(
    IN 	p_id INT(11),
    IN 	p_user_id INT(11),
    IN 	p_permission VARCHAR(32),
    IN	p_permission_level INT(11),
    IN 	p_site VARCHAR(32)
)
BEGIN

	INSERT INTO main_user_permissions 
	 (
		user_id,
		permission,
		permission_level,
		site,
		created_datetime,
		modified_datetime,
		created_by,
		modified_by,
		company
	)
	VALUES
	(
		p_id,
		p_permission,
		p_permission_level,
		p_site,
		now(),
		NULL,
		p_user_id,
		NULL,
		'vista'
	)
	ON DUPLICATE KEY UPDATE permission_level = p_permission_level, modified_by=p_user_id, modified_datetime=now();
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_adm_UserUpdateV2` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_adm_UserUpdateV2`(
    IN  p_id int(11),
    IN  p_first_name VARCHAR(32),
    IN  p_last_name VARCHAR(32),
    IN  p_display_name VARCHAR(64),
    IN  p_email VARCHAR(128),
    IN p_username varchar(128),
    IN  p_company VARCHAR(32),
    IN  p_main_department_id INT(11),
    IN  p_start_date DATE,
    IN 	p_separation_date DATE,
    IN  p_is_active TINYINT(1),
    IN 	p_qc_labtech TINYINT(1),
    IN 	p_qc_sampler TINYINT(1),
    IN 	p_qc_operator TINYINT(1),
    IN 	p_user_type_id TINYINT(1),
    IN 	p_user_id INT(11)
)
BEGIN
	UPDATE main_users
		SET 
			first_name = p_first_name, 
			last_name = p_last_name, 
			display_name = p_display_name, 
			email = p_email, 
            username = p_username,
			company = p_company, 
			main_department_id = p_main_department_id, 
			start_date = p_start_date,
			separation_date = p_separation_date,
			is_active = p_is_active,
			user_type_id = p_user_type_id
		WHERE id = p_id;
 
	IF p_qc_operator = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 1); 
    ELSEIF p_qc_operator = 0 THEN CALL sp_adm_RoleDelete(p_id, 1);
		END IF;
	IF p_qc_sampler = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 2);
    ELSEIF p_qc_sampler = 0 THEN CALL sp_adm_RoleDelete(p_id, 2);
    		END IF;
	IF p_qc_labtech = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 10, 3);
    ELSEIF p_qc_labtech = 0 THEN CALL sp_adm_RoleDelete(p_id, 3);
		END IF;
        IF p_qc_operator = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 50, 1); 
    ELSEIF p_qc_operator = 0 THEN CALL sp_adm_RoleDelete(p_id, 1);
		END IF;
	IF p_qc_sampler = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 50, 2);
    ELSEIF p_qc_sampler = 0 THEN CALL sp_adm_RoleDelete(p_id, 2);
    		END IF;
	IF p_qc_labtech = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 50, 3);
    ELSEIF p_qc_labtech = 0 THEN CALL sp_adm_RoleDelete(p_id, 3);
		END IF;
        IF p_qc_operator = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 60, 1); 
    ELSEIF p_qc_operator = 0 THEN CALL sp_adm_RoleDelete(p_id, 1);
		END IF;
	IF p_qc_sampler = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 60, 2);
    ELSEIF p_qc_sampler = 0 THEN CALL sp_adm_RoleDelete(p_id, 2);
    		END IF;
	IF p_qc_labtech = 1 THEN CALL sp_adm_RoleCheckInsert(p_id, 60, 3);
    ELSEIF p_qc_labtech = 0 THEN CALL sp_adm_RoleDelete(p_id, 3);
		END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_GetActions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_GetActions`(
    
)
BEGIN
    SELECT name AS "Name", COUNT(*) AS "Calls", MAX(time_called) AS "Last_Called" 
    FROM main_analytics_actions 
    GROUP BY name 
    ORDER BY Calls DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_GetPageLoads` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_GetPageLoads`(
    
)
BEGIN
    SELECT url AS "URL", COUNT(*) AS "Calls", MAX(time_called) AS "Last_Called" 
    FROM main_analytics_page_loads 
    GROUP BY url 
    ORDER BY Calls DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_GetWebsiteID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_GetWebsiteID`(
    IN p_token INT(11)
)
BEGIN
    SELECT * 
    FROM main_analytics_websites 
    WHERE access_token = p_token 
    LIMIT 1;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_LogAction` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_LogAction`(
    IN p_name VARCHAR(64),
    IN p_website_id INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO main_analytics_actions 
      (name, website_id) 
    VALUES 
      (p_name, p_website_id);
    SELECT last_insert_id() INTO p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_LogActionValue` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_LogActionValue`(
    IN p_action_id INT(11),
    IN p_label VARCHAR(64),
    IN p_value VARCHAR(64),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO main_analytics_action_values 
      (action_id, label, item_value) 
    VALUES 
      (p_action_id, p_label, p_value);
    SELECT last_insert_id() INTO p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_logPageLoad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_logPageLoad`(
    IN p_url VARCHAR(64),
    IN p_website_id INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO main_analytics_page_loads 
      (url, website_id) 
    VALUES 
      (p_url, p_website_id);
    SELECT last_insert_id() INTO p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_LogPageValue` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_LogPageValue`(
    IN p_page_id INT(11),
    IN p_label VARCHAR(64),
    IN p_value VARCHAR(64),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO main_analytics_page_values 
      (page_id, label, item_value) 
    VALUES 
      (p_page_id, p_label, p_value);
    SELECT last_insert_id() INTO p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_MaxActionIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_MaxActionIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM main_analytics_actions 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_MaxActionValueIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_MaxActionValueIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM main_analytics_action_values
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_MaxPageIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_MaxPageIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM main_analytics_page_loads
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_analytics_MaxPageValueIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_analytics_MaxPageValueIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM main_analytics_page_values 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_AssetRequestById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_AssetRequestById`(IN p_id int(11))
(
select 
r.id,
r.employee_id, 
r.first_name, 
r.last_name, 
r.type, 
r.product_id, 
r.request_date, 
r.requested_by,
concat(m3.first_name, ' ', m3.last_name) as requested_by_name,  
r.is_approved, 
r.approved_date, 
r.approved_by, 
concat(m2.first_name, ' ', m2.last_name) as approved_by_name, 
r.is_complete, 
r.complete_date, 
r.completed_by,
concat(m1.first_name, ' ', m1.last_name) as completed_by_name 
from asset_requests r
left join main_users m1 on m1.id = r.completed_by
left join main_users m2 on m2.id = r.approved_by
left join main_users m3 on m3.id = r.requested_by
where r.employee_id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_AssetRequestMaxId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_AssetRequestMaxId`()
(
select max(id) as id from asset_requests
limit 1
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_AssetRequestsAllGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_AssetRequestsAllGet`()
(
select req.id, req.employee_id, req.first_name, req.last_name, dv.division, s.site, req.type, req.inventory_id, req.request_date, req.requested_by, req.is_approved, req.approved_date, req.approved_by, req.is_complete, req.kace_ticket, req.is_active, req.is_auto, aa.id as signed_id from asset_requests req
left join hr_employees e on e.id = req.employee_id
left join hr_job_titles jt on jt.id = e.job_title_id
left join hr_departments d on d.id = jt.department_id
left join hr_sites s on s.id = d.site_id
left join hr_divisions dv on dv.id = s.division_id
left join it_asset_acknowledgements aa on aa.request_id = req.id
where req.type IN ('Cell Phone','Laptop','Desktop','Radio','Tablet', 'Hotspot') and req.is_active='1' order by req.id desc
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_AssetRequestsById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_AssetRequestsById`(IN p_id int(11))
(
select 
r.id,
r.employee_id, 
r.first_name, 
r.last_name, 
r.type, 
r.inventory_id, 
r.request_date, 
r.requested_by,
concat(m3.first_name, ' ', m3.last_name) as requested_by_name,  
r.is_approved, 
r.approved_date, 
r.approved_by, 
concat(m2.first_name, ' ', m2.last_name) as approved_by_name, 
r.is_complete, 
r.complete_date, 
r.completed_by,
concat(m1.first_name, ' ', m1.last_name) as completed_by_name 
from asset_requests r
left join main_users m1 on m1.id = r.completed_by
left join main_users m2 on m2.id = r.approved_by
left join main_users m3 on m3.id = r.requested_by
where r.employee_id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_asset_request` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_asset_request`(IN p_employee_id int(11), IN p_fname varchar(32), IN p_lname varchar(32), IN p_type varchar(32), IN p_requested_user_id varchar(32))
begin
insert into asset_requests 
(
employee_id, first_name, last_name, type, request_date, requested_by
) 
values 
(
p_employee_id, p_fname, p_lname, p_type, now(), p_requested_user_id
);
select LAST_INSERT_ID() as id;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_asset_request_respond` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_asset_request_respond`(IN p_approved tinyint(1), IN p_approved_by int(11), IN p_id int(11))
update asset_requests 
set is_approved = p_approved,
approved_date = now(),
approved_by = p_approved_by
where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_bo_InvoicesLegacyAPGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_bo_InvoicesLegacyAPGet`(IN p_start_date DATE, IN p_end_date DATE)
BEGIN
SELECT distinct(vin.id), vin.vendor, vin.date, vin.invoice_type, via.path FROM silicore_site.prod_vendor_invoices vin
JOIN prod_vendor_invoices_attachments via
ON vin.id = via.invoice_id 
where vin.date between p_start_date and p_end_date 
AND
via.path is not null;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_bo_InvoicesLegacyARGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_bo_InvoicesLegacyARGet`(IN p_start_date DATE, IN p_end_date DATE)
BEGIN
SELECT distinct(inv.id), inv.invoice_path, inv.date, inv.type_code, ivd.customer FROM silicore_site.prod_invoices inv
JOIN prod_invoices_details ivd
ON inv.id = ivd.invoice_id 
where inv.date between p_start_date and p_end_date
AND
inv.invoice_path is not null;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_bo_PurchaseOrderAttachmentsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_bo_PurchaseOrderAttachmentsGet`(IN p_start_date DATE, IN p_end_date DATE)
BEGIN
SELECT att.po_id, po.customer, att.path, po.date_issued, po.product from prod_purchase_orders_attachments att
JOIN prod_purchase_orders po
ON po.id = att.po_id
where po.date_issued between p_start_date and p_end_date 
AND
att.path is not null;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_bo_RailReleasesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_bo_RailReleasesGet`(IN p_start_date DATE, IN p_end_date DATE)
BEGIN
SELECT release_no, po_id, path, date, cu.description customer from prod_rail_car_releases rc
JOIN prod_customers cu
ON cu.id = rc.customer_id
where rc.date between p_start_date and p_end_date 
AND
rc.path is not null;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_CheckPagePermission` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_CheckPagePermission`(
    IN  p_company varchar(32),
    IN  p_site varchar(32),
    IN  p_permission varchar(32),
    IN  p_web_file varchar(32)
)
BEGIN
SELECT * FROM ui_nav_left_links
    WHERE company = p_company AND site = p_site AND permission = p_permission AND web_file = p_web_file
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_DeleteSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_DeleteSample`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
DELETE FROM gb_qc_samples
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_DeleteUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_DeleteUser`(
    IN  p_id int(11)
)
BEGIN
DELETE FROM main_users
    WHERE id = p_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_DepartmentsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_DepartmentsGet`(
  
)
BEGIN
    SELECT * 
    FROM main_departments;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_dev_UserByDeptGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dev_UserByDeptGet`(IN p_dept_id INT)
(
SELECT id, first_name, last_name FROM main_users
WHERE main_department_id = p_dept_id AND user_type_id IN (3, 4)
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_EmployeeByDeptAllGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_EmployeeByDeptAllGet`(IN p_dept_id int(11))
(
select id, concat(first_name, ' ', last_name) as name from hr_employees where department_id = p_dept_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_employeeInfoGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_employeeInfoGet`()
(
select id, first_name, last_name
from main_users
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_EmployeeUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_EmployeeUpdate`(
  IN  p_id INT(11),
  IN  p_last_name varchar(45),
  IN  p_first_name varchar(45),
  IN  p_employee_id varchar(45),
  IN  p_department_id int(11),
  IN  p_job_title_id int(11),
  IN  p_manager_user_id int(11),
  IN  p_site_id int(11),
  IN  p_edit_user_id int(11),
  IN  p_is_active tinyint(1)
)
UPDATE main_hr_checklist
	SET last_name = p_last_name,
    first_name = p_first_name,
    employee_id = p_employee_id,
    department_id = p_department_id,
    job_title_id = p_job_title_id,
    manager_user_id = p_manager_user_id,
    site_id = p_site_id,
    edit_user_id = p_edit_user_id,
    edit_date = now(),
    is_active = p_is_active   
WHERE id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_esp_LaneGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`silicore_site` PROCEDURE `sp_esp_LaneGet`()
BEGIN
SELECT 'Lane 1' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.load_status,l.load_status_2
		FROM chkin_1 c,chkin_1_esp k,lane_1 l, lane_1_esp a
		UNION
		SELECT 'Lane 2' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.load_status,l.load_status_2
		FROM chkin_2 c,chkin_2_esp k,lane_2 l, lane_2_esp a
		UNION
		SELECT 'Lane 3' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.load_status,l.load_status_2
		FROM chkin_3 c,chkin_3_esp k,lane_3 l, lane_3_esp a
        UNION
		SELECT 'Lane 4' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.load_status,l.load_status_2
		FROM chkin_4 c,chkin_4_esp k,lane_4 l, lane_4_esp a
		UNION
		SELECT 'Lane 5' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.load_status,l.load_status_2
		FROM chkin_5 c,chkin_5_esp k,lane_5 l, lane_5_esp a
		UNION
		SELECT 'Lane 6' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.load_status,l.load_status_2
		FROM chkin_6 c,chkin_6_esp k,lane_6 l, lane_6_esp a;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_adm_EmailByUserIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_adm_EmailByUserIdGet`(IN p_user_id int(11))
(
SELECT
	email
FROM
	main_users
WHERE
	user_id = p_user_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_dev_rainfallGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_dev_rainfallGet`()
BEGIN
	SELECT date, rainfall, high_temp, low_temp, wind from gb_plc_rainfall;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_10MinuteDailyTotal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteDailyTotal`(p_tag_id int(11), p_date datetime)
BEGIN
SELECT sum(value) FROM gb_plc_TS_10minute
WHERE tag_id = p_tag_id AND cast(timestamp as date) = p_date
AND
is_eos = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_10MinuteMaxGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteMaxGet`()
BEGIN
SELECT MAX(Id)
FROM gb_plc_TS_10minute;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_10minuteMaxIdByTagGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10minuteMaxIdByTagGet`(IN p_tag_id int(11))
(
SELECT * FROM (SELECT max(id) AS 'Current ID', value AS 'Current Value', tag_id, quality from gb_plc_TS_10minute t1 WHERE tag_id = p_tag_id AND quality = 192 GROUP BY id DESC LIMIT 1) q1
JOIN 
(SELECT max(id) AS 'Previous ID', value AS 'Previous Value', tag_id, quality from gb_plc_TS_10minute t2 WHERE tag_id = p_tag_id AND quality = 192 GROUP BY id DESC LIMIT 1 OFFSET 1 ) q2
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_10minuteMonthSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10minuteMonthSumGet`(IN p_tag_id int(11), IN p_date datetime)
SELECT 
	IFNULL((SELECT sum(value) FROM gb_plc_TS_10minute
	WHERE tag_id = p_tag_id AND cast(timestamp as date) BETWEEN p_date AND LAST_DAY(p_date)
	AND
	CASE WHEN (cast(timestamp as Time) between '05:20:00' and '05:29:59' 
	OR cast(timestamp as Time) between '17:20:00' and '17:39:59') = 0 THEN (cast(timestamp as Time) between '05:10:00' and '05:19:59'
	OR cast(timestamp as Time) between '17:10:00' and '17:19:59') END), 0) +
	IFNULL((SELECT sum(value) FROM gb_plc_TS_10minuteArchive
	WHERE tag_id = p_tag_id AND cast(timestamp as date) BETWEEN p_date AND LAST_DAY(p_date)
	AND
	CASE WHEN (cast(timestamp as Time) between '05:20:00' and '05:29:59' 
	OR cast(timestamp as Time) between '17:20:00' and '17:39:59') = 0 THEN (cast(timestamp as Time) between '05:10:00' and '05:19:59'
	OR cast(timestamp as Time) between '17:10:00' and '17:19:59') END), 0) AS 'sum(value)' ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_10MinuteRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteRecordInsert`(
	IN p_id int,
    IN p_timestamp datetime,
    IN p_tag_id int(11),
    IN p_value float,
    IN p_quality int,
    IN p_is_eos int
)
BEGIN
INSERT INTO gb_plc_TS_10minute 
(
	id,
	timestamp, 
	tag_id,
	value,
	quality,
    is_eos
)
VALUES 
(
	p_id,
    p_timestamp,
    p_tag_id,
    p_value,
    p_quality,
    p_is_eos
);
 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_10MinuteRecordsAverageGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteRecordsAverageGet`(IN p_tag_id int(11))
(
SELECT avg(value) as 'AvgValue' from gb_plc_TS_10minute 
WHERE tag_id = p_tag_id
AND quality = 192
AND
CASE WHEN (cast(timestamp as Time) between '05:50:00' and '05:59:59' 
OR cast(timestamp as Time) between '17:50:00' and '17:59:59') = 0 THEN (cast(timestamp as Time) between '05:40:00' and '05:49:59'
OR cast(timestamp as Time) between '17:40:00' and '17:49:59') END
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_10MinuteRecordsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteRecordsGet`(IN p_tag_id int(11), IN p_start date, IN p_end date)
SELECT 
	IFNULL((select avg(value) FROM gb_plc_TS_10minute where tag_id = p_tag_id
	AND timestamp between p_start AND p_end
	AND quality = 192
	AND 
	CASE WHEN (cast(timestamp as Time) between '05:50:00' and '05:59:59' 
	OR cast(timestamp as Time) between '17:50:00' and '17:59:59') = 0 THEN (cast(timestamp as Time) between '05:40:00' and '05:49:59'
	OR cast(timestamp as Time) between '17:40:00' and '17:49:59') END), 0) +
	IFNULL((select avg(value) from gb_plc_TS_10minuteArchive where tag_id = p_tag_id
	AND timestamp between p_start AND p_end
	AND quality = 192
	AND 
	CASE WHEN (cast(timestamp as Time) between '05:50:00' and '05:59:59' 
	OR cast(timestamp as Time) between '17:50:00' and '17:59:59') = 0 THEN (cast(timestamp as Time) between '05:40:00' and '05:49:59'
	OR cast(timestamp as Time) between '17:40:00' and '17:49:59') END), 0) AS 'AvgValue' ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_10MinuteSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_10MinuteSumGet`(IN p_tag_id int(11), IN p_start date, IN p_end date)
(
SELECT SUM(value) AS 'SumValue' FROM gb_plc_TS_10minute 
WHERE tag_id = p_tag_id
AND timestamp BETWEEN p_start AND p_end
AND quality = 192
AND is_eos = 1
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_12HourMaxGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_12HourMaxGet`()
BEGIN
SELECT MAX(Id)
FROM gb_plc_TS_12Hour;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_12HourMaxIdByTagGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_12HourMaxIdByTagGet`(IN p_tag_id int(11))
(
SELECT * FROM (SELECT max(id) AS 'Current ID', value AS 'Current Value', tag_id, quality from gb_plc_TS_12Hour t1 WHERE tag_id = p_tag_id AND quality = 192 GROUP BY id DESC LIMIT 1) q1
JOIN 
(SELECT max(id) AS 'Previous ID', value AS 'Previous Value', tag_id, quality from gb_plc_TS_12Hour t2 WHERE tag_id = p_tag_id AND quality = 192 GROUP BY id DESC LIMIT 1 OFFSET 1 ) q2
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_12HourMonthSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_12HourMonthSumGet`(IN p_tag_id int(11), IN p_date datetime)
SELECT sum(value) FROM gb_plc_TS_12Hour
WHERE tag_id = p_tag_id AND cast(timestamp as date) BETWEEN p_date AND LAST_DAY(p_date)
AND
CASE WHEN (cast(timestamp as Time) between '05:20:00' and '05:29:59' 
OR cast(timestamp as Time) between '17:20:00' and '17:39:59') = 0 THEN (cast(timestamp as Time) between '05:10:00' and '05:19:59'
OR cast(timestamp as Time) between '17:10:00' and '17:19:59') END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_12HourRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_12HourRecordInsert`(
	IN p_id int,
    IN p_timestamp datetime,
    IN p_tag_id int(11),
    IN p_value float,
    IN p_quality int
)
BEGIN
INSERT INTO gb_plc_TS_12Hour 
(
	id,
	timestamp, 
	tag_id,
	value,
	quality
)
VALUES 
(
	p_id,
    p_timestamp,
    p_tag_id,
    p_value,
    p_quality
);
 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_12HourRecordsAverageGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_12HourRecordsAverageGet`(IN p_tag_id int(11))
(
SELECT avg(value) as 'AvgValue' from gb_plc_TS_12Hour 
WHERE tag_id = p_tag_id
AND quality = 192
AND
CASE WHEN (cast(timestamp as Time) between '05:50:00' and '05:59:59' 
OR cast(timestamp as Time) between '17:50:00' and '17:59:59') = 0 THEN (cast(timestamp as Time) between '05:40:00' and '05:49:59'
OR cast(timestamp as Time) between '17:40:00' and '17:49:59') END
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_12HourRecordsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_12HourRecordsGet`(IN p_tag_id int(11), IN p_start date, IN p_end date)
(
SELECT avg(value) as 'AvgValue' from gb_plc_TS_12Hour 
where tag_id = p_tag_id
AND timestamp between p_start AND p_end
AND quality = 192
AND 
CASE WHEN (cast(timestamp as Time) between '05:50:00' and '05:59:59' 
OR cast(timestamp as Time) between '17:50:00' and '17:59:59') = 0 THEN (cast(timestamp as Time) between '05:40:00' and '05:49:59'
OR cast(timestamp as Time) between '17:40:00' and '17:49:59') END
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_12HourSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_12HourSumGet`(IN p_tag_id int(11), IN p_start date, IN p_end date)
(
SELECT SUM(value) AS 'SumValue' FROM gb_plc_TS_12Hour 
WHERE tag_id = p_tag_id
AND timestamp BETWEEN p_start AND p_end
AND quality = 192
AND 
CASE WHEN (cast(timestamp as Time) BETWEEN '05:20:00' AND '05:29:59' 
OR CAST(timestamp as Time) BETWEEN '17:20:00' AND '17:29:59') = 0 THEN (CAST(timestamp as Time) BETWEEN '05:10:00' AND '05:19:59'
OR CAST(timestamp as Time) BETWEEN '17:10:00' AND '17:19:59') END
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_1MinuteMaxGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_1MinuteMaxGet`()
BEGIN
SELECT MAX(Id)
FROM gb_plc_TS_1minute;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_1MinuteRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_1MinuteRecordInsert`(
	IN p_Id int,
    IN p_Timestamp datetime,
    IN p_Name varchar(50),
    IN p_Value float,
    IN p_Quality int
)
BEGIN
INSERT INTO gb_plc_TS_1minute 
(
	Id,
	Timestamp,
    Name,
    Value,
    Quality
)
VALUES 
(
    p_Id,
    p_Timestamp,
    p_Name,
    p_Value,
    p_Quality
);
 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_600IntervalMaxIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_600IntervalMaxIdGet`()
(
SELECT 
	MAX(Xfer_id) AS MaxId
FROM
	gb_plc_analog_data
WHERE 
	interval_seconds = 600
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_60IntervalMaxIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_60IntervalMaxIdGet`()
(
SELECT 
	MAX(Xfer_id) AS MaxId
FROM
	gb_plc_analog_data
WHERE 
	interval_seconds = 60
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_AnalogDataInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_AnalogDataInsert`(
    IN p_Xfer_id bigint(20),
    IN p_tag_id bigint(20), 
    IN p_tag_plc varchar(50), 
    IN p_value decimal(16,4), 
    IN p_dt datetime, 
    IN p_interval_seconds int(7)

)
insert into gb_plc_analog_data
(
	Xfer_id, 
	tag_id,
	tag_plc,
	value,
	dt, 
	interval_seconds
)
values 
(
	p_Xfer_id, 
	p_tag_id,
	p_tag_plc,
	p_value,
	p_dt, 
	p_interval_seconds
) 
ON DUPLICATE KEY UPDATE
	Xfer_id = p_Xfer_id, 
	tag_id = p_tag_id,
	tag_plc = p_tag_plc,
	value = p_value,
	dt = p_dt, 
	interval_seconds = p_interval_seconds ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_AnalogTagGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_AnalogTagGet`(IN p_tag varchar(32))
SELECT id 
FROM prod_auto_plant_analog_tags 
WHERE tag = p_tag
LIMIT 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_Bcv100ByDateGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_Bcv100ByDateGet`(IN p_start datetime, IN p_end datetime)
(
SELECT
	r1.tons AS 'Fine',
	r2.tons AS 'Coarse',
    s.date AS 'Date'
FROM 
	gb_plc_production p
JOIN 
	gb_plc_shifts s ON s.Xfer_id = p.shift_id
JOIN 
	(SELECT shift_id, tons FROM gb_plc_production WHERE tag_id = 166) r1 ON r1.shift_id = p.shift_id
JOIN 
	(SELECT shift_id, tons FROM gb_plc_production WHERE tag_id = 167) r2 ON r2.shift_id = p.shift_id
WHERE 
	s.date BETWEEN p_start AND p_end
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ClassificationsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ClassificationsGet`()
BEGIN
		SELECT DISTINCT classification 
        FROM gb_plc_analog_tags 
        WHERE classification IS NOT NULL; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ConveyorAvgTotalGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ConveyorAvgTotalGet`(IN p_tag varchar(64), IN p_start datetime, IN p_end datetime, IN p_operator varchar(32))
(
SELECT 
	DATEDIFF(MAX(s.date), MIN(s.date)) AS 'Days', 
	p.tag, 
    AVG(p.tons) AS 'AverageTons',
	SUM(p.tons) AS 'TotalTons' 
FROM 
	gb_plc_production p 
JOIN gb_plc_shifts s ON s.Xfer_id = p.shift_id
WHERE p.tag = p_tag
AND s.operator LIKE p_operator
AND s.date BETWEEN p_start AND p_end) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ConveyorTagsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ConveyorTagsGet`()
(
SELECT DISTINCT tag FROM silicore_site.gb_plc_production 
WHERE tag LIKE 'C___SCL_TOTAL'
OR tag LIKE 'a__Cv___Scl_Total') ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_DashboardSettingInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DashboardSettingInsert`(
    IN p_user_id INT(11),
	IN p_settings_json varchar(2080)
)
BEGIN
INSERT INTO gb_plc_dashboard_settings
(
`user_id`,
`settings_json`
)

VALUES
(
p_user_id,
p_settings_json
)

ON DUPLICATE KEY UPDATE 
 

    settings_json = p_settings_json;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_DashboardSettingsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DashboardSettingsGet`(
	IN p_user_id INT (11)
)
BEGIN

SELECT 
settings_json
from gb_plc_dashboard_settings
WHERE user_id = p_user_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_DataForExportGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DataForExportGet`( IN p_startDate datetime, IN p_endDate datetime)
(
SELECT
	pz.shift_id AS 'Shift ID',
	s.operator AS 'Operator',
  s.prod_area AS 'Plant',
	pz.product AS 'Product',
	pa.fuel AS 'Fuel',
	pz.tons 'Tons',
	round((pz.tons / CASE WHEN s.uptime + s.downtime = 0 THEN r.duration ELSE s.uptime + s.downtime END), 2) AS 'Tons Per Hour',
	round(((pz.tons / CASE WHEN s.uptime + s.downtime = 0 THEN r.duration ELSE s.uptime + s.downtime END) / 60), 2) AS 'Tons Per Minute',
  round((((pz.tons / CASE WHEN s.uptime + s.downtime = 0 THEN r.duration ELSE s.uptime + s.downtime END) / 60) /60), 3) AS 'Tons Per Second',
	CASE WHEN s.uptime + s.downtime = 0 THEN r.duration ELSE s.uptime + s.downtime END AS 'Runtime',
  s.uptime AS 'Uptime',
	s.downtime AS 'Downtime',
  s.idletime AS 'Idletime',
 
 
  r.create_dt AS 'Date'
FROM gb_plc_production_fuel_view_Sum pa
JOIN gb_plc_production pz ON pz.shift_id = pa.shift_id
JOIN (SELECT id, operator, prod_area, uptime, downtime, idletime FROM gb_plc_shifts) s ON s.id = pa.shift_id
JOIN (SELECT DISTINCT shift_id, duration, create_dt FROM gb_plc_runtime) r ON r.shift_id = pa.shift_id
WHERE fuel IS NOT NULL AND r.create_dt BETWEEN p_startDate AND p_endDate
ORDER BY pz.shift_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_DowntimeDurationSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DowntimeDurationSumGet`(
	IN p_shift_id bigint(20)
)
SELECT 
	SUM(duration_minutes) AS downtime_minutes 
FROM 
	gb_plc_downtime 
WHERE 
	shift_id = p_shift_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_DowntimeInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DowntimeInsert`(
    IN p_id int(11),
    IN p_shift_id int(11), 
    IN p_start_dt datetime, 
    IN p_end_dt datetime, 
    IN p_duration_minutes int, 
    IN p_duration decimal(5,2), 
    IN p_reason varchar(64), 
    IN p_device_name varchar(255), 
    IN p_comments varchar(255), 
    IN p_is_scheduled tinyint(1)	
)
BEGIN
INSERT INTO gb_plc_downtime
(
    id,
    shift_id, 
    start_dt, 
    end_dt, 
    duration_minutes, 
    duration, 
    reason, 
    device_name, 
    comments, 
    is_scheduled
)
VALUES 
(
    p_id,
    p_shift_id, 
    p_start_dt, 
    p_end_dt, 
    p_duration_minutes, 
    p_duration, 
    p_reason, 
    p_device_name, 
    p_comments, 
    p_is_scheduled
)
ON DUPLICATE KEY UPDATE 
    id = p_id,
    shift_id = p_shift_id, 
    start_dt = p_start_dt, 
    end_dt = p_end_dt, 
    duration_minutes = p_duration_minutes, 
    duration = p_duration, 
    reason = p_reason, 
    device_name = p_device_name, 
    comments = p_comments,
    is_scheduled = p_is_scheduled;
SET SQL_SAFE_UPDATES = 0;
UPDATE gb_plc_shifts s LEFT JOIN gb_plc_downtime d ON d.shift_id = s.id
SET s.downtime = d.duration
WHERE d.shift_id = s.id;
SET SQL_SAFE_UPDATES = 1;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_DowntimeMaxIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_DowntimeMaxIdGet`()
SELECT MAX(Xfer_id) As maxId
FROM gb_plc_downtime ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_HourReadingsByTagIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_HourReadingsByTagIdGet`(IN p_tag_id int(11))
SELECT value, timestamp FROM gb_plc_TS_10minute
WHERE tag_id = p_tag_id
ORDER BY id DESC LIMIT 6 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_IdByTagGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_IdByTagGet`(IN p_tag varchar(32))
SELECT id 
FROM prod_auto_plant_analog_tags 
WHERE tag = p_tag 
LIMIT 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_IdletimeDurationSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_IdletimeDurationSumGet`(
	IN p_shift_id bigint(20)
)
SELECT 
	SUM(duration_minutes) AS idletime_minutes 
FROM 
	gb_plc_idletime
WHERE 
	shift_id = p_shift_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_IdletimeInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_IdletimeInsert`(
    IN p_id int(11),
    IN p_shift_id int(11), 
    IN p_start_dt datetime, 
    IN p_end_dt datetime, 
    IN p_duration_minutes int, 
    IN p_duration decimal(5,2), 
    IN p_reason varchar(64), 
    IN p_comments varchar(255)

)
begin
insert into gb_plc_idletime
(
    id,
    shift_id, 
    start_dt, 
    end_dt, 
    duration_minutes, 
    duration, 
    reason, 
    comments

)
values 
(
    p_id,
    p_shift_id, 
    p_start_dt, 
    p_end_dt, 
    p_duration_minutes, 
    p_duration, 
    p_reason, 
    p_comments
)
ON DUPLICATE KEY UPDATE 
    id = p_id,
    shift_id = p_shift_id, 
    start_dt = p_start_dt, 
    end_dt = p_end_dt, 
    duration_minutes = p_duration_minutes, 
    duration = p_duration, 
    reason = p_reason,
    comments = p_comments;
SET SQL_SAFE_UPDATES = 0;
UPDATE gb_plc_shifts s LEFT JOIN gb_plc_idletime i ON i.shift_id = s.id
SET s.idletime = i.duration
WHERE i.shift_id = s.id;
SET SQL_SAFE_UPDATES = 1;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_IdletimeMaxIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_IdletimeMaxIdGet`()
SELECT MAX(Xfer_id) As maxId
FROM gb_plc_idletime ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_InventorySiloXferInfoByDateGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_InventorySiloXferInfoByDateGet`(IN p_date datetime)
(
SELECT 
        t.dt, so.site_id, t.silo_id, so.capacity_pounds, so.cone_pounds, max(t.product_id) product_id, max(t.volume) volume 
    FROM
        (
        SELECT 
            dt, 
            CASE WHEN at.tag = "SILO1_PROD_temp" THEN 1 
            WHEN at.tag = "SILO2_PROD_temp" THEN 2 
            WHEN at.tag = "SILO6_PROD_temp" THEN 6 
            WHEN at.tag = "SILO7_PROD_temp" THEN 7 END silo_id, 
            value product_id, 
            NULL volume
        FROM 
            gb_plc_analog_data ad JOIN gb_plc_analog_tags at ON ad.tag_id = at.id  
        WHERE 
            tag IN ("SILO1_PROD_temp", "SILO2_PROD_temp", "SILO6_PROD_temp", "SILO7_PROD_temp") AND
            dt > p_date
        UNION
        SELECT 
            dt, 
            CASE WHEN at.tag = "SILO1_LVL_temp" THEN 1 
				 WHEN at.tag = "SILO2_LVL_temp" THEN 2 
				 WHEN at.tag = "SILO6_LVL_temp" THEN 6 
                 WHEN at.tag = "SILO7_LVL_temp" THEN 7 END silo_id, 
			NULL product_id, 
			ad.value volume
        FROM 
            gb_plc_analog_data ad JOIN gb_plc_analog_tags at ON ad.tag_id = at.id  
        WHERE 
            tag IN ("SILO1_LVL_temp", "SILO2_LVL_temp", "SILO6_LVL_temp", "SILO7_LVL_temp") AND
            dt > p_date
        ) t JOIN gb_plc_silos so ON t.silo_id = so.id 
    GROUP BY 
        t.dt, t.silo_id, so.capacity_pounds 
    HAVING 
        MAX(t.product_id) IS NOT NULL AND
        MAX(t.volume) IS NOT NULL
    ORDER BY t.dt, t.silo_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_MoistureDayAvgGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_MoistureDayAvgGet`(IN p_location_id int(11), IN p_date datetime)
SELECT avg(moisture_rate) FROM gb_qc_samples
WHERE location_id = p_location_id AND date = p_date AND  moisture_rate != 0 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_MoistureMonthAvgGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_MoistureMonthAvgGet`(IN p_location_id int(11), IN p_date datetime)
SELECT avg(moisture_rate) FROM gb_qc_samples
WHERE location_id = p_location_id AND date BETWEEN p_date AND LAST_DAY(p_date) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_OperatorsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_OperatorsGet`()
BEGIN
SELECT DISTINCT operator FROM gb_plc_shifts;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_PlantProductShiftTagGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlantProductShiftTagGet`(
	IN p_shift_id bigint(20), 
	IN p_tag_id bigint(20), 
	IN p_product_id int(3)
)
SELECT id 
FROM prod_auto_plant_production 
WHERE shift_id = p_shift_id
AND tag_id = p_tag_id
AND product_id = p_product_id
LIMIT 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_PlantsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlantsGet`()
BEGIN
	SELECT 
      id, 
      name 
  FROM 
      silicore_site.main_plants;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_PlantThresholdsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlantThresholdsInsert`(
	IN p_tag_id int(11),
	IN p_user_id int(11),
	IN p_threshold int(11),
	IN p_gauge_max int(11),
  IN p_gauge_action_limit int(11),
  IN p_gauge_warning_limit int(11),
	IN p_send_alert int(1)
)
INSERT INTO gb_plc_plant_thresholds 
(
    tag_id,
    user_id,
    threshold,
	  gauge_max,
    gauge_action_limit,
    gauge_warning_limit,
    send_alert,
    create_date,
    create_user_id,
    is_active
)
VALUES
(
    p_tag_id,
    p_user_id,
    p_threshold,
	  p_gauge_max,
    p_gauge_action_limit,
    p_gauge_warning_limit,
    p_send_alert,
    now(),
    p_user_id,
	1
)
ON DUPLICATE KEY UPDATE
	threshold = p_threshold,
	gauge_max = p_gauge_max,
  gauge_action_limit = p_gauge_action_limit,
  gauge_warning_limit = p_gauge_warning_limit,
	send_alert = p_send_alert,
	modify_date = now(),
	modify_user_id = p_user_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_PlantThresholdsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlantThresholdsUpdate`(
	IN p_id int(11),
	IN p_user_id int(11),
	IN p_threshold int(11),
  IN p_gauge_max int(11),
  IN p_gauge_action_limit int(11),
  IN p_gauge_warning_limit int(11),
	IN p_send_alert int(1)
)
BEGIN
UPDATE gb_plc_plant_thresholds
SET
	threshold = p_threshold,
  gauge_max = p_gauge_max,
  gauge_action_limit = p_gauge_action_limit,
  gauge_warning_limit = p_gauge_warning_limit,
	send_alert = p_send_alert,
	modify_date = now(),
	modify_user_id = p_user_id
WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_PlcDataForExportGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_PlcDataForExportGet`(
IN p_startDate datetime, 
IN p_endDate datetime
)
SELECT 
	id, 
    shift_id, 
    duration_minutes, 
    duration, 
    device, 
    tag_id, 
    tag, 
    create_dt
FROM 
	gb_plc_runtime
WHERE 
	create_dt BETWEEN p_startDate AND p_endDate
ORDER BY 
	id ASC ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ProdAutoProductionInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ProdAutoProductionInsert`(
    IN p_id int(5),
    IN p_shift_id bigint(20), 
    IN p_tons int(5), 
    IN p_tag_id bigint(20), 
    IN p_tag varchar(32), 
    IN p_product_id int(3), 
    IN p_product varchar(32)
)
INSERT INTO prod_auto_plant_production 
(
    id,
    shift_id, 
    tons, 
    tag_id, 
    tag, 
    product_id, 
    product
) 
VALUES
(
    p_id,
    p_shift_id, 
    p_tons, 
    p_tag_id, 
    p_tag, 
    p_product_id, 
    p_product
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ProdProductsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ProdProductsGet`(IN p_tag varchar(32))
SELECT id 
FROM prod_products 
WHERE tag = p_tag
LIMIT 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ProductionInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ProductionInsert`(
	IN p_Xfer_id int(5), 
	IN p_shift_id bigint(20), 
    IN p_tons int(5), 
    IN p_tag_id bigint(20), 
    IN p_tag varchar(32), 
    IN p_product_id int(3), 
    IN p_product varchar(64)
)
INSERT INTO gb_plc_production
(	
    Xfer_id,
    shift_id, 
    tons, 
    tag_id, 
    tag, 
    product_id, 
    product
) 
VALUES
(
    p_Xfer_id,
	  p_shift_id, 
    p_tons, 
    p_tag_id, 
    p_tag, 
    p_product_id, 
    p_product
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ProductionMaxIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ProductionMaxIdGet`()
SELECT id 
FROM prod_auto_plant_production
WHERE id in (SELECT MAX(id) FROM prod_auto_plant_production) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_RainfallAllGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RainfallAllGet`()
(
SELECT date, rainfall, wind, high_temp, low_temp FROM silicore_site.gb_plc_rainfall
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_RainfallDayGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RainfallDayGet`(p_date date)
select rainfall from gb_plc_rainfall where date = p_date ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_RainfallInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RainfallInsert`(
	IN p_date datetime,
    IN p_rainfall decimal(5,2),
    IN p_wind decimal(5,2),
    IN p_high_temp int,
    IN p_low_temp int
)
INSERT INTO gb_plc_rainfall
(
	date,
    rainfall,
    wind,
    high_temp,
    low_temp
)
VALUES
(
	p_date,
    p_rainfall,
    p_wind,
    p_high_temp,
    p_low_temp
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_RainfallMaxDateGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RainfallMaxDateGet`()
(
	SELECT max(date) FROM gb_plc_rainfall
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_RainfallSummaryGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RainfallSummaryGet`()
(
SELECT 
	month(date) as 'Month',
    year(date) as 'Year',
    sum(rainfall) as 'Rainfall',
    round(avg(wind), 2) as 'wind',
    round(avg(high_temp), 2) as 'avg_high_temp',
    round(avg(low_temp), 2) as 'avg_low_temp',
	concat(year(date), '-', concat(month(date)), '-', (01), ' ', '00:00:00') as date_data
FROM
	gb_plc_rainfall
GROUP BY date_data, month(date), year(date)
ORDER BY year(date) ,month(date)
limit 12
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_runtimeCorrect` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_runtimeCorrect`(
		IN  p_id bigint(20),
		IN  p_duration_minutes int(5),
		IN  p_duration decimal(5,2)
)
BEGIN
	UPDATE gb_plc_runtime
		SET duration_minutes = p_duration_minutes,
			duration = p_duration
		WHERE id = p_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_runtimeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`loclahost` PROCEDURE `sp_gb_plc_runtimeGet`(IN p_tag varchar(32), p_startDate datetime, IN p_endDate datetime)
BEGIN

SELECT
    id,
    PR.shift_id,
    PR.duration_minutes,
    PR.duration,
    PR.device,
    PR.tag_id,
    @tag = p_tag,
    PR.create_dt,
    if(@shift_id := PR.shift_id, PR.duration_minutes - @duration_minutes, 0) as real_runtime,
    @shift_id := PR.shift_id,
    @duration_minutes := PR.duration_minutes,
    @startDate := p_startDate,
    @endDate := p_endDate


FROM
	gb_plc_runtime PR,
    (SELECT @shift_id := 0,
			@duration_minutes := 0) SQLVars
WHERE 
	tag = p_tag
	AND create_dt > p_startDate 
	AND create_dt < p_endDate
  AND duration_minutes > 2000


ORDER BY 
    PR.shift_id,
    PR.tag,
    PR.create_dt ASC;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_RuntimeInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RuntimeInsert`(   
  IN p_id int(11),
	IN p_shift_id int(11), 
	IN p_duration_minutes int, 
	IN p_duration decimal(5,2), 
	IN p_device varchar(64), 
	IN p_tag_id int(11), 
	IN p_tag varchar(32), 
	IN p_create_dt datetime
)
BEGIN
INSERT INTO gb_plc_runtime 
(
  id,
	shift_id, 
	duration_minutes, 
	duration, 
  device, 
	tag_id, 
	tag, 
	create_dt
)
VALUES 
(
  p_id,
	p_shift_id, 
	p_duration_minutes,	
	p_duration, 
  p_device, 
  p_tag_id, 
	p_tag, 
  p_create_dt
);
SET SQL_SAFE_UPDATES = 0;
UPDATE gb_plc_shifts s LEFT JOIN gb_plc_runtime r ON r.shift_id = s.id
SET s.duration = r.duration, s.duration_minutes = r.duration_minutes
WHERE r.shift_id = s.id;
SET SQL_SAFE_UPDATES = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_RuntimeMaxIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RuntimeMaxIdGet`()
SELECT MAX(id) AS maxId
FROM gb_plc_runtime ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_SampleDayAvgGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_SampleDayAvgGet`(IN p_location_id int, IN p_date date)
(
SELECT 
	AVG(s.plus_70),
	AVG(s.minus_40_plus_70),
	AVG(s.minus_70), 
	AVG(s.minus_70_plus_140), 
	AVG(s.plus_140), 
	AVG(s.minus_140)
FROM 
	gb_qc_samples s
WHERE 
	date = p_date
    AND
    location_id = p_location_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_SamplesByLocationGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_SamplesByLocationGet`(IN p_start date, IN p_end date, IN p_location_id int)
(
SELECT 
	AVG(s.moisture_rate), 
	AVG(s.plus_70),
	AVG(s.minus_40_plus_70),
	AVG(s.minus_70), 
	AVG(s.minus_70_plus_140), 
	AVG(s.plus_140), 
	AVG(s.minus_140)
FROM 
	gb_qc_samples s
WHERE 
	date BETWEEN p_start AND p_end
    AND
    location_id = p_location_id
    AND
    s.moisture_rate != 0
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_SamplesByPlantGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_SamplesByPlantGet`(IN p_start date, IN p_end date, IN p_plant int(11))
(
SELECT 
	AVG(moisture_rate), 
    AVG(plus_70),
	AVG(minus_40_plus_70),
	AVG(minus_70), 
	AVG(minus_70_plus_140), 
	AVG(plus_140), 
	AVG(minus_140)
FROM 
	gb_qc_samples
WHERE 
	date BETWEEN p_start AND p_end
    AND
    plant_id = p_plant
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_SamplesOverallAvgGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_SamplesOverallAvgGet`(IN p_location int(11))
(
SELECT 
	AVG(moisture_rate), 
  AVG(plus_70),
	AVG(minus_40_plus_70),
	AVG(minus_70), 
	AVG(minus_70_plus_140), 
	AVG(plus_140), 
	AVG(minus_140)
FROM 
	gb_qc_samples
WHERE 
  location_id = p_location
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ScorecardSettingInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ScorecardSettingInsert`(
	IN p_date date,    
	IN p_rotary_gross_setting int(11),  
    IN p_rotary_net_setting int(11), 
	IN p_rotary_output_setting int(11),
	IN p_carrier100_gross_setting int(11),  
    IN p_carrier100_net_setting int(11), 
	IN p_carrier100_output_setting int(11),
	IN p_carrier200_gross_setting int(11),  
    IN p_carrier200_net_setting int(11), 
	IN p_carrier200_output_setting int(11),
    IN p_user_id INT(11)
	
)
BEGIN
INSERT INTO gb_plc_scorecard_settings
(
`date`,
`rotary_gross_setting`,
`rotary_net_setting`,
`rotary_output_setting`,
`carrier100_gross_setting`,
`carrier100_net_setting`,
`carrier100_output_setting`,
`carrier200_gross_setting`,
`carrier200_net_setting`,
`carrier200_output_setting`,
`create_user_id`,
`create_date`
)

VALUES
(
p_date,
p_rotary_gross_setting,
p_rotary_net_setting,
p_rotary_output_setting,
p_carrier100_gross_setting,
p_carrier100_net_setting,
p_carrier100_output_setting,
p_carrier200_gross_setting,
p_carrier200_net_setting,
p_carrier200_output_setting,
p_user_id,
now()
)

ON DUPLICATE KEY UPDATE 
 

    rotary_gross_setting = p_rotary_gross_setting, 
    rotary_net_setting = p_rotary_net_setting, 
    rotary_output_setting = p_rotary_output_setting,
	carrier100_gross_setting = p_carrier100_gross_setting, 
    carrier100_net_setting = p_carrier100_net_setting, 
    carrier100_output_setting = p_carrier100_output_setting,
	carrier200_gross_setting = p_carrier200_gross_setting, 
    carrier200_net_setting = p_carrier200_net_setting, 
    carrier200_output_setting = p_carrier200_output_setting,
    modify_user_id = p_user_id, 
    modify_date = now() ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ScorecardSettingsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ScorecardSettingsGet`(
	IN p_user_id INT (11),
    IN p_date DATE
)
BEGIN

SELECT 
rotary_net_setting, rotary_output_setting, rotary_gross_setting,
carrier100_net_setting, carrier100_output_setting, carrier100_gross_setting,
carrier200_net_setting, carrier200_output_setting, carrier200_gross_setting  
from gb_plc_scorecard_settings
WHERE date = p_date AND create_user_id = p_user_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ShiftInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ShiftInsert`(
IN p_id int(11),
IN p_prod_area_id int(3),
IN p_is_day tinyint(1), 
IN p_start_dt datetime, 
IN p_end_dt datetime,
IN p_operator varchar(64),
IN p_duration_minutes int(5),
IN p_duration decimal(10,4), 
IN p_uptime decimal(10,2),
IN p_downtime decimal(10,4),
IN p_schdowntime decimal(10,4), 
IN p_idletime decimal(10,4)
)
begin
SET foreign_key_checks= 0;

INSERT INTO gb_plc_shifts
(
id,
prod_area_id,
plant_id,  
is_day,  
start_dt, 
end_dt, 
operator,
duration_minutes,
duration,
uptime,
downtime,
schdowntime,
idletime 
)
VALUES
(
p_id,
p_prod_area_id,  
0,    
p_is_day,  
p_start_dt, 
p_end_dt, 
p_operator,
p_duration_minutes,
p_duration,
p_uptime,
p_downtime,
p_schdowntime,
p_idletime  
);

SET foreign_key_checks= 1;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ShiftsMaxIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ShiftsMaxIdGet`()
SELECT MAX(id) As maxId
FROM gb_plc_shifts ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ShiftSummaryByDateGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ShiftSummaryByDateGet`(IN p_prod_area_id int, IN p_start_dt datetime, IN p_end_dt datetime)
(
SELECT prod_area_id, sum(duration_minutes) AS 'duration_minutes', sum(uptime) AS 'uptime', sum(downtime) AS 'downtime', sum(idletime) AS 'idletime'
FROM gb_plc_shifts
WHERE prod_area_id = p_prod_area_id AND start_dt > p_start_dt AND end_dt < p_end_dt

) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ShiftTimesDayGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ShiftTimesDayGet`(IN p_prod_area_id int, IN p_start_time datetime, IN p_end_time datetime)
(
SELECT 
    SUM(duration_minutes) AS 'duration_minutes',
    SUM(uptime) AS 'uptime',
    SUM(downtime) AS 'downtime',
    SUM(idletime) AS 'idletime',
    SUM(schdowntime) AS 'schdowntime'
FROM
    gb_plc_shifts
WHERE
     prod_area_id = p_prod_area_id and start_dt BETWEEN p_start_time AND p_end_time
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ShiftTimesSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ShiftTimesSumGet`(IN p_prod_area_id int, IN p_start_dt datetime)
(
SELECT prod_area_id, sum(duration_minutes) AS 'duration_minutes', sum(uptime) AS 'uptime', sum(downtime) AS 'downtime', sum(idletime) AS 'idletime'
FROM gb_plc_shifts
WHERE prod_area_id = p_prod_area_id AND start_dt BETWEEN p_start_dt AND LAST_DAY(p_start_dt)

) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_Silo1LevelGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_plc_Silo1LevelGet`()
select value from gb_plc_TS_10minute ts where tag_id = 78 order by id desc limit 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_Silo2LevelGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_plc_Silo2LevelGet`()
select value from gb_plc_TS_10minute ts where tag_id = 79 order by id desc limit 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_Silo6LevelGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_plc_Silo6LevelGet`()
select value from gb_plc_TS_10minute ts where tag_id = 80 order by id desc limit 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_Silo7LevelGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_plc_Silo7LevelGet`()
select value from gb_plc_TS_10minute ts where tag_id = 81 order by id desc limit 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_Silo8LevelGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_plc_Silo8LevelGet`()
select value from gb_plc_TS_10minute ts where tag_id = 82 order by id desc limit 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_Silo9LevelGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_plc_Silo9LevelGet`()
select value from gb_plc_TS_10minute ts where tag_id = 83 order by id desc limit 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_SiloLevelGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_plc_SiloLevelGetAll`()
begin
select s1.silo1_val, s2.silo2_val, s6.silo6_val, s7.silo7_val, s8.silo8_val, s9.silo9_val, ts.timestamp from gb_plc_TS_10minute ts 
join (select  id, value as silo1_val, timestamp from gb_plc_TS_10minute where tag_id = 78 order by id desc) s1 on ts.id = s1.id
join (select  id, value as silo2_val, timestamp from gb_plc_TS_10minute where tag_id = 79 order by id desc) s2 on ts.timestamp = s2.timestamp
join (select  id, value as silo6_val, timestamp from gb_plc_TS_10minute where tag_id = 80 order by id desc) s6 on ts.timestamp = s6.timestamp
join (select  id, value as silo7_val, timestamp from gb_plc_TS_10minute where tag_id = 81 order by id desc) s7 on ts.timestamp = s7.timestamp
join (select  id, value as silo8_val, timestamp from gb_plc_TS_10minute where tag_id = 82 order by id desc) s8 on ts.timestamp = s8.timestamp
join (select  id, value as silo9_val, timestamp from gb_plc_TS_10minute where tag_id = 83 order by id desc) s9 on ts.timestamp = s9.timestamp
order by ts.id desc limit 72;end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_TagAutomatedInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagAutomatedInsert`(
    p_tag varchar(50),
    p_address varchar(50),
    p_ehouse varchar(50)
)
BEGIN
set FOREIGN_KEY_CHECKS = 0;
	INSERT INTO `silicore_site`.`gb_plc_tags`
		(
    `ui_label`,
		`classification`,
    `ehouse`,
		`tag`,
		`address`,
		`units`,
		`plant_id`,
    `create_user_id`,
    `create_date`
     )
	VALUES
		(
    'Needs Definition',
		'Needs Definition',
    p_ehouse,
		p_tag,
		p_address,
		'ND',
		31,
    25,
    now()
    );
    set FOREIGN_KEY_CHECKS = 1;
    SELECT id FROM gb_plc_tags 
    WHERE tag like p_tag
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_TagByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagByIdGet`(IN p_id int(11))
(
select ui_label, tag, address
from gb_plc_tags
where id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_TagIdByNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagIdByNameGet`(
	p_address varchar(50)
)
BEGIN
	SELECT id FROM gb_plc_tags
  WHERE address like p_address;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_TagInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagInsert`(
	  p_ui_label varchar(50),
    p_classification varchar(50),
    p_ehouse varchar(4),
    p_tag varchar(50),
    p_address varchar(50),
    p_units varchar(50),
    p_plant_id int(11),
    p_user_id int(11)
)
BEGIN
	INSERT INTO `silicore_site`.`gb_plc_analog_tags`
		(
    `ui_label`,
		`classification`,
    `ehouse`,
		`tag`,
		`address`,
		`units`,
		`plant_id`,
    `create_user_id`,
    `create_date`
        )
	VALUES
		(
    p_ui_label,
		p_classification,
    p_ehouse,
		p_tag,
		p_address,
		p_units,
		p_plant_id,
    p_user_id,
    now()
        )
    ON DUPLICATE KEY UPDATE
		ui_label = p_ui_label,
		classification = p_classification,
    ehouse = p_ehouse,
		tag = p_tag,
		address = p_address,
		units = p_units,
		plant_id = p_plant_id,
		modify_date = now(),
    modify_user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_TagsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagsGet`()
BEGIN
SELECT 
	id,
  ui_label,
  classification,
  tag,
  address,
  units
FROM 
	gb_plc_tags
WHERE is_active = 1 AND is_kpi = 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_tceq_pull` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_tceq_pull`()
BEGIN
declare first_day date;
declare last_day date;
declare p_wp1_tons int(11);
declare p_wp2_tons int(11);
declare p_100t_tons int(11);
declare p_200t_tons int(11);
declare p_rotary_tons int(11);

declare p_wp1_moisture_rate DECIMAL(6,2);
declare p_wp2_moisture_rate DECIMAL(6,2);
declare p_100t_moisture_rate DECIMAL(6,2);
declare p_200t_moisture_rate DECIMAL(6,2);
declare p_rotary_moisture_rate DECIMAL(6,2);

declare p_wp1_uptime DECIMAL(7,2);
declare p_wp2_uptime DECIMAL(7,2);
declare p_100t_uptime DECIMAL(7,2);
declare p_200t_uptime DECIMAL(7,2);
declare p_rotary_uptime DECIMAL(7,2);

declare p_rainfall DECIMAL(6,2);


select last_day(curdate() - interval 2 month) + interval 1 day into first_day;
select last_day(curdate() - interval 1 month) into last_day;

SELECT sum(value) from gb_plc_TS_12Hour where timestamp between '2018-03-01' and '2018-03-31' AND tag_id = 8 into p_wp1_tons;
SELECT sum(value) from gb_plc_TS_12Hour where timestamp between '2018-03-01' and '2018-03-31' AND tag_id = 4 into p_wp2_tons;
SELECT sum(value) from gb_plc_TS_12Hour where timestamp between '2018-03-01' and '2018-03-31' AND tag_id = 28 into p_100t_tons;
SELECT sum(value) from gb_plc_TS_12Hour where timestamp between '2018-03-01' and '2018-03-31' AND tag_id = 22 into p_200t_tons;
SELECT sum(value) from gb_plc_TS_12Hour where timestamp between '2018-03-01' and '2018-03-31' AND tag_id = 18 into p_rotary_tons;

SELECT avg(moisture_rate) from gb_qc_samples where date between '2018-03-01' and '2018-03-31' and location_id = 128 into p_wp1_moisture_rate;
SELECT avg(moisture_rate) from gb_qc_samples where date between '2018-03-01' and '2018-03-31' and location_id = 127 into p_wp2_moisture_rate;
SELECT avg(moisture_rate) from gb_qc_samples where date between '2018-03-01' and '2018-03-31' and location_id = 24 into p_100t_moisture_rate;
SELECT avg(moisture_rate) from gb_qc_samples where date between '2018-03-01' and '2018-03-31' and location_id = 103 into p_200t_moisture_rate;
SELECT avg(moisture_rate) from gb_qc_samples where date between '2018-03-01' and '2018-03-31' and location_id = 49 into p_rotary_moisture_rate;

SELECT sum(uptime)/60 from gb_plc_shifts where end_dt between '2018-03-01' and '2018-03-31' AND prod_area_id = 1 into p_wp1_uptime;
SELECT sum(uptime)/60 from gb_plc_shifts where end_dt between '2018-03-01' and '2018-03-31' AND prod_area_id = 1 into p_wp2_uptime;
SELECT sum(uptime)/60 from gb_plc_shifts where end_dt between '2018-03-01' and '2018-03-31' AND prod_area_id = 5 into p_100t_uptime;
SELECT sum(uptime)/60 from gb_plc_shifts where end_dt between '2018-03-01' and '2018-03-31' AND prod_area_id = 8 into p_200t_uptime;
SELECT sum(uptime)/60 from gb_plc_shifts where end_dt between '2018-03-01' and '2018-03-31' AND prod_area_id = 6 into p_rotary_uptime;

SELECT sum(rainfall) from gb_plc_rainfall where date between '2018-03-01' and '2018-03-31' into p_rainfall; 

 
INSERT INTO gb_plc_tceq 
(
	start_date, 
	end_date,
	wp1_tons,
	wp2_tons,
	100t_tons,
	200t_tons,
	rotary_tons,
	wp1_moisture_rate,
	wp2_moisture_rate, 
	100t_moisture_rate,
	200t_moisture_rate,
	rotary_moisture_rate,
	wp1_uptime, 
	wp2_uptime,
	100t_uptime,
	200t_uptime,
	rotary_uptime,
	rainfall
 )
 VALUES
 (
'2018-03-01',
'2018-03-31',
	 p_wp1_tons,
	 p_wp2_tons,
	 p_100t_tons,
	 p_200t_tons,
	 p_rotary_tons,
	 p_wp1_moisture_rate,
	 p_wp2_moisture_rate,
	 p_100t_moisture_rate,
	 p_200t_moisture_rate,
	 p_rotary_moisture_rate,
	 p_wp1_uptime,
	 p_wp2_uptime,
	 p_100t_uptime,
	 p_200t_uptime,
	 p_rotary_uptime,
	 p_rainfall 
 );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ThresholdsByTagIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ThresholdsByTagIdGet`(
	IN p_tag_id int(11)
)
(
SELECT 
	threshold,
    user_id
FROM 
	gb_plc_plant_thresholds
WHERE tag_id = p_tag_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ThresholdsGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ThresholdsGetAll`()
(
SELECT
	threshold,
	user_id,
	tag_id
FROM
	gb_plc_plant_thresholds
WHERE
	send_alert = 1
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_ThresholdUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ThresholdUpdate`(
		IN  p_description varchar(256),
		IN  p_gauge_min float,
		IN  p_gauge_max float,
		IN  p_low_threshold float,
		IN  p_high_threshold float
)
BEGIN
	UPDATE gb_plc_tags
		SET description = p_description,
			gauge_min = p_gauge_min,
			gauge_max = p_gauge_max,
			low_threshold = p_low_threshold,
      high_threshold = p_high_threshold
		WHERE id = p_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_UnitsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_UnitsGet`()
BEGIN
		SELECT DISTINCT units 
        FROM gb_plc_analog_tags 
        WHERE units IS NOT NULL; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_plc_UserThresholdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_UserThresholdGet`(IN p_tag_id int(11), IN p_user_id int(11))
(
SELECT
	id,
	threshold,
  gauge_max,
  gauge_action_limit,
  gauge_warning_limit,
  send_alert
FROM
	gb_plc_plant_thresholds
WHERE
	tag_id = p_tag_id AND user_id = p_user_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_CleanSieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_CleanSieveStackUpdate`(IN p_id int(11), IN p_site_id INT(11), IN p_user_id int(11))
update gb_qc_sieve_stacks
set last_cleaned = now(),
 last_cleaned_by = p_user_id
where id = p_id AND main_site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_CompletedSamplesInDateRangeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_CompletedSamplesInDateRangeGet`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * FROM gb_qc_samples 
    WHERE void_status_code != 'V' 
    AND date >= p_start_date
    AND date <= p_end_date
    AND is_complete = '1'
    ORDER BY date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_CompletedSamplesInDateRangeGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_CompletedSamplesInDateRangeGetByLabTech`(
    IN  p_lab_tech_id VARCHAR(32),
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * FROM gb_qc_samples 
    WHERE void_status_code != 'V' 
    AND lab_tech = p_lab_tech_id
    AND date >= p_start_date
    AND date <= p_end_date
    AND is_complete = '1'
    ORDER BY date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_CompositeTypeGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_CompositeTypeGetByID`(
    IN  p_compositeTypeId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_composites
    WHERE id = p_compositeTypeId
LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_CompositeTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_CompositeTypesGet`()
BEGIN
    SELECT * from gb_qc_composites;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_DateRangePercentAveragesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_DateRangePercentAveragesGet`(
    IN p_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT gb_qc_samples.id, DATE_FORMAT(gb_qc_samples.date, '%Y-%m-%d') as 'date', gb_qc_finalpercentages.finalpercent1, gb_qc_finalpercentages.finalpercent2, gb_qc_finalpercentages.finalpercent3, gb_qc_finalpercentages.finalpercent4, gb_qc_finalpercentages.finalpercent5, gb_qc_finalpercentages.finalpercent6, gb_qc_finalpercentages.finalpercent7, gb_qc_finalpercentages.finalpercent8, gb_qc_finalpercentages.finalpercent9, gb_qc_finalpercentages.finalpercent10, gb_qc_finalpercentages.finalpercent11, gb_qc_finalpercentages.finalpercent12, gb_qc_finalpercentages.finalpercent13, gb_qc_finalpercentages.finalpercent14, gb_qc_finalpercentages.finalpercent15, gb_qc_finalpercentages.finalpercent16, gb_qc_finalpercentages.finalpercent17, gb_qc_finalpercentages.finalpercent18, gb_qc_samples.plus_40, gb_qc_samples.plus_70, gb_qc_samples.minus_40_plus_70, gb_qc_samples.minus_70, gb_qc_samples.minus_70_plus_140, gb_qc_samples.plus_140, gb_qc_samples.minus_140
    FROM gb_qc_samples
    LEFT JOIN gb_qc_finalpercentages ON gb_qc_samples.id = gb_qc_finalpercentages.sample_id
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND location_id = p_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_DateRangePercentSamplesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_DateRangePercentSamplesGet`(
    IN p_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT gb_qc_samples.id, DATE_FORMAT(gb_qc_samples.date, '%Y-%m-%d') as 'date',gb_qc_samples.sieve_1_value,gb_qc_samples.sieve_2_value,gb_qc_samples.sieve_3_value,gb_qc_samples.sieve_4_value,gb_qc_samples.sieve_5_value,gb_qc_samples.sieve_6_value,gb_qc_samples.sieve_7_value,gb_qc_samples.sieve_8_value,gb_qc_samples.sieve_9_value,gb_qc_samples.sieve_10_value,gb_qc_samples.sieve_11_value,gb_qc_samples.sieve_12_value,gb_qc_samples.sieve_13_value,gb_qc_samples.sieve_14_value,gb_qc_samples.sieve_15_value,gb_qc_samples.sieve_16_value,gb_qc_samples.sieve_17_value,gb_qc_samples.sieve_18_value, gb_qc_samples.plus_70, gb_qc_samples.plus_50, gb_qc_samples.plus_40, gb_qc_samples.minus_40_plus_70, gb_qc_samples.minus_70, gb_qc_samples.minus_70_plus_140, gb_qc_samples.plus_140, gb_qc_samples.minus_140, 
    oversize_percent, minus_140_plus_325, minus_60_plus_70,
    near_size, minus_50_plus_140
    FROM gb_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND location_id = p_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_DateRangePercentSamplesGetBySpecificLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_DateRangePercentSamplesGetBySpecificLocation`(
    IN p_specific_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT gb_qc_samples.id, DATE_FORMAT(gb_qc_samples.date, '%Y-%m-%d') as 'date',
    gb_qc_samples.sieve_1_value,
    gb_qc_samples.sieve_2_value,
    gb_qc_samples.sieve_3_value,
    gb_qc_samples.sieve_4_value,
    gb_qc_samples.sieve_5_value,
    gb_qc_samples.sieve_6_value,
    gb_qc_samples.sieve_7_value,
    gb_qc_samples.sieve_8_value,
    gb_qc_samples.sieve_9_value,
    gb_qc_samples.sieve_10_value,
    gb_qc_samples.sieve_11_value,
    gb_qc_samples.sieve_12_value,
    gb_qc_samples.sieve_13_value,
    gb_qc_samples.sieve_14_value,
    gb_qc_samples.sieve_15_value,
    gb_qc_samples.sieve_16_value,
    gb_qc_samples.sieve_17_value,
    gb_qc_samples.sieve_18_value, 
    gb_qc_samples.plus_70,
    gb_qc_samples.plus_40,
    gb_qc_samples.minus_40_plus_70,
    gb_qc_samples.minus_70, gb_qc_samples.minus_70_plus_140, gb_qc_samples.plus_140, gb_qc_samples.minus_140
    FROM gb_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND specific_location_id = p_specific_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_FinalPercentagesGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_FinalPercentagesGetByID`(
    IN p_sample_id INT(11)
)
BEGIN
    SELECT * 
    FROM gb_qc_finalpercentages 
    WHERE sample_id = p_sample_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_FinalPercentagesInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_FinalPercentagesInsert`(
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
INSERT INTO gb_qc_finalpercentages 
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_FinalPercentagesUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_FinalPercentagesUpdate`(
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
gb_qc_finalpercentages 
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

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetCompositeTypeByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetCompositeTypeByID`(
    IN  p_compositeTypeId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_composites
    WHERE id = p_compositeTypeId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetCompositeTypes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetCompositeTypes`()
BEGIN
    SELECT * from gb_qc_composites;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetKValues` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetKValues`()
BEGIN
    SELECT * from gb_qc_k_values;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetLabTechs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetLabTechs`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
        mu.display_name,
        mu.email,
        mu.company,
        mu.main_department_id,
		mu.password, 
		mu.last_logged,
		mu.start_date,
		mu.separation_date, 
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		mu.role_check,
		mu.user_type_id, 
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id, 
		mu.is_active
FROM main_users mu INNER JOIN main_users_roles_check rc ON rc.user_id = mu.id 
WHERE rc.role_id = 3;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetLocations` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetLocations`()
BEGIN
    SELECT * from gb_qc_locations 
    WHERE is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetOperators` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetOperators`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
        mu.display_name,
        mu.email,
        mu.company,
        mu.main_department_id,
		mu.password, 
		mu.last_logged,
		mu.start_date,
		mu.separation_date, 
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		mu.role_check,
		mu.user_type_id, 
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id, 
		mu.is_active
FROM main_users mu INNER JOIN main_users_roles_check rc ON rc.user_id = mu.id 
WHERE rc.role_id = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetPlantByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetPlantByID`(
    IN  p_plantId varchar(64)
)
BEGIN
SELECT * FROM main_plants
    WHERE id = p_plantId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetPlants` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetPlants`()
BEGIN
    SELECT * from main_plants 
    where is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetSampleByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetSampleByID`(
    IN  p_sampleId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_samples
    WHERE id = p_sampleId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetSamplers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetSamplers`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
        mu.display_name,
        mu.email,
        mu.company,
        mu.main_department_id,
		mu.password, 
		mu.last_logged,
		mu.start_date,
		mu.separation_date, 
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		mu.role_check,
		mu.user_type_id, 
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id, 
		mu.is_active
FROM main_users mu INNER JOIN main_users_roles_check rc ON rc.user_id = mu.id 
WHERE rc.role_id = 2;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetSamples` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetSamples`()
BEGIN
    SELECT * from gb_qc_samples;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetSievesByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetSievesByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_sieves
WHERE sieve_stack_id = p_sieveStackId; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetSieveStackByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetSieveStackByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_sieve_stacks
    WHERE id = p_sieveStackId
    ORDER BY sort_order ASC
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetSieveStacks` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetSieveStacks`()
BEGIN
    SELECT * from gb_qc_sieve_stacks WHERE is_active = '1' ORDER BY sort_order;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetTestTypeByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetTestTypeByID`(
    IN  p_testTypeId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_test_types
    WHERE id = p_testTypeId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_GetTestTypes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_GetTestTypes`()
BEGIN
    SELECT * from gb_qc_test_types;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_InsertSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_InsertSample`(
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
    IN  p_shift VARCHAR(5)
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_KPIPLCTagsGetByPlantID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_KPIPLCTagsGetByPlantID`(
    IN p_plant_id INT(11)
)
BEGIN
    SELECT * FROM prod_auto_plant_analog_tags
    WHERE is_kpi = 1
    AND is_mir = 1
    AND is_hidden = 0
    AND is_removed = 0
    AND plant_id = p_plant_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_KValueRecordGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_KValueRecordGet`(
    IN  p_sample_id INT(11),
    IN  p_k_value_id INT(11),
    IN  p_description VARCHAR(50)
)
BEGIN
    SELECT * FROM gb_qc_k_value_records 
    WHERE sample_id = p_sample_id
    AND k_value_id = p_k_value_id
    AND description = p_description
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_KValueRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_KValueRecordInsert`(
    IN p_sample_id INT(11),
    IN p_k_value_id INT(11),
    IN p_description VARCHAR(50),
    IN p_value DOUBLE
)
BEGIN
    INSERT INTO gb_qc_k_value_records 
    (
        sample_id,
        k_value_id, 
        description, 
        value
    ) 
    VALUES 
    (
        p_sample_id, 
        p_k_value_id, 
        p_description, 
        p_value
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_KValueRecordUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_KValueRecordUpdate`(
    IN p_value DOUBLE,
    IN p_id INT(11),
    IN p_k_value_id INT(11),
    IN p_description VARCHAR(50) 
)
BEGIN
    UPDATE gb_qc_k_value_records 
    SET `value` = p_value 
    WHERE `sample_id` = p_id
    AND `k_value_id` = p_k_value_id
    AND `description` = p_description;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_KValuesBySampleIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_KValuesBySampleIdGet`(
    IN  p_sample_id INT(11)
)
BEGIN
    SELECT kr.*, kv.description FROM gb_qc_k_value_records kr join gb_qc_k_values kv on kv.id = kr.k_value_id
    WHERE kr.sample_id = p_sample_id and kr.value > 0 order by kr.k_value_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_KValuesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_KValuesGet`()
BEGIN
    SELECT * from gb_qc_k_values;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationDetailsByNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationDetailsByNameGet`(IN site_id int(11))
(
select
	locd.id, locd.qc_location_id AS 'location_id', loc.description AS 'location', locd.description AS 'specific_location', locd.sort_order, locd.is_active
from
	gb_qc_locations_details locd
right join
	gb_qc_locations loc ON locd.qc_location_id = loc.id
where loc.main_site_id = site_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationDetailsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationDetailsInsert`(
IN p_qc_location_id int(11),
IN p_description varchar(255),
IN p_create_user_id int(11)
)
begin
set @sort = (select max(sort_order)+10 from gb_qc_locations_details);
insert into gb_qc_locations_details
(
qc_location_id,
description,
sort_order,
create_date,
create_user_id
)
values
(
p_qc_location_id,
p_description,
@sort,
now(),
p_create_user_id
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationDetailsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationDetailsUpdate`(
IN p_id int(11),
IN p_qc_location_id int(11),
IN p_description varchar(255),
IN p_sort_order int(11),
IN p_is_active tinyint(1),
IN p_modify_user_id int(11)
)
update gb_qc_locations_details
set
qc_location_id = p_qc_location_id,
description = p_description,
sort_order = p_sort_order,
modify_date = now(),
is_active = p_is_active,
modify_user_id = p_modify_user_id
where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationGetByID`(
    IN  p_locationId INT(11)
)
BEGIN
SELECT * FROM gb_qc_locations
    WHERE id = p_locationId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationInsert`(
IN p_description varchar(255), 
IN p_main_site_id int(11), 
IN p_main_plant_id int(11),
IN p_is_split_sample_only tinyint(1),
IN p_create_user_id int(11)
)
BEGIN
set @sort = (select max(sort_order)+10 from gb_qc_locations);
insert into gb_qc_locations 
(
description, 
main_site_id, 
main_plant_id,
is_split_sample_only,
sort_order,
create_date,
create_user_id
)
values 
(
p_description, 
p_main_site_id, 
p_main_plant_id,
p_is_split_sample_only,
@sort,
now(),
p_create_user_id
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationsDelete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationsDelete`(IN P_id INT(11))
BEGIN
DELETE FROM gb_qc_locations WHERE id = p_id LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationsGet`()
BEGIN
    SELECT * from gb_qc_locations
    WHERE is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationsGetByPlant` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationsGetByPlant`(
    IN  p_main_plant_id INT(11)
)
BEGIN
    SELECT * FROM gb_qc_locations 
    WHERE is_active = 1 
    AND main_plant_id = p_main_plant_id
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationsNamesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationsNamesGet`()
SELECT 
    l.id,
    l.sort_order,
    s.id as 'site_id',
    s.description as 'site',
    p.id as 'plant_id',
    p.name,
    l.description as 'description',
    l.is_split_sample_only,
    l.is_active
FROM
    gb_qc_locations l
JOIN 
	main_sites s on s.id = l.main_site_id
JOIN
	main_plants p on p.id = l.main_plant_id
ORDER BY l.sort_order desc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_LocationsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_LocationsUpdate`(
IN p_id int(11),
IN p_description varchar(256),
IN p_main_site_id int(11), 
IN p_main_plant_id int(11),
IN p_is_split_sample_only tinyint(1),
IN p_sort_order int(11),
IN p_is_active tinyint(1),
IN p_modify_user_id int(11)
)
UPDATE gb_qc_locations
SET
id = p_id,
description = p_description,
main_site_id = p_main_site_id,
main_plant_id = p_main_plant_id,
is_split_sample_only = p_is_split_sample_only,
sort_order = p_sort_order,
is_active = p_is_active,
modify_date = now(),
modify_user_id = p_modify_user_id
WHERE 
id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_MaxFinalPercentageIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_MaxFinalPercentageIDGet`(
    
)
BEGIN
    SELECT MAX(id) 
    FROM gb_qc_finalpercentages 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_MaxRepeatabilityPairIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_MaxRepeatabilityPairIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM gb_qc_repeatability_pairs
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_MaxRepeatabilityUserIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_MaxRepeatabilityUserIDGet`(
    
)
BEGIN
    SELECT MAX(id) 
    FROM gb_qc_user_repeatability
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_MaxSampleIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_MaxSampleIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM gb_qc_samples 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_MaxSieveStackIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_MaxSieveStackIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM gb_qc_sieve_stacks
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_MoistureRateGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_MoistureRateGet`(in p_sample_id int(11))
select moisture_rate from gb_qc_samples where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_MostRecentSampleBySpecificLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_MostRecentSampleBySpecificLocation`(
    IN  p_specific_location_id int(11)
)
BEGIN
SELECT * FROM gb_qc_samples 
    WHERE void_status_code != 'V' 
    AND test_type_id != '7'
    AND specific_location_id = p_specific_location_id
    AND is_complete = 1 
    ORDER BY id DESC 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_OperatorsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_OperatorsGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
		CONCAT(mu.first_name, ' ', mu.last_name) AS display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		rc.role_id,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu LEFT JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 1
AND mu.is_active = 1
ORDER BY first_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PerformanceCyclesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PerformanceCyclesGet`(
    IN p_plant_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT lab_tech, 
        sum(case when test_type_id = 1 then 1 else 0 end) as test_type_1_count, 
        sum(case when test_type_id = 2 then 1 else 0 end) as test_type_2_count, 
        sum(case when test_type_id = 3 then 1 else 0 end) as test_type_3_count, 
        sum(case when test_type_id = 4 then 1 else 0 end) as test_type_4_count, 
        sum(case when test_type_id = 5 then 1 else 0 end) as test_type_5_count, 
        sum(case when test_type_id = 6 then 1 else 0 end) as test_type_6_count,
        sum(case when test_type_id = 7 then 1 else 0 end) as test_type_7_count,        
        avg(duration) as duration 
    FROM gb_qc_samples 
    WHERE dt >= p_start_date 
        AND dt <= p_end_date 
        AND plant_id = p_plant_id 
        AND lab_tech != '' 
        GROUP by lab_tech;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PerformanceCyclesGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PerformanceCyclesGetByLabTech`(
    IN p_plant_id INT(11),
    IN p_lab_tech INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT lab_tech, 
        sum(case when test_type_id = 1 then 1 else 0 end) as test_type_1_count, 
        sum(case when test_type_id = 2 then 1 else 0 end) as test_type_2_count, 
        sum(case when test_type_id = 3 then 1 else 0 end) as test_type_3_count, 
        sum(case when test_type_id = 4 then 1 else 0 end) as test_type_4_count, 
        sum(case when test_type_id = 5 then 1 else 0 end) as test_type_5_count, 
        sum(case when test_type_id = 6 then 1 else 0 end) as test_type_6_count,    
        sum(case when test_type_id = 7 then 1 else 0 end) as test_type_7_count,
        avg(duration) as duration 
    FROM gb_qc_samples 
    WHERE dt >= p_start_date 
        AND dt <= p_end_date 
        AND plant_id = p_plant_id 
        AND lab_tech = p_lab_tech 
        GROUP by lab_tech;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PlantsBySiteGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PlantsBySiteGet`(
   IN  p_main_site_id INT(11)
)
BEGIN
   SELECT main_site_id, name FROM main_plants
   WHERE is_active = 1
   AND main_site_id = p_main_site_id
   ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PlantSettingsDataByTagAndSampleIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PlantSettingsDataByTagAndSampleIDGet`(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11)
)
BEGIN
    SELECT prod_plant_mir_data.id, prod_plant_mir_data.sample_id, prod_plant_mir_data.tag_id, prod_plant_mir_data.value, prod_auto_plant_analog_tags.device 
    FROM prod_plant_mir_data 
    LEFT JOIN prod_auto_plant_analog_tags ON prod_plant_mir_data.tag_id = prod_auto_plant_analog_tags.id 
    WHERE prod_plant_mir_data.sample_id = p_sample_id 
    AND prod_plant_mir_data.tag_id = p_tag_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PlantSettingsRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PlantSettingsRecordInsert`(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11),
    IN p_value DECIMAL(16,4)
)
BEGIN
    INSERT INTO prod_plant_mir_data 
    (
        sample_id, 
        tag_id, 
        value
    ) 
    VALUES 
    (
        p_sample_id, 
        p_tag_id, 
        p_value
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PlantSettingsRecordUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PlantSettingsRecordUpdate`(
    IN p_value DECIMAL(16,4),
    IN p_id INT(11)
)
BEGIN
    UPDATE prod_plant_mir_data 
    SET `value` = p_value
    WHERE `id` = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PlantsGetBySite` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PlantsGetBySite`(
    IN  p_main_site_id INT(11)
)
BEGIN
    SELECT * FROM main_plants 
    WHERE is_active = 1 
    AND main_site_id = p_main_site_id
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PLCTagsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PLCTagsGet`(

)
BEGIN
    SELECT * FROM prod_auto_plant_analog_tags WHERE is_mir = 1 AND is_hidden = 0 AND is_removed = 0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_PLCTagsGetByPlantID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PLCTagsGetByPlantID`(
    IN p_plant_id INT(11)
)
BEGIN
    SELECT * FROM prod_auto_plant_analog_tags 
    WHERE is_mir = 1 
    AND is_hidden = 0 
    AND is_removed = 0 
    AND plant_id = p_plant_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_QCThresholdsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_QCThresholdsGet`(
    IN  p_location_id INT(11),
    IN  p_screen VARCHAR(16)
)
BEGIN
    SELECT * FROM gb_qc_thresholds 
    WHERE location_id = p_location_id
        AND screen = p_screen;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_QCThresholdsGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_QCThresholdsGetAll`(
)
BEGIN
    SELECT * FROM gb_qc_thresholds
    WHERE is_active = 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabilityGetByUserID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilityGetByUserID`(
    IN p_user_id INT(11)
)
BEGIN

    SELECT * 
    FROM gb_qc_user_repeatability 
    WHERE user_id = p_user_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabilitySamplePairInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilitySamplePairInsert`(
    IN p_original_sample BIGINT(20),
    IN p_repeated_sample BIGINT(20),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO gb_qc_repeatability_pairs 
    (
        original_sample, 
        repeated_sample
    ) 
    VALUES 
    (
        p_original_sample, 
        p_repeated_sample
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabilitySamplePairsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilitySamplePairsGet`(
  IN p_start_date DATE, IN p_end_date DATE
)
BEGIN
SELECT
  pairs.id,
  pairs.original_sample,
  pairs.repeated_sample,
  original.date AS original_date,
  repeated.date AS repeated_date,
  original.lab_tech AS original_lab_tech,
  repeated.lab_tech AS repeated_lab_tech,
  original.location_id AS original_location_id,
  repeated.location_id AS repeated_location_id,
  original.sieve_method_id AS original_sieve_method_id,
  repeated.sieve_method_id AS repeated_sieve_method_id,
  original.sieve_1_desc AS original_sieve_1_desc,
  original.sieve_2_desc AS original_sieve_2_desc,
  original.sieve_3_desc AS original_sieve_3_desc,
  original.sieve_4_desc AS original_sieve_4_desc,
  original.sieve_5_desc AS original_sieve_5_desc,
  original.sieve_6_desc AS original_sieve_6_desc,
  original.sieve_7_desc AS original_sieve_7_desc,
  original.sieve_8_desc AS original_sieve_8_desc,
  original.sieve_9_desc AS original_sieve_9_desc,
  original.sieve_10_desc AS original_sieve_10_desc,
  original.sieve_1_value AS original_sieve_1_value,
  original.sieve_2_value AS original_sieve_2_value,
  original.sieve_3_value AS original_sieve_3_value,
  original.sieve_4_value AS original_sieve_4_value,
  original.sieve_5_value AS original_sieve_5_value,
  original.sieve_6_value AS original_sieve_6_value,
  original.sieve_7_value AS original_sieve_7_value,
  original.sieve_8_value AS original_sieve_8_value,
  original.sieve_9_value AS original_sieve_9_value,
  original.sieve_10_value AS original_sieve_10_value,
  original.plus_70 AS original_plus_70,
  original.plus_50 AS original_plus_50,
original.plus_40 AS original_plus_40,
  repeated.sieve_1_desc AS repeated_sieve_1_desc,
  repeated.sieve_2_desc AS repeated_sieve_2_desc,
  repeated.sieve_3_desc AS repeated_sieve_3_desc,
  repeated.sieve_4_desc AS repeated_sieve_4_desc,
  repeated.sieve_5_desc AS repeated_sieve_5_desc,
  repeated.sieve_6_desc AS repeated_sieve_6_desc,
  repeated.sieve_7_desc AS repeated_sieve_7_desc,
  repeated.sieve_8_desc AS repeated_sieve_8_desc,
  repeated.sieve_9_desc AS repeated_sieve_9_desc,
  repeated.sieve_10_desc AS repeated_sieve_10_desc,
  repeated.sieve_1_value AS repeated_sieve_1_value,
  repeated.sieve_2_value AS repeated_sieve_2_value,
  repeated.sieve_3_value AS repeated_sieve_3_value,
  repeated.sieve_4_value AS repeated_sieve_4_value,
  repeated.sieve_5_value AS repeated_sieve_5_value,
  repeated.sieve_6_value AS repeated_sieve_6_value,
  repeated.sieve_7_value AS repeated_sieve_7_value,
  repeated.sieve_8_value AS repeated_sieve_8_value,
  repeated.sieve_9_value AS repeated_sieve_9_value,
  repeated.sieve_10_value AS repeated_sieve_10_value,
  repeated.plus_70 AS repeated_plus_70,
  repeated.plus_50 AS repeated_plus_50,
  repeated.plus_40 AS repeated_plus_40,
  original.sieve_11_desc AS original_sieve_11_desc,
  original.sieve_12_desc AS original_sieve_12_desc,
  original.sieve_13_desc AS original_sieve_13_desc,
  original.sieve_14_desc AS original_sieve_14_desc,
  original.sieve_15_desc AS original_sieve_15_desc,
  original.sieve_16_desc AS original_sieve_16_desc,
  original.sieve_17_desc AS original_sieve_17_desc,
  original.sieve_18_desc AS original_sieve_18_desc,
  original.sieve_11_value AS original_sieve_11_value,
  original.sieve_12_value AS original_sieve_12_value,
  original.sieve_13_value AS original_sieve_13_value,
  original.sieve_14_value AS original_sieve_14_value,
  original.sieve_15_value AS original_sieve_15_value,
  original.sieve_16_value AS original_sieve_16_value,
  original.sieve_17_value AS original_sieve_17_value,
  original.sieve_18_value AS original_sieve_18_value,
  repeated.sieve_11_desc AS repeated_sieve_11_desc,
  repeated.sieve_12_desc AS repeated_sieve_12_desc,
  repeated.sieve_13_desc AS repeated_sieve_13_desc,
  repeated.sieve_14_desc AS repeated_sieve_14_desc,
  repeated.sieve_15_desc AS repeated_sieve_15_desc,
  repeated.sieve_16_desc AS repeated_sieve_16_desc,
  repeated.sieve_17_desc AS repeated_sieve_17_desc,
  repeated.sieve_18_desc AS repeated_sieve_18_desc,
  repeated.sieve_11_value AS repeated_sieve_11_value,
  repeated.sieve_12_value AS repeated_sieve_12_value,
  repeated.sieve_13_value AS repeated_sieve_13_value,
  repeated.sieve_14_value AS repeated_sieve_14_value,
  repeated.sieve_15_value AS repeated_sieve_15_value,
  repeated.sieve_16_value AS repeated_sieve_16_value,
  repeated.sieve_17_value AS repeated_sieve_17_value,
  repeated.sieve_18_value AS repeated_sieve_18_value
FROM
  gb_qc_repeatability_pairs AS pairs
  LEFT JOIN gb_qc_samples AS original ON pairs.original_sample = original.id
  LEFT JOIN gb_qc_samples AS repeated ON pairs.repeated_sample = repeated.id
WHERE
  original.date >= p_start_date
  AND original.date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabilitySamplePairsGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilitySamplePairsGetByLabTech`(
    IN p_start_date DATE,
    IN p_end_date DATE,
    IN p_lab_tech_id INT(11)
)
BEGIN

    SELECT pairs.id,
    pairs.original_sample,
    pairs.repeated_sample,
    original.date AS original_date,
    repeated.date,
    original.lab_tech AS original_lab_tech,
    repeated.lab_tech,
    original.location_id AS original_location_id,
    repeated.location_id,
    original.sieve_method_id AS original_sieve_method_id,
    repeated.sieve_method_id,
    original.sieve_1_desc AS original_sieve_1_desc,
    original.sieve_2_desc AS original_sieve_2_desc,
    original.sieve_3_desc AS original_sieve_3_desc,
    original.sieve_4_desc AS original_sieve_4_desc,
    original.sieve_5_desc AS original_sieve_5_desc,
    original.sieve_6_desc AS original_sieve_6_desc,
    original.sieve_7_desc AS original_sieve_7_desc,
    original.sieve_8_desc AS original_sieve_8_desc,
    original.sieve_9_desc AS original_sieve_9_desc,
    original.sieve_10_desc AS original_sieve_10_desc,
    original.sieve_11_desc AS original_sieve_11_desc,
    original.sieve_12_desc AS original_sieve_12_desc,
    original.sieve_13_desc AS original_sieve_13_desc,
    original.sieve_14_desc AS original_sieve_14_desc,
    original.sieve_15_desc AS original_sieve_15_desc,
    original.sieve_16_desc AS original_sieve_16_desc,
    original.sieve_17_desc AS original_sieve_17_desc,
    original.sieve_18_desc AS original_sieve_18_desc,
    original.sieve_1_value AS original_sieve_1_value,
    original.sieve_2_value AS original_sieve_2_value,
    original.sieve_3_value AS original_sieve_3_value,
    original.sieve_4_value AS original_sieve_4_value,
    original.sieve_5_value AS original_sieve_5_value,
    original.sieve_6_value AS original_sieve_6_value,
    original.sieve_7_value AS original_sieve_7_value,
    original.sieve_8_value AS original_sieve_8_value,
    original.sieve_9_value AS original_sieve_9_value,
    original.sieve_10_value AS original_sieve_10_value,
    original.sieve_11_value AS original_sieve_11_value,
    original.sieve_12_value AS original_sieve_12_value,
    original.sieve_13_value AS original_sieve_13_value,
    original.sieve_14_value AS original_sieve_14_value,
    original.sieve_15_value AS original_sieve_15_value,
    original.sieve_16_value AS original_sieve_16_value,
    original.sieve_17_value AS original_sieve_17_value,
    original.sieve_18_value AS original_sieve_18_value,
    original.plus_70 AS original_plus_70,
    original.plus_50 AS original_plus_50,
    original.plus_40 AS original_plus_40,
    repeated.sieve_1_desc AS repeated_sieve_1_desc,
    repeated.sieve_2_desc AS repeated_sieve_2_desc,
    repeated.sieve_3_desc AS repeated_sieve_3_desc,
    repeated.sieve_4_desc AS repeated_sieve_4_desc,
    repeated.sieve_5_desc AS repeated_sieve_5_desc,
    repeated.sieve_6_desc AS repeated_sieve_6_desc,
    repeated.sieve_7_desc AS repeated_sieve_7_desc,
    repeated.sieve_8_desc AS repeated_sieve_8_desc,
    repeated.sieve_9_desc AS repeated_sieve_9_desc,
    repeated.sieve_10_desc AS repeated_sieve_10_desc,
	repeated.sieve_1_desc AS repeated_sieve_11_desc,
    repeated.sieve_2_desc AS repeated_sieve_12_desc,
    repeated.sieve_3_desc AS repeated_sieve_13_desc,
    repeated.sieve_4_desc AS repeated_sieve_14_desc,
    repeated.sieve_5_desc AS repeated_sieve_15_desc,
    repeated.sieve_6_desc AS repeated_sieve_16_desc,
    repeated.sieve_7_desc AS repeated_sieve_17_desc,
    repeated.sieve_8_desc AS repeated_sieve_18_desc,
    repeated.sieve_1_value AS repeated_sieve_1_value,
    repeated.sieve_2_value AS repeated_sieve_2_value,
    repeated.sieve_3_value AS repeated_sieve_3_value,
    repeated.sieve_4_value AS repeated_sieve_4_value,
    repeated.sieve_5_value AS repeated_sieve_5_value,
    repeated.sieve_6_value AS repeated_sieve_6_value,
    repeated.sieve_7_value AS repeated_sieve_7_value,
    repeated.sieve_8_value AS repeated_sieve_8_value,
    repeated.sieve_9_value AS repeated_sieve_9_value,
    repeated.sieve_10_value AS repeated_sieve_10_value,
    repeated.sieve_11_value AS repeated_sieve_11_value,
    repeated.sieve_12_value AS repeated_sieve_12_value,
    repeated.sieve_13_value AS repeated_sieve_13_value,
    repeated.sieve_14_value AS repeated_sieve_14_value,
    repeated.sieve_15_value AS repeated_sieve_15_value,
    repeated.sieve_16_value AS repeated_sieve_16_value,
    repeated.sieve_17_value AS repeated_sieve_17_value,
    repeated.sieve_18_value AS repeated_sieve_18_value,
    repeated.plus_70 AS repeated_plus_70,
    repeated.plus_50 AS repeated_plus_50,
    repeated.plus_40 AS repeated_plus_40
    FROM wt_qc_repeatability_pairs AS pairs
    LEFT JOIN gb_qc_samples AS original ON pairs.original_sample = original.id
    LEFT JOIN gb_qc_samples AS repeated ON pairs.repeated_sample = repeated.id
    WHERE original.date >= p_start_date
    AND original.date <= p_end_date
    AND original.lab_tech = p_lab_tech_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabilitySamplePairsGetByOriginalSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilitySamplePairsGetByOriginalSample`(
    IN  p_original_sample_id INT(11)
)
BEGIN
    SELECT * FROM gb_qc_repeatability_pairs 
    WHERE original_sample = p_original_sample_id 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabilitySamplePairsGetByRepeatedSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilitySamplePairsGetByRepeatedSample`(
    IN  p_repeated_sample_id INT(11)
)
BEGIN
    SELECT * FROM gb_qc_repeatability_pairs 
    WHERE repeated_sample = p_repeated_sample_id 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabilityUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilityUpdate`(
    IN p_repeatability_value INT(11),
    IN p_user_id INT(11)
)
BEGIN

    UPDATE gb_qc_user_repeatability 
    SET repeatability_counter = p_repeatability_value 
    WHERE user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabilityUserInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilityUserInsert`(
    IN p_user_id INT(11),
    IN p_repeatability_counter INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO gb_qc_user_repeatability 
    (
        user_id, 
        repeatability_counter
    ) 
    VALUES 
    (
        p_user_id, 
        p_repeatability_counter
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RepeatabiltyUserInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabiltyUserInsert`(
    IN p_user_id INT(11),
    IN p_repeatability_counter INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO gb_qc_user_repeatability 
    (
        user_id, 
        repeatability_counter
    ) 
    VALUES 
    (
        p_user_id, 
        p_repeatability_counter
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RetireSieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RetireSieveStackUpdate`(IN p_id int(11), IN p_site_id INT(11), p_user_id int(11))
update gb_qc_sieve_stacks
set is_active = 0,
modify_date = now(),
modify_user_id = p_user_id
where id = p_id AND main_site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RetireSieveUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RetireSieveUpdate`(IN p_id int(11), IN p_site_id INT(11), IN p_user_id int(11))
update gb_qc_sieves
set is_active = 0,
edit_date = now(),
sort_order = 0,
edit_user_id = p_user_id
where id = p_id AND site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_RndSphericityBySampleIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_RndSphericityBySampleIdGet`(
IN p_sample_id int(11)
)
BEGIN
    SELECT roundness, sphericity from gb_qc_samples where id = p_sample_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleByIdGet`(
    IN  p_sampleId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_samples
    WHERE id = p_sampleId
LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleByLocationMostRecentGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleByLocationMostRecentGet`(
    IN  p_location INT
)
BEGIN
    SELECT * FROM gb_qc_samples
    WHERE void_status_code != 'V'
    AND location_id = p_location
    AND test_type_id != '1'
    AND test_type_id != '7'
    AND is_complete = 1
    ORDER BY dt DESC
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleFinishDtCheck` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_SampleFinishDtCheck`(in p_id int(11))
select finish_dt from gb_qc_samples where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleFinishDtUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_SampleFinishDtUpdate`(in p_sample_id int(11))
update gb_qc_samples set finish_dt = now(), duration = round(TIMESTAMPDIFF(minute, dt, now())/60,2),  duration_minutes = round(TIMESTAMPDIFF(minute, dt, now()),2) where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleGetByID`(
    IN  p_sampleId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_samples
    WHERE id = p_sampleId
LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleGetByPlantAndDatetimeIncludeVoided` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleGetByPlantAndDatetimeIncludeVoided`(
    IN  p_plant_id INT(11),
    IN  p_date_id DATETIME
)
BEGIN
    SELECT * FROM gb_qc_samples 
    WHERE plant_id = p_plant_id
    AND dt = p_date_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleGroupGetBySample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleGroupGetBySample`(
    IN p_sample_id INT(11)
)
BEGIN
    SELECT * 
    FROM gb_qc_sample_groups 
    WHERE sample_id = p_sample_id 
    LIMIT 1;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleGroupInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleGroupInsert`(
  IN p_group_id INT(11),
  IN p_sample_id INT(11)
)
BEGIN
  INSERT INTO gb_qc_sample_groups 
    (group_id, sample_id) 
  VALUES 
    (p_group_id, p_sample_id);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleGroupMaxGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleGroupMaxGet`(
    
)
BEGIN
    SELECT MAX(group_id)
    FROM gb_qc_sample_groups 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleIDsGetByGroupID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleIDsGetByGroupID`(
    IN p_group_id INT(11)
)
BEGIN
    SELECT * 
    FROM gb_qc_sample_groups 
    WHERE group_id = p_group_id;    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleInsert`(

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
    IN  p_lab_Tech INT(11),
    IN  p_sampler INT(11),
    IN  p_operator INT(11),
    IN  p_shift VARCHAR(5),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO gb_qc_samples
    (
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
    );
insert into prod_plant_mir_data (sample_id, tag_id, value)
SELECT (select max(id) from gb_qc_samples), id, value  FROM gb_qc_plc_DataView
WHERE timestamp between p_dt - INTERVAL 10 MINUTE AND p_dt; 
Select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleRepeatCheck` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_SampleRepeatCheck`(in p_sample_id int(11))
select s.is_repeat_process, s.is_repeat_labtech, concat(mu.first_name, ' ', mu.last_name) as lab_tech from gb_qc_samples s
join main_users mu on mu.id = s.is_repeat_labtech where s.is_repeat_process = 1 and s.id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SamplersGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SamplersGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
		CONCAT(mu.first_name, ' ', mu.last_name) AS display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		rc.role_id,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu LEFT JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 2
AND mu.is_active = 1
ORDER BY first_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SamplesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SamplesGet`()
BEGIN
    SELECT * from gb_qc_samples;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SamplesGetByPlantAndDatetimeWhereNotComplete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SamplesGetByPlantAndDatetimeWhereNotComplete`(
    IN  p_plant_id INT(11),
    IN  p_date_id DATETIME
)
BEGIN
    SELECT * FROM gb_qc_samples 
    WHERE plant_id = p_plant_id
    AND dt = p_date_id
    AND is_complete = 0
    AND void_status_code = 'A';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SamplesInDateRangeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SamplesInDateRangeGet`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE dt >= p_start_date AND
    dt <= p_end_date
    ORDER BY id DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SamplesInDateRangeGetFiltered` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SamplesInDateRangeGetFiltered`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT(11),
    IN  p_results_per_page INT(11),
    IN  p_is_complete VARCHAR(64),
    IN  p_test_type_ids VARCHAR(64),
    IN  p_composite_type_ids VARCHAR(64),
    IN  p_min_time TIME,
    IN  p_max_time TIME,
    IN  p_lab_tech_ids VARCHAR(64),
    IN  p_sampler_ids VARCHAR(64),
    IN  p_operator_ids VARCHAR(64),
    IN  p_site_ids VARCHAR(64),
    IN  p_plant_ids VARCHAR(64),
    IN  p_sample_location_ids VARCHAR(64),
    IN  p_specific_location_ids VARCHAR(64),
    IN  p_void_status_codes VARCHAR(8)
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date AND
    ((p_is_complete = '') OR (is_complete = p_is_complete)) AND
    ((p_test_type_ids = '') OR (FIND_IN_SET(test_type_id, p_test_type_ids) <> 0)) AND
    ((p_composite_type_ids = '') OR (FIND_IN_SET(composite_type_id, p_composite_type_ids) <> 0)) AND
    ((time >= p_min_time AND time <= p_max_time)
    OR ((time >= p_min_time OR time <= p_max_time) AND p_min_time > p_max_time)) AND
    ((p_lab_tech_ids = '') OR (FIND_IN_SET(lab_tech, p_lab_tech_ids) <> 0)) AND
    ((p_sampler_ids = '') OR (FIND_IN_SET(sampler, p_sampler_ids) <> 0)) AND
    ((p_operator_ids = '') OR (FIND_IN_SET(operator, p_operator_ids) <> 0)) AND
    ((p_site_ids = '') OR (FIND_IN_SET(site_id, p_site_ids) <> 0)) AND
    ((p_plant_ids = '') OR (FIND_IN_SET(plant_id, p_plant_ids) <> 0)) AND
    ((p_sample_location_ids = '') OR (FIND_IN_SET(location_id, p_sample_location_ids) <> 0)) AND
    ((p_specific_location_ids = '') OR (FIND_IN_SET(specific_location_id, p_composite_type_ids) <> 0)) AND
    ((p_void_status_codes = '') OR (FIND_IN_SET(void_status_code, p_void_status_codes) <> 0))
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SamplesInDateRangeGetFilteredv2` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SamplesInDateRangeGetFilteredv2`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT(11),
    IN  p_results_per_page INT(11),
    IN  p_is_complete VARCHAR(64),
    IN  p_test_type_ids VARCHAR(64),
    IN  p_composite_type_ids VARCHAR(64),
    IN  p_min_time TIME,
    IN  p_max_time TIME,
    IN  p_lab_tech_ids VARCHAR(64),
    IN  p_sampler_ids VARCHAR(64),
    IN  p_operator_ids VARCHAR(64),
    IN  p_site_ids VARCHAR(64),
    IN  p_plant_ids VARCHAR(64),
    IN  p_sample_location_ids VARCHAR(64),
    IN  p_specific_location_ids VARCHAR(64),
    IN  p_void_status_codes VARCHAR(8),
    IN  p_is_coa VARCHAR(1)
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date AND
    ((p_is_complete = '') OR (is_complete = p_is_complete)) AND
    ((p_test_type_ids = '') OR (FIND_IN_SET(test_type_id, p_test_type_ids) <> 0)) AND
    ((p_composite_type_ids = '') OR (FIND_IN_SET(composite_type_id, p_composite_type_ids) <> 0)) AND
    ((time >= p_min_time AND time <= p_max_time)
    OR ((time >= p_min_time OR time <= p_max_time) AND p_min_time > p_max_time)) AND
    ((p_lab_tech_ids = '') OR (FIND_IN_SET(lab_tech, p_lab_tech_ids) <> 0)) AND
    ((p_sampler_ids = '') OR (FIND_IN_SET(sampler, p_sampler_ids) <> 0)) AND
    ((p_operator_ids = '') OR (FIND_IN_SET(operator, p_operator_ids) <> 0)) AND
    ((p_site_ids = '') OR (FIND_IN_SET(site_id, p_site_ids) <> 0)) AND
    ((p_plant_ids = '') OR (FIND_IN_SET(plant_id, p_plant_ids) <> 0)) AND
    ((p_sample_location_ids = '') OR (FIND_IN_SET(location_id, p_sample_location_ids) <> 0)) AND
    ((p_specific_location_ids = '') OR (FIND_IN_SET(specific_location_id, p_composite_type_ids) <> 0)) AND
    ((p_void_status_codes = '') OR (FIND_IN_SET(void_status_code, p_void_status_codes) <> 0)) AND
    ((p_is_coa = '') OR (FIND_IN_SET(is_coa, p_is_coa) <> 0))
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SamplesInDateRangeGetIncludeVoided` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SamplesInDateRangeGetIncludeVoided`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT,
    IN  p_results_per_page INT
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_SampleUpdate`(
    IN p_id INT(11),
    IN p_edit_dt DATETIME,
    IN p_edit_user_id BIGINT(20), 
    IN p_site_id INT(11),
    IN p_plant_id INT(11),
    IN p_dt DATETIME,
    IN p_test_type_id INT(11),
    IN p_composite_type_id INT(11),
    IN p_sieve_method_id INT(11),
    IN p_location_id INT(11),
    IN p_specific_location_id INT(11),
    IN p_date DATE,
    IN p_time TIME,
    IN p_date_short BIGINT(8),
    IN p_dt_short BIGINT(11),
    IN p_oversize_percent DECIMAL(5, 4),
    IN p_oversize_weight DECIMAL(5, 1),
    IN p_slimes_percent DECIMAL(5, 4),
    IN p_depth_to DECIMAL(5, 1),
    IN p_depth_from DECIMAL(5, 1),
    IN p_drillhole_no VARCHAR(50),
    IN p_description VARCHAR(50),
    IN p_sampler int(11),
    IN p_lab_tech int(11),
    IN p_operator int(11),
    IN p_beginning_wet_weight DECIMAL(5, 1),
    IN p_prewash_dry_weight DECIMAL(5, 1),
    IN p_postwash_dry_weight DECIMAL(5, 1),
    IN p_split_sample_weight DECIMAL(5, 1),
    IN p_moisture_rate DECIMAL(6, 4),
    IN p_notes VARCHAR(255),
    IN p_turbidity INT(11),
    IN p_k_value INT(11),
    IN p_k_pan_1 DECIMAL(7, 4),
    IN p_k_pan_2 DECIMAL(7, 4),
    IN p_k_pan_3 DECIMAL(7, 4),
    IN p_roundness DECIMAL(5, 1),
    IN p_sphericity DECIMAL(5, 1),
    IN p_group_time TIME,
    IN p_start_weights_raw TEXT,
    IN p_end_weights_raw TEXT,
    IN p_sieves_raw TEXT,
    IN p_sieves_total DECIMAL(5, 1),
    IN p_sieve_1_value DECIMAL(7, 4),
    IN p_sieve_2_value DECIMAL(7, 4),
    IN p_sieve_3_value DECIMAL(7, 4),
    IN p_sieve_4_value DECIMAL(7, 4),
    IN p_sieve_5_value DECIMAL(7, 4),
    IN p_sieve_6_value DECIMAL(7, 4),
    IN p_sieve_7_value DECIMAL(7, 4),
    IN p_sieve_8_value DECIMAL(7, 4),
    IN p_sieve_9_value DECIMAL(7, 4),
    IN p_sieve_10_value DECIMAL(7, 4),
    IN p_sieve_11_value DECIMAL(7, 4),
    IN p_sieve_12_value DECIMAL(7, 4),
    IN p_sieve_13_value DECIMAL(7, 4),
    IN p_sieve_14_value DECIMAL(7, 4),
    IN p_sieve_15_value DECIMAL(7, 4),
    IN p_sieve_16_value DECIMAL(7, 4),
    IN p_sieve_17_value DECIMAL(7, 4),
    IN p_sieve_18_value DECIMAL(7, 4),
    IN p_sieve_1_desc CHAR(3),
    IN p_sieve_2_desc CHAR(3),
    IN p_sieve_3_desc CHAR(3),
    IN p_sieve_4_desc CHAR(3),
    IN p_sieve_5_desc CHAR(3),
    IN p_sieve_6_desc CHAR(3),
    IN p_sieve_7_desc CHAR(3),
    IN p_sieve_8_desc CHAR(3),
    IN p_sieve_9_desc CHAR(3),
    IN p_sieve_10_desc CHAR(3),
    IN p_sieve_11_desc CHAR(3),
    IN p_sieve_12_desc CHAR(3),
    IN p_sieve_13_desc CHAR(3),
    IN p_sieve_14_desc CHAR(3),
    IN p_sieve_15_desc CHAR(3),
    IN p_sieve_16_desc CHAR(3),
    IN p_sieve_17_desc CHAR(3),
    IN p_sieve_18_desc CHAR(3),
    IN p_plus_70 DECIMAL(5, 4),
    IN p_plus_50 DECIMAL(5, 4),
    IN p_plus_40 DECIMAL(5, 4),
    IN p_minus_50_plus_140 DECIMAL(5,4),
    IN p_minus_40_plus_70 DECIMAL(5, 4),
    IN p_minus_70 DECIMAL(5, 4),
    IN p_minus_70_plus_140 DECIMAL(5, 4),
    IN p_minus_60_plus_70 DECIMAL(5, 4),
    IN p_minus_140_plus_325 DECIMAL(5, 4),
    IN p_minus_140 DECIMAL(5, 4),
    IN p_finish_dt DATETIME,
    IN p_duration DECIMAL(5, 2),
    IN p_duration_minutes DECIMAL(5, 1),
    IN p_is_coa TINYINT(1),
    IN p_near_size DECIMAL(5, 4),
    IN p_sand_height float,
    IN p_silt_height float,
    IN p_silt_percent float
)
BEGIN
UPDATE gb_qc_samples
    SET 
        edit_dt = p_edit_dt,
        edit_user_id = p_edit_user_id, 
        site_id = p_site_id,
        plant_id = p_plant_id,
        dt = p_dt,
        test_type_id = p_test_type_id,
        composite_type_id = p_composite_type_id,
        sieve_method_id = p_sieve_method_id,
        location_id = p_location_id,
        specific_location_id = p_specific_location_id, 
        date = p_date,
        time = p_time,
        date_short = p_date_short,
        dt_short = p_dt_short,
        oversize_percent = p_oversize_percent, 
        oversize_weight = p_oversize_weight, 
        slimes_percent = p_slimes_percent, 
        depth_to = p_depth_to, 
        depth_from = p_depth_from, 
        drillhole_no = p_drillhole_no,
        description = p_description,
        sampler = p_sampler,
        lab_tech = p_lab_tech,
        operator = p_operator,
        beginning_wet_weight = p_beginning_wet_weight,
        prewash_dry_weight = p_prewash_dry_weight,
        postwash_dry_weight = p_postwash_dry_weight,
        split_sample_weight = p_split_sample_weight,
        moisture_rate = p_moisture_rate,
        notes = p_notes,
        turbidity = p_turbidity,
        k_value = p_k_value,
        k_pan_1 = p_k_pan_1,
        k_pan_2 = p_k_pan_2,
        k_pan_3 = p_k_pan_3,
        roundness = p_roundness,
        sphericity = p_sphericity,
        group_time = p_group_time,
        start_weights_raw = p_start_weights_raw,
        end_weights_raw = p_end_weights_raw,
        sieves_raw = p_sieves_raw,
        sieves_total = p_sieves_total, 
        sieve_1_value = p_sieve_1_value, 
        sieve_2_value = p_sieve_2_value, 
        sieve_3_value = p_sieve_3_value, 
        sieve_4_value = p_sieve_4_value, 
        sieve_5_value = p_sieve_5_value, 
        sieve_6_value = p_sieve_6_value, 
        sieve_7_value = p_sieve_7_value, 
        sieve_8_value = p_sieve_8_value, 
        sieve_9_value = p_sieve_9_value, 
        sieve_10_value = p_sieve_10_value, 
        sieve_11_value = p_sieve_11_value, 
        sieve_12_value = p_sieve_12_value, 
        sieve_13_value = p_sieve_13_value, 
        sieve_14_value = p_sieve_14_value, 
        sieve_15_value = p_sieve_15_value, 
        sieve_16_value = p_sieve_16_value, 
        sieve_17_value = p_sieve_17_value, 
        sieve_18_value = p_sieve_18_value, 
        sieve_1_desc = p_sieve_1_desc,
        sieve_2_desc = p_sieve_2_desc,
        sieve_3_desc = p_sieve_3_desc,
        sieve_4_desc = p_sieve_4_desc,
        sieve_5_desc = p_sieve_5_desc,
        sieve_6_desc = p_sieve_6_desc,
        sieve_7_desc = p_sieve_7_desc,
        sieve_8_desc = p_sieve_8_desc,
        sieve_9_desc = p_sieve_9_desc,
        sieve_10_desc = p_sieve_10_desc,
        sieve_11_desc = p_sieve_11_desc,
        sieve_12_desc = p_sieve_12_desc,
        sieve_13_desc = p_sieve_13_desc,
        sieve_14_desc = p_sieve_14_desc,
        sieve_15_desc = p_sieve_15_desc,
        sieve_16_desc = p_sieve_16_desc,
        sieve_17_desc = p_sieve_17_desc,
        sieve_18_desc = p_sieve_18_desc,        
        plus_70 = p_plus_70,
        plus_50 = p_plus_50, 
        plus_40 = p_plus_40, 
        minus_50_plus_140 = p_minus_50_plus_140,
        minus_40_plus_70 = p_minus_40_plus_70, 
        minus_70 = p_minus_70, 
        minus_70_plus_140 = p_minus_70_plus_140, 
        minus_60_plus_70 = p_minus_60_plus_70,
        minus_140_plus_325 = p_minus_140_plus_325,
        minus_140 = p_minus_140, 
        finish_dt = p_finish_dt, 
        duration = p_duration, 
        duration_minutes = p_duration_minutes,
        is_coa = p_is_coa,
        near_size = p_near_size,
        sand_height = p_sand_height,
        silt_height = p_silt_height,
        silt_percent = p_silt_percent
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleVoid` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleVoid`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `gb_qc_samples` 
    SET `void_status_code`='V' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SampleVoidReverse` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleVoidReverse`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `gb_qc_samples` 
    SET `void_status_code`='A' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_sample_repeat_lock` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_sample_repeat_lock`(in p_labtech int(11), in p_sample_id int(11))
update gb_qc_samples set is_repeat_process = 1, is_repeat_labtech = p_labtech where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_sample_repeat_unlock` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_sample_repeat_unlock`( in p_sample_id int(11))
update gb_qc_samples set is_repeat_process = 0, is_repeat_labtech = null where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_ShiftsGetBySiteAndDate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_ShiftsGetBySiteAndDate`(
    IN p_plant_id INT(11),
    IN p_time TIME
)
BEGIN
    SELECT * 
    FROM main_shifts 
    WHERE site_id = p_plant_id 
        AND p_time >= start_time 
    ORDER BY start_time DESC 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SieveInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SieveInsert`(
    IN p_sieve_stack_id INT(11),
    IN p_site_id int(11),
    IN p_screen_size varchar(16),
    IN p_start_weight decimal(5,1),
	IN p_serial_no varchar(32),
    IN p_sort_order int(11),
    IN p_user_id int(11)
    )
BEGIN
  INSERT INTO gb_qc_sieves 
    (sieve_stack_id, site_id, screen, start_weight, serial_no, sort_order, create_date, create_user_id) 
  VALUES 
    (p_sieve_stack_id, p_site_id, p_screen_size, p_start_weight, p_serial_no, p_sort_order, now(), p_user_id);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SievesGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SievesGetByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_sieves
WHERE sieve_stack_id = p_sieveStackId
and is_active=1
order by sort_order;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SieveStackGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SieveStackGetByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_sieve_stacks
    WHERE id = p_sieveStackId
    ORDER BY sort_order ASC
LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SieveStackInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SieveStackInsert`(
    IN p_description VARCHAR(64),
    IN p_main_site_id INT(11),
    IN p_is_camsizer TINYINT(1),
    IN p_user_id INT(11)
)
INSERT INTO gb_qc_sieve_stacks 
    (description, main_site_id, is_camsizer, last_cleaned, create_date, create_user_id)
  VALUES 
    (p_description, p_main_site_id, p_is_camsizer, now(), now(), p_user_id) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SieveStacksGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SieveStacksGet`()
BEGIN
    SELECT * from gb_qc_sieve_stacks WHERE is_active = '1' ORDER BY sort_order;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SieveStacksGetBySiteID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SieveStacksGetBySiteID`(
    IN  p_sieveStackSiteID int(11)
)
BEGIN
    SELECT * FROM gb_qc_sieve_stacks
    WHERE main_site_id = p_sieveStackSiteID
    AND is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SieveStackUpdate`(IN p_id int(11), IN p_description varchar(64), IN p_site_id int(11), p_is_camsizer tinyint(1), p_sort_order int(11), p_is_active tinyint(1), p_modify_user_id int(11))
update gb_qc_sieve_stacks 
set 
description = p_description,
main_site_id = p_site_id,
is_camsizer = p_is_camsizer,
sort_order = p_sort_order,
is_active = p_is_active,
modify_date = now(),
modify_user_id = p_modify_user_id
where
id=p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SieveStartingWeightUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SieveStartingWeightUpdate`(
    IN p_start_weight DECIMAL(5,1),
    IN p_sieve_stack_id INT(11),
    IN p_screen VARCHAR(16)
)
BEGIN
    UPDATE gb_qc_sieves 
    SET start_weight = p_start_weight 
    WHERE sieve_stack_id = p_sieve_stack_id 
        AND screen = p_screen;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SieveUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SieveUpdate`(
IN p_id int(11),
IN p_stack_id int(11),
IN p_site_id int(11),
IN p_serial_no varchar(32),
IN p_screen varchar(16),
IN p_start_weight decimal(5,1),
IN p_is_active tinyint(1),
IN p_sort_order int(11),
IN p_user_id int(11)
)
update gb_qc_sieves 
set 
site_id = p_site_id,
sieve_stack_id = p_stack_id,
serial_no = p_serial_no,
screen = p_screen,
start_weight = p_start_weight,
is_active = p_is_active,
sort_order = p_sort_order,
edit_date = now(),
edit_user_id = p_user_id
where
id = p_id and sieve_stack_id = p_stack_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SiltPercentGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_SiltPercentGet`(in p_sample_id int(11))
select silt_percent from gb_qc_samples where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SiteGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SiteGetByID`(
    IN  p_site_id INT(11)
)
BEGIN
    SELECT * FROM main_sites 
    WHERE id = p_site_id
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SpecificLocationGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SpecificLocationGetByID`(
    IN  p_specific_location_id INT(11)
)
BEGIN
    SELECT * FROM gb_qc_locations_details 
    WHERE id = p_specific_location_id
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SpecificLocationsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SpecificLocationsGet`()
BEGIN
    SELECT sp.id, sp.qc_location_id, sp.description, sp.sort_order, sp.is_active, l.main_site_id as site, l.main_plant_id as plant  from gb_qc_locations_details sp
    join gb_qc_locations l 
    on qc_location_id = l.id
    WHERE sp.is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_SpecificLocationsGetByLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SpecificLocationsGetByLocation`(
    IN  p_locationId int(11)
)
BEGIN
SELECT * FROM gb_qc_locations_details 
    WHERE is_active = 1 
    AND qc_location_id = p_locationId 
    ORDER BY sort_order ASC; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_TestTypeGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_TestTypeGetByID`(
    IN  p_testTypeId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_test_types
    WHERE id = p_testTypeId
LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_TestTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_TestTypesGet`()
BEGIN
    SELECT * from gb_qc_test_types;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_ThresholdsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_ThresholdsInsert`(
    IN p_screen VARCHAR(16),
    IN p_location_id INT(11),
    IN p_low_threshold DOUBLE,
    IN p_high_threshold DOUBLE
)
BEGIN
INSERT INTO gb_qc_thresholds
(
    screen, 
    location_id, 
    low_threshold, 
    high_threshold
) 
VALUES 
(
    p_screen, 
    p_location_id, 
    p_low_threshold, 
    p_high_threshold
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_ThresholdsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_ThresholdsUpdate`(
    IN p_id INT(11),
    IN p_screen VARCHAR(16),
    IN p_location_id INT(11),
    IN p_low_threshold DOUBLE,
    IN p_high_threshold DOUBLE,
    IN p_is_active TINYINT(1)
)
BEGIN
    UPDATE gb_qc_thresholds
    SET 
    `screen` = p_screen,
    `location_id` = p_location_id,
    `low_threshold` = p_low_threshold,
    `high_threshold` = p_high_threshold,
    `is_active` = p_is_active
    WHERE `id` = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_TimeFixGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_TimeFixGet`()
(
SELECT 
	id,
    date, 
	time, 
    group_time,
	case WHEN date_format(time, '%H') = '01' THEN date_format(time, '13:%i:%s')
		 WHEN date_format(time, '%H') = '02' THEN date_format(time, '14:%i:%s')
         WHEN date_format(time, '%H') = '03' THEN date_format(time, '15:%i:%s')
		 WHEN date_format(time, '%H') = '04' THEN date_format(time, '16:%i:%s')
         WHEN date_format(time, '%H') = '05' THEN date_format(time, '17:%i:%s')
		 WHEN date_format(time, '%H') = '06' THEN date_format(time, '18:%i:%s')
         WHEN date_format(time, '%H') = '07' THEN date_format(time, '19:%i:%s')
		 WHEN date_format(time, '%H') = '08' THEN date_format(time, '20:%i:%s')
         WHEN date_format(time, '%H') = '09' THEN date_format(time, '21:%i:%s')
		 WHEN date_format(time, '%H') = '10' THEN date_format(time, '22:%i:%s')
         WHEN date_format(time, '%H') = '11' THEN date_format(time, '23:%i:%s')
		 WHEN date_format(time, '%H') = '12' THEN date_format(time, '24:%i:%s') end as 'fixtime'
FROM gb_qc_samples
where group_time > '13:00:00' 
and group_time < '23:59:59'
and time < '12:59:59'
order by id asc
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_TurbidityBySampleIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_gb_qc_TurbidityBySampleIdGet`(
IN p_sample_id int(11)
)
BEGIN
    SELECT turbidity from gb_qc_samples where id = p_sample_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_UsesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_UsesGet`(IN p_sieve_method_id int(11))
select sieve_method_id from gb_qc_samples where sieve_method_id = p_sieve_method_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_qc_UsesSinceLastCleanedGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_UsesSinceLastCleanedGet`(IN p_sieve_method_id int(11), IN p_dt datetime)
select sieve_method_id, dt from gb_qc_samples where sieve_method_id = p_sieve_method_id and dt > p_dt ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gb_UserTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_UserTypesGet`()
SELECT name, value, id
FROM main_user_types ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gen_PageHelpGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gen_PageHelpGet`(
    
)
BEGIN
    SELECT * 
    FROM main_page_help;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gen_PageHelpGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gen_PageHelpGetByID`(
    IN p_id INT(11)
)
BEGIN
    SELECT * 
    FROM main_page_help 
    WHERE id = p_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gen_PageHelpUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gen_PageHelpUpdate`(
    IN p_id INT(11),
    IN p_text VARCHAR(1024)
)
BEGIN
    UPDATE main_page_help 
    SET text = p_text 
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gen_PageNavInfoGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gen_PageNavInfoGetByID`(
    IN p_id INT(11)
)
BEGIN
    SELECT * 
    FROM ui_nav_left_links 
    LEFT JOIN main_departments 
    ON ui_nav_left_links.main_department_id = main_departments.id 
    WHERE ui_nav_left_links.id = p_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetAllUsers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetAllUsers`()
BEGIN
    SELECT * from main_users;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetCompositeTypeByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetCompositeTypeByID`(
    IN  p_compositeTypeId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_composites
    WHERE id = p_compositeTypeId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetCompositeTypes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetCompositeTypes`()
BEGIN
    SELECT * from gb_qc_composites;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetHelpText` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetHelpText`(
    IN  p_page varchar(64),
    IN  p_department varchar(64)
)
BEGIN
SELECT * FROM main_page_help
    WHERE page = p_page AND department = p_department
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetKValues` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetKValues`()
BEGIN
    SELECT * from gb_qc_k_values;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetLocationByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetLocationByID`(
    IN  p_locationId varchar(64)
)
BEGIN
SELECT * FROM main_locations
    WHERE id = p_locationId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetLocations` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetLocations`()
BEGIN
    SELECT * from gb_qc_locations 
    WHERE is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetNavLeftLinks` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetNavLeftLinks`()
BEGIN

  SELECT 
      ul.id, 
      ul.main_department_id, 
      md.name as 'DeptName', 
      ul.parent_link_id, 
      ul.link_name, 
      ul.link_title, 
      ul.web_file, 
      ul.indent, 
      ul.permission_level, 
      ul.company, 
      ul.site, 
      ul.permission, 
      ul.is_external
  FROM ui_nav_left_links ul
  LEFT JOIN main_departments md on ul.main_department_id = md.id
  WHERE ul.is_active = 1
  ORDER BY ul.sort_order; 

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetPlantByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetPlantByID`(
    IN  p_plantId varchar(64)
)
BEGIN
SELECT * FROM main_plants
    WHERE id = p_plantId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetPlants` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetPlants`()
BEGIN
    SELECT * from main_plants 
    where is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetSampleByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSampleByID`(
    IN  p_sampleId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_samples
    WHERE id = p_sampleId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetSamples` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSamples`()
BEGIN
    SELECT * from gb_qc_samples;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetSamplesInDateRange` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSamplesInDateRange`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE void_status_code != 'V' AND
    dt >= p_start_date AND
    dt <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetSievesByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSievesByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_sieves
WHERE sieve_stack_id = p_sieveStackId; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetSieveStackByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSieveStackByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_sieve_stacks
    WHERE id = p_sieveStackId
    ORDER BY sort_order ASC
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetSieveStacks` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSieveStacks`()
BEGIN
    SELECT * from gb_qc_sieve_stacks WHERE is_active = '1' ORDER BY sort_order;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetSites` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetSites`()
BEGIN
    SELECT * from main_sites WHERE is_qc_samples_site = "1";
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetTestTypeByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetTestTypeByID`(
    IN  p_testTypeId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_test_types
    WHERE id = p_testTypeId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetTestTypes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetTestTypes`()
BEGIN
    SELECT * from gb_qc_test_types;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUser`(
    IN  p_id int(11)
)
BEGIN
SELECT * FROM main_users
    WHERE id = p_id
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetUserByEmail` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUserByEmail`(
    IN  p_email varchar(128)
)
BEGIN
SELECT * FROM main_users
    WHERE email = p_email
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetUserByName` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUserByName`(
    IN  p_username varchar(64)
)
BEGIN
SELECT * FROM main_users
    WHERE username = p_username
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetUserByToken` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUserByToken`(
    IN  p_password_reset_token varchar(64)
)
BEGIN
SELECT * FROM main_users
    WHERE password_reset_token = p_password_reset_token
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetUserPermissions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUserPermissions`(
    IN  p_user_id int(11)
)
BEGIN
SELECT * FROM main_user_permissions
    WHERE user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_HrDeptSelect` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_HrDeptSelect`()
BEGIN
    SELECT id, name, is_active from main_departments
    WHERE is_active='1';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_HrEmpDeptSelectById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_HrEmpDeptSelectById`(
     IN p_id INT(11)   
)
BEGIN
        SELECT main_hr_checklist.id,
		       main_hr_checklist.first_name,
               main_hr_checklist.last_name,
		       main_hr_checklist.employee_id,
		       main_hr_checklist.department_id,
		       main_hr_checklist.manager,
		       main_hr_checklist.silicore_account_requested,
               main_hr_checklist.silicore_account_model,
		       main_hr_checklist.email_account_requested,
		       main_hr_checklist.cell_phone_requested,
		       main_hr_checklist.laptop_requested,
			   main_hr_checklist.desktop_requested,
               main_hr_checklist.monitors_requested,
		       main_hr_checklist.tablet_requested,
		       main_hr_checklist.two_way_radio_requested,
			   main_hr_checklist.special_software_requested,
               main_hr_checklist.create_date,
		       main_hr_checklist.create_user_id,
		       main_hr_checklist.edit_date,
		       main_hr_checklist.edit_user_id,
		       main_hr_checklist.is_active,
               main_departments.name
    FROM main_hr_checklist
    LEFT JOIN main_departments 
    ON main_hr_checklist.department_id = main_departments.id
	WHERE main_hr_checklist.id=p_id;    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_HrEmpInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_HrEmpInsert`(
    IN  p_first_name varchar(45),
    IN  p_last_name varchar(45),
    IN  p_employee_id varchar(45),
    IN  p_department_id varchar(45),
	IN  p_manager varchar(45),
    IN  p_silicore_account_requested tinyint(1),
    IN  p_silicore_account_model varchar(45),
    IN  p_email_account_requested tinyint(1),
    IN  p_cell_phone_requested tinyint(1),
    IN  p_laptop_requested tinyint(1),
    IN  p_desktop_requested tinyint(1),
    IN  p_monitors_requested varchar(45),
    IN  p_tablet_requested tinyint(1),
    IN  p_two_way_radio_requested tinyint(1),
    IN  p_special_software_requested varchar(45),
    IN  p_create_date varchar(45),
    IN  p_create_user_id varchar(45),
    IN  p_is_active tinyint(1)
)
BEGIN
INSERT INTO main_hr_checklist 
(
	    first_name,
		last_name,
        employee_id,
        department_id,
        manager,
        silicore_account_requested,
        silicore_account_model,
        email_account_requested,
        cell_phone_requested,
        laptop_requested,
        desktop_requested,
        monitors_requested,
        tablet_requested,
		two_way_radio_requested,
	    special_software_requested,
        create_date,
        create_user_id,
        is_active
)        
VALUES 
(   
        p_first_name,
        p_last_name,
        p_employee_id,
        p_department_id,
        p_manager,
        p_silicore_account_requested,
        p_silicore_account_model,
        p_email_account_requested,
        p_cell_phone_requested,
        p_laptop_requested,
        p_desktop_requested,
        p_monitors_requested,
        p_tablet_requested,
        p_two_way_radio_requested,
        p_special_software_requested,
        p_create_date,
        p_create_user_id,
        p_is_active
);
        
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_HrEmpSelect` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_HrEmpSelect`()
BEGIN
    SELECT * from main_hr_checklist;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_HrEmpSelectById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_HrEmpSelectById`(   
	IN p_id INT(11)
)
BEGIN
    SELECT * from main_hr_checklist WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_HrEmpUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_HrEmpUpdate`(
	IN  p_id INT(11),
    IN  p_first_name varchar(45),
    IN  p_last_name varchar(45),
    IN  p_employee_id varchar(45),
    IN  p_department_id varchar(45),
	IN  p_manager varchar(45),
    IN  p_silicore_account_requested tinyint(1),
    IN  p_silicore_account_model varchar(45),
    IN  p_email_account_requested tinyint(1),
    IN  p_cell_phone_requested tinyint(1),
    IN  p_laptop_requested tinyint(1),
    IN  p_desktop_requested tinyint(1),
    IN  p_monitors_requested varchar(45),
    IN  p_tablet_requested tinyint(1),
    IN  p_two_way_radio_requested tinyint(1),
    IN  p_special_software_requested varchar(45),
    IN  p_edit_date varchar(45),
    IN  p_edit_user_id varchar(45),
    IN  p_is_active tinyint(1)
)
BEGIN
UPDATE main_hr_checklist
	SET first_name=p_first_name,
		last_name=p_last_name,
        employee_id=p_employee_id,
        department_id=p_department_id,
        manager=p_manager,
        silicore_account_requested=p_silicore_account_requested,
        silicore_account_model=p_silicore_account_model,
        email_account_requested=p_email_account_requested, 
        cell_phone_requested=p_cell_phone_requested,
        laptop_requested=p_laptop_requested,
        desktop_requested=p_desktop_requested,
        monitors_requested=p_monitors_requested,
        tablet_requested=p_tablet_requested,
		two_way_radio_requested=p_two_way_radio_requested,
	    special_software_requested=p_special_software_requested,
        edit_date=p_edit_date,
        edit_user_id=p_edit_user_id,
        is_active=p_is_active
        
    WHERE id = p_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_AccountRequestsByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_AccountRequestsByIdGet`(IN p_id int(11))
(
SELECT * FROM account_requests where employee_id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_AccountRequestsByNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_AccountRequestsByNameGet`(IN p_name varchar(128))
(
SELECT * FROM account_requests where concat(first_name, ' ', last_name) = p_name
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_AllMedicalRequestsByFollowUpGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_AllMedicalRequestsByFollowUpGet`()
select ma.*, ar.description as reason_text, sc.description as status_code_text, hc.name as clinic_name, hc.city as clinic_city, hc.state as clinic_state, rc.description as result_code_text
from hr_medical_auths ma 
join hr_medical_auth_result_codes rc on rc.id = ma.result_code_id
join hr_medical_auth_reasons ar on ar.id = ma.hr_auth_reason_id
join hr_medical_auths_status_codes sc on sc.id = ma.status_code_id
join hr_clinics hc on hc.id = ma.hr_clinic_id where check_up_code_id = 2 order by id desc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_AllMedicalRequestsByStatusGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_AllMedicalRequestsByStatusGet`(in p_status char(11))
select ma.*, ar.description as reason_text, sc.description as status_code_text, hc.name as clinic_name, hc.city as clinic_city, hc.state as clinic_state, rc.description as result_code_text
from hr_medical_auths ma 
join hr_medical_auth_result_codes rc on rc.id = ma.result_code_id
join hr_medical_auth_reasons ar on ar.id = ma.hr_auth_reason_id
join hr_medical_auths_status_codes sc on sc.id = ma.status_code_id
join hr_clinics hc on hc.id = ma.hr_clinic_id 
where sc.description = p_status 
order by id desc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_AllMedicalRequestsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_AllMedicalRequestsGet`()
select ma.*, ar.description as reason_text, sc.description as status_code_text, hc.name as clinic_name, hc.city as clinic_city, hc.state as clinic_state, rc.description as result_code_text
from hr_medical_auths ma 
join hr_medical_auth_result_codes rc on rc.id = ma.result_code_id
join hr_medical_auth_reasons ar on ar.id = ma.hr_auth_reason_id
join hr_medical_auths_status_codes sc on sc.id = ma.status_code_id
join hr_clinics hc on hc.id = ma.hr_clinic_id order by id desc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApplicantByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApplicantByIdGet`(in p_id int(11))
select * from hr_applicants where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApplicantEmployeeCheckByRequestId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApplicantEmployeeCheckByRequestId`(in p_request_id int(11))
select hr_applicant_employee_code from hr_medical_auths where id = p_request_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApplicantInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApplicantInsert`(IN p_first_name varchar(32), IN p_last_name varchar(32), IN p_phone_number varchar(11), IN p_dob date, IN p_site int(11), IN p_division int(11), IN p_user_id int(11))
insert into hr_applicants(first_name, last_name, phone_number, dob, hr_site_id, hr_division_id, create_user_id, create_date)
values (
p_first_name, p_last_name, p_phone_number, p_dob, p_site, p_division, p_user_id, now()
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApplicantsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApplicantsGet`()
select a.*, concat(mu.first_name, ' ', mu.last_name) as username, sc.description as hr_status_code_text  from hr_applicants a 
join hr_applicant_status_codes sc on sc.id = a.hr_applicant_status_code_id
join main_users mu on mu.id = a.create_user_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApplicantStatusesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApplicantStatusesGet`()
select * from hr_applicant_status_codes ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApplicantUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApplicantUpdate`(in p_id int(11), in p_division int(11), in p_site int(11), in p_fName varchar(25), in p_lName varchar(25), in p_dob datetime, in p_phone varchar(11), in p_status int(11), in p_user int(11))
update hr_applicants set 
hr_division_id = p_division,
hr_site_id = p_site,
first_name = p_fName, 
last_name = p_lName, 
dob = p_dob, 
phone_number = p_phone,  
hr_applicant_status_code_id = p_status,
modify_user_id = p_user,
modify_date = now()
where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApproveAccountRequest` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApproveAccountRequest`(IN p_user_id int(11), IN p_id int(11))
update account_requests
set is_approved = 1, approved_date = now(), approved_by = p_user_id where employee_id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApproveAssetRequestByEmployeeId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApproveAssetRequestByEmployeeId`(IN p_approved tinyint(1), IN p_approved_by int(11), IN p_id int(11))
update asset_requests 
set is_approved = p_approved,
approved_date = now(),
approved_by = p_approved_by
where employee_id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApproveEmployeeById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApproveEmployeeById`(IN p_id int(11), IN p_user_id int(11))
update hr_employees set is_approved = 1, approved_date = now(), approved_by_user_id = p_user_id where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ApproveEmployeeByName` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ApproveEmployeeByName`(in p_name varchar(128))
update hr_employees 
set is_approved = 1 where concat(first_name, ' ', last_name) = p_name ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_AssetRequestByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_AssetRequestByIdGet`(IN p_id varchar(128))
(
SELECT * FROM silicore_site.asset_requests where employee_id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_AssetRequestByNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_AssetRequestByNameGet`(IN p_name varchar(128))
(
SELECT * FROM silicore_site.asset_requests where concat(first_name, ' ', last_name) = p_name
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ClinicInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ClinicInsert`(IN p_name varchar(32), IN p_address varchar(64), IN p_city varchar(24), IN p_state varchar(2), IN p_zip varchar(8), IN p_phone varchar(16), IN p_fax varchar(16), IN p_email varchar(32), IN p_user_id int(11))
insert into hr_clinics(name, address, city, state, zip, phone_number, fax_number, email_address, create_user_id, create_date)
values (
p_name, p_address, p_city, p_state, p_zip, p_phone, p_fax, p_email, p_user_id, now()
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_clinicsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_clinicsGet`()
select * from hr_clinics order by name asc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ClinicTestRelationshipGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ClinicTestRelationshipGet`(in p_hr_clinic_id int(11))
select * from hr_lab_test_relationship where hr_clinic_id = p_hr_clinic_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_DepartmentsBySiteGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_DepartmentsBySiteGet`(in p_site_id int(11))
select * from hr_departments where site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_DeptManagersGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_DeptManagersGetAll`()
BEGIN
  SELECT 
    id, 
    main_department_id,
    CONCAT(first_name, ' ',last_name) as mgrname
  FROM main_users
  WHERE is_active = 1
  AND user_type_id in(3,4,5)
  AND main_department_id != 2
  UNION
  SELECT 
    id, 
    main_department_id,
    CONCAT(first_name, ' ',last_name) as mgrname
  FROM main_users
  WHERE id in(2,20);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_DeptSelect` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_DeptSelect`()
BEGIN
    SELECT id, name, is_active from main_departments
    WHERE is_active='1'
    AND id !='1';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_DivisionsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_DivisionsGet`()
(
select * from hr_divisions
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmailByNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmailByNameGet`(IN p_name varchar(32))
(
select first_name, last_name, email from main_users where concat(first_name, ' ', last_name) LIKE p_name
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmpDeptSelectById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmpDeptSelectById`(
     IN p_id INT(11)   
)
BEGIN
        SELECT main_hr_checklist.id,
		       main_hr_checklist.first_name,
               main_hr_checklist.last_name,
		       main_hr_checklist.employee_id,
		       main_hr_checklist.department_id,
		       main_hr_checklist.manager,
		       main_hr_checklist.silicore_account_requested,
               main_hr_checklist.silicore_account_model,
		       main_hr_checklist.email_account_requested,
		       main_hr_checklist.cell_phone_requested,
		       main_hr_checklist.laptop_requested,
			   main_hr_checklist.desktop_requested,
               main_hr_checklist.monitors_requested,
		       main_hr_checklist.tablet_requested,
		       main_hr_checklist.two_way_radio_requested,
			   main_hr_checklist.special_software_requested,
               main_hr_checklist.create_date,
		       main_hr_checklist.create_user_id,
		       main_hr_checklist.edit_date,
		       main_hr_checklist.edit_user_id,
		       main_hr_checklist.is_active,
               main_departments.name
    FROM main_hr_checklist
    LEFT JOIN main_departments 
    ON main_hr_checklist.department_id = main_departments.id
	WHERE main_hr_checklist.id=p_id;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmpDeptSiteSelectById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmpDeptSiteSelectById`(
    IN p_id INT(11)   
)
BEGIN
        SELECT 
          main_hr_checklist.id,
          main_hr_checklist.last_name,
          main_hr_checklist.first_name,
          main_hr_checklist.employee_id,
          main_hr_checklist.department_id,
          main_hr_checklist.job_title_id,
          main_hr_checklist.manager_user_id,
          main_hr_checklist.site_id,
          main_hr_checklist.start_date,
          main_hr_checklist.separation_date,
          main_hr_checklist.silicore_account_requested,
          main_hr_checklist.silicore_account_model,
          main_hr_checklist.email_account_requested,
          main_hr_checklist.email_account_model_id,
          main_hr_checklist.cell_phone_requested,
          main_hr_checklist.laptop_requested,
          main_hr_checklist.desktop_requested,
          main_hr_checklist.monitors_requested,
          main_hr_checklist.tablet_requested,
          main_hr_checklist.two_way_radio_requested,
          main_hr_checklist.special_software_requested,
          main_hr_checklist.comments,
          main_hr_checklist.create_date,
          main_hr_checklist.create_user_id,
          main_hr_checklist.edit_date,
          main_hr_checklist.edit_user_id,
          main_hr_checklist.is_active,
          main_departments.name,
          main_sites.description,
          main_hr_job_titles.name as job_title_name,
          CONCAT(main_users.first_name, ' ',main_users.last_name) as mgrname
    FROM main_hr_checklist
    LEFT JOIN main_departments 
    ON main_hr_checklist.department_id = main_departments.id
    LEFT JOIN main_sites 
    ON main_hr_checklist.site_id = main_sites.id
    LEFT JOIN main_hr_job_titles 
    ON main_hr_checklist.job_title_id = main_hr_job_titles.id
	LEFT JOIN main_users 
    ON main_hr_checklist.manager_user_id = main_users.id
	WHERE main_hr_checklist.id=p_id;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmpGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmpGetAll`()
BEGIN
  SELECT 
    id, 
    main_department_id,
    CONCAT(first_name, ' ',last_name) as empname
  FROM main_users
  WHERE is_active = 1
  AND user_type_id in(1,2,3)
  AND main_department_id != 2
  UNION
  SELECT 
    id,  
    main_department_id,
    CONCAT(first_name, ' ',last_name) as empname
  FROM main_users
  WHERE user_type_id in(1,2,3,4,5)
  AND is_active = 1
  ORDER BY main_department_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmpInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmpInsert`(
  IN  p_last_name varchar(45),
  IN  p_first_name varchar(45),
  IN  p_employee_id varchar(45),
  IN  p_department_id int(11),
  IN  p_job_title_id int(11),
  IN  p_manager_user_id int(11),
  IN  p_site_id int(11),
  IN  p_start_date DATE,
  IN  p_silicore_account_requested tinyint(1),
  IN  p_email_account_requested tinyint(1),
  IN  p_email_account_model_id int(11),
  IN  p_cell_phone_requested tinyint(1),
  IN  p_laptop_requested tinyint(1),
  IN  p_desktop_requested tinyint(1),
  IN  p_monitors_requested varchar(45),
  IN  p_tablet_requested tinyint(1),
  IN  p_two_way_radio_requested tinyint(1),
  IN  p_special_software_requested varchar(45),
  IN  p_uniform_requested tinyint(1),
  IN  p_business_card_requested tinyint(1),
  IN  p_credit_card_requested tinyint(1),
  IN  p_fuel_card_requested tinyint(1),
  IN  p_comments varchar(1024),
  IN  p_is_approved tinyint(1),
  IN  p_approved_user_id int(11),
  IN  p_create_user_id int(11),
  IN  p_is_active tinyint(1),
  IN  p_cell_phone_note varchar(256),
  IN  p_laptop_note varchar(256),
  IN  p_desktop_note varchar(256),
  IN  p_tablet_note varchar(256),
  IN  p_two_way_radio_note varchar(256)
)
BEGIN
INSERT INTO main_hr_checklist 
(
  last_name,
  first_name,
  employee_id,
  department_id,
  job_title_id,
  manager_user_id,
  site_id,
  start_date,
  silicore_account_requested,
  email_account_requested,
  email_account_model_id,
  cell_phone_requested,
  laptop_requested,
  desktop_requested,
  monitors_requested,
  tablet_requested, 
  two_way_radio_requested,
  special_software_requested,
  uniform_requested,
  business_card_requested,
  credit_card_requested,
  fuel_card_requested,
  comments,
  is_approved,
  approved_date,
  approved_user_id,
  create_date,
  create_user_id,
  is_active,
  cell_phone_notes,
  laptop_notes,
  desktop_notes,
  tablet_notes,
  two_way_radio_notes        
)        
VALUES 
(   
  p_last_name,
  p_first_name,
  p_employee_id,
  p_department_id,
  p_job_title_id,
  p_manager_user_id,
  p_site_id,
  p_start_date,
  p_silicore_account_requested,
  p_email_account_requested,
  p_email_account_model_id,
  p_cell_phone_requested,
  p_laptop_requested,
  p_desktop_requested,
  p_monitors_requested,
  p_tablet_requested,
  p_two_way_radio_requested,
  p_special_software_requested,
  p_uniform_requested,
  p_business_card_requested,
  p_credit_card_requested,
  p_fuel_card_requested,
  p_comments,
  p_is_approved,
  now(),
  p_approved_user_id,
  now(),
  p_create_user_id,
  p_is_active,
  p_cell_phone_note,
  p_laptop_note,
  p_desktop_note,
  p_tablet_note,
  p_two_way_radio_note
  );        
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeeAndApplicantNamesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_EmployeeAndApplicantNamesGet`(in p_query varchar(70))
select concat('001', id) as id, first_name, last_name from hr_employees e where concat(first_name, ' ', last_name) LIKE concat('%', p_query, '%') union select concat('000', id) as id, first_name, last_name from hr_applicants where concat(first_name, ' ', last_name) LIKE concat('%', p_query, '%') ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeeByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmployeeByIdGet`(IN p_id int(11))
select e.*, hd.division, hs.site from hr_employees e join hr_job_titles jt on jt.id = e.job_title_id join hr_departments dep on dep.id = jt.department_id
join hr_sites hs on hs.id = dep.site_id join hr_divisions hd on hd.id = hs.division_id where e.id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeeByPaycomGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmployeeByPaycomGet`(in p_paycom_id varchar(32))
select count(id) as result from hr_employees where paycom_id = p_paycom_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeeInactivateUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmployeeInactivateUpdate`(in p_id int(11))
update hr_employees set is_active = 0, separation_date = now() where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeeInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmployeeInsert`(
  IN  p_last_name varchar(64),
  IN  p_first_name varchar(64),
  IN  p_paycom_id varchar(32),
  IN  p_department_id int(11),
  IN  p_job_title_id int(11),
  IN  p_manager_user_id int(11),
  IN  p_start_date DATE,
  IN  p_comments varchar(1024),
  IN p_approved_date datetime,
  IN p_is_approved tinyint(1),
  IN  p_create_user_id int(11),
  IN p_approved_by int(11)
)
BEGIN
INSERT INTO hr_employees
(
  last_name,
  first_name,
  paycom_id,
  department_id,
  job_title_id,
  manager_user_id,
  start_date,
  comments,
  is_approved,
  approved_date,
  approved_by_user_id,
  create_date,
  create_user_id   
)        
VALUES 
(   
  p_last_name,
  p_first_name,
  p_paycom_id,
  p_department_id,
  p_job_title_id,
  p_manager_user_id,
  p_start_date,
  p_comments,
  p_is_approved,
  p_approved_date,
  p_approved_by,
  now(),
  p_create_user_id
  ); 
  select LAST_INSERT_ID() as id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeeNamesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmployeeNamesGet`(in p_query varchar(70))
select id, first_name, last_name from hr_employees where concat(first_name, ' ', last_name) LIKE concat('%', p_query, '%') ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmployeesGet`()
(
select hr.id as id, 
hr.first_name as first_name, 
hr.last_name as last_name, 
hr.paycom_id as paycom_id, 
jt.department_id as department_id, 
jt.id as job_title,
jt.position as job_title_name,
d.department_display as department_name,
hd.id as division_id, 
hd.division as division_name,
hr.manager_user_id as manager_user_id, 
concat(hr2.first_name, ' ', hr2.last_name) as manager_name, 
hr.approved_by_user_id,
s.id as site_id,
s.site as site_name,
hr.start_date,  
hr.is_active,
hr.is_approved,
hr.comments
from hr_employees hr
left join hr_employees hr2 on hr.manager_user_id = hr2.id
left join hr_job_titles jt on jt.id = hr.job_title_id
left join hr_departments d on d.id = jt.department_id
left join hr_sites s on s.id = d.site_id
left join hr_divisions hd on hd.id = s.division_id
where hr.separation_date is null
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeeUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmployeeUpdate`(
  IN  p_id INT(11),
  IN  p_last_name varchar(45),
  IN  p_first_name varchar(45),
  IN  p_paycom_id varchar(45),
  IN  p_department_id int(11),
  IN  p_job_title_id int(11),
  IN  p_manager_user_id int(11),
  IN  p_edit_user_id int(11),
  IN  p_is_active tinyint(1)
)
UPDATE hr_employees
	SET last_name = p_last_name,
    first_name = p_first_name,
    paycom_id = p_paycom_id,
    department_id = p_department_id,
    job_title_id = p_job_title_id,
    manager_user_id = p_manager_user_id,
    edit_user_id = p_edit_user_id,
    edit_date = now(),
    is_active = p_is_active   
WHERE id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmployeeView` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmployeeView`()
(
select hr.id as id, 
hr.first_name as first_name, 
hr.last_name as last_name, 
hr.employee_id as employee_id, 
hr.department_id as department_id, 
hr.job_title_id as job_title,
jt.name as job_title_name,
d.name as department_name, 
hr.manager_user_id as manager_user_id, 
concat(mu.first_name, ' ', mu.last_name) as manager_name, 
hr.site_id, 
s.description as site_name, 
hr.start_date,  
hr.is_active,
hr.cell_phone_requested as cell_phone_requested,
hr.laptop_requested as laptop_requested,
hr.two_way_radio_requested as two_way_radio_requested,
hr.business_card_requested as business_card_requested,
hr.fuel_card_requested as fuel_card_requested,
hr.credit_card_requested as credit_card_requested,
hr.desktop_requested as desktop_requested
from main_hr_checklist hr
join main_users mu on mu.id = hr.manager_user_id
join main_hr_job_titles jt on jt.id = hr.job_title_id
join main_departments d on d.id = hr.department_id
join main_sites s on s.id = hr.site_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmpSelect` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmpSelect`(
 
)
BEGIN
    SELECT main_hr_checklist.id,
		   main_hr_checklist.last_name,
           main_hr_checklist.first_name,
		   main_hr_checklist.employee_id,
		   main_hr_checklist.department_id,
		   main_hr_checklist.manager_user_id,
           main_hr_checklist.site_id,
		   main_hr_checklist.start_date,
           main_hr_checklist.is_active,
           main_hr_checklist.is_approved,
           main_departments.name,
           main_sites.description
    FROM main_hr_checklist
    LEFT JOIN main_departments 
    ON main_hr_checklist.department_id = main_departments.id
    LEFT JOIN main_sites 
    ON main_hr_checklist.site_id = main_sites.id
	ORDER BY main_hr_checklist.create_date DESC ;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmpSelectById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmpSelectById`(   
	IN p_id INT(11)
)
BEGIN
    SELECT main_hr_checklist.id,
		   main_hr_checklist.last_name,
		   main_hr_checklist.first_name,
		   main_hr_checklist.employee_id,
		   main_hr_checklist.department_id,
		   main_hr_checklist.manager_user_id,
           main_hr_checklist.site_id,
           main_hr_checklist.start_date,
           main_hr_checklist.separation_date,
		   main_hr_checklist.uniform_requested,
           main_hr_checklist.business_card_requested,
           main_hr_checklist.fuel_card_requested,
           main_hr_checklist.credit_card_requested,
		   main_hr_checklist.silicore_account_requested,
		   main_hr_checklist.silicore_account_model,
		   main_hr_checklist.email_account_requested,
           main_hr_checklist.email_account_model_id,
		   main_hr_checklist.cell_phone_requested,
		   main_hr_checklist.laptop_requested,
		   main_hr_checklist.desktop_requested,
		   main_hr_checklist.monitors_requested,
		   main_hr_checklist.tablet_requested,
		   main_hr_checklist.two_way_radio_requested,
		   main_hr_checklist.special_software_requested,
		   main_hr_checklist.comments,
           main_hr_checklist.is_approved,
		   main_hr_checklist.create_date,
		   main_hr_checklist.create_user_id,
		   main_hr_checklist.edit_date,
		   main_hr_checklist.edit_user_id,
		   main_hr_checklist.is_active,
           main_hr_checklist.cell_phone_notes,
           main_hr_checklist.laptop_notes,
		   main_hr_checklist.desktop_notes,
           main_hr_checklist.tablet_notes,
           main_hr_checklist.two_way_radio_notes
        
    FROM main_hr_checklist 
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_EmpUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_EmpUpdate`(
  IN  p_id INT(11),
  IN  p_last_name varchar(45),
  IN  p_first_name varchar(45),
  IN  p_employee_id varchar(45),
  IN  p_department_id int(11),
  IN  p_job_title_id int(11),
  IN  p_manager_user_id int(11),
  IN  p_site_id int(11),
  IN  p_start_date DATE,
  IN  p_separation_date DATE,
  IN  p_silicore_account_requested tinyint(1),
 
  IN  p_email_account_requested tinyint(1),
  IN  p_email_account_model_id int(11),
  IN  p_cell_phone_requested tinyint(1),
  IN  p_laptop_requested tinyint(1),
  IN  p_desktop_requested tinyint(1),
  IN  p_monitors_requested varchar(45),
  IN  p_tablet_requested tinyint(1),
  IN  p_two_way_radio_requested tinyint(1),
  IN  p_special_software_requested varchar(45),
  IN  p_uniform_requested tinyint(1),
  
  IN  p_business_card_requested tinyint(1),
  IN  p_credit_card_requested tinyint(1),
  IN  p_fuel_card_requested tinyint(1),
  IN  p_comments varchar(1024),
  IN  p_is_approved tinyint(1),
  IN  p_approved_user_id int(11),
  IN  p_edit_user_id int(11),
  IN  p_is_active tinyint(1),
  IN  p_cell_phone_note varchar(256),
  IN  p_laptop_note varchar(256),
  IN  p_desktop_note varchar(256),
  IN  p_tablet_note varchar(256),
  IN  p_two_way_radio_note varchar(256)
)
BEGIN
UPDATE main_hr_checklist
	SET last_name = p_last_name,
    first_name = p_first_name,
    employee_id = p_employee_id,
    department_id = p_department_id,
    job_title_id = p_job_title_id,
    manager_user_id = p_manager_user_id,
    site_id = p_site_id,
    start_date = p_start_date,
    separation_date = p_separation_date,
    silicore_account_requested = p_silicore_account_requested,
   
    email_account_requested = p_email_account_requested,
    email_account_model_id = p_email_account_model_id,
    cell_phone_requested = p_cell_phone_requested,
    laptop_requested = p_laptop_requested,
    desktop_requested = p_desktop_requested,
    monitors_requested = p_monitors_requested,
    tablet_requested = p_tablet_requested,
    two_way_radio_requested = p_two_way_radio_requested,
    special_software_requested = p_special_software_requested,
    uniform_requested = p_uniform_requested,
    
    business_card_requested = p_business_card_requested,
    credit_card_requested = p_credit_card_requested,
    fuel_card_requested = p_fuel_card_requested,
    comments = p_comments,
    is_approved = p_is_approved,
    approved_date = now(),
    approved_user_id = p_approved_user_id,
    edit_date = now(),
    edit_user_id = p_edit_user_id,
    is_active = p_is_active,
    cell_phone_notes = p_cell_phone_note,
    laptop_notes = p_laptop_note,
    desktop_notes = p_desktop_note,
    tablet_notes = p_tablet_note,
    two_way_radio_notes = p_two_way_radio_note        
WHERE id = p_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_JobSelect` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_JobSelect`()
BEGIN
  SELECT id,
         description,
         name
  from main_hr_job_titles
  WHERE is_active='1';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_JobTitleFastInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_JobTitleFastInsert`(in p_dept_id int(11), in p_position varchar(64), in p_is_management tinyint(1))
insert into hr_job_titles (department_id, position, is_management) values (p_dept_id, p_position, p_is_management) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_JobTitleInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_JobTitleInsert`(
IN p_site_id int(11),
IN p_department_id int(11),
IN p_name varchar(45),
IN p_description varchar(45),
IN p_user_type_id int(11),
IN p_create_user_id int(11) 
)
insert into main_hr_job_titles
(
site_id,
department_id,
name,
description,
user_type_id,
create_user_id,
create_date
)
values
(
p_site_id,
p_department_id,
p_name,
p_description,
p_user_type_id,
p_create_user_id,
now()
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_JobTitlesGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_JobTitlesGetAll`()
BEGIN
	SELECT  id,
			name,
			site_id,
            description,
            department_id,
            user_type_id	
    FROM  main_hr_job_titles
    WHERE is_active = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_JobTitlesGetByDept` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_JobTitlesGetByDept`(
     IN p_department_id INT(11)
)
BEGIN
  SELECT id, position as name, department_id from hr_job_titles
  WHERE department_id=p_department_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_JobTitleUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_JobTitleUpdate`(
IN p_id int(11),
IN p_site_id int(11),
IN p_department_id int(11),
IN p_name varchar(45),
IN p_description varchar(45),
IN p_user_type_id int(11),
IN p_edit_user_id int(11),
IN p_is_active tinyint(1)
)
update main_hr_job_titles
set 
site_id = p_site_id,
department_id = p_department_id,
name = p_name,
description = p_description,
user_type_id = p_user_type_id,
edit_date = now(),
edit_user_id = p_edit_user_id,
is_active = p_is_active
where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_LabTestByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_LabTestByIdGet`(in p_id int(11))
select * from hr_lab_tests where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_LabTestRelationshipDelete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_LabTestRelationshipDelete`(in p_hr_clinic_id int(11), in p_hr_lab_test_id int(11))
begin
delete from hr_lab_test_relationship where hr_clinic_id = p_hr_clinic_id and hr_lab_test_id =  p_hr_lab_test_id;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_LabTestRelationshipInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_LabTestRelationshipInsert`(in p_hr_clinic_id int(11), in p_hr_lab_test_id int(11))
begin
insert into hr_lab_test_relationship(hr_clinic_id, hr_lab_test_id) values (p_hr_clinic_id, p_hr_lab_test_id)
on duplicate key update hr_lab_test_id = p_hr_lab_test_id;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MainDeptIdByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MainDeptIdByIdGet`(in p_id int(11))
select main_department_id from hr_departments where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MainUserPermissionsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MainUserPermissionsInsert`(in p_user_id int(11), in p_permission varchar(32), in p_permission_level int(11), in p_site varchar(40), in p_created_by int(11))
insert into main_user_permissions 
(user_id, permission, permission_level, site, created_datetime, created_by, company)
values
(p_user_id, p_permission, p_permission_level, p_site, now(), p_created_by, 'vista') ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MainUserRolesInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MainUserRolesInsert`(in p_user_id int(11), in p_role_id int(11))
insert into main_users_roles_check 
(user_id, role_id)
values
(p_user_id, p_role_id) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ManagerNameGetById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ManagerNameGetById`(
    IN  p_manager_id INT(11)
)
BEGIN
    SELECT display_name FROM main_users
    WHERE id = p_manager_id
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ManagersGetByDept` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ManagersGetByDept`(in p_dept_id int(11))
BEGIN
select e.id, concat(e.first_name, ' ', e.last_name) as mgrname from hr_employees e 
join hr_departments d on d.id = e.department_id
join hr_job_titles j on j.id = e.job_title_id
where j.is_management = 1 and d.id = p_dept_id and e.is_active = 1 and j.is_exec = 0
union 
select e.id, concat(e.first_name, ' ', e.last_name) as mgrname from hr_employees e 
join hr_job_titles j on j.id = e.job_title_id
where e.is_active = 1 and j.is_exec = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthByApplicantId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthByApplicantId`(in p_applicant_id int(11))
select ma.*, ar.description as reason_text, sc.description as status_code_text, hc.name as clinic_name, hc.city as clinic_city, hc.state as clinic_state, rc.description as result_code_text 
from hr_medical_auths ma 
join hr_medical_auth_result_codes rc on rc.id = ma.result_code_id
join hr_medical_auth_reasons ar on ar.id = ma.hr_auth_reason_id
join hr_medical_auths_status_codes sc on sc.id = ma.status_code_id
join hr_clinics hc on hc.id = ma.hr_clinic_id where hr_applicant_employee_code = p_applicant_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthFilePathGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthFilePathGet`(in p_id int(11))
select file_path from hr_medical_auths where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthFilePathInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthFilePathInsert`(in p_id int(11), in p_file_path varchar(64))
update hr_medical_auths set file_path = p_file_path where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthInsert`(in p_applicant_employee_code varchar(11), in p_clinic_id int(11), in p_reason_id int(11), in p_is_dot tinyint(1), in p_comments text(128), in p_user_id int(11))
begin
insert into hr_medical_auths 
(hr_applicant_employee_code, hr_clinic_id, hr_auth_reason_id, is_dot, comments, create_user_id, create_date, modify_user_id, modify_date)
values 
(p_applicant_employee_code, p_clinic_id, p_reason_id, p_is_dot, p_comments, p_user_id, now(), p_user_id, now());
select LAST_INSERT_ID() as id;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthLabTestInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthLabTestInsert`(in p_med_auth_id int(11), in p_lab_test_id int(11))
insert into hr_medical_auths_lab_tests (hr_medical_auth_id, hr_lab_test_id) values (p_med_auth_id, p_lab_test_id) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthReasonsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthReasonsGet`()
select * from hr_medical_auth_reasons order by description asc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthsFollowUpCheck` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthsFollowUpCheck`()
select * from hr_medical_auths where check_up_code_id = 1 and status_code_id > 1 and status_code_id < 5 and datediff(now(), modify_date) >= 7 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthsFollowUpUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthsFollowUpUpdate`(in p_id int(11), in p_check_up_code int(11))
update hr_medical_auths set check_up_code_id = p_check_up_code where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthStatusCodeByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthStatusCodeByIdGet`(in p_request_id int(11))
select ma.status_code_id, sc.description from hr_medical_auths ma join hr_medical_auths_status_codes sc on sc.id = ma.status_code_id where ma.id = p_request_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthStatusCodesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthStatusCodesGet`()
select * from hr_medical_auths_status_codes where id != 1 and id !=2 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalAuthStatusUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalAuthStatusUpdate`(in p_id int(11), in p_status_code_id int(3), in p_user_id int(11), in p_paid_date datetime)
update hr_medical_auths set status_code_id = p_status_code_id, modify_date = now(), modify_user_id = p_user_id, paid_date = p_paid_date where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalRequestByAppEmpCodeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalRequestByAppEmpCodeGet`(in p_query int(11))
select ma.*, ar.description as reason_text, sc.description as status_code_text, hc.name as clinic_name, hc.city as clinic_city, hc.state as clinic_state, rc.description as result_code_text
from hr_medical_auths ma 
join hr_medical_auth_result_codes rc on rc.id = ma.result_code_id
join hr_medical_auth_reasons ar on ar.id = ma.hr_auth_reason_id
join hr_medical_auths_status_codes sc on sc.id = ma.status_code_id
join hr_clinics hc on hc.id = ma.hr_clinic_id where ma.hr_applicant_employee_code = p_query order by id desc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalRequestByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalRequestByIdGet`(in p_id int(11))
select ma.*, hc.name, hc.address, hc.city, hc.state, hc.zip, hc.phone_number, hc.fax_number, r.description as reason, concat(mu.first_name, ' ', mu.last_name) as authorized_by
from hr_medical_auths ma 
join hr_clinics hc on ma.hr_clinic_id = hc.id
join hr_medical_auth_reasons r on r.id = ma.hr_auth_reason_id
join main_users mu on mu.id = ma.create_user_id
where ma.id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalRequestsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalRequestsGet`(in p_hr_applicant_id int(11))
select * from hr_medical_auths where hr_applicant_id = p_hr_applicant_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_MedicalTestsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_MedicalTestsGet`()
select * from hr_lab_tests ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_PaycomIdByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_PaycomIdByIdGet`(IN p_id int(11))
select paycom_id from hr_employees where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_PaycomUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_PaycomUpdate`(IN p_id int(11), IN p_paycom_id varchar(32))
update hr_employees set paycom_id = p_paycom_id  where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_RequestedEmployeeApplicantCodeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_RequestedEmployeeApplicantCodeGet`(in p_id int(11))
select hr_applicant_employee_code as code from hr_medical_auths where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_RequestedTestsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_RequestedTestsGet`(in p_id int(11))
select * from hr_medical_auths_lab_tests mt join hr_lab_tests lt on lt.id = mt.hr_lab_test_id where hr_medical_auth_id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ReturnAssetInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ReturnAssetInsert`(in p_id int(11), in p_asset_type varchar(20), in p_user_id int(11))
insert into hr_returned_assets (employee_id, asset_type, return_date, user_id) values (p_id, p_asset_type, now(), p_user_id) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_ReturnedAssetsByEmployeeIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_ReturnedAssetsByEmployeeIdGet`(in p_id int(11))
select * from hr_returned_assets where employee_id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_SilicoreUserAutoInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_SilicoreUserAutoInsert`(
in p_employee_id int(11), in p_username varchar(45), in p_first varchar(45), in p_last varchar(45), in p_display varchar(45), in p_email varchar(45), in p_dept int(11), in p_manager_id int(11), in p_user_id int(11)
)
begin
insert into main_users 
(
employee_id, username, first_name, last_name, display_name, email, company, require_password_reset, main_department_id, password, start_date, role_check, user_type_id, manager_id, create_date, create_user_id, is_active
) values (
p_employee_id, p_username, p_first, p_last, p_display, p_email, 'vista', '1', p_dept, '$2y$10$byDzRxZrtD7Q50z262lg3OOWVld4d1umuF3rxGCjrm.pA2Wgzwy5G', now(), '0', '1', p_manager_id, now(), p_user_id, '0'
);
select LAST_INSERT_ID() as id; 
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_SiteByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_SiteByIdGet`(IN p_id int(11))
select site from hr_sites where id = p_id and is_active = 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_SiteNameGetById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_SiteNameGetById`(
    IN  p_site_id INT(11)
)
BEGIN
    SELECT description FROM main_sites 
    WHERE id = p_site_id
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_SitesByDivisionGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_SitesByDivisionGet`(in p_division_id int(11))
select * from hr_sites where division_id = p_division_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_SiteSelect` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_SiteSelect`()
BEGIN
  SELECT id, description from main_sites
  WHERE is_vista_site = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_TestNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_TestNameGet`(in p_id int(11))
select description from hr_lab_tests where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_TestsByClinicGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_TestsByClinicGet`(in p_hr_clinic_id int(11))
select ltr.hr_clinic_id, lt.id, lt.description from hr_lab_test_relationship ltr join hr_lab_tests lt on lt.id = ltr.hr_lab_test_id where hr_clinic_id = p_hr_clinic_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_UserAccountPermissionsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_UserAccountPermissionsGet`(in p_user varchar(128))
select * from main_user_permissions p 
join main_users mu on mu.id = p.user_id
join hr_employees e on concat(e.first_name, ' ', e.last_name) = concat(mu.first_name, ' ', mu.last_name)
where  concat(e.first_name, ' ', e.last_name) = p_user ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hr_UserAccountRolesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_hr_UserAccountRolesGet`(in p_user varchar(128))
select * from main_users_roles_check p 
join main_users mu on mu.id = p.user_id
join hr_employees e on concat(e.first_name, ' ', e.last_name) = concat(mu.first_name, ' ', mu.last_name)
where  concat(e.first_name, ' ', e.last_name) = p_user ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_InsertSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertSample`(
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
    IN  p_shift VARCHAR(5)
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_AcknowledgementGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_AcknowledgementGet`(in p_request_id int(11))
select file_path from it_asset_acknowledgements where request_id = p_request_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_AssetAcknowledgementInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_AssetAcknowledgementInsert`(in p_request_id int(11),in p_file_name varchar(128), in p_file_path varchar(128), in p_user_id int(11))
begin
insert into it_asset_acknowledgements
(request_id, file_name, file_path, user_id)
values
(p_request_id, p_file_name, p_file_path, p_user_id)
on duplicate key update request_id = p_request_id, file_name = p_file_name, file_path = p_file_path, user_id = p_user_id;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_AssetMakesByTypeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_AssetMakesByTypeGet`(in p_type_id int(11))
(
select * from it_asset_makes where type_id = p_type_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_AssetPricesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_AssetPricesGet`()
select t.type as type, i.description as description, i.part_number, i.create_date, i.purchase_price, null as total from it_inventory i
join it_asset_types t on t.id = i.type ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_AssetRequestInactivate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_AssetRequestInactivate`(in p_id int(11))
update asset_requests set is_active = 0 where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_AssetRequestInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_AssetRequestInsert`(in p_employee_id int(11), in p_first_name varchar(45), in p_last_name varchar(45), in p_type varchar(45), in p_user_id int(11))
insert into asset_requests 
(employee_id, first_name, last_name, type, request_date, requested_by, is_approved, approved_date, approved_by)
values
(p_employee_id, p_first_name, p_last_name, p_type, now(), p_user_id, '1', now(), p_user_id) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_AssetTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_AssetTypesGet`()
(
select * from it_asset_types where is_active = 1
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_AssignLogGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_AssignLogGet`()
(
select 
l.inventory_id as inventory_id,
t.type as type, 
i.part_number as part_number,
i.description as description,
i.create_date as create_date, 
l.employee_id as employee_id, 
concat(e.first_name, ' ', e.last_name) as name, 
l.in_timestamp as in_timestamp,
l.out_timestamp as out_timestamp from it_assign_log l
join it_inventory i on i.id = l.inventory_id
join hr_employees e on e.id = l.employee_id
join it_asset_types t on t.id = i.type
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_auto_asset_request` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_auto_asset_request`(IN p_employee_id int(11), IN p_fname varchar(32), IN p_lname varchar(32), 
IN p_type varchar(32), IN p_requested_user_id varchar(32), in p_is_approved tinyint(1), in p_approved_date datetime, in p_approved_by int(11))
begin
insert into asset_requests 
(
employee_id, first_name, last_name, type, request_date, requested_by, is_approved, approved_date, approved_by, is_auto
) 
values 
(
p_employee_id, p_fname, p_lname, p_type, now(), p_requested_user_id, p_is_approved, p_approved_date, p_approved_by, '1'
);
select LAST_INSERT_ID() as id;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_CompleteRequest` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_CompleteRequest`(IN p_id int(11), IN p_inventory_id varchar(128), p_kace_ticket int(11), p_completed_by int(11), p_employee_id int(11))
BEGIN
update asset_requests
set 
inventory_id = p_inventory_id, 
kace_ticket = p_kace_ticket,
is_complete = 1,
complete_date = now(),
completed_by = p_completed_by
where id = p_id;
insert into it_assign_log (inventory_id, employee_id, in_timestamp, create_date, create_user_id)
values (p_inventory_id, p_employee_id, now(), now(), p_completed_by);
update it_inventory set assigned_user = p_employee_id
where id = p_inventory_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_DischargeLogGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_DischargeLogGet`()
(
select 
t.type as type,
i.part_number as serial, 
l.note as note, 
l.timestamp as timestamp, 
concat(u.first_name, ' ', u.last_name) as name 
from it_asset_discharge_log l
join it_inventory i on i.id = l.inventory_id
join it_asset_types t on t.id = i.type
join main_users u on u.id = l.create_user_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_EmployeeByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_EmployeeByIdGet`(in p_id int(11))
select id, first_name, last_name from hr_employees where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_EmployeeUnassignAndRemoveAssetUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_EmployeeUnassignAndRemoveAssetUpdate`(in p_id int(11), in p_user_id int(11), in p_note varchar(255))
begin
update it_inventory 
set assigned_user = NULL,
 modify_user_id = p_user_id, 
 modify_date = now(),
is_active = 0
where id = p_id;
update it_assign_log set out_timestamp = now(), modify_date = now(), modify_user_id = p_user_id where inventory_id = p_id;
insert it_asset_discharge_log (inventory_id, note, create_user_id, create_date, timestamp) values (p_id, p_note, p_user_id, now(), now()); 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_EmployeeUnassignAssetUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_EmployeeUnassignAssetUpdate`(in p_id int(11), in p_user_id int(11))
begin
update it_inventory set assigned_user = NULL, modify_user_id = p_user_id, modify_date = now() where id = p_id;
update it_assign_log set out_timestamp = now(), modify_date = now(), modify_user_id = p_user_id where inventory_id = p_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_IncompleteRequestsCountGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_IncompleteRequestsCountGet`()
SELECT count(id) as incomplete_requests FROM silicore_site.asset_requests where is_complete = 0 and is_active = 1 and type IN ('Cell Phone','Laptop','Desktop','Radio','Tablet') ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_InventoryByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_InventoryByIdGet`(in p_id int(11))
(
select * from it_inventory where id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_InventoryGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_InventoryGet`()
(
select i.id as id, i.division_id as division_id, d.division as division_name, i.site_id as site_id, s.site as site_name, i.type as type, t.type as type_name, i.make_id as make_id, m.make as make, i.part_number as part_number, pn.phone_number as phone_number, i.description as description, concat(e.first_name, ' ', e.last_name) as assigned_user, concat(u.first_name, ' ', u.last_name) as name, i.create_date as create_date 
from it_inventory i 
left join it_asset_types t on t.id = i.type
left join main_users u on u.id = i.create_user_id
left join hr_employees e on e.id = i.assigned_user
left join it_asset_makes m on m.id = i.make_id
left join it_asset_phone_numbers pn on pn.inventory_id = i.id
join hr_divisions d on d.id = i.division_id
join hr_sites s on s.id = i.site_id
where i.is_active = 1) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_InventoryInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_InventoryInsert`(in p_division int(11), in p_site int(11), in p_type int(11), in p_make_id int(11), in p_description varchar(64), in p_part_number varchar(128), in p_purchase_price decimal(9,2), in p_user_id int(11))
begin
if p_purchase_price IS NULL THEN
insert into it_inventory (division_id, site_id, type, make_id, description, part_number, create_date, create_user_id)
values (p_division, p_site, p_type, p_make_id, p_description, p_part_number, now(), p_user_id);
else 
insert into it_inventory (division_id, site_id, type, make_id, description, part_number, purchase_price, create_date, create_user_id)
values (p_division, p_site, p_type, p_make_id, p_description, p_part_number, p_purchase_price, now(), p_user_id);
end if;
select LAST_INSERT_ID() as id;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_InventoryUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_InventoryUpdate`(IN p_id int(11), IN p_division_id int(11), IN p_site_id int(11), IN type int(11), IN p_make_id int(11), IN p_description varchar(64), IN p_user_id int(11))
update it_inventory set 
division_id = p_division_id,
site_id = p_site_id,
make_id = p_make_id,
description = p_description,
modify_date = now(),
modify_user_id = p_user_id
where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_NamesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_NamesGet`(in p_name varchar(70))
select id, concat(first_name, ' ', last_name) as name from hr_employees where is_active = 1 and concat(first_name, ' ', last_name) like concat('%', p_name, '%') ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_NetworkAlertUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_NetworkAlertUpdate`(IN  p_id INT(11),IN p_alerts_on tinyint(1))
BEGIN
UPDATE `silicore_site`.`it_network_locations`
SET `alerts_on` = p_alerts_on
WHERE `id` = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_NetworkSitesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_NetworkSitesGet`()
BEGIN
SELECT 
    id,
    site_name,
    server_name,
    rtx_ip,
    rtx_status,
    gateway_ip,
    gateway_status,
    att_ip,
    att_status,
    att_circuit,
    alerts_on,
    last_alert,
    last_update
FROM
    it_network_locations;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_NetworkSiteUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_NetworkSiteUpdate`(
	IN  p_id INT(11),
	IN  p_site_name varchar(45),
	IN  p_server_name varchar(45),
	IN  p_rtx_ip varchar(16),
	IN  p_rtx_status tinyint(1),
	IN  p_gateway_ip varchar(16),
	IN  p_gateway_status tinyint(1),
	IN  p_att_ip varchar(16),
	IN  p_att_status tinyint(1),
    IN 	p_att_circuit varchar(45),
	IN  p_last_update DATETIME,
	IN  p_last_alert DATETIME)
BEGIN
UPDATE `silicore_site`.`it_network_locations`
SET
`site_name` = p_site_name,
`server_name` = p_server_name,
`rtx_ip` = p_rtx_ip,
`rtx_status` = P_rtx_status,
`gateway_ip` = p_gateway_ip,
`gateway_status` = p_gateway_status,
`att_ip` = p_att_ip,
`att_status` = p_att_status,
`att_circuit` = p_att_circuit,
`last_alert` = p_last_alert,
`last_update` = p_last_update
WHERE `id` = p_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_NonReturnedAssignedAssetsByEmployeeIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_NonReturnedAssignedAssetsByEmployeeIdGet`(in p_user int(11))
select * from it_inventory i 
join it_asset_types t on t.id = i.type
where i.assigned_user = p_user ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_PartNumberByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_PartNumberByIdGet`(in p_id int(11))
select part_number from it_inventory where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_PaycomByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_PaycomByIdGet`(in p_id int(11))
select paycom_id from hr_employees where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_PhoneNumberInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_PhoneNumberInsert`(p_inventory_id int(11), p_phone_number varchar(15), p_create_user_id int(11))
insert into it_asset_phone_numbers (inventory_id, phone_number, create_date, create_user_id)
values (p_inventory_id, p_phone_number, now(), p_create_user_id) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_PhoneNumberUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_PhoneNumberUpdate`(IN p_id int(11), p_phone_number varchar(15), p_modify_user_id int(11))
update it_asset_phone_numbers set phone_number = p_phone_number, modify_date = now(), modify_user_id = p_modify_user_id where inventory_id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_RemoveAssetUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_RemoveAssetUpdate`(in p_id int(11), in p_user_id int(11), in p_note varchar(256))
begin
update it_inventory set assigned_user = NULL, modify_user_id = p_user_id, modify_date = now(), is_active = 0 where id = p_id;
insert into it_asset_discharge_log (inventory_id, note, timestamp, create_user_id, create_date) values (p_id, p_note, now(), p_user_id, now());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_it_SerialsByTypeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_it_SerialsByTypeGet`(in p_type varchar(32))
(
select i.id as id, i.part_number as part_number 
from it_inventory i 
join it_asset_types t on t.id = i.type 
where t.type = p_type and i.assigned_user IS NULL and i.is_active = 1
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_JobTitlesByDeptGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_JobTitlesByDeptGet`(IN p_department_id int(11))
select hr.id, hr.name, hr.description, hr.site_id, hr.department_id, hr.user_type_id from main_hr_job_titles hr
where hr.department_id = p_department_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_plc_TagsAllGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_plc_TagsAllGet`()
SELECT * FROM main_plc_tags_view ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_AllSievesViewGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_AllSievesViewGet`()
(
select * from qc_AllSieves_View
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_AllSitesLocationsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_AllSitesLocationsGet`()
(
SELECT * FROM qc_AllSitesLocationsView
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_CleanLogGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_CleanLogGet`()
select cl.id, cl.sieve_stack_id, stack.description as stack_name, cl.site_id, site.description as site_name, cl.timestamp, cl.user_id, concat(user.first_name, ' ', user.last_name) as name
from gb_qc_sieve_stacks stack 
join qc_stack_cleaning_log cl on cl.sieve_stack_id = stack.id and cl.site_id = stack.main_site_id
join main_sites site on site.id = cl.site_id
join main_users user on user.id = cl.user_id
union
select cl.id, cl.sieve_stack_id, stack.description as stack_name, cl.site_id, site.description as site_name, cl.timestamp, cl.user_id, concat(user.first_name, ' ', user.last_name) as name
from tl_qc_sieve_stacks stack 
join qc_stack_cleaning_log cl on cl.sieve_stack_id = stack.id and cl.site_id = stack.main_site_id
join main_sites site on site.id = cl.site_id
join main_users user on user.id = cl.user_id
union
select cl.id, cl.sieve_stack_id, stack.description as stack_name, cl.site_id, site.description as site_name, cl.timestamp, cl.user_id, concat(user.first_name, ' ', user.last_name) as name
from wt_qc_sieve_stacks stack 
join qc_stack_cleaning_log cl on cl.sieve_stack_id = stack.id and cl.site_id = stack.main_site_id
join main_sites site on site.id = cl.site_id
join main_users user on user.id = cl.user_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_CleanStackLogInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_CleanStackLogInsert`(IN p_sieve_stack_id int(11), IN p_site_id int(11), IN p_user_id int(11))
insert into qc_stack_cleaning_log
(
sieve_stack_id,
site_id,
timestamp,
user_id
)
values
(
p_sieve_stack_id,
p_site_id,
now(),
p_user_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_COAFileInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_qc_COAFileInsert`(
in p_site_id int(11),
in p_sample_id int(11),
in p_file_name varchar(64), 
in p_file_path varchar(129), 
in p_create_user_id int(11))
begin
insert into qc_coa 
(site_id, sample_id, file_name, file_path, create_date, create_user_id)
values
(p_site_id, p_sample_id, p_file_name, p_file_path, now(), p_create_user_id);
select LAST_INSERT_ID() as id;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_CurrentStartWeightsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_CurrentStartWeightsGet`(IN p_sieve_method_id int(11), p_site_id int(11))
select sam.id, sam.site_id, sam.sieve_method_id, sam.start_weights_raw from gb_qc_samples sam  join gb_qc_sieve_stacks s on s.id = sam.sieve_method_id where sieve_method_id = p_sieve_method_id and site_id = p_site_id
union
select sam.id, sam.site_id, sam.sieve_method_id, sam.start_weights_raw from tl_qc_samples sam  join tl_qc_sieve_stacks s on s.id = sam.sieve_method_id where sieve_method_id = p_sieve_method_id and site_id = p_site_id
union
select sam.id, sam.site_id, sam.sieve_method_id, sam.start_weights_raw from wt_qc_samples sam  join wt_qc_sieve_stacks s on s.id = sam.sieve_method_id where sieve_method_id = p_sieve_method_id and site_id = p_site_id
order by id desc limit 1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_GetSamplesInDateRange` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_GetSamplesInDateRange`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE void_status_code != 'V' AND
    date >= p_start_date AND
    date <= p_end_date
    ORDER BY id DESC
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_GetSamplesInDateRangeIncludeVoided` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_GetSamplesInDateRangeIncludeVoided`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT,
    IN  p_results_per_page INT
)
BEGIN
    SELECT * from gb_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_LabTechsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_LabTechsGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
		CONCAT(mu.first_name, ' ', mu.last_name) AS display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		rc.role_id,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu LEFT JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 3
AND mu.is_active = 1
ORDER BY first_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_locationsViewGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_locationsViewGet`()
(
	select * from qc_locationsView
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_OperatorsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_OperatorsGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
        mu.display_name,
        mu.email,
        mu.company,
        mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		mu.role_check,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu INNER JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_SampleByLocationMostRecentGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_SampleByLocationMostRecentGet`(
    IN  p_location INT
)
BEGIN
    SELECT * FROM gb_qc_samples 
    WHERE void_status_code != 'V' 
    AND location_id = p_location
    AND test_type_id != '1'
    AND test_type_id != '7'
    AND is_complete = 1 
    ORDER BY dt DESC 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_SamplersGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_SamplersGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
        mu.display_name,
        mu.email,
        mu.company,
        mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		mu.role_check,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu INNER JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 2;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_ScreensAllGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_ScreensAllGet`(IN p_id int(11), p_site_id int(11))
create temporary table qc_all_screens_temp_table
select * from gb_qc_sieves
where id = p_id and main_site_id = p_site_id
union
select * from tl_qc_sieves
where id = p_id and main_site_id = p_site_id
union
select * from wt_qc_sieves
where id = p_id and main_site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_SievesAllGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_SievesAllGet`(IN p_description varchar(64), p_site_id int(11))
begin
drop temporary table if exists qc_all_sieves_temp_table;
create temporary table qc_all_sieves_temp_table
select * from gb_qc_sieve_stacks
where description = p_description and main_site_id = p_site_id
union
select * from tl_qc_sieve_stacks
where description = p_description and main_site_id = p_site_id
union
select * from wt_qc_sieve_stacks
where description = p_description and main_site_id = p_site_id;
select id from qc_all_sieves_temp_table;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_SievesByIdAndSiteGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_SievesByIdAndSiteGet`(IN p_id int(11), p_site_id int(11))
select * from gb_qc_sieves
where sieve_stack_id = p_id and site_id = p_site_id

union
select * from tl_qc_sieves
where sieve_stack_id = p_id and site_id = p_site_id

union
select * from wt_qc_sieves
where sieve_stack_id = p_id and site_id = p_site_id
order by sort_order ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_SievesByIsActiveGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_SievesByIsActiveGet`()
SELECT `stack`.`id`              AS `id`,
       `stack`.`description`     AS `description`, 
       `stack`.`main_site_id`    AS `main_site_id`, 
       `stack`.`last_cleaned`    AS `last_cleaned`, 
       concat(users.first_name,' ', users.last_name) as last_cleaned_by,
       `stack`.`is_active`       AS `is_active`, 
       `stack`.`is_camsizer`     AS `is_camsizer`, 
       `stack`.`create_date`     AS `create_date`, 
              concat(users1.first_name,' ', users1.last_name)  AS `create_user`,  
       `stack`.`modify_date`     AS `modify_date`, 
              concat(users2.first_name,' ', users2.last_name)  AS `modify_user`, 
       `site`.`description`      AS `site`, 
       `stack`.`sort_order`      AS `sort_order` 
FROM   `gb_qc_sieve_stacks` `stack` 
JOIN   `main_sites` `site` ON     `site`.`id` = `stack`.`main_site_id`
left JOIN main_users users on users.id = stack.last_cleaned_by
left JOIN main_users users1 on users1.id = stack.create_user_id
left JOIN main_users users2 on users2.id = stack.modify_user_id
UNION 
SELECT `stack`.`id`              AS `id`, 
       `stack`.`description`     AS `description`, 
       `stack`.`main_site_id`    AS `main_site_id`, 
       `stack`.`last_cleaned`    AS `last_cleaned`, 
       concat(users.first_name,' ', users.last_name) as last_cleaned_by,
       `stack`.`is_active`       AS `is_active`, 
       `stack`.`is_camsizer`     AS `is_camsizer`, 
       `stack`.`create_date`     AS `create_date`, 
              concat(users1.first_name,' ', users1.last_name)  AS `create_user`, 
       `stack`.`modify_date`     AS `modify_date`, 
              concat(users2.first_name,' ', users2.last_name)  AS `modify_user`, 
       `site`.`description`      AS `site`, 
       `stack`.`sort_order`      AS `sort_order` 
FROM   `tl_qc_sieve_stacks` `stack` 
JOIN   `main_sites` `site` 
ON  
`site`.`id` = `stack`.`main_site_id`
left JOIN main_users users on users.id = stack.last_cleaned_by
left JOIN main_users users1 on users1.id = stack.create_user_id
left JOIN main_users users2 on users2.id = stack.modify_user_id
UNION 
SELECT `stack`.`id`              AS `id`, 
       `stack`.`description`     AS `description`, 
       `stack`.`main_site_id`    AS `main_site_id`, 
       `stack`.`last_cleaned`    AS `last_cleaned`, 

       concat(users.first_name,' ', users.last_name) as last_cleaned_by,
       `stack`.`is_active`       AS `is_active`, 
       `stack`.`is_camsizer`     AS `is_camsizer`, 
       `stack`.`create_date`     AS `create_date`, 
		concat(users1.first_name,' ', users1.last_name)  AS `create_user`, 
       `stack`.`modify_date`     AS `modify_date`, 
       concat(users2.first_name,' ', users2.last_name)  AS `modify_user`, 
       `site`.`description`      AS `site`, 
       `stack`.`sort_order`      AS `sort_order` 
FROM   (`wt_qc_sieve_stacks` `stack` 
JOIN   `main_sites` `site` 
ON    (( 
                     `site`.`id` = `stack`.`main_site_id`)))
left JOIN main_users users on users.id = stack.last_cleaned_by
left JOIN main_users users1 on users1.id = stack.create_user_id
left JOIN main_users users2 on users2.id = stack.modify_user_id; ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_qc_SieveStacksGetBySiteID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_qc_SieveStacksGetBySiteID`(
    IN  p_sieveStackSiteID int(11)
)
BEGIN
    SELECT * FROM gb_qc_sieve_stacks
    WHERE main_site_id = p_sieveStackSiteID
    AND is_active = 1
    ORDER BY sort_order ASC; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_safety_ResetSafeDays` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_safety_ResetSafeDays`(IN col VARCHAR(20), IN p_date DATE)
BEGIN
	CASE 
		WHEN col = 'gb_date' THEN UPDATE main_safe_days SET gb_date = p_date where id = 1;
		WHEN col = '58_date' THEN UPDATE main_safe_days SET 58_date = p_date where id = 1;
		WHEN col = 'tl_date' THEN UPDATE main_safe_days SET tl_date = p_date where id = 1;
		WHEN col = 'wt_date' THEN UPDATE main_safe_days SET wt_date = p_date where id = 1;
	END CASE;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_safety_SafeDaysGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_safety_SafeDaysGet`()
BEGIN
SELECT 
id, gb_date, tl_date, wt_date, 58_date from main_safe_days;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_SiteNameByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_SiteNameByIdGet`(in p_id int(11))
select description from main_sites where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_TestDepartments` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_TestDepartments`()
BEGIN

  SELECT


      id,
      name,
      description

  FROM main_departments
  ORDER BY id DESC;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_10MinuteDailyTotal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_10MinuteDailyTotal`(p_tag_id int(11), p_date datetime)
BEGIN
SELECT sum(value) FROM tl_plc_TS_10minute
WHERE tag_id = p_tag_id AND cast(timestamp as date) = p_date
AND
(cast(timestamp as Time) between '05:20:00' and '05:29:59' OR cast(timestamp as Time) between '17:20:00' and '17:29:59');
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_10MinuteMaxGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_10MinuteMaxGet`()
BEGIN
SELECT MAX(Id)
FROM tl_plc_TS_10minute;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_10minuteMaxIdByTagGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_10minuteMaxIdByTagGet`(IN p_tag_id int(11))
(
SELECT * FROM (SELECT max(id) AS 'Current ID', value AS 'Current Value', tag_id, quality from tl_plc_TS_10minute t1 WHERE tag_id = p_tag_id AND quality = 192 GROUP BY id DESC LIMIT 1) q1
JOIN 
(SELECT max(id) AS 'Previous ID', value AS 'Previous Value', tag_id, quality from tl_plc_TS_10minute t2 WHERE tag_id = p_tag_id AND quality = 192 GROUP BY id DESC LIMIT 1 OFFSET 1 ) q2
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_10minuteMonthSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_10minuteMonthSumGet`(IN p_tag_id int(11), IN p_date datetime)
SELECT sum(value) FROM tl_plc_TS_10minute
WHERE tag_id = p_tag_id AND cast(timestamp as date) BETWEEN p_date AND LAST_DAY(p_date)
AND
CASE WHEN (cast(timestamp as Time) between '05:20:00' and '05:29:59' 
OR cast(timestamp as Time) between '17:20:00' and '17:39:59') = 0 THEN (cast(timestamp as Time) between '05:10:00' and '05:19:59'
OR cast(timestamp as Time) between '17:10:00' and '17:19:59') END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_10MinuteRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_10MinuteRecordInsert`(
	IN p_id int,
    IN p_timestamp datetime,
    IN p_tag_id int(11),
    IN p_value float,
    IN p_quality int
)
BEGIN
INSERT INTO tl_plc_TS_10minute 
(
	id,
	timestamp, 
	tag_id,
	value,
	quality
)
VALUES 
(
	p_id,
    p_timestamp,
    p_tag_id,
    p_value,
    p_quality
);
 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_10MinuteRecordsAverageGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_10MinuteRecordsAverageGet`(IN p_tag_id int(11))
(
SELECT avg(value) as 'AvgValue' from tl_plc_TS_10minute 
WHERE tag_id = p_tag_id
AND quality = 192
AND
CASE WHEN (cast(timestamp as Time) between '05:50:00' and '05:59:59' 
OR cast(timestamp as Time) between '17:50:00' and '17:59:59') = 0 THEN (cast(timestamp as Time) between '05:40:00' and '05:49:59'
OR cast(timestamp as Time) between '17:40:00' and '17:49:59') END
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_10MinuteRecordsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_10MinuteRecordsGet`(IN p_tag_id int(11), IN p_start date, IN p_end date)
(
SELECT avg(value) as 'AvgValue' from tl_plc_TS_10minute 
where tag_id = p_tag_id
AND timestamp between p_start AND p_end
AND quality = 192
AND 
CASE WHEN (cast(timestamp as Time) between '05:50:00' and '05:59:59' 
OR cast(timestamp as Time) between '17:50:00' and '17:59:59') = 0 THEN (cast(timestamp as Time) between '05:40:00' and '05:49:59'
OR cast(timestamp as Time) between '17:40:00' and '17:49:59') END
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_10MinuteSumGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_10MinuteSumGet`(IN p_tag_id int(11), IN p_start date, IN p_end date)
(
SELECT SUM(value) AS 'SumValue' FROM tl_plc_TS_10minute 
WHERE tag_id = p_tag_id
AND timestamp BETWEEN p_start AND p_end
AND quality = 192
AND 
CASE WHEN (cast(timestamp as Time) BETWEEN '05:20:00' AND '05:29:59' 
OR CAST(timestamp as Time) BETWEEN '17:20:00' AND '17:29:59') = 0 THEN (CAST(timestamp as Time) BETWEEN '05:10:00' AND '05:19:59'
OR CAST(timestamp as Time) BETWEEN '17:10:00' AND '17:19:59') END
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_MoistureDayAvgGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_MoistureDayAvgGet`(IN p_location_id int(11), IN p_date datetime)
SELECT avg(moisture_rate) FROM tl_qc_samples
WHERE location_id = p_location_id AND date = p_date AND moisture_rate != 0 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_PlantThresholdsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_PlantThresholdsInsert`(
	IN p_tag_id int(11),
	IN p_user_id int(11),
	IN p_threshold int(11),
	IN p_gauge_max int(11),
    IN p_gauge_action_limit int(11),
    IN p_gauge_warning_limit int(11),
	IN p_send_alert int(1)
)
INSERT INTO tl_plc_plant_thresholds 
(
    tag_id,
    user_id,
    threshold,
	gauge_max,
    gauge_action_limit,
    gauge_warning_limit,
    send_alert,
    create_date,
    create_user_id,
    is_active
)
VALUES
(
    p_tag_id,
    p_user_id,
    p_threshold,
	p_gauge_max,
    p_gauge_action_limit,
    p_gauge_warning_limit,
    p_send_alert,
    now(),
    p_user_id,
	1
)
ON DUPLICATE KEY UPDATE
	threshold = p_threshold,
	gauge_max = p_gauge_max,
    gauge_action_limit = p_gauge_action_limit,
    gauge_warning_limit = p_gauge_warning_limit,
	send_alert = p_send_alert,
	modify_date = now(),
	modify_user_id = p_user_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_PlantThresholdsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_PlantThresholdsUpdate`(
	IN p_id int(11),
	IN p_user_id int(11),
	IN p_threshold int(11),
    IN p_gauge_max int(11),
    IN p_gauge_action_limit int(11),
    IN p_gauge_warning_limit int(11),
	IN p_send_alert int(1)
)
BEGIN
UPDATE tl_plc_plant_thresholds
SET
	threshold = p_threshold,
    gauge_max = p_gauge_max,
    gauge_action_limit = p_gauge_action_limit,
    gauge_warning_limit = p_gauge_warning_limit,
	send_alert = p_send_alert,
	modify_date = now(),
	modify_user_id = p_user_id
WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_rainfallGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_rainfallGet`()
BEGIN
	SELECT date, rainfall, high_temp, low_temp, wind from tl_plc_rainfall;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_RainfallInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_RainfallInsert`(
	IN p_date datetime,
    IN p_rainfall decimal(5,2),
    IN p_wind decimal(5,2),
    IN p_high_temp int,
    IN p_low_temp int
)
INSERT INTO tl_plc_rainfall
(
	date,
    rainfall,
    wind,
    high_temp,
    low_temp
)
VALUES
(
	p_date,
    p_rainfall,
    p_wind,
    p_high_temp,
    p_low_temp
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_RainfallMaxDateGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_RainfallMaxDateGet`()
(
	SELECT max(date) FROM tl_plc_rainfall
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_RainfallSummaryGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_RainfallSummaryGet`()
(
SELECT 
	month(date) as 'Month',
    year(date) as 'Year',
    sum(rainfall) as 'Rainfall',
    round(avg(wind), 2) as 'wind',
    round(avg(high_temp), 2) as 'avg_high_temp',
    round(avg(low_temp), 2) as 'avg_low_temp',
	concat(year(date), '-', concat(month(date)), '-', (01), ' ', '00:00:00') as date_data
FROM
	tl_plc_rainfall
GROUP BY date_data, month(date), year(date)
ORDER BY year(date) ,month(date)
limit 12
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_SamplesByLocationGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_SamplesByLocationGet`(IN p_start date, IN p_end date, IN p_location_id int)
(
SELECT 
	AVG(s.moisture_rate), 
	AVG(s.plus_70),
	AVG(s.minus_40_plus_70),
	AVG(s.minus_70), 
	AVG(s.minus_70_plus_140), 
	AVG(s.plus_140), 
	AVG(s.minus_140)
FROM 
	tl_qc_samples s
WHERE 
	date BETWEEN p_start AND p_end
    AND
    location_id = p_location_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_SamplesOverallAvgGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_SamplesOverallAvgGet`(IN p_location int(11))
(
SELECT 
	AVG(moisture_rate), 
  AVG(plus_70),
	AVG(minus_40_plus_70),
	AVG(minus_70), 
	AVG(minus_70_plus_140), 
	AVG(plus_140), 
	AVG(minus_140)
FROM 
	tl_qc_samples
WHERE 
  location_id = p_location
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_ScorecardSettingInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_ScorecardSettingInsert`(
	IN p_date date,   
	IN p_output_setting int(11),
    IN p_net_setting int(11), 
	IN p_gross_setting int(11),
    IN p_user_id INT(11)
	
)
BEGIN
INSERT INTO tl_plc_scorecard_settings
(
`date`,
`net_setting`,
`output_setting`,
`gross_setting`,
`create_user_id`,
`create_date`
)

VALUES
(
p_date,
p_net_setting,
p_output_setting,
p_gross_setting,
p_user_id,
now()
)

ON DUPLICATE KEY UPDATE 
 

    net_setting = p_net_setting, 
    output_setting = p_output_setting, 
    gross_setting = p_gross_setting, 
    modify_user_id = p_user_id, 
    modify_date = now() ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_ScorecardSettingsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_ScorecardSettingsGet`(
	IN p_user_id INT (11),
    IN p_date DATE
)
BEGIN

SELECT net_setting, output_setting, gross_setting from tl_plc_scorecard_settings
WHERE date = p_date AND create_user_id = p_user_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_ShiftInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_ShiftInsert`(
IN p_id int(11),
IN p_prod_area_id int(3),
IN p_is_day tinyint(1), 
IN p_start_dt datetime, 
IN p_end_dt datetime,
IN p_operator varchar(64),
IN p_duration_minutes int(5),
IN p_duration decimal(10,4), 
IN p_uptime decimal(10,2),
IN p_downtime decimal(10,4), 
IN p_idletime decimal(10,4)
)
begin
SET foreign_key_checks= 0;

INSERT INTO tl_plc_shifts
(
id,
prod_area_id,
plant_id,  
is_day,  
start_dt, 
end_dt, 
operator,
duration_minutes,
duration,
uptime,
downtime,
idletime 
)
VALUES
(
p_id,
p_prod_area_id,  
0,    
p_is_day,  
p_start_dt, 
p_end_dt, 
p_operator,
p_duration_minutes,
p_duration,
p_uptime,
p_downtime,
p_idletime  
);

SET foreign_key_checks= 1;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_ShiftsMaxIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_ShiftsMaxIdGet`()
SELECT MAX(id) As maxId
FROM tl_plc_shifts ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_ShiftSummaryByDateGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_ShiftSummaryByDateGet`(IN p_prod_area_id int, IN p_start_dt datetime, IN p_end_dt datetime)
(
SELECT prod_area_id, sum(duration_minutes) AS 'duration_minutes', sum(uptime) AS 'uptime', sum(downtime) AS 'downtime', sum(idletime) AS 'idletime'
FROM tl_plc_shifts
WHERE prod_area_id = p_prod_area_id AND start_dt > p_start_dt AND end_dt < p_end_dt

) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_ShiftTimesDayGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_ShiftTimesDayGet`(IN p_prod_area_id int, IN p_start_time datetime, IN p_end_time datetime)
(
SELECT 
    SUM(duration_minutes) AS 'duration_minutes',
    SUM(uptime) AS 'uptime',
    SUM(downtime) AS 'downtime',
    SUM(idletime) AS 'idletime'
FROM
    tl_plc_shifts
WHERE
     prod_area_id = p_prod_area_id and start_dt BETWEEN p_start_time AND p_end_time
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_TagAutomatedInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_TagAutomatedInsert`(
    p_tag varchar(50),
    p_address varchar(50),
    p_ehouse varchar(50)
)
BEGIN
	INSERT INTO `silicore_site`.`tl_plc_tags`
		(
    `ui_label`,
		`classification`,
    `ehouse`,
		`tag`,
		`address`,
		`units`,
		`plant_id`,
    `create_user_id`,
    `create_date`
     )
	VALUES
		(
    'Needs Definition',
		'Needs Definition',
    p_ehouse,
		p_tag,
		p_address,
		'ND',
		31,
    25,
    now()
    );
    SELECT id FROM tl_plc_tags 
    WHERE tag like p_tag
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_TagByIdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_TagByIdGet`(IN p_id int(11))
(
select ui_label, tag, address
from tl_plc_tags
where id = p_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_TagIdByNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_TagIdByNameGet`(
	p_address varchar(50)
)
BEGIN
	SELECT id FROM tl_plc_tags
  WHERE address like p_address;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_TagInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_TagInsert`(
	  p_ui_label varchar(50),
    p_classification varchar(50),
    p_ehouse varchar(4),
    p_tag varchar(50),
    p_address varchar(50),
    p_units varchar(50),
    p_plant_id int(11),
    p_user_id int(11)
)
BEGIN
	INSERT INTO `silicore_site`.`tl_plc_analog_tags`
		(
    `ui_label`,
		`classification`,
    `ehouse`,
		`tag`,
		`address`,
		`units`,
		`plant_id`,
    `create_user_id`,
    `create_date`
        )
	VALUES
		(
    p_ui_label,
		p_classification,
        p_ehouse,
		p_tag,
		p_address,
		p_units,
		p_plant_id,
    p_user_id,
    now()
        )
    ON DUPLICATE KEY UPDATE
		ui_label = p_ui_label,
		classification = p_classification,
    ehouse = p_ehouse,
		tag = p_tag,
		address = p_address,
		units = p_units,
		plant_id = p_plant_id,
		modify_date = now(),
    modify_user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_TagsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_TagsGet`()
BEGIN
SELECT 
	id,
  ui_label,
  classification,
  tag,
  address,
  units
FROM 
	tl_plc_tags
WHERE is_active = 1 AND is_kpi = 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_plc_UserThresholdGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_plc_UserThresholdGet`(IN p_tag_id int(11), IN p_user_id int(11))
(
SELECT
	id,
	threshold,
    gauge_max,
    gauge_action_limit,
    gauge_warning_limit,
  send_alert
FROM
	tl_plc_plant_thresholds
WHERE
	tag_id = p_tag_id AND user_id = p_user_id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_CleanSieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_CleanSieveStackUpdate`(IN p_id int(11), IN p_site_id INT(11), IN p_user_id int(11))
update tl_qc_sieve_stacks
set last_cleaned = now(),
 last_cleaned_by = p_user_id
where id = p_id AND main_site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_CompletedSamplesInDateRangeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_CompletedSamplesInDateRangeGet`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE void_status_code != 'V' 
    AND date >= p_start_date
    AND date <= p_end_date
    AND is_complete = '1'
    ORDER BY date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_CompletedSamplesInDateRangeGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_CompletedSamplesInDateRangeGetByLabTech`(
    IN  p_lab_tech_id VARCHAR(32),
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE void_status_code != 'V' 
    AND lab_tech = p_lab_tech_id
    AND date >= p_start_date
    AND date <= p_end_date
    AND is_complete = '1'
    ORDER BY date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_CompositeTypeGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_CompositeTypeGetByID`(
    IN  p_compositeTypeId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_composites
    WHERE id = p_compositeTypeId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_CompositeTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_CompositeTypesGet`()
BEGIN
    SELECT * from tl_qc_composites;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_DateRangePercentAveragesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_DateRangePercentAveragesGet`(
    IN p_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT tl_qc_samples.id, DATE_FORMAT(tl_qc_samples.date, '%Y-%m-%d') as 'date', tl_qc_finalpercentages.finalpercent1, tl_qc_finalpercentages.finalpercent2, tl_qc_finalpercentages.finalpercent3, tl_qc_finalpercentages.finalpercent4, tl_qc_finalpercentages.finalpercent5, tl_qc_finalpercentages.finalpercent6, tl_qc_finalpercentages.finalpercent7, tl_qc_finalpercentages.finalpercent8, tl_qc_finalpercentages.finalpercent9, tl_qc_finalpercentages.finalpercent10, tl_qc_finalpercentages.finalpercent11, tl_qc_finalpercentages.finalpercent12, tl_qc_finalpercentages.finalpercent13, tl_qc_finalpercentages.finalpercent14, tl_qc_finalpercentages.finalpercent15, tl_qc_finalpercentages.finalpercent16, tl_qc_finalpercentages.finalpercent17, tl_qc_finalpercentages.finalpercent18, tl_qc_samples.plus_70, tl_qc_samples.minus_40_plus_70, tl_qc_samples.minus_70, tl_qc_samples.minus_70_plus_140, tl_qc_samples.plus_140, tl_qc_samples.minus_140
    FROM tl_qc_samples
    LEFT JOIN tl_qc_finalpercentages ON tl_qc_samples.id = tl_qc_finalpercentages.sample_id
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND location_id = p_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_DateRangePercentSamplesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_tl_qc_DateRangePercentSamplesGet`(
    IN p_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT tl_qc_samples.id, DATE_FORMAT(tl_qc_samples.date, '%Y-%m-%d') as 'date',tl_qc_samples.sieve_1_value,tl_qc_samples.sieve_2_value,tl_qc_samples.sieve_3_value,tl_qc_samples.sieve_4_value,tl_qc_samples.sieve_5_value,tl_qc_samples.sieve_6_value,tl_qc_samples.sieve_7_value,tl_qc_samples.sieve_8_value,tl_qc_samples.sieve_9_value,tl_qc_samples.sieve_10_value,tl_qc_samples.sieve_11_value,tl_qc_samples.sieve_12_value,tl_qc_samples.sieve_13_value,tl_qc_samples.sieve_14_value,tl_qc_samples.sieve_15_value,tl_qc_samples.sieve_16_value,tl_qc_samples.sieve_17_value,tl_qc_samples.sieve_18_value, tl_qc_samples.plus_70, tl_qc_samples.plus_50, tl_qc_samples.plus_40, tl_qc_samples.minus_40_plus_70, tl_qc_samples.minus_70, tl_qc_samples.minus_70_plus_140, tl_qc_samples.plus_140, tl_qc_samples.minus_140, 
    oversize_percent, minus_140_plus_325, minus_60_plus_70,
    near_size, minus_50_plus_140
    FROM tl_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND location_id = p_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_DateRangePercentSamplesGetBySpecificLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_DateRangePercentSamplesGetBySpecificLocation`(
    IN p_specific_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT tl_qc_samples.id, DATE_FORMAT(tl_qc_samples.date, '%Y-%m-%d') as 'date',tl_qc_samples.sieve_1_value,tl_qc_samples.sieve_2_value,tl_qc_samples.sieve_3_value,tl_qc_samples.sieve_4_value,tl_qc_samples.sieve_5_value,tl_qc_samples.sieve_6_value,tl_qc_samples.sieve_7_value,tl_qc_samples.sieve_8_value,tl_qc_samples.sieve_9_value,tl_qc_samples.sieve_10_value,tl_qc_samples.sieve_11_value,tl_qc_samples.sieve_12_value,tl_qc_samples.sieve_13_value,tl_qc_samples.sieve_14_value,tl_qc_samples.sieve_15_value,tl_qc_samples.sieve_16_value,tl_qc_samples.sieve_17_value,tl_qc_samples.sieve_18_value, tl_qc_samples.plus_70, tl_qc_samples.minus_40_plus_70, tl_qc_samples.minus_70, tl_qc_samples.minus_70_plus_140, tl_qc_samples.plus_140, tl_qc_samples.minus_140
    FROM tl_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND specific_location_id = p_specific_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_FinalPercentagesGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_FinalPercentagesGetByID`(
    IN p_sample_id INT(11)
)
BEGIN
    SELECT * 
    FROM tl_qc_finalpercentages 
    WHERE sample_id = p_sample_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_FinalPercentagesInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_FinalPercentagesInsert`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_FinalPercentagesUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_FinalPercentagesUpdate`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_InsertSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_InsertSample`(
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
    IN  p_shift VARCHAR(5)
)
BEGIN
INSERT INTO tl_qc_samples
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_KPIPLCTagsGetByPlantID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_KPIPLCTagsGetByPlantID`(
    IN p_plant_id INT(11)
)
BEGIN
    SELECT * FROM prod_auto_plant_analog_tags
    WHERE is_kpi = 1
    AND is_mir = 1
    AND is_hidden = 0
    AND is_removed = 0
    AND plant_id = p_plant_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_KValueRecordGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_KValueRecordGet`(
    IN  p_sample_id INT(11),
    IN  p_k_value_id INT(11),
    IN  p_description VARCHAR(50)
)
BEGIN
    SELECT * FROM tl_qc_k_value_records 
    WHERE sample_id = p_sample_id
    AND k_value_id = p_k_value_id
    AND description = p_description
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_KValueRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_KValueRecordInsert`(
    IN p_sample_id INT(11),
    IN p_k_value_id INT(11),
    IN p_description VARCHAR(50),
    IN p_value DOUBLE
)
BEGIN
    INSERT INTO tl_qc_k_value_records 
    (
        sample_id,
        k_value_id, 
        description, 
        value
    ) 
    VALUES 
    (
        p_sample_id, 
        p_k_value_id, 
        p_description, 
        p_value
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_KValueRecordUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_KValueRecordUpdate`(
    IN p_value DOUBLE,
    IN p_id INT(11),
    IN p_k_value_id INT(11),
    IN p_description VARCHAR(50) 
)
BEGIN
    UPDATE tl_qc_k_value_records 
    SET `value` = p_value 
    WHERE `sample_id` = p_id
    AND `k_value_id` = p_k_value_id
    AND `description` = p_description;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_KValuesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_KValuesGet`()
BEGIN
    SELECT * from tl_qc_k_values;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationDetailsByNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationDetailsByNameGet`()
(
select
	locd.id, locd.qc_location_id AS 'location_id', loc.description AS 'location', locd.description AS 'specific_location', locd.sort_order, locd.is_active
from
	tl_qc_locations_details locd
join
	tl_qc_locations loc ON locd.qc_location_id = loc.id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationDetailsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationDetailsInsert`(IN p_qc_location_id int, IN p_description varchar(255), IN p_create_user_id int)
begin
set @sort = (select max(sort_order)+10 from tl_qc_locations_details);
insert into tl_qc_locations_details
(
qc_location_id,
description,
sort_order,
create_date,
create_user_id
)
values
(
p_qc_location_id,
p_description,
@sort,
now(),
p_create_user_id
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationDetailsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationDetailsUpdate`(IN p_id int, IN p_qc_location_id int, IN p_description varchar(255), IN p_sort_order int, IN p_is_active tinyint(1), IN p_modify_user_id int)
update tl_qc_locations_details
set
qc_location_id = p_qc_location_id,
description = p_description,
sort_order = p_sort_order,
modify_date = now(),
is_active = p_is_active,
modify_user_id = p_modify_user_id
where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationGetByID`(
    IN  p_locationId INT(11)
)
BEGIN
SELECT * FROM tl_qc_locations
    WHERE id = p_locationId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationInsert`(
IN p_description varchar(255), 
IN p_main_site_id int(11), 
IN p_main_plant_id int(11),
IN p_is_split_sample_only tinyint(1),
IN p_create_user_id int(11)
)
BEGIN
set @sort = (select max(sort_order)+10 from tl_qc_locations);
insert into tl_qc_locations 
(
description, 
main_site_id, 
main_plant_id,
is_split_sample_only,
sort_order,
create_date,
create_user_id
)
values 
(
p_description, 
p_main_site_id, 
p_main_plant_id,
p_is_split_sample_only,
@sort,
now(),
p_create_user_id
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationsDelete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationsDelete`(IN P_id INT(11))
BEGIN
DELETE FROM tl_qc_locations WHERE id = p_id LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationsGet`()
BEGIN
    SELECT * from tl_qc_locations 
    WHERE is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationsGetByPlant` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationsGetByPlant`(
    IN  p_main_plant_id INT(11)
)
BEGIN
    SELECT * FROM tl_qc_locations 
    WHERE is_active = 1 
    AND main_plant_id = p_main_plant_id
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationsNamesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationsNamesGet`()
SELECT 
    l.id,
    l.sort_order,
    s.id as 'site_id',
    s.description as 'site',
    p.id as 'plant_id',
    p.name,
    l.description as 'description',
    l.is_split_sample_only,
    l.is_active
FROM
    tl_qc_locations l
JOIN 
	main_sites s on s.id = l.main_site_id
JOIN
	main_plants p on p.id = l.main_plant_id
ORDER BY l.sort_order desc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_LocationsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationsUpdate`(
IN p_id int(11),
IN p_description varchar(256),
IN p_main_site_id int(11), 
IN p_main_plant_id int(11),
IN p_is_split_sample_only tinyint(1),
IN p_sort_order int(11),
IN p_is_active tinyint(1),
IN p_modify_user_id int(11)
)
UPDATE tl_qc_locations
SET
id = p_id,
description = p_description,
main_site_id = p_main_site_id,
main_plant_id = p_main_plant_id,
is_split_sample_only = p_is_split_sample_only,
sort_order = p_sort_order,
is_active = p_is_active,
modify_date = now(),
modify_user_id = p_modify_user_id
WHERE 
id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_MaxFinalPercentageIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_MaxFinalPercentageIDGet`(
    
)
BEGIN
    SELECT MAX(id) 
    FROM tl_qc_finalpercentages 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_MaxRepeatabilityPairIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_MaxRepeatabilityPairIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM tl_qc_repeatability_pairs
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_MaxRepeatabilityUserIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_MaxRepeatabilityUserIDGet`(
    
)
BEGIN
    SELECT MAX(id) 
    FROM tl_qc_user_repeatability
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_MaxSampleIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_MaxSampleIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM tl_qc_samples 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_MaxSieveStackIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_MaxSieveStackIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM tl_qc_sieve_stacks
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_MostRecentSampleBySpecificLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_MostRecentSampleBySpecificLocation`(
    IN  p_specific_location_id int(11)
)
BEGIN
SELECT * FROM tl_qc_samples 
    WHERE void_status_code != 'V' 
    AND test_type_id != '7'
    AND specific_location_id = p_specific_location_id
    AND is_complete = 1 
    ORDER BY id DESC 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_OperatorsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_OperatorsGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
		CONCAT(mu.first_name, ' ', mu.last_name) AS display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		rc.role_id,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu LEFT JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 1
AND mu.is_active = 1
ORDER BY first_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_PerformanceCyclesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PerformanceCyclesGet`(
    IN p_plant_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT lab_tech, 
        sum(case when test_type_id = 1 then 1 else 0 end) as test_type_1_count, 
        sum(case when test_type_id = 2 then 1 else 0 end) as test_type_2_count, 
        sum(case when test_type_id = 3 then 1 else 0 end) as test_type_3_count, 
        sum(case when test_type_id = 4 then 1 else 0 end) as test_type_4_count, 
        sum(case when test_type_id = 5 then 1 else 0 end) as test_type_5_count, 
        sum(case when test_type_id = 6 then 1 else 0 end) as test_type_6_count, 
        sum(case when test_type_id = 7 then 1 else 0 end) as test_type_7_count, 
        avg(duration) as duration 
    FROM tl_qc_samples 
    WHERE dt >= p_start_date 
        AND dt <= p_end_date 
        AND plant_id = p_plant_id 
        AND lab_tech != '' 
        GROUP by lab_tech;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_PerformanceCyclesGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PerformanceCyclesGetByLabTech`(
    IN p_plant_id INT(11),
    IN p_lab_tech INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT lab_tech, 
        sum(case when test_type_id = 1 then 1 else 0 end) as test_type_1_count, 
        sum(case when test_type_id = 2 then 1 else 0 end) as test_type_2_count, 
        sum(case when test_type_id = 3 then 1 else 0 end) as test_type_3_count, 
        sum(case when test_type_id = 4 then 1 else 0 end) as test_type_4_count, 
        sum(case when test_type_id = 5 then 1 else 0 end) as test_type_5_count, 
        sum(case when test_type_id = 6 then 1 else 0 end) as test_type_6_count,   
        sum(case when test_type_id = 7 then 1 else 0 end) as test_type_7_count,
        avg(duration) as duration 
    FROM tl_qc_samples 
    WHERE dt >= p_start_date 
        AND dt <= p_end_date 
        AND plant_id = p_plant_id 
        AND lab_tech = p_lab_tech 
        GROUP by lab_tech;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_PlantSettingsDataByTagAndSampleIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PlantSettingsDataByTagAndSampleIDGet`(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11)
)
BEGIN
    SELECT tl_plant_mir_data.id, tl_plant_mir_data.sample_id, tl_plant_mir_data.tag_id, tl_plant_mir_data.value, tl_auto_plant_analog_tags.device 
    FROM tl_plant_mir_data 
    LEFT JOIN tl_auto_plant_analog_tags ON tl_plant_mir_data.tag_id = tl_auto_plant_analog_tags.id 
    WHERE tl_plant_mir_data.sample_id = p_sample_id 
    AND tl_plant_mir_data.tag_id = p_tag_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_PlantSettingsRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PlantSettingsRecordInsert`(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11),
    IN p_value DECIMAL(16,4)
)
BEGIN
    INSERT INTO tl_plant_settings_data 
    (
        sample_id, 
        tag_id, 
        value
    ) 
    VALUES 
    (
        p_sample_id, 
        p_tag_id, 
        p_value
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_PlantSettingsRecordUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PlantSettingsRecordUpdate`(
    IN p_value DECIMAL(16,4),
    IN p_id INT(11)
)
BEGIN
    UPDATE tl_plant_settings_data 
    SET `value` = p_value
    WHERE `id` = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_PlantsGetBySite` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PlantsGetBySite`(
    IN  p_main_site_id INT(11)
)
BEGIN
    SELECT * FROM main_plants 
    WHERE is_active = 1 
    AND main_site_id = p_main_site_id
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_PLCTagsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PLCTagsGet`(

)
BEGIN
    SELECT * FROM tl_auto_plant_analog_tags WHERE is_mir = 1 AND is_hidden = 0 AND is_removed = 0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_PLCTagsGetByPlantID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_PLCTagsGetByPlantID`(
    IN p_plant_id INT(11)
)
BEGIN
    SELECT * FROM tl_auto_plant_analog_tags 
    WHERE is_mir = 1 
    AND is_hidden = 0 
    AND is_removed = 0 
    AND plant_id = p_plant_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_QCThresholdsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_QCThresholdsGet`(
    IN  p_location_id INT(11),
    IN  p_screen VARCHAR(16)
)
BEGIN
    SELECT * FROM tl_qc_thresholds 
    WHERE location_id = p_location_id
        AND screen = p_screen;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_QCThresholdsGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_QCThresholdsGetAll`(
)
BEGIN
    SELECT * FROM tl_qc_thresholds
    WHERE is_active = 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabilityGetByUserID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilityGetByUserID`(
    IN p_user_id INT(11)
)
BEGIN

    SELECT * 
    FROM tl_qc_user_repeatability 
    WHERE user_id = p_user_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabilitySamplePairInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilitySamplePairInsert`(
    IN p_original_sample BIGINT(20),
    IN p_repeated_sample BIGINT(20),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO tl_qc_repeatability_pairs 
    (
        original_sample, 
        repeated_sample
    ) 
    VALUES 
    (
        p_original_sample, 
        p_repeated_sample
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabilitySamplePairsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilitySamplePairsGet`(
  IN p_start_date DATE, IN p_end_date DATE
)
BEGIN
SELECT
  pairs.id,
  pairs.original_sample,
  pairs.repeated_sample,
  original.date AS original_date,
  repeated.date AS repeated_date,
  original.lab_tech AS original_lab_tech,
  repeated.lab_tech AS repeated_lab_tech,
  original.location_id AS original_location_id,
  repeated.location_id AS repeated_location_id,
  original.sieve_method_id AS original_sieve_method_id,
  repeated.sieve_method_id AS repeated_sieve_method_id,
  original.sieve_1_desc AS original_sieve_1_desc,
  original.sieve_2_desc AS original_sieve_2_desc,
  original.sieve_3_desc AS original_sieve_3_desc,
  original.sieve_4_desc AS original_sieve_4_desc,
  original.sieve_5_desc AS original_sieve_5_desc,
  original.sieve_6_desc AS original_sieve_6_desc,
  original.sieve_7_desc AS original_sieve_7_desc,
  original.sieve_8_desc AS original_sieve_8_desc,
  original.sieve_9_desc AS original_sieve_9_desc,
  original.sieve_10_desc AS original_sieve_10_desc,
  original.sieve_1_value AS original_sieve_1_value,
  original.sieve_2_value AS original_sieve_2_value,
  original.sieve_3_value AS original_sieve_3_value,
  original.sieve_4_value AS original_sieve_4_value,
  original.sieve_5_value AS original_sieve_5_value,
  original.sieve_6_value AS original_sieve_6_value,
  original.sieve_7_value AS original_sieve_7_value,
  original.sieve_8_value AS original_sieve_8_value,
  original.sieve_9_value AS original_sieve_9_value,
  original.sieve_10_value AS original_sieve_10_value,
  original.plus_70 AS original_plus_70,
  original.plus_50 AS original_plus_50,
original.plus_40 AS original_plus_40,
  repeated.sieve_1_desc AS repeated_sieve_1_desc,
  repeated.sieve_2_desc AS repeated_sieve_2_desc,
  repeated.sieve_3_desc AS repeated_sieve_3_desc,
  repeated.sieve_4_desc AS repeated_sieve_4_desc,
  repeated.sieve_5_desc AS repeated_sieve_5_desc,
  repeated.sieve_6_desc AS repeated_sieve_6_desc,
  repeated.sieve_7_desc AS repeated_sieve_7_desc,
  repeated.sieve_8_desc AS repeated_sieve_8_desc,
  repeated.sieve_9_desc AS repeated_sieve_9_desc,
  repeated.sieve_10_desc AS repeated_sieve_10_desc,
  repeated.sieve_1_value AS repeated_sieve_1_value,
  repeated.sieve_2_value AS repeated_sieve_2_value,
  repeated.sieve_3_value AS repeated_sieve_3_value,
  repeated.sieve_4_value AS repeated_sieve_4_value,
  repeated.sieve_5_value AS repeated_sieve_5_value,
  repeated.sieve_6_value AS repeated_sieve_6_value,
  repeated.sieve_7_value AS repeated_sieve_7_value,
  repeated.sieve_8_value AS repeated_sieve_8_value,
  repeated.sieve_9_value AS repeated_sieve_9_value,
  repeated.sieve_10_value AS repeated_sieve_10_value,
  repeated.plus_70 AS repeated_plus_70,
  repeated.plus_50 AS repeated_plus_50,
  repeated.plus_40 AS repeated_plus_40,
  original.sieve_11_desc AS original_sieve_11_desc,
  original.sieve_12_desc AS original_sieve_12_desc,
  original.sieve_13_desc AS original_sieve_13_desc,
  original.sieve_14_desc AS original_sieve_14_desc,
  original.sieve_15_desc AS original_sieve_15_desc,
  original.sieve_16_desc AS original_sieve_16_desc,
  original.sieve_17_desc AS original_sieve_17_desc,
  original.sieve_18_desc AS original_sieve_18_desc,
  original.sieve_11_value AS original_sieve_11_value,
  original.sieve_12_value AS original_sieve_12_value,
  original.sieve_13_value AS original_sieve_13_value,
  original.sieve_14_value AS original_sieve_14_value,
  original.sieve_15_value AS original_sieve_15_value,
  original.sieve_16_value AS original_sieve_16_value,
  original.sieve_17_value AS original_sieve_17_value,
  original.sieve_18_value AS original_sieve_18_value,
  repeated.sieve_11_desc AS repeated_sieve_11_desc,
  repeated.sieve_12_desc AS repeated_sieve_12_desc,
  repeated.sieve_13_desc AS repeated_sieve_13_desc,
  repeated.sieve_14_desc AS repeated_sieve_14_desc,
  repeated.sieve_15_desc AS repeated_sieve_15_desc,
  repeated.sieve_16_desc AS repeated_sieve_16_desc,
  repeated.sieve_17_desc AS repeated_sieve_17_desc,
  repeated.sieve_18_desc AS repeated_sieve_18_desc,
  repeated.sieve_11_value AS repeated_sieve_11_value,
  repeated.sieve_12_value AS repeated_sieve_12_value,
  repeated.sieve_13_value AS repeated_sieve_13_value,
  repeated.sieve_14_value AS repeated_sieve_14_value,
  repeated.sieve_15_value AS repeated_sieve_15_value,
  repeated.sieve_16_value AS repeated_sieve_16_value,
  repeated.sieve_17_value AS repeated_sieve_17_value,
  repeated.sieve_18_value AS repeated_sieve_18_value
FROM
  tl_qc_repeatability_pairs AS pairs
  LEFT JOIN tl_qc_samples AS original ON pairs.original_sample = original.id
  LEFT JOIN tl_qc_samples AS repeated ON pairs.repeated_sample = repeated.id
WHERE
  original.date >= p_start_date
  AND original.date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabilitySamplePairsGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilitySamplePairsGetByLabTech`(
    IN p_start_date DATE,
    IN p_end_date DATE,
    IN p_lab_tech_id INT(11)
)
BEGIN

    SELECT pairs.id,
    pairs.original_sample,
    pairs.repeated_sample,
    original.date AS original_date,
    repeated.date,
    original.lab_tech AS original_lab_tech,
    repeated.lab_tech,
    original.location_id AS original_location_id,
    repeated.location_id,
    original.sieve_method_id AS original_sieve_method_id,
    repeated.sieve_method_id,
    original.sieve_1_desc AS original_sieve_1_desc,
    original.sieve_2_desc AS original_sieve_2_desc,
    original.sieve_3_desc AS original_sieve_3_desc,
    original.sieve_4_desc AS original_sieve_4_desc,
    original.sieve_5_desc AS original_sieve_5_desc,
    original.sieve_6_desc AS original_sieve_6_desc,
    original.sieve_7_desc AS original_sieve_7_desc,
    original.sieve_8_desc AS original_sieve_8_desc,
    original.sieve_9_desc AS original_sieve_9_desc,
    original.sieve_10_desc AS original_sieve_10_desc,
    original.sieve_11_desc AS original_sieve_11_desc,
    original.sieve_12_desc AS original_sieve_12_desc,
    original.sieve_13_desc AS original_sieve_13_desc,
    original.sieve_14_desc AS original_sieve_14_desc,
    original.sieve_15_desc AS original_sieve_15_desc,
    original.sieve_16_desc AS original_sieve_16_desc,
    original.sieve_17_desc AS original_sieve_17_desc,
    original.sieve_18_desc AS original_sieve_18_desc,
    original.sieve_1_value AS original_sieve_1_value,
    original.sieve_2_value AS original_sieve_2_value,
    original.sieve_3_value AS original_sieve_3_value,
    original.sieve_4_value AS original_sieve_4_value,
    original.sieve_5_value AS original_sieve_5_value,
    original.sieve_6_value AS original_sieve_6_value,
    original.sieve_7_value AS original_sieve_7_value,
    original.sieve_8_value AS original_sieve_8_value,
    original.sieve_9_value AS original_sieve_9_value,
    original.sieve_10_value AS original_sieve_10_value,
    original.sieve_11_value AS original_sieve_11_value,
    original.sieve_12_value AS original_sieve_12_value,
    original.sieve_13_value AS original_sieve_13_value,
    original.sieve_14_value AS original_sieve_14_value,
    original.sieve_15_value AS original_sieve_15_value,
    original.sieve_16_value AS original_sieve_16_value,
    original.sieve_17_value AS original_sieve_17_value,
    original.sieve_18_value AS original_sieve_18_value,
    original.plus_70 AS original_plus_70,
    original.plus_50 AS original_plus_50,
    original.plus_40 AS original_plus_40,
    repeated.sieve_1_desc AS repeated_sieve_1_desc,
    repeated.sieve_2_desc AS repeated_sieve_2_desc,
    repeated.sieve_3_desc AS repeated_sieve_3_desc,
    repeated.sieve_4_desc AS repeated_sieve_4_desc,
    repeated.sieve_5_desc AS repeated_sieve_5_desc,
    repeated.sieve_6_desc AS repeated_sieve_6_desc,
    repeated.sieve_7_desc AS repeated_sieve_7_desc,
    repeated.sieve_8_desc AS repeated_sieve_8_desc,
    repeated.sieve_9_desc AS repeated_sieve_9_desc,
    repeated.sieve_10_desc AS repeated_sieve_10_desc,
	repeated.sieve_1_desc AS repeated_sieve_11_desc,
    repeated.sieve_2_desc AS repeated_sieve_12_desc,
    repeated.sieve_3_desc AS repeated_sieve_13_desc,
    repeated.sieve_4_desc AS repeated_sieve_14_desc,
    repeated.sieve_5_desc AS repeated_sieve_15_desc,
    repeated.sieve_6_desc AS repeated_sieve_16_desc,
    repeated.sieve_7_desc AS repeated_sieve_17_desc,
    repeated.sieve_8_desc AS repeated_sieve_18_desc,
    repeated.sieve_1_value AS repeated_sieve_1_value,
    repeated.sieve_2_value AS repeated_sieve_2_value,
    repeated.sieve_3_value AS repeated_sieve_3_value,
    repeated.sieve_4_value AS repeated_sieve_4_value,
    repeated.sieve_5_value AS repeated_sieve_5_value,
    repeated.sieve_6_value AS repeated_sieve_6_value,
    repeated.sieve_7_value AS repeated_sieve_7_value,
    repeated.sieve_8_value AS repeated_sieve_8_value,
    repeated.sieve_9_value AS repeated_sieve_9_value,
    repeated.sieve_10_value AS repeated_sieve_10_value,
    repeated.sieve_11_value AS repeated_sieve_11_value,
    repeated.sieve_12_value AS repeated_sieve_12_value,
    repeated.sieve_13_value AS repeated_sieve_13_value,
    repeated.sieve_14_value AS repeated_sieve_14_value,
    repeated.sieve_15_value AS repeated_sieve_15_value,
    repeated.sieve_16_value AS repeated_sieve_16_value,
    repeated.sieve_17_value AS repeated_sieve_17_value,
    repeated.sieve_18_value AS repeated_sieve_18_value,
    repeated.plus_70 AS repeated_plus_70,
    repeated.plus_50 AS repeated_plus_50,
    repeated.plus_40 AS repeated_plus_40
    FROM wt_qc_repeatability_pairs AS pairs
    LEFT JOIN tl_qc_samples AS original ON pairs.original_sample = original.id
    LEFT JOIN tl_qc_samples AS repeated ON pairs.repeated_sample = repeated.id
    WHERE original.date >= p_start_date
    AND original.date <= p_end_date
    AND original.lab_tech = p_lab_tech_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabilitySamplePairsGetByOriginalSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilitySamplePairsGetByOriginalSample`(
    IN  p_original_sample_id INT(11)
)
BEGIN
    SELECT * FROM tl_qc_repeatability_pairs 
    WHERE original_sample = p_original_sample_id 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabilitySamplePairsGetByRepeatedSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilitySamplePairsGetByRepeatedSample`(
    IN  p_repeated_sample_id INT(11)
)
BEGIN
    SELECT * FROM tl_qc_repeatability_pairs 
    WHERE repeated_sample = p_repeated_sample_id 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabilityUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilityUpdate`(
    IN p_repeatability_value INT(11),
    IN p_user_id INT(11)
)
BEGIN

    UPDATE tl_qc_user_repeatability 
    SET repeatability_counter = p_repeatability_value 
    WHERE user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabilityUserInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilityUserInsert`(
    IN p_user_id INT(11),
    IN p_repeatability_counter INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO tl_qc_user_repeatability 
    (
        user_id, 
        repeatability_counter
    ) 
    VALUES 
    (
        p_user_id, 
        p_repeatability_counter
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RepeatabiltyUserInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabiltyUserInsert`(
    IN p_user_id INT(11),
    IN p_repeatability_counter INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO tl_qc_user_repeatability 
    (
        user_id, 
        repeatability_counter
    ) 
    VALUES 
    (
        p_user_id, 
        p_repeatability_counter
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RetireSieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RetireSieveStackUpdate`(IN p_id int(11), IN p_site_id INT(11), p_user_id int(11))
update tl_qc_sieve_stacks
set is_active = 0,
modify_date = now(),
modify_user_id = p_user_id
where id = p_id AND main_site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_RetireSieveUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RetireSieveUpdate`(IN p_id int(11), IN p_site_id INT(11), IN p_user_id int(11))
update tl_qc_sieves
set is_active = 0,
edit_date = now(),
sort_order = 0,
edit_user_id = p_user_id
where id = p_id AND site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleByLocationMostRecentGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleByLocationMostRecentGet`(
    IN  p_location INT
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE void_status_code != 'V' 
    AND location_id = p_location
    AND test_type_id != '1'
    AND test_type_id != '7'
    AND is_complete = 1 
    ORDER BY dt DESC 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleFinishDtCheck` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_tl_qc_SampleFinishDtCheck`(in p_id int(11))
select finish_dt from tl_qc_samples where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleFinishDtUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_tl_qc_SampleFinishDtUpdate`(in p_sample_id int(11))
update tl_qc_samples set finish_dt = now(), duration = round(TIMESTAMPDIFF(minute, dt, now())/60,2),  duration_minutes = round(TIMESTAMPDIFF(minute, dt, now()),2) where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleGetByID`(
    IN  p_sampleId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_samples
    WHERE id = p_sampleId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleGetByPlantAndDatetimeIncludeVoided` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleGetByPlantAndDatetimeIncludeVoided`(
    IN  p_plant_id INT(11),
    IN  p_date_id DATETIME
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE plant_id = p_plant_id
    AND dt = p_date_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleGroupGetBySample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleGroupGetBySample`(
    IN p_sample_id INT(11)
)
BEGIN
    SELECT * 
    FROM tl_qc_sample_groups 
    WHERE sample_id = p_sample_id 
    LIMIT 1;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleGroupInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleGroupInsert`(
  IN p_group_id INT(11),
  IN p_sample_id INT(11)
)
BEGIN
  INSERT INTO tl_qc_sample_groups 
    (group_id, sample_id) 
  VALUES 
    (p_group_id, p_sample_id);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleGroupMaxGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleGroupMaxGet`(
    
)
BEGIN
    SELECT MAX(group_id)
    FROM tl_qc_sample_groups 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleIDsGetByGroupID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleIDsGetByGroupID`(
    IN p_group_id INT(11)
)
BEGIN
    SELECT * 
    FROM tl_qc_sample_groups 
    WHERE group_id = p_group_id;    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleInsert`(

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
    IN  p_lab_Tech INT(11),
    IN  p_sampler INT(11),
    IN  p_operator INT(11),
    IN  p_shift VARCHAR(5),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO tl_qc_samples
    (
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleRepeatCheck` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_tl_qc_SampleRepeatCheck`(in p_sample_id int(11))
select s.is_repeat_process, s.is_repeat_labtech, concat(mu.first_name, ' ', mu.last_name) as lab_tech from tl_qc_samples s
join main_users mu on mu.id = s.is_repeat_labtech where s.is_repeat_process = 1 and s.id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SamplersGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplersGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
		CONCAT(mu.first_name, ' ', mu.last_name) AS display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		rc.role_id,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu LEFT JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 2
AND mu.is_active = 1
ORDER BY first_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SamplesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesGet`()
BEGIN
    SELECT * from tl_qc_samples;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SamplesGetByPlantAndDatetimeWhereNotComplete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesGetByPlantAndDatetimeWhereNotComplete`(
    IN  p_plant_id INT(11),
    IN  p_date_id DATETIME
)
BEGIN
    SELECT * FROM tl_qc_samples 
    WHERE plant_id = p_plant_id
    AND dt = p_date_id
    AND is_complete = 0
    AND void_status_code = 'A';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SamplesInDateRangeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesInDateRangeGet`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * from tl_qc_samples
    WHERE dt >= p_start_date AND
    dt <= p_end_date
    ORDER BY id DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SamplesInDateRangeGetFiltered` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesInDateRangeGetFiltered`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT(11),
    IN  p_results_per_page INT(11),
    IN  p_is_complete VARCHAR(64),
    IN  p_test_type_ids VARCHAR(64),
    IN  p_composite_type_ids VARCHAR(64),
    IN  p_min_time TIME,
    IN  p_max_time TIME,
    IN  p_lab_tech_ids VARCHAR(64),
    IN  p_sampler_ids VARCHAR(64),
    IN  p_operator_ids VARCHAR(64),
    IN  p_site_ids VARCHAR(64),
    IN  p_plant_ids VARCHAR(64),
    IN  p_sample_location_ids VARCHAR(64),
    IN  p_specific_location_ids VARCHAR(64),
    IN  p_void_status_codes VARCHAR(8)
)
BEGIN
    SELECT * from tl_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date AND
    ((p_is_complete = '') OR (is_complete = p_is_complete)) AND
    ((p_test_type_ids = '') OR (FIND_IN_SET(test_type_id, p_test_type_ids) <> 0)) AND
    ((p_composite_type_ids = '') OR (FIND_IN_SET(composite_type_id, p_composite_type_ids) <> 0)) AND
    ((time >= p_min_time AND time <= p_max_time)
    OR ((time >= p_min_time OR time <= p_max_time) AND p_min_time > p_max_time)) AND
    ((p_lab_tech_ids = '') OR (FIND_IN_SET(lab_tech, p_lab_tech_ids) <> 0)) AND
    ((p_sampler_ids = '') OR (FIND_IN_SET(sampler, p_sampler_ids) <> 0)) AND
    ((p_operator_ids = '') OR (FIND_IN_SET(operator, p_operator_ids) <> 0)) AND
    ((p_site_ids = '') OR (FIND_IN_SET(site_id, p_site_ids) <> 0)) AND
    ((p_plant_ids = '') OR (FIND_IN_SET(plant_id, p_plant_ids) <> 0)) AND
    ((p_sample_location_ids = '') OR (FIND_IN_SET(location_id, p_sample_location_ids) <> 0)) AND
    ((p_specific_location_ids = '') OR (FIND_IN_SET(specific_location_id, p_composite_type_ids) <> 0)) AND
    ((p_void_status_codes = '') OR (FIND_IN_SET(void_status_code, p_void_status_codes) <> 0))
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SamplesInDateRangeGetFilteredv2` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesInDateRangeGetFilteredv2`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT(11),
    IN  p_results_per_page INT(11),
    IN  p_is_complete VARCHAR(64),
    IN  p_test_type_ids VARCHAR(64),
    IN  p_composite_type_ids VARCHAR(64),
    IN  p_min_time TIME,
    IN  p_max_time TIME,
    IN  p_lab_tech_ids VARCHAR(64),
    IN  p_sampler_ids VARCHAR(64),
    IN  p_operator_ids VARCHAR(64),
    IN  p_site_ids VARCHAR(64),
    IN  p_plant_ids VARCHAR(64),
    IN  p_sample_location_ids VARCHAR(64),
    IN  p_specific_location_ids VARCHAR(64),
    IN  p_void_status_codes VARCHAR(8),
    IN  p_is_coa VARCHAR(1)
)
BEGIN
    SELECT * from tl_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date AND
    ((p_is_complete = '') OR (is_complete = p_is_complete)) AND
    ((p_test_type_ids = '') OR (FIND_IN_SET(test_type_id, p_test_type_ids) <> 0)) AND
    ((p_composite_type_ids = '') OR (FIND_IN_SET(composite_type_id, p_composite_type_ids) <> 0)) AND
    ((time >= p_min_time AND time <= p_max_time)
    OR ((time >= p_min_time OR time <= p_max_time) AND p_min_time > p_max_time)) AND
    ((p_lab_tech_ids = '') OR (FIND_IN_SET(lab_tech, p_lab_tech_ids) <> 0)) AND
    ((p_sampler_ids = '') OR (FIND_IN_SET(sampler, p_sampler_ids) <> 0)) AND
    ((p_operator_ids = '') OR (FIND_IN_SET(operator, p_operator_ids) <> 0)) AND
    ((p_site_ids = '') OR (FIND_IN_SET(site_id, p_site_ids) <> 0)) AND
    ((p_plant_ids = '') OR (FIND_IN_SET(plant_id, p_plant_ids) <> 0)) AND
    ((p_sample_location_ids = '') OR (FIND_IN_SET(location_id, p_sample_location_ids) <> 0)) AND
    ((p_specific_location_ids = '') OR (FIND_IN_SET(specific_location_id, p_composite_type_ids) <> 0)) AND
    ((p_void_status_codes = '') OR (FIND_IN_SET(void_status_code, p_void_status_codes) <> 0)) AND
    ((p_is_coa = '') OR (FIND_IN_SET(is_coa, p_is_coa) <> 0))
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SamplesInDateRangeGetIncludeVoided` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SamplesInDateRangeGetIncludeVoided`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT,
    IN  p_results_per_page INT
)
BEGIN
    SELECT * from tl_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_tl_qc_SampleUpdate`(
    IN p_id INT(11),
    IN p_edit_dt DATETIME,
    IN p_edit_user_id BIGINT(20), 
    IN p_site_id INT(11),
    IN p_plant_id INT(11),
    IN p_dt DATETIME,
    IN p_test_type_id INT(11),
    IN p_composite_type_id INT(11),
    IN p_sieve_method_id INT(11),
    IN p_location_id INT(11),
    IN p_specific_location_id INT(11),
    IN p_date DATE,
    IN p_time TIME,
    IN p_date_short BIGINT(8),
    IN p_dt_short BIGINT(11),
    IN p_oversize_percent DECIMAL(5, 4),
    IN p_oversize_weight DECIMAL(5, 1),
    IN p_slimes_percent DECIMAL(5, 4),
    IN p_depth_to DECIMAL(5, 1),
    IN p_depth_from DECIMAL(5, 1),
    IN p_drillhole_no VARCHAR(50),
    IN p_description VARCHAR(50),
    IN p_sampler int(11),
    IN p_lab_tech int(11),
    IN p_operator int(11),
    IN p_beginning_wet_weight DECIMAL(5, 1),
    IN p_prewash_dry_weight DECIMAL(5, 1),
    IN p_postwash_dry_weight DECIMAL(5, 1),
    IN p_split_sample_weight DECIMAL(5, 1),
    IN p_moisture_rate DECIMAL(6, 4),
    IN p_notes VARCHAR(255),
    IN p_turbidity INT(11),
    IN p_k_value INT(11),
    IN p_k_pan_1 DECIMAL(7, 4),
    IN p_k_pan_2 DECIMAL(7, 4),
    IN p_k_pan_3 DECIMAL(7, 4),
    IN p_roundness DECIMAL(5, 1),
    IN p_sphericity DECIMAL(5, 1),
    IN p_group_time TIME,
    IN p_start_weights_raw TEXT,
    IN p_end_weights_raw TEXT,
    IN p_sieves_raw TEXT,
    IN p_sieves_total DECIMAL(5, 1),
    IN p_sieve_1_value DECIMAL(7, 4),
    IN p_sieve_2_value DECIMAL(7, 4),
    IN p_sieve_3_value DECIMAL(7, 4),
    IN p_sieve_4_value DECIMAL(7, 4),
    IN p_sieve_5_value DECIMAL(7, 4),
    IN p_sieve_6_value DECIMAL(7, 4),
    IN p_sieve_7_value DECIMAL(7, 4),
    IN p_sieve_8_value DECIMAL(7, 4),
    IN p_sieve_9_value DECIMAL(7, 4),
    IN p_sieve_10_value DECIMAL(7, 4),
    IN p_sieve_11_value DECIMAL(7, 4),
    IN p_sieve_12_value DECIMAL(7, 4),
    IN p_sieve_13_value DECIMAL(7, 4),
    IN p_sieve_14_value DECIMAL(7, 4),
    IN p_sieve_15_value DECIMAL(7, 4),
    IN p_sieve_16_value DECIMAL(7, 4),
    IN p_sieve_17_value DECIMAL(7, 4),
    IN p_sieve_18_value DECIMAL(7, 4),
    IN p_sieve_1_desc CHAR(3),
    IN p_sieve_2_desc CHAR(3),
    IN p_sieve_3_desc CHAR(3),
    IN p_sieve_4_desc CHAR(3),
    IN p_sieve_5_desc CHAR(3),
    IN p_sieve_6_desc CHAR(3),
    IN p_sieve_7_desc CHAR(3),
    IN p_sieve_8_desc CHAR(3),
    IN p_sieve_9_desc CHAR(3),
    IN p_sieve_10_desc CHAR(3),
    IN p_sieve_11_desc CHAR(3),
    IN p_sieve_12_desc CHAR(3),
    IN p_sieve_13_desc CHAR(3),
    IN p_sieve_14_desc CHAR(3),
    IN p_sieve_15_desc CHAR(3),
    IN p_sieve_16_desc CHAR(3),
    IN p_sieve_17_desc CHAR(3),
    IN p_sieve_18_desc CHAR(3),
    IN p_plus_70 DECIMAL(5, 4),
    IN p_plus_50 DECIMAL(5, 4),
    IN p_plus_40 DECIMAL(5, 4),
    IN p_minus_50_plus_140 DECIMAL(5,4),
    IN p_minus_40_plus_70 DECIMAL(5, 4),
    IN p_minus_70 DECIMAL(5, 4),
    IN p_minus_70_plus_140 DECIMAL(5, 4),
    IN p_minus_60_plus_70 DECIMAL(5, 4),
    IN p_minus_140_plus_325 DECIMAL(5, 4),
    IN p_minus_140 DECIMAL(5, 4),
    IN p_finish_dt DATETIME,
    IN p_duration DECIMAL(5, 2),
    IN p_duration_minutes DECIMAL(5, 1),
    IN p_is_coa TINYINT(1),
    IN p_near_size DECIMAL(5, 4),
    IN p_sand_height float,
    IN p_silt_height float,
    IN p_silt_percent float
)
BEGIN
UPDATE tl_qc_samples
    SET 
        edit_dt = p_edit_dt,
        edit_user_id = p_edit_user_id, 
        site_id = p_site_id,
        plant_id = p_plant_id,
        dt = p_dt,
        test_type_id = p_test_type_id,
        composite_type_id = p_composite_type_id,
        sieve_method_id = p_sieve_method_id,
        location_id = p_location_id,
        specific_location_id = p_specific_location_id, 
        date = p_date,
        time = p_time,
        date_short = p_date_short,
        dt_short = p_dt_short,
        oversize_percent = p_oversize_percent, 
        oversize_weight = p_oversize_weight, 
        slimes_percent = p_slimes_percent, 
        depth_to = p_depth_to, 
        depth_from = p_depth_from, 
        drillhole_no = p_drillhole_no,
        description = p_description,
        sampler = p_sampler,
        lab_tech = p_lab_tech,
        operator = p_operator,
        beginning_wet_weight = p_beginning_wet_weight,
        prewash_dry_weight = p_prewash_dry_weight,
        postwash_dry_weight = p_postwash_dry_weight,
        split_sample_weight = p_split_sample_weight,
        moisture_rate = p_moisture_rate,
        notes = p_notes,
        turbidity = p_turbidity,
        k_value = p_k_value,
        k_pan_1 = p_k_pan_1,
        k_pan_2 = p_k_pan_2,
        k_pan_3 = p_k_pan_3,
        roundness = p_roundness,
        sphericity = p_sphericity,
        group_time = p_group_time,
        start_weights_raw = p_start_weights_raw,
        end_weights_raw = p_end_weights_raw,
        sieves_raw = p_sieves_raw,
        sieves_total = p_sieves_total, 
        sieve_1_value = p_sieve_1_value, 
        sieve_2_value = p_sieve_2_value, 
        sieve_3_value = p_sieve_3_value, 
        sieve_4_value = p_sieve_4_value, 
        sieve_5_value = p_sieve_5_value, 
        sieve_6_value = p_sieve_6_value, 
        sieve_7_value = p_sieve_7_value, 
        sieve_8_value = p_sieve_8_value, 
        sieve_9_value = p_sieve_9_value, 
        sieve_10_value = p_sieve_10_value, 
        sieve_11_value = p_sieve_11_value, 
        sieve_12_value = p_sieve_12_value, 
        sieve_13_value = p_sieve_13_value, 
        sieve_14_value = p_sieve_14_value, 
        sieve_15_value = p_sieve_15_value, 
        sieve_16_value = p_sieve_16_value, 
        sieve_17_value = p_sieve_17_value, 
        sieve_18_value = p_sieve_18_value, 
        sieve_1_desc = p_sieve_1_desc,
        sieve_2_desc = p_sieve_2_desc,
        sieve_3_desc = p_sieve_3_desc,
        sieve_4_desc = p_sieve_4_desc,
        sieve_5_desc = p_sieve_5_desc,
        sieve_6_desc = p_sieve_6_desc,
        sieve_7_desc = p_sieve_7_desc,
        sieve_8_desc = p_sieve_8_desc,
        sieve_9_desc = p_sieve_9_desc,
        sieve_10_desc = p_sieve_10_desc,
        sieve_11_desc = p_sieve_11_desc,
        sieve_12_desc = p_sieve_12_desc,
        sieve_13_desc = p_sieve_13_desc,
        sieve_14_desc = p_sieve_14_desc,
        sieve_15_desc = p_sieve_15_desc,
        sieve_16_desc = p_sieve_16_desc,
        sieve_17_desc = p_sieve_17_desc,
        sieve_18_desc = p_sieve_18_desc,        
        plus_70 = p_plus_70,
        plus_50 = p_plus_50, 
        plus_40 = p_plus_40, 
        minus_50_plus_140 = p_minus_50_plus_140,
        minus_40_plus_70 = p_minus_40_plus_70, 
        minus_70 = p_minus_70, 
        minus_70_plus_140 = p_minus_70_plus_140, 
        minus_60_plus_70 = p_minus_60_plus_70,
        minus_140_plus_325 = p_minus_140_plus_325,
        minus_140 = p_minus_140, 
        finish_dt = p_finish_dt, 
        duration = p_duration, 
        duration_minutes = p_duration_minutes,
        is_coa = p_is_coa,
        near_size = p_near_size,
        sand_height = p_sand_height,
        silt_height = p_silt_height,
        silt_percent = p_silt_percent
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleVoid` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleVoid`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `tl_qc_samples` 
    SET `void_status_code`='V' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SampleVoidReverse` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SampleVoidReverse`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `tl_qc_samples` 
    SET `void_status_code`='A' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_sample_repeat_lock` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_tl_qc_sample_repeat_lock`(in p_labtech int(11), in p_sample_id int(11))
update tl_qc_samples set is_repeat_process = 1, is_repeat_labtech = p_labtech where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_sample_repeat_unlock` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_tl_qc_sample_repeat_unlock`(in p_sample_id int(11))
update tl_qc_samples set is_repeat_process = 0, is_repeat_labtech = null where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_ShiftsGetBySiteAndDate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_ShiftsGetBySiteAndDate`(
    IN p_plant_id INT(11),
    IN p_time TIME
)
BEGIN
    SELECT * 
    FROM main_shifts 
    WHERE site_id = p_plant_id 
        AND p_time >= start_time 
    ORDER BY start_time DESC 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SieveInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveInsert`(
    IN p_sieve_stack_id INT(11),
    IN p_site_id int(11),
    IN p_screen_size varchar(16),
    IN p_start_weight decimal(5,1),
	IN p_serial_no varchar(32),
    IN p_sort_order int(11),
    IN p_user_id int(11)
    )
BEGIN
  INSERT INTO tl_qc_sieves 
    (sieve_stack_id, site_id, screen, start_weight, serial_no, sort_order, create_date, create_user_id) 
  VALUES 
    (p_sieve_stack_id, p_site_id, p_screen_size, p_start_weight, p_serial_no, p_sort_order, now(), p_user_id);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SievesGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SievesGetByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_sieves
WHERE sieve_stack_id = p_sieveStackId
and is_active=1
order by sort_order;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SieveStackGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveStackGetByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_sieve_stacks
    WHERE id = p_sieveStackId
    ORDER BY sort_order ASC
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SieveStackInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveStackInsert`(
    IN p_description VARCHAR(64),
    IN p_main_site_id INT(11),
    IN p_is_camsizer TINYINT(1),
    IN p_user_id INT(11)
)
INSERT INTO tl_qc_sieve_stacks 
    (description, main_site_id, is_camsizer, last_cleaned, create_date, create_user_id)
  VALUES 
    (p_description, p_main_site_id, p_is_camsizer, now(), now(), p_user_id) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SieveStacksGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveStacksGet`()
BEGIN
    SELECT * from tl_qc_sieve_stacks WHERE is_active = '1' ORDER BY sort_order;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SieveStacksGetBySiteID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveStacksGetBySiteID`(
    IN  p_sieveStackSiteID int(11)
)
BEGIN
    SELECT * FROM tl_qc_sieve_stacks
    WHERE main_site_id = p_sieveStackSiteID
    AND is_active = 1
    ORDER BY sort_order ASC; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveStackUpdate`(IN p_id int(11), IN p_description varchar(64), IN p_site_id int(11), p_is_camsizer tinyint(1), p_sort_order int(11), p_is_active tinyint(1), p_modify_user_id int(11))
update tl_qc_sieve_stacks 
set 
description = p_description,
main_site_id = p_site_id,
is_camsizer = p_is_camsizer,
sort_order = p_sort_order,
is_active = p_is_active,
modify_date = now(),
modify_user_id = p_modify_user_id
where
id=p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SieveStartingWeightUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveStartingWeightUpdate`(
    IN p_start_weight DECIMAL(5,1),
    IN p_sieve_stack_id INT(11),
    IN p_screen VARCHAR(16)
)
BEGIN
    UPDATE tl_qc_sieves 
    SET start_weight = p_start_weight 
    WHERE sieve_stack_id = p_sieve_stack_id 
        AND screen = p_screen;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SieveUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SieveUpdate`(
IN p_id int(11),
IN p_stack_id int(11),
IN p_site_id int(11),
IN p_serial_no varchar(32),
IN p_screen varchar(16),
IN p_start_weight decimal(5,1),
IN p_is_active tinyint(1),
IN p_sort_order int(11),
IN p_user_id int(11)
)
update tl_qc_sieves 
set 
site_id = p_site_id,
sieve_stack_id = p_stack_id,
serial_no = p_serial_no,
screen = p_screen,
start_weight = p_start_weight,
is_active = p_is_active,
sort_order = p_sort_order,
edit_date = now(),
edit_user_id = p_user_id
where
id = p_id and sieve_stack_id = p_stack_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SiteGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SiteGetByID`(
    IN  p_site_id INT(11)
)
BEGIN
    SELECT * FROM main_sites 
    WHERE id = p_site_id
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SpecificLocationGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SpecificLocationGetByID`(
    IN  p_specific_location_id INT(11)
)
BEGIN
    SELECT * FROM tl_qc_locations_details 
    WHERE id = p_specific_location_id
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SpecificLocationsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SpecificLocationsGet`()
BEGIN
    SELECT sp.id, sp.qc_location_id, sp.description, sp.sort_order, sp.is_active, l.main_site_id as site, l.main_plant_id as plant  from tl_qc_locations_details sp
    join gb_qc_locations l 
    on qc_location_id = l.id
    WHERE sp.is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_SpecificLocationsGetByLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_SpecificLocationsGetByLocation`(
    IN  p_locationId int(11)
)
BEGIN
SELECT * FROM tl_qc_locations_details 
    WHERE is_active = 1 
    AND qc_location_id = p_locationId 
    ORDER BY sort_order ASC; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_TestTypeGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_TestTypeGetByID`(
    IN  p_testTypeId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_test_types
    WHERE id = p_testTypeId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_TestTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_TestTypesGet`()
BEGIN
    SELECT * from tl_qc_test_types;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_ThresholdsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_ThresholdsInsert`(
    IN p_screen VARCHAR(16),
    IN p_location_id INT(11),
    IN p_low_threshold DOUBLE,
    IN p_high_threshold DOUBLE
)
BEGIN
INSERT INTO tl_qc_thresholds
(
    screen, 
    location_id, 
    low_threshold, 
    high_threshold
) 
VALUES 
(
    p_screen, 
    p_location_id, 
    p_low_threshold, 
    p_high_threshold
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_ThresholdsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_ThresholdsUpdate`(
    IN p_id INT(11),
    IN p_screen VARCHAR(16),
    IN p_location_id INT(11),
    IN p_low_threshold DOUBLE,
    IN p_high_threshold DOUBLE,
    IN p_is_active TINYINT(1)
)
BEGIN
    UPDATE tl_qc_thresholds
    SET 
    `screen` = p_screen,
    `location_id` = p_location_id,
    `low_threshold` = p_low_threshold,
    `high_threshold` = p_high_threshold,
    `is_active` = p_is_active
    WHERE `id` = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_UsesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_UsesGet`(IN p_sieve_method_id int(11))
select sieve_method_id from tl_qc_samples where sieve_method_id = p_sieve_method_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_UsesSinceLastCleanedGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_UsesSinceLastCleanedGet`(IN p_sieve_method_id int(11), IN p_dt datetime)
select sieve_method_id, dt from tl_qc_samples where sieve_method_id = p_sieve_method_id and dt > p_dt ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_tl_qc_VoidSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_VoidSample`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `tl_qc_samples` 
    SET `void_status_code`='V' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_ui_NavbarLinksByUserGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ui_NavbarLinksByUserGet`(IN p_username varchar(64))
(
SELECT u.username, d.name AS DeptName, web_file, p.permission_level AS role, l.permission_level FROM main_user_permissions p
LEFT JOIN ui_nav_left_links l ON l.permission = p.permission
LEFT JOIN main_departments d ON d.id = l.main_department_id
LEFT JOIN main_users u on u.id = p.user_id
where username = p_username and l.is_active = 1
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_ui_NavLeftLinksGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ui_NavLeftLinksGetAll`()
BEGIN
  SELECT 
      ul.id, 
      ul.main_department_id, 
      md.name as 'DeptName', 
      ul.parent_link_id, 
      ul.link_name, 
      ul.link_title, 
      ul.web_file, 
      ul.indent, 
      ul.permission_level, 
      ul.company, 
      ul.site, 
      ul.permission, 
      ul.is_external,
      ul.is_hidden
  FROM ui_nav_left_links ul
  LEFT JOIN main_departments md on ul.main_department_id = md.id
  WHERE ul.is_active = 1
  ORDER BY ul.sort_order; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_UpdateSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateSample`(
    IN p_id INT(11),
    IN p_edit_dt DATETIME,
    IN p_edit_user_id BIGINT(20), 
    IN p_site_id INT(11),
    IN p_plant_id INT(11),
    IN p_dt DATETIME,
    IN p_test_type_id INT(11),
    IN p_composite_type_id INT(11),
    IN p_sieve_method_id INT(11),
    IN p_location_id INT(11),
    IN p_date DATE,
    IN p_time TIME,
    IN p_date_short BIGINT(8),
    IN p_dt_short DATETIME,
    IN p_drillhole_no VARCHAR(50),
    IN p_description VARCHAR(50),
    IN p_sampler VARCHAR(32),
    IN p_lab_tech VARCHAR(32),
    IN p_operator VARCHAR(32),
    IN p_beginning_wet_weight DECIMAL(5, 1),
    IN p_prewash_dry_weight DECIMAL(5, 1),
    IN p_postwash_dry_weight DECIMAL(5, 1),
    IN p_split_sample_weight DECIMAL(5, 1),
    IN p_moisture_rate DECIMAL(6, 4),
    IN p_notes VARCHAR(255),
    IN p_turbidity INT(11),
    IN p_k_value INT(11),
    IN p_k_pan_1 DECIMAL(7, 4),
    IN p_k_pan_2 DECIMAL(7, 4),
    IN p_k_pan_3 DECIMAL(7, 4),
    IN p_roundness DECIMAL(5, 1),
    IN p_sphericity DECIMAL(5, 1),
    IN p_group_time TIME,
    IN p_start_weights_raw TEXT,
    IN p_end_weights_raw TEXT,
    IN p_sieves_raw TEXT
)
BEGIN
UPDATE gb_qc_samples
    SET 
        edit_dt = p_edit_dt,
        edit_user_id = p_edit_user_id, 
        site_id = p_site_id,
        plant_id = p_plant_id,
        dt = p_dt,
        test_type_id = p_test_type_id,
        composite_type_id = p_composite_type_id,
        sieve_method_id = p_sieve_method_id,
        location_id = p_location_id,
        date = p_date,
        time = p_time,
        date_short = p_date_short,
        dt_short = p_dt_short,
        drillhole_no = p_drillhole_no,
        description = p_description,
        sampler = p_sampler,
        lab_tech = p_lab_tech,
        operator = p_operator,
        beginning_wet_weight = p_beginning_wet_weight,
        prewash_dry_weight = p_prewash_dry_weight,
        postwash_dry_weight = p_postwash_dry_weight,
        split_sample_weight = p_split_sample_weight,
        moisture_rate = p_moisture_rate,
        notes = p_notes,
        turbidity = p_turbidity,
        k_value = p_k_value,
        k_pan_1 = p_k_pan_1,
        k_pan_2 = p_k_pan_2,
        k_pan_3 = p_k_pan_3,
        roundness = p_roundness,
        sphericity = p_sphericity,
        group_time = p_group_time,
        start_weights_raw = p_start_weights_raw,
        end_weights_raw = p_end_weights_raw,
        sieves_raw = p_sieves_raw
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_UpdateUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateUser`(
    IN  p_id int(11),
    IN  p_username VARCHAR(64),
    IN  p_first_name VARCHAR(32),
    IN  p_last_name VARCHAR(32),
    IN  p_display_name VARCHAR(64),
    IN  p_email VARCHAR(128),
    IN  p_company VARCHAR(32),
    IN  p_main_department_id INT(11),
    IN  p_last_logged DATETIME,
    IN  p_start_date DATE,
    IN  p_is_active TINYINT(1),
    IN  p_require_password_reset TINYINT(1),
    IN  p_password_reset_token VARCHAR(64),
    IN  p_password_token_expiration DATETIME
)
BEGIN
UPDATE main_users
    SET 
        username = p_username,
        first_name = p_first_name, 
        last_name = p_last_name, 
        display_name = p_display_name, 
        email = p_email, 
        company = p_company, 
        main_department_id = p_main_department_id, 
        last_logged = p_last_logged,
        start_date = p_start_date,
        is_active = p_is_active,
        require_password_reset = p_require_password_reset,
        password_reset_token = p_password_reset_token,
	password_token_expiration = p_password_token_expiration
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_UpdateUserPassword` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateUserPassword`(
    IN  p_password varchar(255),
    IN  p_userid int(11)
)
BEGIN
UPDATE main_users 
SET 
    password = p_password, 
    require_password_reset = '0' 
WHERE id = p_userid;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_UserGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UserGetAll`()
BEGIN
	SELECT  id, 
			username,
            first_name,
            last_name,
            display_name,
            email,
            company,
            main_department_id,
            last_logged,
            start_date,
            separation_date,
            is_active,
            qc_labtech,
            qc_sampler,
            qc_operator,
            manager_id
	FROM main_users;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_UserIdByEmailGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_UserIdByEmailGet`(in p_email varchar(128))
(
select id, concat(first_name, ' ', last_name) as name from main_users where email LIKE p_email
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_UserInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UserInsert`(
    IN p_username VARCHAR(64),
    IN p_first_name VARCHAR(32),
    IN p_last_name VARCHAR(32),
    IN p_display_name VARCHAR(64),
    IN p_email VARCHAR(128),
    IN p_company VARCHAR(64),
    IN p_main_department_id INT(11),
    IN p_password VARCHAR(255),
    IN p_last_logged DATETIME,
    IN p_start_date DATE,
    IN p_separation_date DATE,
    IN p_is_active TINYINT(1),
    IN p_require_password_reset TINYINT(1),
    IN p_password_reset_token VARCHAR(64),
    IN p_password_token_expiration DATETIME,
    IN p_user_type_id INT(11)
)
BEGIN
INSERT INTO main_users
(
    username, 
    first_name, 
    last_name, 
    display_name, 
    email, 
    company, 
    main_department_id, 
    password, 
    last_logged, 
    start_date, 
    separation_date, 
    is_active, 
    require_password_reset, 
    password_reset_token,
    password_token_expiration, 
    user_type_id
)
VALUES 
(
    p_username, 
    p_first_name, 
    p_last_name, 
    p_display_name, 
    p_email, 
    p_company, 
    p_main_department_id, 
    p_password, 
    p_last_logged, 
    p_start_date, 
    p_separation_date, 
    p_is_active, 
    p_require_password_reset, 
    p_password_reset_token,
    p_password_token_expiration, 
    p_user_type_id
) ; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_UserTypesSelectAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UserTypesSelectAll`()
BEGIN
    SELECT * from main_user_types WHERE is_active = '1' ORDER BY value ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_VoidSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_VoidSample`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `gb_qc_samples` 
    SET `void_status_code`='V' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_CleanSieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_CleanSieveStackUpdate`(IN p_id int(11), IN p_site_id INT(11), IN p_user_id int(11))
update wt_qc_sieve_stacks
set last_cleaned = now(),
 last_cleaned_by = p_user_id
where id = p_id AND main_site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_CompletedSamplesInDateRangeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_CompletedSamplesInDateRangeGet`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * FROM wt_qc_samples 
    WHERE void_status_code != 'V' 
    AND date >= p_start_date
    AND date <= p_end_date
    AND is_complete = '1'
    ORDER BY date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_CompletedSamplesInDateRangeGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_CompletedSamplesInDateRangeGetByLabTech`(
    IN  p_lab_tech_id VARCHAR(32),
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * FROM wt_qc_samples 
    WHERE void_status_code != 'V' 
    AND lab_tech = p_lab_tech_id
    AND date >= p_start_date
    AND date <= p_end_date
    AND is_complete = '1'
    ORDER BY date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_CompositeTypeGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_CompositeTypeGetByID`(
    IN  p_compositeTypeId varchar(64)
)
BEGIN
SELECT * FROM wt_qc_composites
    WHERE id = p_compositeTypeId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_CompositeTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_CompositeTypesGet`()
BEGIN
    SELECT * from wt_qc_composites;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_DateRangePercentAveragesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_DateRangePercentAveragesGet`(
    IN p_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT wt_qc_samples.id, DATE_FORMAT(wt_qc_samples.date, '%Y-%m-%d') as 'date', wt_qc_finalpercentages.finalpercent1, wt_qc_finalpercentages.finalpercent2, wt_qc_finalpercentages.finalpercent3, wt_qc_finalpercentages.finalpercent4, wt_qc_finalpercentages.finalpercent5, wt_qc_finalpercentages.finalpercent6, wt_qc_finalpercentages.finalpercent7, wt_qc_finalpercentages.finalpercent8, wt_qc_finalpercentages.finalpercent9, wt_qc_finalpercentages.finalpercent10, wt_qc_finalpercentages.finalpercent11, wt_qc_finalpercentages.finalpercent12, wt_qc_finalpercentages.finalpercent13, wt_qc_finalpercentages.finalpercent14, wt_qc_finalpercentages.finalpercent15, wt_qc_finalpercentages.finalpercent16, wt_qc_finalpercentages.finalpercent17, wt_qc_finalpercentages.finalpercent18, wt_qc_samples.plus_70, wt_qc_samples.minus_40_plus_70, wt_qc_samples.minus_70, wt_qc_samples.minus_70_plus_140, wt_qc_samples.plus_140, wt_qc_samples.minus_140
    FROM wt_qc_samples
    LEFT JOIN wt_qc_finalpercentages ON wt_qc_samples.id = wt_qc_finalpercentages.sample_id
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND location_id = p_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_DateRangePercentSamplesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_wt_qc_DateRangePercentSamplesGet`(
    IN p_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT id, DATE_FORMAT(date, '%Y-%m-%d') as 'date',sieve_1_value,sieve_2_value,sieve_3_value,sieve_4_value,sieve_5_value,sieve_6_value,sieve_7_value,sieve_8_value,sieve_9_value,sieve_10_value,sieve_11_value,sieve_12_value,sieve_13_value,sieve_14_value,sieve_15_value,sieve_16_value,sieve_17_value,sieve_18_value, plus_70, plus_50, plus_40, minus_40_plus_70, minus_70, minus_70_plus_140, plus_140, minus_140, 
    oversize_percent, minus_140_plus_325, minus_60_plus_70,
    near_size, minus_50_plus_140
    FROM wt_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND location_id = p_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_DateRangePercentSamplesGetBySpecificLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_DateRangePercentSamplesGetBySpecificLocation`(
    IN p_specific_location_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT wt_qc_samples.id, DATE_FORMAT(wt_qc_samples.date, '%Y-%m-%d') as 'date',wt_qc_samples.sieve_1_value,wt_qc_samples.sieve_2_value,wt_qc_samples.sieve_3_value,wt_qc_samples.sieve_4_value,wt_qc_samples.sieve_5_value,wt_qc_samples.sieve_6_value,wt_qc_samples.sieve_7_value,wt_qc_samples.sieve_8_value,wt_qc_samples.sieve_9_value,wt_qc_samples.sieve_10_value,wt_qc_samples.sieve_11_value,wt_qc_samples.sieve_12_value,wt_qc_samples.sieve_13_value,wt_qc_samples.sieve_14_value,wt_qc_samples.sieve_15_value,wt_qc_samples.sieve_16_value,wt_qc_samples.sieve_17_value,wt_qc_samples.sieve_18_value, wt_qc_samples.plus_70, wt_qc_samples.minus_40_plus_70, wt_qc_samples.minus_70, wt_qc_samples.minus_70_plus_140, wt_qc_samples.plus_140, wt_qc_samples.minus_140
    FROM wt_qc_samples
    WHERE test_type_id > 1 
        AND test_type_id < 4 
        AND void_status_code != 'V' 
        AND specific_location_id = p_specific_location_id
        AND sieve_method_id is NOT NULL 
        AND date >= p_start_date 
        AND date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_FinalPercentagesGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_FinalPercentagesGetByID`(
    IN p_sample_id INT(11)
)
BEGIN
    SELECT * 
    FROM wt_qc_finalpercentages 
    WHERE sample_id = p_sample_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_FinalPercentagesInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_FinalPercentagesInsert`(
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
INSERT INTO wt_qc_finalpercentages 
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_FinalPercentagesUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_FinalPercentagesUpdate`(
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
wt_qc_finalpercentages 
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_InsertSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_InsertSample`(
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
    IN  p_shift VARCHAR(5)
)
BEGIN
INSERT INTO wt_qc_samples
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_KPIPLCTagsGetByPlantID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_KPIPLCTagsGetByPlantID`(
    IN p_plant_id INT(11)
)
BEGIN
    SELECT * FROM prod_auto_plant_analog_tags
    WHERE is_kpi = 1
    AND is_mir = 1
    AND is_hidden = 0
    AND is_removed = 0
    AND plant_id = p_plant_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_KValueRecordGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_KValueRecordGet`(
    IN  p_sample_id INT(11),
    IN  p_k_value_id INT(11),
    IN  p_description VARCHAR(50)
)
BEGIN
    SELECT * FROM wt_qc_k_value_records 
    WHERE sample_id = p_sample_id
    AND k_value_id = p_k_value_id
    AND description = p_description
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_KValueRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_KValueRecordInsert`(
    IN p_sample_id INT(11),
    IN p_k_value_id INT(11),
    IN p_description VARCHAR(50),
    IN p_value DOUBLE
)
BEGIN
    INSERT INTO wt_qc_k_value_records 
    (
        sample_id,
        k_value_id, 
        description, 
        value
    ) 
    VALUES 
    (
        p_sample_id, 
        p_k_value_id, 
        p_description, 
        p_value
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_KValueRecordUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_KValueRecordUpdate`(
    IN p_value DOUBLE,
    IN p_id INT(11),
    IN p_k_value_id INT(11),
    IN p_description VARCHAR(50) 
)
BEGIN
    UPDATE wt_qc_k_value_records 
    SET `value` = p_value 
    WHERE `sample_id` = p_id
    AND `k_value_id` = p_k_value_id
    AND `description` = p_description;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_KValuesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_KValuesGet`()
BEGIN
    SELECT * from wt_qc_k_values;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LabTechsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LabTechsGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
		CONCAT(mu.first_name, ' ', mu.last_name) AS display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.password, 
		mu.last_logged,
		mu.start_date,
		mu.separation_date, 
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
    rc.role_id,
		mu.user_type_id, 
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id, 
		mu.is_active
FROM main_users mu LEFT JOIN main_users_roles_check rc ON rc.user_id = mu.id 
WHERE rc.role_id = 3
AND mu.is_active = 1
ORDER BY first_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationDetailsByNameGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationDetailsByNameGet`()
(
select
	locd.id, locd.qc_location_id AS 'location_id', loc.description AS 'location', locd.description AS 'specific_location', locd.sort_order, locd.is_active
from
	wt_qc_locations_details locd
join
	wt_qc_locations loc ON locd.qc_location_id = loc.id
) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationDetailsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationDetailsInsert`(IN p_qc_location_id int, IN p_description varchar(255), IN p_create_user_id int)
begin
set @sort = (select max(sort_order)+10 from wt_qc_locations_details);
insert into wt_qc_locations_details
(
qc_location_id,
description,
sort_order,
create_date,
create_user_id
)
values
(
p_qc_location_id,
p_description,
@sort,
now(),
p_create_user_id
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationDetailsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationDetailsUpdate`(IN p_id int, IN p_qc_location_id int, IN p_description varchar(255), IN p_sort_order int, IN p_is_active tinyint(1), IN p_modify_user_id int)
update wt_qc_locations_details
set
qc_location_id = p_qc_location_id,
description = p_description,
sort_order = p_sort_order,
modify_date = now(),
is_active = p_is_active,
modify_user_id = p_modify_user_id
where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationGetByID`(
    IN  p_locationId INT(11)
)
BEGIN
SELECT * FROM wt_qc_locations
    WHERE id = p_locationId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationInsert`(
IN p_description varchar(255), 
IN p_main_site_id int(11), 
IN p_main_plant_id int(11),
IN p_is_split_sample_only tinyint(1),
IN p_create_user_id int(11)
)
BEGIN
set @sort = (select max(sort_order)+10 from wt_qc_locations);
insert into wt_qc_locations 
(
description, 
main_site_id, 
main_plant_id,
is_split_sample_only,
sort_order,
create_date,
create_user_id
)
values 
(
p_description, 
p_main_site_id, 
p_main_plant_id,
p_is_split_sample_only,
@sort,
now(),
p_create_user_id
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationsDelete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationsDelete`(IN P_id INT(11))
BEGIN
DELETE FROM wt_qc_locations WHERE id = p_id LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationsGet`()
BEGIN
    SELECT * from wt_qc_locations 
    WHERE is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationsGetByPlant` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationsGetByPlant`(
    IN  p_main_plant_id INT(11)
)
BEGIN
    SELECT * FROM wt_qc_locations 
    WHERE is_active = 1 
    AND main_plant_id = p_main_plant_id
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationsNamesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationsNamesGet`()
SELECT 
    l.id,
    l.sort_order,
    s.id as 'site_id',
    s.description as 'site',
    p.id as 'plant_id',
    p.name,
    l.description as 'description',
    l.is_split_sample_only,
    l.is_active
FROM
    wt_qc_locations l
JOIN 
	main_sites s on s.id = l.main_site_id
JOIN
	main_plants p on p.id = l.main_plant_id
ORDER BY l.sort_order desc ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_LocationsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_LocationsUpdate`(
IN p_id int(11),
IN p_description varchar(256),
IN p_main_site_id int(11), 
IN p_main_plant_id int(11),
IN p_is_split_sample_only tinyint(1),
IN p_sort_order int(11),
IN p_is_active tinyint(1),
IN p_modify_user_id int(11)
)
UPDATE wt_qc_locations
SET
id = p_id,
description = p_description,
main_site_id = p_main_site_id,
main_plant_id = p_main_plant_id,
is_split_sample_only = p_is_split_sample_only,
sort_order = p_sort_order,
is_active = p_is_active,
modify_date = now(),
modify_user_id = p_modify_user_id
WHERE 
id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_MaxFinalPercentageIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_MaxFinalPercentageIDGet`(
    
)
BEGIN
    SELECT MAX(id) 
    FROM wt_qc_finalpercentages 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_MaxRepeatabilityPairIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_MaxRepeatabilityPairIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM wt_qc_repeatability_pairs
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_MaxRepeatabilityUserIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_MaxRepeatabilityUserIDGet`(
    
)
BEGIN
    SELECT MAX(id) 
    FROM wt_qc_user_repeatability
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_MaxSampleIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_MaxSampleIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM wt_qc_samples 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_MaxSieveStackIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_MaxSieveStackIDGet`(
    
)
BEGIN
    SELECT MAX(id)
    FROM wt_qc_sieve_stacks
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_MostRecentSampleBySpecificLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_MostRecentSampleBySpecificLocation`(
    IN  p_specific_location_id int(11)
)
BEGIN
SELECT * FROM wt_qc_samples 
    WHERE void_status_code != 'V' 
    AND test_type_id != '7'
    AND specific_location_id = p_specific_location_id
    AND is_complete = 1 
    ORDER BY id DESC 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_OperatorsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_OperatorsGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
		CONCAT(mu.first_name, ' ', mu.last_name) AS display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		rc.role_id,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu LEFT JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 1
AND mu.is_active = 1
ORDER BY first_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_PerformanceCyclesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_PerformanceCyclesGet`(
    IN p_plant_id INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT lab_tech, 
        sum(case when test_type_id = 1 then 1 else 0 end) as test_type_1_count, 
        sum(case when test_type_id = 2 then 1 else 0 end) as test_type_2_count, 
        sum(case when test_type_id = 3 then 1 else 0 end) as test_type_3_count, 
        sum(case when test_type_id = 4 then 1 else 0 end) as test_type_4_count, 
        sum(case when test_type_id = 5 then 1 else 0 end) as test_type_5_count, 
        sum(case when test_type_id = 6 then 1 else 0 end) as test_type_6_count,             
        sum(case when test_type_id = 7 then 1 else 0 end) as test_type_7_count,
        avg(duration) as duration 
    FROM wt_qc_samples 
    WHERE dt >= p_start_date 
        AND dt <= p_end_date 
        AND plant_id = p_plant_id 
        AND lab_tech != '' 
        GROUP by lab_tech;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_PerformanceCyclesGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_PerformanceCyclesGetByLabTech`(
    IN p_plant_id INT(11),
    IN p_lab_tech INT(11),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT lab_tech, 
        sum(case when test_type_id = 1 then 1 else 0 end) as test_type_1_count, 
        sum(case when test_type_id = 2 then 1 else 0 end) as test_type_2_count, 
        sum(case when test_type_id = 3 then 1 else 0 end) as test_type_3_count, 
        sum(case when test_type_id = 4 then 1 else 0 end) as test_type_4_count, 
        sum(case when test_type_id = 5 then 1 else 0 end) as test_type_5_count, 
        sum(case when test_type_id = 6 then 1 else 0 end) as test_type_6_count,    
        sum(case when test_type_id = 7 then 1 else 0 end) as test_type_7_count,
        avg(duration) as duration 
    FROM wt_qc_samples 
    WHERE dt >= p_start_date 
        AND dt <= p_end_date 
        AND plant_id = p_plant_id 
        AND lab_tech = p_lab_tech 
        GROUP by lab_tech;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_PlantSettingsDataByTagAndSampleIDGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_PlantSettingsDataByTagAndSampleIDGet`(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11)
)
BEGIN
    SELECT tl_plant_mir_data.id, tl_plant_mir_data.sample_id, tl_plant_mir_data.tag_id, tl_plant_mir_data.value, tl_auto_plant_analog_tags.device 
    FROM tl_plant_mir_data 
    LEFT JOIN tl_auto_plant_analog_tags ON tl_plant_mir_data.tag_id = tl_auto_plant_analog_tags.id 
    WHERE tl_plant_mir_data.sample_id = p_sample_id 
    AND tl_plant_mir_data.tag_id = p_tag_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_PlantSettingsRecordInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_PlantSettingsRecordInsert`(
    IN p_sample_id INT(11),
    IN p_tag_id INT(11),
    IN p_value DECIMAL(16,4)
)
BEGIN
    INSERT INTO tl_plant_settings_data 
    (
        sample_id, 
        tag_id, 
        value
    ) 
    VALUES 
    (
        p_sample_id, 
        p_tag_id, 
        p_value
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_PlantSettingsRecordUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_PlantSettingsRecordUpdate`(
    IN p_value DECIMAL(16,4),
    IN p_id INT(11)
)
BEGIN
    UPDATE tl_plant_settings_data 
    SET `value` = p_value
    WHERE `id` = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_PlantsGetBySite` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_PlantsGetBySite`(
    IN  p_main_site_id INT(11)
)
BEGIN
    SELECT * FROM main_plants 
    WHERE is_active = 1 
    AND main_site_id = p_main_site_id
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_PLCTagsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_PLCTagsGet`(

)
BEGIN
    SELECT * FROM tl_auto_plant_analog_tags WHERE is_mir = 1 AND is_hidden = 0 AND is_removed = 0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_PLCTagsGetByPlantID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_PLCTagsGetByPlantID`(
    IN p_plant_id INT(11)
)
BEGIN
    SELECT * FROM tl_auto_plant_analog_tags 
    WHERE is_mir = 1 
    AND is_hidden = 0 
    AND is_removed = 0 
    AND plant_id = p_plant_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_QCThresholdsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_QCThresholdsGet`(
    IN  p_location_id INT(11),
    IN  p_screen VARCHAR(16)
)
BEGIN
    SELECT * FROM wt_qc_thresholds 
    WHERE location_id = p_location_id
        AND screen = p_screen;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_QCThresholdsGetAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_QCThresholdsGetAll`(
)
BEGIN
    SELECT * FROM wt_qc_thresholds
    WHERE is_active = 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabilityGetByUserID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilityGetByUserID`(
    IN p_user_id INT(11)
)
BEGIN

    SELECT * 
    FROM wt_qc_user_repeatability 
    WHERE user_id = p_user_id 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabilitySamplePairInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilitySamplePairInsert`(
    IN p_original_sample BIGINT(20),
    IN p_repeated_sample BIGINT(20),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO wt_qc_repeatability_pairs 
    (
        original_sample, 
        repeated_sample
    ) 
    VALUES 
    (
        p_original_sample, 
        p_repeated_sample
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabilitySamplePairsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilitySamplePairsGet`(
  IN p_start_date DATE, IN p_end_date DATE
)
BEGIN
SELECT
  pairs.id,
  pairs.original_sample,
  pairs.repeated_sample,
  original.date AS original_date,
  repeated.date AS repeated_date,
  original.lab_tech AS original_lab_tech,
  repeated.lab_tech AS repeated_lab_tech,
  original.location_id AS original_location_id,
  repeated.location_id AS repeated_location_id,
  original.sieve_method_id AS original_sieve_method_id,
  repeated.sieve_method_id AS repeated_sieve_method_id,
  original.sieve_1_desc AS original_sieve_1_desc,
  original.sieve_2_desc AS original_sieve_2_desc,
  original.sieve_3_desc AS original_sieve_3_desc,
  original.sieve_4_desc AS original_sieve_4_desc,
  original.sieve_5_desc AS original_sieve_5_desc,
  original.sieve_6_desc AS original_sieve_6_desc,
  original.sieve_7_desc AS original_sieve_7_desc,
  original.sieve_8_desc AS original_sieve_8_desc,
  original.sieve_9_desc AS original_sieve_9_desc,
  original.sieve_10_desc AS original_sieve_10_desc,
  original.sieve_1_value AS original_sieve_1_value,
  original.sieve_2_value AS original_sieve_2_value,
  original.sieve_3_value AS original_sieve_3_value,
  original.sieve_4_value AS original_sieve_4_value,
  original.sieve_5_value AS original_sieve_5_value,
  original.sieve_6_value AS original_sieve_6_value,
  original.sieve_7_value AS original_sieve_7_value,
  original.sieve_8_value AS original_sieve_8_value,
  original.sieve_9_value AS original_sieve_9_value,
  original.sieve_10_value AS original_sieve_10_value,
  original.plus_70 AS original_plus_70,
  original.plus_50 AS original_plus_50,
original.plus_40 AS original_plus_40,
  repeated.sieve_1_desc AS repeated_sieve_1_desc,
  repeated.sieve_2_desc AS repeated_sieve_2_desc,
  repeated.sieve_3_desc AS repeated_sieve_3_desc,
  repeated.sieve_4_desc AS repeated_sieve_4_desc,
  repeated.sieve_5_desc AS repeated_sieve_5_desc,
  repeated.sieve_6_desc AS repeated_sieve_6_desc,
  repeated.sieve_7_desc AS repeated_sieve_7_desc,
  repeated.sieve_8_desc AS repeated_sieve_8_desc,
  repeated.sieve_9_desc AS repeated_sieve_9_desc,
  repeated.sieve_10_desc AS repeated_sieve_10_desc,
  repeated.sieve_1_value AS repeated_sieve_1_value,
  repeated.sieve_2_value AS repeated_sieve_2_value,
  repeated.sieve_3_value AS repeated_sieve_3_value,
  repeated.sieve_4_value AS repeated_sieve_4_value,
  repeated.sieve_5_value AS repeated_sieve_5_value,
  repeated.sieve_6_value AS repeated_sieve_6_value,
  repeated.sieve_7_value AS repeated_sieve_7_value,
  repeated.sieve_8_value AS repeated_sieve_8_value,
  repeated.sieve_9_value AS repeated_sieve_9_value,
  repeated.sieve_10_value AS repeated_sieve_10_value,
  repeated.plus_70 AS repeated_plus_70,
  repeated.plus_50 AS repeated_plus_50,
  repeated.plus_40 AS repeated_plus_40,
  original.sieve_11_desc AS original_sieve_11_desc,
  original.sieve_12_desc AS original_sieve_12_desc,
  original.sieve_13_desc AS original_sieve_13_desc,
  original.sieve_14_desc AS original_sieve_14_desc,
  original.sieve_15_desc AS original_sieve_15_desc,
  original.sieve_16_desc AS original_sieve_16_desc,
  original.sieve_17_desc AS original_sieve_17_desc,
  original.sieve_18_desc AS original_sieve_18_desc,
  original.sieve_11_value AS original_sieve_11_value,
  original.sieve_12_value AS original_sieve_12_value,
  original.sieve_13_value AS original_sieve_13_value,
  original.sieve_14_value AS original_sieve_14_value,
  original.sieve_15_value AS original_sieve_15_value,
  original.sieve_16_value AS original_sieve_16_value,
  original.sieve_17_value AS original_sieve_17_value,
  original.sieve_18_value AS original_sieve_18_value,
  repeated.sieve_11_desc AS repeated_sieve_11_desc,
  repeated.sieve_12_desc AS repeated_sieve_12_desc,
  repeated.sieve_13_desc AS repeated_sieve_13_desc,
  repeated.sieve_14_desc AS repeated_sieve_14_desc,
  repeated.sieve_15_desc AS repeated_sieve_15_desc,
  repeated.sieve_16_desc AS repeated_sieve_16_desc,
  repeated.sieve_17_desc AS repeated_sieve_17_desc,
  repeated.sieve_18_desc AS repeated_sieve_18_desc,
  repeated.sieve_11_value AS repeated_sieve_11_value,
  repeated.sieve_12_value AS repeated_sieve_12_value,
  repeated.sieve_13_value AS repeated_sieve_13_value,
  repeated.sieve_14_value AS repeated_sieve_14_value,
  repeated.sieve_15_value AS repeated_sieve_15_value,
  repeated.sieve_16_value AS repeated_sieve_16_value,
  repeated.sieve_17_value AS repeated_sieve_17_value,
  repeated.sieve_18_value AS repeated_sieve_18_value
FROM
  wt_qc_repeatability_pairs AS pairs
  LEFT JOIN wt_qc_samples AS original ON pairs.original_sample = original.id
  LEFT JOIN wt_qc_samples AS repeated ON pairs.repeated_sample = repeated.id
WHERE
  original.date >= p_start_date
  AND original.date <= p_end_date;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabilitySamplePairsGetByLabTech` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilitySamplePairsGetByLabTech`(
    IN p_start_date DATE,
    IN p_end_date DATE,
    IN p_lab_tech_id INT(11)
)
BEGIN

    SELECT pairs.id,
    pairs.original_sample,
    pairs.repeated_sample,
    original.date AS original_date,
    repeated.date,
    original.lab_tech AS original_lab_tech,
    repeated.lab_tech,
    original.location_id AS original_location_id,
    repeated.location_id,
    original.sieve_method_id AS original_sieve_method_id,
    repeated.sieve_method_id,
    original.sieve_1_desc AS original_sieve_1_desc,
    original.sieve_2_desc AS original_sieve_2_desc,
    original.sieve_3_desc AS original_sieve_3_desc,
    original.sieve_4_desc AS original_sieve_4_desc,
    original.sieve_5_desc AS original_sieve_5_desc,
    original.sieve_6_desc AS original_sieve_6_desc,
    original.sieve_7_desc AS original_sieve_7_desc,
    original.sieve_8_desc AS original_sieve_8_desc,
    original.sieve_9_desc AS original_sieve_9_desc,
    original.sieve_10_desc AS original_sieve_10_desc,
    original.sieve_11_desc AS original_sieve_11_desc,
    original.sieve_12_desc AS original_sieve_12_desc,
    original.sieve_13_desc AS original_sieve_13_desc,
    original.sieve_14_desc AS original_sieve_14_desc,
    original.sieve_15_desc AS original_sieve_15_desc,
    original.sieve_16_desc AS original_sieve_16_desc,
    original.sieve_17_desc AS original_sieve_17_desc,
    original.sieve_18_desc AS original_sieve_18_desc,
    original.sieve_1_value AS original_sieve_1_value,
    original.sieve_2_value AS original_sieve_2_value,
    original.sieve_3_value AS original_sieve_3_value,
    original.sieve_4_value AS original_sieve_4_value,
    original.sieve_5_value AS original_sieve_5_value,
    original.sieve_6_value AS original_sieve_6_value,
    original.sieve_7_value AS original_sieve_7_value,
    original.sieve_8_value AS original_sieve_8_value,
    original.sieve_9_value AS original_sieve_9_value,
    original.sieve_10_value AS original_sieve_10_value,
    original.sieve_11_value AS original_sieve_11_value,
    original.sieve_12_value AS original_sieve_12_value,
    original.sieve_13_value AS original_sieve_13_value,
    original.sieve_14_value AS original_sieve_14_value,
    original.sieve_15_value AS original_sieve_15_value,
    original.sieve_16_value AS original_sieve_16_value,
    original.sieve_17_value AS original_sieve_17_value,
    original.sieve_18_value AS original_sieve_18_value,
    original.plus_70 AS original_plus_70,
    original.plus_50 AS original_plus_50,
    original.plus_40 AS original_plus_40,
    repeated.sieve_1_desc AS repeated_sieve_1_desc,
    repeated.sieve_2_desc AS repeated_sieve_2_desc,
    repeated.sieve_3_desc AS repeated_sieve_3_desc,
    repeated.sieve_4_desc AS repeated_sieve_4_desc,
    repeated.sieve_5_desc AS repeated_sieve_5_desc,
    repeated.sieve_6_desc AS repeated_sieve_6_desc,
    repeated.sieve_7_desc AS repeated_sieve_7_desc,
    repeated.sieve_8_desc AS repeated_sieve_8_desc,
    repeated.sieve_9_desc AS repeated_sieve_9_desc,
    repeated.sieve_10_desc AS repeated_sieve_10_desc,
	repeated.sieve_1_desc AS repeated_sieve_11_desc,
    repeated.sieve_2_desc AS repeated_sieve_12_desc,
    repeated.sieve_3_desc AS repeated_sieve_13_desc,
    repeated.sieve_4_desc AS repeated_sieve_14_desc,
    repeated.sieve_5_desc AS repeated_sieve_15_desc,
    repeated.sieve_6_desc AS repeated_sieve_16_desc,
    repeated.sieve_7_desc AS repeated_sieve_17_desc,
    repeated.sieve_8_desc AS repeated_sieve_18_desc,
    repeated.sieve_1_value AS repeated_sieve_1_value,
    repeated.sieve_2_value AS repeated_sieve_2_value,
    repeated.sieve_3_value AS repeated_sieve_3_value,
    repeated.sieve_4_value AS repeated_sieve_4_value,
    repeated.sieve_5_value AS repeated_sieve_5_value,
    repeated.sieve_6_value AS repeated_sieve_6_value,
    repeated.sieve_7_value AS repeated_sieve_7_value,
    repeated.sieve_8_value AS repeated_sieve_8_value,
    repeated.sieve_9_value AS repeated_sieve_9_value,
    repeated.sieve_10_value AS repeated_sieve_10_value,
    repeated.sieve_11_value AS repeated_sieve_11_value,
    repeated.sieve_12_value AS repeated_sieve_12_value,
    repeated.sieve_13_value AS repeated_sieve_13_value,
    repeated.sieve_14_value AS repeated_sieve_14_value,
    repeated.sieve_15_value AS repeated_sieve_15_value,
    repeated.sieve_16_value AS repeated_sieve_16_value,
    repeated.sieve_17_value AS repeated_sieve_17_value,
    repeated.sieve_18_value AS repeated_sieve_18_value,
    repeated.plus_70 AS repeated_plus_70,
    repeated.plus_50 AS repeated_plus_50,
    repeated.plus_40 AS repeated_plus_40
    FROM wt_qc_repeatability_pairs AS pairs
    LEFT JOIN wt_qc_samples AS original ON pairs.original_sample = original.id
    LEFT JOIN wt_qc_samples AS repeated ON pairs.repeated_sample = repeated.id
    WHERE original.date >= p_start_date
    AND original.date <= p_end_date
    AND original.lab_tech = p_lab_tech_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabilitySamplePairsGetByOriginalSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilitySamplePairsGetByOriginalSample`(
    IN  p_original_sample_id INT(11)
)
BEGIN
    SELECT * FROM wt_qc_repeatability_pairs 
    WHERE original_sample = p_original_sample_id 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabilitySamplePairsGetByRepeatedSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilitySamplePairsGetByRepeatedSample`(
    IN  p_repeated_sample_id INT(11)
)
BEGIN
    SELECT * FROM wt_qc_repeatability_pairs 
    WHERE repeated_sample = p_repeated_sample_id 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabilityUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilityUpdate`(
    IN p_repeatability_value INT(11),
    IN p_user_id INT(11)
)
BEGIN

    UPDATE wt_qc_user_repeatability 
    SET repeatability_counter = p_repeatability_value 
    WHERE user_id = p_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabilityUserInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabilityUserInsert`(
    IN p_user_id INT(11),
    IN p_repeatability_counter INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO wt_qc_user_repeatability 
    (
        user_id, 
        repeatability_counter
    ) 
    VALUES 
    (
        p_user_id, 
        p_repeatability_counter
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RepeatabiltyUserInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RepeatabiltyUserInsert`(
    IN p_user_id INT(11),
    IN p_repeatability_counter INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO wt_qc_user_repeatability 
    (
        user_id, 
        repeatability_counter
    ) 
    VALUES 
    (
        p_user_id, 
        p_repeatability_counter
    );
    select last_insert_id() into p_insert_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RetireSieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RetireSieveStackUpdate`(IN p_id int(11), IN p_site_id INT(11), p_user_id int(11))
update wt_qc_sieve_stacks
set is_active = 0,
modify_date = now(),
modify_user_id = p_user_id
where id = p_id AND main_site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_RetireSieveUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_RetireSieveUpdate`(IN p_id int(11), IN p_site_id INT(11), IN p_user_id int(11))
update wt_qc_sieves
set is_active = 0,
edit_date = now(),
sort_order = 0,
edit_user_id = p_user_id
where id = p_id AND site_id = p_site_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleByLocationMostRecentGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleByLocationMostRecentGet`(
    IN  p_location INT
)
BEGIN
    SELECT * FROM wt_qc_samples 
    WHERE void_status_code != 'V' 
    AND location_id = p_location
    AND test_type_id != '1'
    AND test_type_id != '7'
    AND is_complete = 1 
    ORDER BY dt DESC 
    LIMIT 1
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleFinishDtCheck` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_wt_qc_SampleFinishDtCheck`(in p_id int(11))
select finish_dt from wt_qc_samples where id = p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleFinishDtUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_wt_qc_SampleFinishDtUpdate`(in p_sample_id int(11))
update wt_qc_samples set finish_dt = now(), duration = round(TIMESTAMPDIFF(minute, dt, now())/60,2),  duration_minutes = round(TIMESTAMPDIFF(minute, dt, now()),2) where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleGetByID`(
    IN  p_sampleId varchar(64)
)
BEGIN
SELECT * FROM wt_qc_samples
    WHERE id = p_sampleId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleGetByPlantAndDatetimeIncludeVoided` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleGetByPlantAndDatetimeIncludeVoided`(
    IN  p_plant_id INT(11),
    IN  p_date_id DATETIME
)
BEGIN
    SELECT * FROM wt_qc_samples 
    WHERE plant_id = p_plant_id
    AND dt = p_date_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleGroupGetBySample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleGroupGetBySample`(
    IN p_sample_id INT(11)
)
BEGIN
    SELECT * 
    FROM wt_qc_sample_groups 
    WHERE sample_id = p_sample_id 
    LIMIT 1;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleGroupInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleGroupInsert`(
  IN p_group_id INT(11),
  IN p_sample_id INT(11)
)
BEGIN
  INSERT INTO wt_qc_sample_groups 
    (group_id, sample_id) 
  VALUES 
    (p_group_id, p_sample_id);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleGroupMaxGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleGroupMaxGet`(
    
)
BEGIN
    SELECT MAX(group_id)
    FROM wt_qc_sample_groups 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleIDsGetByGroupID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleIDsGetByGroupID`(
    IN p_group_id INT(11)
)
BEGIN
    SELECT * 
    FROM wt_qc_sample_groups 
    WHERE group_id = p_group_id;    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleInsert`(

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
    IN  p_lab_Tech INT(11),
    IN  p_sampler INT(11),
    IN  p_operator INT(11),
    IN  p_shift VARCHAR(5),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO wt_qc_samples
    (
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleRepeatCheck` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_wt_qc_SampleRepeatCheck`(in p_sample_id int(11))
select s.is_repeat_process, s.is_repeat_labtech, concat(mu.first_name, ' ', mu.last_name) as lab_tech from wt_qc_samples s
join main_users mu on mu.id = s.is_repeat_labtech where s.is_repeat_process = 1 and s.id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SamplersGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SamplersGet`()
BEGIN
    SELECT
		mu.id,
		mu.username,
        mu.first_name,
        mu.last_name,
		CONCAT(mu.first_name, ' ', mu.last_name) AS display_name,
		mu.email,
		mu.company,
		mu.main_department_id,
		mu.password,
		mu.last_logged,
		mu.start_date,
		mu.separation_date,
		mu.require_password_reset,
		mu.password_reset_token,
		mu.password_token_expiration,
		rc.role_id,
		mu.user_type_id,
		mu.manager_id,
		mu.create_date,
		mu.create_user_id,
		mu.modify_date,
		mu.modify_user_id,
		mu.is_active
FROM main_users mu LEFT JOIN main_users_roles_check rc ON rc.user_id = mu.id
WHERE rc.role_id = 2
AND mu.is_active = 1
ORDER BY first_name;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SamplesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SamplesGet`()
BEGIN
    SELECT * from wt_qc_samples;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SamplesGetByPlantAndDatetimeWhereNotComplete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SamplesGetByPlantAndDatetimeWhereNotComplete`(
    IN  p_plant_id INT(11),
    IN  p_date_id DATETIME
)
BEGIN
    SELECT * FROM wt_qc_samples 
    WHERE plant_id = p_plant_id
    AND dt = p_date_id
    AND is_complete = 0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SamplesInDateRangeGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SamplesInDateRangeGet`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME
)
BEGIN
    SELECT * from wt_qc_samples
    WHERE dt >= p_start_date AND
    dt <= p_end_date
    ORDER BY id DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SamplesInDateRangeGetFiltered` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SamplesInDateRangeGetFiltered`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT(11),
    IN  p_results_per_page INT(11),
    IN  p_is_complete VARCHAR(64),
    IN  p_test_type_ids VARCHAR(11),
    IN  p_composite_type_ids VARCHAR(64),
    IN  p_min_time TIME,
    IN  p_max_time TIME,
    IN  p_lab_tech_ids VARCHAR(64),
    IN  p_sampler_ids VARCHAR(64),
    IN  p_operator_ids VARCHAR(64),
    IN  p_site_ids VARCHAR(64),
    IN  p_plant_ids VARCHAR(64),
    IN  p_sample_location_ids VARCHAR(64),
    IN  p_specific_location_ids VARCHAR(64),
    IN  p_void_status_codes VARCHAR(8)
)
BEGIN
    SELECT * from wt_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date AND
    is_complete REGEXP p_is_complete AND
    test_type_id REGEXP p_test_type_ids AND
    composite_type_id REGEXP p_composite_type_ids AND
    ((time >= p_min_time AND time <= p_max_time)
    OR ((time >= p_min_time OR time <= p_max_time) AND p_min_time > p_max_time)) AND
    lab_tech REGEXP p_lab_tech_ids AND
    sampler REGEXP p_sampler_ids AND
    operator REGEXP p_operator_ids AND
    site_id REGEXP p_site_ids AND
    plant_id REGEXP p_plant_ids AND
    location_id REGEXP p_sample_location_ids AND
    specific_location_id REGEXP p_specific_location_ids AND
    void_status_code REGEXP p_void_status_codes
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SamplesInDateRangeGetFilteredv2` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SamplesInDateRangeGetFilteredv2`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT(11),
    IN  p_results_per_page INT(11),
    IN  p_is_complete VARCHAR(64),
    IN  p_test_type_ids VARCHAR(64),
    IN  p_composite_type_ids VARCHAR(64),
    IN  p_min_time TIME,
    IN  p_max_time TIME,
    IN  p_lab_tech_ids VARCHAR(64),
    IN  p_sampler_ids VARCHAR(64),
    IN  p_operator_ids VARCHAR(64),
    IN  p_site_ids VARCHAR(64),
    IN  p_plant_ids VARCHAR(64),
    IN  p_sample_location_ids VARCHAR(64),
    IN  p_specific_location_ids VARCHAR(64),
    IN  p_void_status_codes VARCHAR(8),
    IN  p_is_coa VARCHAR(1)
)
BEGIN
    SELECT * from wt_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date AND
    ((p_is_complete = '') OR (is_complete = p_is_complete)) AND
    ((p_test_type_ids = '') OR (FIND_IN_SET(test_type_id, p_test_type_ids) <> 0)) AND
    ((p_composite_type_ids = '') OR (FIND_IN_SET(composite_type_id, p_composite_type_ids) <> 0)) AND
    ((time >= p_min_time AND time <= p_max_time)
    OR ((time >= p_min_time OR time <= p_max_time) AND p_min_time > p_max_time)) AND
    ((p_lab_tech_ids = '') OR (FIND_IN_SET(lab_tech, p_lab_tech_ids) <> 0)) AND
    ((p_sampler_ids = '') OR (FIND_IN_SET(sampler, p_sampler_ids) <> 0)) AND
    ((p_operator_ids = '') OR (FIND_IN_SET(operator, p_operator_ids) <> 0)) AND
    ((p_site_ids = '') OR (FIND_IN_SET(site_id, p_site_ids) <> 0)) AND
    ((p_plant_ids = '') OR (FIND_IN_SET(plant_id, p_plant_ids) <> 0)) AND
    ((p_sample_location_ids = '') OR (FIND_IN_SET(location_id, p_sample_location_ids) <> 0)) AND
    ((p_specific_location_ids = '') OR (FIND_IN_SET(specific_location_id, p_composite_type_ids) <> 0)) AND
    ((p_void_status_codes = '') OR (FIND_IN_SET(void_status_code, p_void_status_codes) <> 0)) AND
    ((p_is_coa = '') OR (FIND_IN_SET(is_coa, p_is_coa) <> 0))
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SamplesInDateRangeGetIncludeVoided` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SamplesInDateRangeGetIncludeVoided`(
    IN  p_start_date DATETIME,
    IN  p_end_date DATETIME,
    IN  p_start_row INT,
    IN  p_results_per_page INT
)
BEGIN
    SELECT * from wt_qc_samples
    WHERE date >= p_start_date AND
    date <= p_end_date
    ORDER BY id DESC
    LIMIT p_start_row, p_results_per_page
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_wt_qc_SampleUpdate`(
    IN p_id INT(11),
    IN p_edit_dt DATETIME,
    IN p_edit_user_id BIGINT(20), 
    IN p_site_id INT(11),
    IN p_plant_id INT(11),
    IN p_dt DATETIME,
    IN p_test_type_id INT(11),
    IN p_composite_type_id INT(11),
    IN p_sieve_method_id INT(11),
    IN p_location_id INT(11),
    IN p_specific_location_id INT(11),
    IN p_date DATE,
    IN p_time TIME,
    IN p_date_short BIGINT(8),
    IN p_dt_short BIGINT(11),
    IN p_oversize_percent DECIMAL(5, 4),
    IN p_oversize_weight DECIMAL(5, 1),
    IN p_slimes_percent DECIMAL(5, 4),
    IN p_depth_to DECIMAL(5, 1),
    IN p_depth_from DECIMAL(5, 1),
    IN p_drillhole_no VARCHAR(50),
    IN p_description VARCHAR(50),
    IN p_sampler int(11),
    IN p_lab_tech int(11),
    IN p_operator int(11),
    IN p_beginning_wet_weight DECIMAL(5, 1),
    IN p_prewash_dry_weight DECIMAL(5, 1),
    IN p_postwash_dry_weight DECIMAL(5, 1),
    IN p_split_sample_weight DECIMAL(5, 1),
    IN p_moisture_rate DECIMAL(6, 4),
    IN p_notes VARCHAR(255),
    IN p_turbidity INT(11),
    IN p_k_value INT(11),
    IN p_k_pan_1 DECIMAL(7, 4),
    IN p_k_pan_2 DECIMAL(7, 4),
    IN p_k_pan_3 DECIMAL(7, 4),
    IN p_roundness DECIMAL(5, 1),
    IN p_sphericity DECIMAL(5, 1),
    IN p_group_time TIME,
    IN p_start_weights_raw TEXT,
    IN p_end_weights_raw TEXT,
    IN p_sieves_raw TEXT,
    IN p_sieves_total DECIMAL(5, 1),
    IN p_sieve_1_value DECIMAL(7, 4),
    IN p_sieve_2_value DECIMAL(7, 4),
    IN p_sieve_3_value DECIMAL(7, 4),
    IN p_sieve_4_value DECIMAL(7, 4),
    IN p_sieve_5_value DECIMAL(7, 4),
    IN p_sieve_6_value DECIMAL(7, 4),
    IN p_sieve_7_value DECIMAL(7, 4),
    IN p_sieve_8_value DECIMAL(7, 4),
    IN p_sieve_9_value DECIMAL(7, 4),
    IN p_sieve_10_value DECIMAL(7, 4),
    IN p_sieve_11_value DECIMAL(7, 4),
    IN p_sieve_12_value DECIMAL(7, 4),
    IN p_sieve_13_value DECIMAL(7, 4),
    IN p_sieve_14_value DECIMAL(7, 4),
    IN p_sieve_15_value DECIMAL(7, 4),
    IN p_sieve_16_value DECIMAL(7, 4),
    IN p_sieve_17_value DECIMAL(7, 4),
    IN p_sieve_18_value DECIMAL(7, 4),
    IN p_sieve_1_desc CHAR(3),
    IN p_sieve_2_desc CHAR(3),
    IN p_sieve_3_desc CHAR(3),
    IN p_sieve_4_desc CHAR(3),
    IN p_sieve_5_desc CHAR(3),
    IN p_sieve_6_desc CHAR(3),
    IN p_sieve_7_desc CHAR(3),
    IN p_sieve_8_desc CHAR(3),
    IN p_sieve_9_desc CHAR(3),
    IN p_sieve_10_desc CHAR(3),
    IN p_sieve_11_desc CHAR(3),
    IN p_sieve_12_desc CHAR(3),
    IN p_sieve_13_desc CHAR(3),
    IN p_sieve_14_desc CHAR(3),
    IN p_sieve_15_desc CHAR(3),
    IN p_sieve_16_desc CHAR(3),
    IN p_sieve_17_desc CHAR(3),
    IN p_sieve_18_desc CHAR(3),
    IN p_plus_70 DECIMAL(5, 4),
    IN p_plus_50 DECIMAL(5, 4),
    IN p_plus_40 DECIMAL(5, 4),
    IN p_minus_50_plus_140 DECIMAL(5,4),
    IN p_minus_40_plus_70 DECIMAL(5, 4),
    IN p_minus_70 DECIMAL(5, 4),
    IN p_minus_70_plus_140 DECIMAL(5, 4),
    IN p_minus_60_plus_70 DECIMAL(5, 4),
    IN p_minus_140_plus_325 DECIMAL(5, 4),
    IN p_minus_140 DECIMAL(5, 4),
    IN p_finish_dt DATETIME,
    IN p_duration DECIMAL(5, 2),
    IN p_duration_minutes DECIMAL(5, 1),
    IN p_is_coa TINYINT(1),
    IN p_near_size DECIMAL(5, 4),
    IN p_sand_height float,
    IN p_silt_height float,
    IN p_silt_percent float
)
BEGIN
UPDATE wt_qc_samples
    SET 
        edit_dt = p_edit_dt,
        edit_user_id = p_edit_user_id, 
        site_id = p_site_id,
        plant_id = p_plant_id,
        dt = p_dt,
        test_type_id = p_test_type_id,
        composite_type_id = p_composite_type_id,
        sieve_method_id = p_sieve_method_id,
        location_id = p_location_id,
        specific_location_id = p_specific_location_id, 
        date = p_date,
        time = p_time,
        date_short = p_date_short,
        dt_short = p_dt_short,
        oversize_percent = p_oversize_percent, 
        oversize_weight = p_oversize_weight, 
        slimes_percent = p_slimes_percent, 
        depth_to = p_depth_to, 
        depth_from = p_depth_from, 
        drillhole_no = p_drillhole_no,
        description = p_description,
        sampler = p_sampler,
        lab_tech = p_lab_tech,
        operator = p_operator,
        beginning_wet_weight = p_beginning_wet_weight,
        prewash_dry_weight = p_prewash_dry_weight,
        postwash_dry_weight = p_postwash_dry_weight,
        split_sample_weight = p_split_sample_weight,
        moisture_rate = p_moisture_rate,
        notes = p_notes,
        turbidity = p_turbidity,
        k_value = p_k_value,
        k_pan_1 = p_k_pan_1,
        k_pan_2 = p_k_pan_2,
        k_pan_3 = p_k_pan_3,
        roundness = p_roundness,
        sphericity = p_sphericity,
        group_time = p_group_time,
        start_weights_raw = p_start_weights_raw,
        end_weights_raw = p_end_weights_raw,
        sieves_raw = p_sieves_raw,
        sieves_total = p_sieves_total, 
        sieve_1_value = p_sieve_1_value, 
        sieve_2_value = p_sieve_2_value, 
        sieve_3_value = p_sieve_3_value, 
        sieve_4_value = p_sieve_4_value, 
        sieve_5_value = p_sieve_5_value, 
        sieve_6_value = p_sieve_6_value, 
        sieve_7_value = p_sieve_7_value, 
        sieve_8_value = p_sieve_8_value, 
        sieve_9_value = p_sieve_9_value, 
        sieve_10_value = p_sieve_10_value, 
        sieve_11_value = p_sieve_11_value, 
        sieve_12_value = p_sieve_12_value, 
        sieve_13_value = p_sieve_13_value, 
        sieve_14_value = p_sieve_14_value, 
        sieve_15_value = p_sieve_15_value, 
        sieve_16_value = p_sieve_16_value, 
        sieve_17_value = p_sieve_17_value, 
        sieve_18_value = p_sieve_18_value, 
        sieve_1_desc = p_sieve_1_desc,
        sieve_2_desc = p_sieve_2_desc,
        sieve_3_desc = p_sieve_3_desc,
        sieve_4_desc = p_sieve_4_desc,
        sieve_5_desc = p_sieve_5_desc,
        sieve_6_desc = p_sieve_6_desc,
        sieve_7_desc = p_sieve_7_desc,
        sieve_8_desc = p_sieve_8_desc,
        sieve_9_desc = p_sieve_9_desc,
        sieve_10_desc = p_sieve_10_desc,
        sieve_11_desc = p_sieve_11_desc,
        sieve_12_desc = p_sieve_12_desc,
        sieve_13_desc = p_sieve_13_desc,
        sieve_14_desc = p_sieve_14_desc,
        sieve_15_desc = p_sieve_15_desc,
        sieve_16_desc = p_sieve_16_desc,
        sieve_17_desc = p_sieve_17_desc,
        sieve_18_desc = p_sieve_18_desc,        
        plus_70 = p_plus_70,
        plus_50 = p_plus_50, 
        plus_40 = p_plus_40, 
        minus_50_plus_140 = p_minus_50_plus_140,
        minus_40_plus_70 = p_minus_40_plus_70, 
        minus_70 = p_minus_70, 
        minus_70_plus_140 = p_minus_70_plus_140, 
        minus_60_plus_70 = p_minus_60_plus_70,
        minus_140_plus_325 = p_minus_140_plus_325,
        minus_140 = p_minus_140, 
        finish_dt = p_finish_dt, 
        duration = p_duration, 
        duration_minutes = p_duration_minutes,
        is_coa = p_is_coa,
        near_size = p_near_size,
        sand_height = p_sand_height,
        silt_height = p_silt_height,
        silt_percent = p_silt_percent
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleVoid` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleVoid`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `wt_qc_samples` 
    SET `void_status_code`='V' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SampleVoidReverse` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleVoidReverse`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `wt_qc_samples` 
    SET `void_status_code`='A' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_sample_repeat_lock` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_wt_qc_sample_repeat_lock`(in p_labtech int(11), in p_sample_id int(11))
update wt_qc_samples set is_repeat_process = 1, is_repeat_labtech = p_labtech where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_sample_repeat_unlock` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`webdev`@`progdev001` PROCEDURE `sp_wt_qc_sample_repeat_unlock`(in p_sample_id int(11))
update wt_qc_samples set is_repeat_process = 0, is_repeat_labtech = null where id = p_sample_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_ShiftsGetBySiteAndDate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_ShiftsGetBySiteAndDate`(
    IN p_plant_id INT(11),
    IN p_time TIME
)
BEGIN
    SELECT * 
    FROM main_shifts 
    WHERE site_id = p_plant_id 
        AND p_time >= start_time 
    ORDER BY start_time DESC 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SieveInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SieveInsert`(
    IN p_sieve_stack_id INT(11),
    IN p_site_id int(11),
    IN p_screen_size varchar(16),
    IN p_start_weight decimal(5,1),
	IN p_serial_no varchar(32),
    IN p_sort_order int(11),
    IN p_user_id int(11)
    )
BEGIN
  INSERT INTO wt_qc_sieves 
    (sieve_stack_id, site_id, screen, start_weight, serial_no, sort_order, create_date, create_user_id) 
  VALUES 
    (p_sieve_stack_id, p_site_id, p_screen_size, p_start_weight, p_serial_no, p_sort_order, now(), p_user_id);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SievesGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SievesGetByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM wt_qc_sieves
WHERE sieve_stack_id = p_sieveStackId
and is_active=1
order by sort_order;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SieveStackGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SieveStackGetByID`(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM wt_qc_sieve_stacks
    WHERE id = p_sieveStackId
    ORDER BY sort_order ASC
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SieveStackInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SieveStackInsert`(
    IN p_description VARCHAR(64),
    IN p_main_site_id INT(11),
    IN p_is_camsizer TINYINT(1),
    IN p_user_id INT(11)
)
INSERT INTO wt_qc_sieve_stacks 
    (description, main_site_id, is_camsizer, last_cleaned, create_date, create_user_id)
  VALUES 
    (p_description, p_main_site_id, p_is_camsizer, now(), now(), p_user_id) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SieveStacksGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SieveStacksGet`()
BEGIN
    SELECT * from wt_qc_sieve_stacks WHERE is_active = '1' ORDER BY sort_order;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SieveStacksGetBySiteID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SieveStacksGetBySiteID`(
    IN  p_sieveStackSiteID int(11)
)
BEGIN
    SELECT * FROM wt_qc_sieve_stacks
    WHERE main_site_id = p_sieveStackSiteID
    AND is_active = 1
    ORDER BY sort_order ASC; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SieveStackUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SieveStackUpdate`(IN p_id int(11), IN p_description varchar(64), IN p_site_id int(11), p_is_camsizer tinyint(1), p_sort_order int(11), p_is_active tinyint(1), p_modify_user_id int(11))
update wt_qc_sieve_stacks 
set 
description = p_description,
main_site_id = p_site_id,
is_camsizer = p_is_camsizer,
sort_order = p_sort_order,
is_active = p_is_active,
modify_date = now(),
modify_user_id = p_modify_user_id
where
id=p_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SieveStartingWeightUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SieveStartingWeightUpdate`(
    IN p_start_weight DECIMAL(5,1),
    IN p_sieve_stack_id INT(11),
    IN p_screen VARCHAR(16)
)
BEGIN
    UPDATE wt_qc_sieves 
    SET start_weight = p_start_weight 
    WHERE sieve_stack_id = p_sieve_stack_id 
        AND screen = p_screen;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SieveUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SieveUpdate`(
IN p_id int(11),
IN p_stack_id int(11),
IN p_site_id int(11),
IN p_serial_no varchar(32),
IN p_screen varchar(16),
IN p_start_weight decimal(5,1),
IN p_is_active tinyint(1),
IN p_sort_order int(11),
IN p_user_id int(11)
)
update wt_qc_sieves 
set 
site_id = p_site_id,
sieve_stack_id = p_stack_id,
serial_no = p_serial_no,
screen = p_screen,
start_weight = p_start_weight,
is_active = p_is_active,
sort_order = p_sort_order,
edit_date = now(),
edit_user_id = p_user_id
where
id = p_id and sieve_stack_id = p_stack_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SiteGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SiteGetByID`(
    IN  p_site_id INT(11)
)
BEGIN
    SELECT * FROM main_sites 
    WHERE id = p_site_id
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SpecificLocationGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SpecificLocationGetByID`(
    IN  p_specific_location_id INT(11)
)
BEGIN
    SELECT * FROM wt_qc_locations_details 
    WHERE id = p_specific_location_id
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SpecificLocationsGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SpecificLocationsGet`()
BEGIN
    SELECT sp.id, sp.qc_location_id, sp.description, sp.sort_order, sp.is_active, l.main_site_id as site, l.main_plant_id as plant  from wt_qc_locations_details sp
    join gb_qc_locations l 
    on qc_location_id = l.id
    WHERE sp.is_active = 1
    ORDER BY sort_order ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_SpecificLocationsGetByLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SpecificLocationsGetByLocation`(
    IN  p_locationId int(11)
)
BEGIN
SELECT * FROM wt_qc_locations_details 
    WHERE is_active = 1 
    AND qc_location_id = p_locationId 
    ORDER BY sort_order ASC; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_TestTypeGetByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_TestTypeGetByID`(
    IN  p_testTypeId varchar(64)
)
BEGIN
SELECT * FROM wt_qc_test_types
    WHERE id = p_testTypeId
LIMIT 1; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_TestTypesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_TestTypesGet`()
BEGIN
    SELECT * from wt_qc_test_types;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_ThresholdsInsert` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_ThresholdsInsert`(
    IN p_screen VARCHAR(16),
    IN p_location_id INT(11),
    IN p_low_threshold DOUBLE,
    IN p_high_threshold DOUBLE
)
BEGIN
INSERT INTO wt_qc_thresholds
(
    screen, 
    location_id, 
    low_threshold, 
    high_threshold
) 
VALUES 
(
    p_screen, 
    p_location_id, 
    p_low_threshold, 
    p_high_threshold
);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_ThresholdsUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_ThresholdsUpdate`(
    IN p_id INT(11),
    IN p_screen VARCHAR(16),
    IN p_location_id INT(11),
    IN p_low_threshold DOUBLE,
    IN p_high_threshold DOUBLE,
    IN p_is_active TINYINT(1)
)
BEGIN
    UPDATE wt_qc_thresholds
    SET 
    `screen` = p_screen,
    `location_id` = p_location_id,
    `low_threshold` = p_low_threshold,
    `high_threshold` = p_high_threshold,
    `is_active` = p_is_active
    WHERE `id` = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_UsesGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_UsesGet`(IN p_sieve_method_id int(11))
select sieve_method_id from wt_qc_samples where sieve_method_id = p_sieve_method_id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_UsesSinceLastCleanedGet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_UsesSinceLastCleanedGet`(IN p_sieve_method_id int(11), IN p_dt datetime)
select sieve_method_id, dt from wt_qc_samples where sieve_method_id = p_sieve_method_id and dt > p_dt ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_wt_qc_VoidSample` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_VoidSample`(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `wt_qc_samples` 
    SET `void_status_code`='V' 
    WHERE id = p_sample_id; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-22 22:08:34
