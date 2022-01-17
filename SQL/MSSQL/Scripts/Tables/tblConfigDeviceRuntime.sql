
/*******************************************************************************************************************************************
 * File Name: tblConfigDeviceRuntime.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/09/2018|whildebrandt|KACE:20499 - A copy of tblConfigDeviceRuntime for SilicorePLC. This table contains definitions for tags from ESP.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('tblConfigDeviceRuntime') IS NOT NULL 
	DROP PROCEDURE 'tblConfigDeviceRuntime'; 
CREATE TABLE [dbo].[tblConfigDeviceRuntime](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[DeviceName] [varchar](50) NOT NULL,
	[RuntimeDesc] [varchar](50) NULL,
	[RuntimeTag] [varchar](50) NULL,
	[ProdAreaId] [int] NULL
) ON [PRIMARY]
GO



