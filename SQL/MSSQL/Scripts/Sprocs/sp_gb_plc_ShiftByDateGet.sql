
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ShiftByDateGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/01/2017|whildebrandt|KACE:19563 - Created stored procedure to get date from shift table
 *
 ******************************************************************************************************************************************/
USE [DataForTransfer]

IF OBJECT_ID('sp_gb_plc_ShiftByDateGet') IS NOT NULL 
DROP PROCEDURE sp_gb_plc_ShiftByDateGet;

GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


CREATE PROCEDURE [dbo].[sp_gb_plc_ShiftByDateGet]
@date datetime
AS
BEGIN
SELECT 
	Id,
	ShiftId,
	ProdAreaId,
	ProdArea,
	StartDate,
	EndDate,
	OperatorName,
	TimeMin
FROM 
    Shift
WHERE 
    StartDate > @date
ORDER BY id
END

GO




