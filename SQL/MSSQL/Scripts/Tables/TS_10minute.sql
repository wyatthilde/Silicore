
/*******************************************************************************************************************************************
 * File Name: TS_10minute.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/27/2017|whildebrandt|KACE:18866 - Initial creation
 *
 ******************************************************************************************************************************************/

/*    ==Scripting Parameters==

    Source Server Version : SQL Server 2008 R2 (10.50.4000)
    Source Database Engine Edition : Microsoft SQL Server Standard Edition
    Source Database Engine Type : Standalone SQL Server

    Target Server Version : SQL Server 2008 R2
    Target Database Engine Edition : Microsoft SQL Server Standard Edition
    Target Database Engine Type : Standalone SQL Server
*/

USE [SilicorePLC]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

IF OBJECT_ID('dbo.TS_10minute') IS NOT NULL 
	DROP TABLE dbo.TS_10minute; 

CREATE TABLE [dbo].[TS_10minute](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[Timestamp] [datetime] NOT NULL,
	[Name] [varchar](50) NOT NULL,
	[Value] [float] NULL,
	[Quality] [int] NOT NULL
) ON [PRIMARY]
GO





