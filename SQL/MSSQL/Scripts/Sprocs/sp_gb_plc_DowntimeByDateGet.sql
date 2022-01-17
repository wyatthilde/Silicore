
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_DowntimeByDateGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/29/2017|whildebrandt|KACE:19563 - Created stored procedure to get downtime by date from Downtime
 *
 ******************************************************************************************************************************************/
USE [DataForTransfer]

IF OBJECT_ID('sp_gb_plc_DowntimeByDateGet') IS NOT NULL 
DROP PROCEDURE sp_gb_plc_DowntimeByDateGet;

GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


CREATE PROCEDURE [dbo].[sp_gb_plc_DowntimeByDateGet]
@date datetime
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
    DtEnd >= @date 
ORDER BY id
END

GO





