
/*******************************************************************************************************************************************
 * File Name: tblConfigProdArea.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/09/2018|whildebrandt|KACE:20499 - Copied tblConfigProdArea to SilicorePLC to house prod area data from ESP.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('tblConfigProdArea') IS NOT NULL 
	DROP PROCEDURE 'tblConfigProdArea'; 
CREATE TABLE [dbo].[tblConfigProdArea](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[Facility] [varchar](50) NOT NULL,
	[ProdArea] [varchar](50) NOT NULL
) ON [PRIMARY]
GO



