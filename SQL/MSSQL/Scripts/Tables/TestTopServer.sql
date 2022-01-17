
/*******************************************************************************************************************************************
 * File Name: TestTopServer.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/21/2017|whildebrandt|KACE:xxxxx - Initial creation
 *
 ******************************************************************************************************************************************/

USE [SilicorePLC]
GO

/****** Object:  Table [dbo].[TestTopServer]    Script Date: 9/21/2017 3:07:21 PM ******/
DROP TABLE [dbo].[TestTopServer]
GO

/****** Object:  Table [dbo].[TestTopServer]    Script Date: 9/21/2017 3:07:21 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[TestTopServer](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[Timestamp] [datetime] NOT NULL,
	[Name] [varchar](50) NOT NULL,
	[Value] [varchar](50) NULL,
	[Quality] [int] NOT NULL
) ON [PRIMARY]
GO



