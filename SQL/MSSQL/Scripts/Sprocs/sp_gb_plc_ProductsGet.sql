
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ProductsGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/

/*    ==Scripting Parameters==

    Source Server Version : SQL Server 2008 R2 (10.50.4000)
    Source Database Engine Edition : Microsoft SQL Server Standard Edition
    Source Database Engine Type : Standalone SQL Server

    Target Server Version : SQL Server 2008 R2
    Target Database Engine Edition : Microsoft SQL Server Standard Edition
    Target Database Engine Type : Standalone SQL Server
*/

USE [SilicorePLC]
GO

/****** Object:  StoredProcedure [dbo].[sp_gb_plc_ProductsGet]    Script Date: 11/15/2017 2:49:14 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

IF OBJECT_ID(`sp_gb_plc_ProductsGet`) IS NOT NULL 
	DROP PROCEDURE `sp_gb_plc_ProductsGet`; 

CREATE PROCEDURE [dbo].[sp_gb_plc_ProductsGet]
@id int
AS
BEGIN
SELECT Id, PtId, ShiftId, TotalVal, TotalDesc, ProdType
FROM ProdTotal
WHERE Id > @id
ORDER BY ShiftId
END
GO



