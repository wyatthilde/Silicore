
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_Silicore10MinuteNewRecordsGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/15/2018|whildebrandt|KACE:20499 - Initial creation
 *
 ******************************************************************************************************************************************/

USE [SilicorePLC]

IF OBJECT_ID('sp_gb_plc_Silicore10MinuteNewRecordsGet') IS NOT NULL 
DROP PROCEDURE sp_gb_plc_Silicore10MinuteNewRecordsGet;

GO


SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


CREATE PROCEDURE [dbo].[sp_gb_plc_Silicore10MinuteNewRecordsGet]

	@Id int
AS
BEGIN

	SET NOCOUNT ON;
	SELECT Id, Name, Timestamp, Value, Quality 
	FROM [dbo].[TS_10minute]
	WHERE Id > @Id;

	
END
GO




