
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_1MinuteMaxGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/29/2017|whildebrandt|KACE:17349 - Initial creation
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

IF OBJECT_ID('sp_gb_plc_1MinuteNewRecordsGet') IS NOT NULL 
	DROP PROCEDURE 'sp_gb_plc_1MinuteNewRecordsGet'; 

CREATE PROCEDURE [dbo].[sp_gb_plc_1MinuteNewRecordsGet]

	@Id int
AS
BEGIN

	SET NOCOUNT ON;
	SELECT Id, Timestamp, Name, Value, Quality 
	FROM [dbo].[TS_1minute]
	WHERE Id > @Id;

	
END
GO





