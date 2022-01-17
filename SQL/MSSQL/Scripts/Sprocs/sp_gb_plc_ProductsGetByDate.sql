
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ProductsGetByDate.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/22/2017|whildebrandt|KACE:16787 - Initial creation
 *
 ******************************************************************************************************************************************/

USE [DataForTransfer]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

IF OBJECT_ID(`sp_gb_plc_ProductsGetByDate`) IS NOT NULL 
DROP PROCEDURE `sp_gb_plc_ProductsGetByDate`;
 
CREATE PROCEDURE [dbo].[sp_gb_plc_ProductsGetByDate]

AS

BEGIN

SELECT ProdTotal.Id, PtId, ProdTotal.ShiftId, TotalVal, TotalDesc, ProdType, Shift.StartDate, Shift.EndDate

FROM ProdTotal

JOIN Shift ON Shift.ShiftId = ProdTotal.ShiftId

WHERE StartDate >= '2017-10-31'

ORDER BY ProdTotal.ShiftId

END
GO




