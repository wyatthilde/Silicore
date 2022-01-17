
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

IF OBJECT_ID('sp_gb_plc_ProductsByDateGet') IS NOT NULL 
DROP PROCEDURE sp_gb_plc_ProductsByDateGet;

GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


CREATE PROCEDURE [dbo].[sp_gb_plc_ProductsByDateGet]

@date datetime

AS

BEGIN

SELECT ProdTotal.Id, PtId, ProdTotal.ShiftId, TotalVal, TotalDesc, ProdType, Shift.StartDate, Shift.EndDate

FROM ProdTotal

JOIN Shift ON Shift.ShiftId = ProdTotal.ShiftId

WHERE StartDate >= @date

ORDER BY ProdTotal.ShiftId

END
GO





