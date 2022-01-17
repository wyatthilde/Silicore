
/*******************************************************************************************************************************************
 * File Name: Runtime.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/09/2018|whildebrandt|KACE:20499 - Created Runtime table for SilicorePLC. Houses runtime duration and tag data from ESP.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('Runtime') IS NOT NULL 
	DROP PROCEDURE 'Runtime'; 
CREATE TABLE [dbo].[Runtime](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[RtId] [int] NOT NULL,
	[ShiftId] [int] NOT NULL,
	[Runtime] [int] NOT NULL,
	[RuntimeDescription] [varchar](50) NOT NULL,
	[Tag] [varchar](50) NOT NULL,
 CONSTRAINT [PK_Runtimes] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO



