
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_10MinuteNewRecordsGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/09/2018|whildebrandt|KACE:xxxxx - Initial creation
 *
 ******************************************************************************************************************************************/
USE [DataForTransfer]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

IF OBJECT_ID('sp_gb_plc_10MinuteNewRecordsGet') IS NOT NULL 
	DROP PROCEDURE 'sp_gb_plc_10MinuteNewRecordsGet'; 

CREATE PROCEDURE [dbo].[sp_gb_plc_10MinuteNewRecordsGet]

	@Id int
AS
BEGIN

	SET NOCOUNT ON;
	SELECT TableIndex, TagTimestamp, TagItemID, TagValue, TagQuality 
	FROM [dbo].[TOPServerAnalogData10MinuteInterval]
	WHERE TableIndex > @Id
	AND
	TagQuality = 192;

	
END
GO





