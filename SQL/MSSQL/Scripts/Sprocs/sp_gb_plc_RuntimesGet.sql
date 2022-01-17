
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RuntimesGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 05/17/2018|whildebrandt|KACE:20499 - Gets runtimes from shift with idletime and downtime times and their reasons.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO



CREATE PROCEDURE [dbo].[sp_gb_plc_RuntimesGet]
@shiftId int
AS
BEGIN

SELECT s.Id, s.StartDate, s.EndDate, s.OperatorName, s.ProdAreaId, s.TimeMin, r.Runtime, i.ItAmount, i2.Code, d.DtAmount, d2.Code
FROM [OpenPlantRuntime].[dbo].[tblShift] AS s 
LEFT JOIN [OpenPlantRuntime].[dbo].[tblRuntime] AS r ON r.ShiftId = s.Id
LEFT JOIN OpenPlantRuntime.dbo.tblITReason as i ON i.ShiftId = s.Id
LEFT JOIN OpenPlantRuntime.dbo.tblDTReason as d on d.ShiftId = s.Id
LEFT JOIN OpenPlantRuntime.dbo.tblITReasonText as i2 on i2.Id = i.Id
LEFT JOIN OpenPlantRuntime.dbo.tblITReasonText as d2 on d2.Id = d.Id
WHERE s.Id = @shiftId
		  
	
END
GO




