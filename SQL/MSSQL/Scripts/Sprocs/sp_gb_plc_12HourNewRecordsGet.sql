
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_12HourNewRecordsGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 04/02/2018|whildebrandt|KACE:22003 - Gets new records from TS_12Hour table.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO

DROP PROCEDURE [dbo].[sp_gb_plc_12HourNewRecordsGet]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[sp_gb_plc_12HourNewRecordsGet]

	@Id int
AS
BEGIN

	SET NOCOUNT ON;
	SELECT Id, Name, Timestamp, Value, Quality 
	FROM [dbo].[TS_12Hour]
	WHERE Id > @Id;

END
GO





