/*******************************************************************************************************************************************
 * File Name: PLC_AnalogTagHourlyTotal.sql
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

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[PLC_AnalogTagHourlyTotals]') AND type in (N'U'))
DROP TABLE [dbo].[PLC_AnalogTagHourlyTotals]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[PLC_AnalogTagHourlyTotals](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[Timestamp] [datetime] NOT NULL,
	[Name] [varchar](50) NOT NULL,
	[Value] [varchar](50) NULL,
	[Quality] [int] NOT NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

SELECT * FROM PLC_AnalogTagHourlyTotals;


