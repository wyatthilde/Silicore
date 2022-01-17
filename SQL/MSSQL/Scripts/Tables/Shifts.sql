
/*******************************************************************************************************************************************
 * File Name: Shifts.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/09/2018|whildebrandt|KACE:20499 - Created Shifts table in SilicorePLC. Houses shift data from ESP.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('Shifts') IS NOT NULL 
	DROP PROCEDURE 'Shifts'; 
CREATE TABLE [dbo].[Shifts](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[ShiftId] [int] NOT NULL,
	[ProdAreaId] [int] NOT NULL,
	[ProdArea] [nvarchar](50) NULL,
	[StartDate] [datetime] NOT NULL,
	[EndDate] [datetime] NULL,
	[OperatorName] [varchar](50) NULL,
	[TimeMin] [int] NULL
) ON [PRIMARY]
GO



