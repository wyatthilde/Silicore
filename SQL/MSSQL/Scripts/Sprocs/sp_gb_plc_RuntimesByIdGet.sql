
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RuntimesByIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/27/2017|whildebrandt|KACE:19563 - created stored procedure to sort runtimes by given Id
 * 11/29/2017|whildebrandt|KACE:19563 - updated RuntimesByIdGet to include join on shift table
 ******************************************************************************************************************************************/
USE [DataForTransfer]
IF OBJECT_ID('sp_gb_plc_RuntimesByIdGet') IS NOT NULL 
DROP PROCEDURE sp_gb_plc_RuntimesByIdGet; 
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_gb_plc_RuntimesByIdGet]
@Id int
AS
BEGIN
SELECT Runtimes.Id, RtId, Runtimes.ShiftId, Runtime, RuntimeDescription, Tag, StartDate, EndDate
FROM Runtimes
JOIN 
Shift ON Shift.ShiftId = Runtimes.ShiftId 
WHERE Runtimes.Id > @Id
ORDER BY Id
END
GO

