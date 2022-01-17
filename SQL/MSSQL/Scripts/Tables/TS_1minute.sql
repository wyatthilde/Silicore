
/*******************************************************************************************************************************************
 * File Name: TS_1minute.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/27/2017|whildebrandt|KACE:18866 - Initial creation
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

IF OBJECT_ID('dbo.TS_1minute') IS NOT NULL 
	DROP TABLE dbo.TS_1minute; 

CREATE TABLE [dbo].[TS_1minute](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[Timestamp] [datetime] NOT NULL,
	[Name] [varchar](50) NOT NULL,
	[Value] [float] NULL,
	[Quality] [int] NOT NULL
) ON [PRIMARY]
GO





