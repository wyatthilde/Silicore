
/*******************************************************************************************************************************************
 * File Name: ProdTotal.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/09/2018|whildebrandt|KACE:20499 - Created ProdTotal table for SilicorePLC.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('ProdTotal') IS NOT NULL 
	DROP PROCEDURE 'ProdTotal'; 
CREATE TABLE [dbo].[ProdTotal](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[PtId] [int] NOT NULL,
	[ShiftId] [int] NOT NULL,
	[TotalVal] [int] NULL,
	[TotalDesc] [nvarchar](50) NULL,
	[ProdType] [nvarchar](50) NULL
) ON [PRIMARY]
GO




