
/*******************************************************************************************************************************************
 * File Name: Downtime.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/09/2018|whildebrandt|KACE:20499 - Created Downtime table for SilicorePLC. Houses downtime duration coming from ESP.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('Downtime') IS NOT NULL 
	DROP PROCEDURE 'Downtime'; 
CREATE TABLE [dbo].[Downtime](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[DtId] [int] NOT NULL,
	[ShiftId] [int] NOT NULL,
	[DtEnd] [datetime] NULL,
	[DtAmount] [int] NULL,
	[DtReason] [nvarchar](50) NULL,
	[DeviceName] [nvarchar](50) NULL,
	[Comment] [nvarchar](131) NULL
) ON [PRIMARY]
GO



