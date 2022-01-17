
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_DowntimeByIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/29/2017|whildebrandt|KACE:19563 - Created stored procedure that returns downtimes by id from Downtime table.
 *
 ******************************************************************************************************************************************/
USE [DataForTransfer]

IF OBJECT_ID('sp_gb_plc_DowntimeByIdGet') IS NOT NULL 
DROP PROCEDURE sp_gb_plc_DowntimeByIdGet;

GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


CREATE PROCEDURE [dbo].[sp_gb_plc_DowntimeByIdGet]
@id int
AS
BEGIN
SELECT 
	id,
  DtId, 
	ShiftId, 
	DtEnd, 
	DtAmount, 
	DtReason, 
	DeviceName, 
	Comment
FROM 
    DownTime
WHERE 
    id > @id
ORDER BY id
END

GO







