/*******************************************************************************************************************************************
 * File Name: sp_plc_AnalogTagsHourlyTotalsGetAll.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/09/2017|kkuehn|KACE:16842 - Initial creation
 * 
 ******************************************************************************************************************************************/

USE [SilicorePLC]
GO

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[sp_plc_AnalogTagHourlyTotalsGetAll]') AND type in (N'P', N'PC'))
DROP PROCEDURE [dbo].[sp_plc_AnalogTagHourlyTotalsGetAll]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


CREATE PROCEDURE [dbo].[sp_plc_AnalogTagHourlyTotalsGetAll]

AS

BEGIN

  SELECT Id,Timestamp,Name,Value,Quality
  FROM PLC_AnalogTagHourlyTotals
  WHERE Quality = 192

END

GO

exec sp_plc_AnalogTagHourlyTotalsGetAll;