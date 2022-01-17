
/*******************************************************************************************************************************************
 * File Name: IdleTime.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/12/2018|whildebrandt|KACE:20499 - Initial creation
 *
 ******************************************************************************************************************************************/

USE [SilicorePLC]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('IdleTime') IS NOT NULL 
	DROP PROCEDURE 'IdleTime'; 
CREATE TABLE [dbo].[IdleTime](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[ItId] [int] NOT NULL,
	[ShiftId] [int] NOT NULL,
	[ItEnd] [datetime] NULL,
	[ItReason] [nvarchar](50) NULL,
	[ItAmount] [int] NULL,
	[Comment] [nvarchar](131) NULL
) ON [PRIMARY]
GO





