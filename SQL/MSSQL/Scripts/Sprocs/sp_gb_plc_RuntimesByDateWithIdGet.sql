
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RuntimesByDateWithIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/27/2017|whildebrandt|KACE:19563 - Created stored procedure to get runtimes where they match on the shift table by their id
 *
 ******************************************************************************************************************************************/
USE [DataForTransfer]
IF OBJECT_ID('sp_gb_plc_RuntimesByDateWithIdGet') IS NOT NULL 
DROP PROCEDURE sp_gb_plc_RuntimesByDateWithIdGet; 
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_gb_plc_RuntimesByDateWithIdGet]
@startDate datetime
AS
BEGIN
SELECT Runtimes.Id, RtId, Runtimes.ShiftId, Runtime, RuntimeDescription, Tag, StartDate, EndDate
FROM Runtimes
JOIN 
Shift ON Shift.ShiftId = Runtimes.ShiftId 
WHERE Shift.StartDate >= @startDate
ORDER BY Runtimes.Id
END
GO




