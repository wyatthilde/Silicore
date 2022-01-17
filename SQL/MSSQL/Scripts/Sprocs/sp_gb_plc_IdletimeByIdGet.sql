
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_IdletimeByIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/04/2017|whildebrandt|KACE:19563 - Initial creation
 *
 ******************************************************************************************************************************************/

USE [DataForTransfer]

IF OBJECT_ID('sp_gb_plc_IdletimeByIdGet') IS NOT NULL 
DROP PROCEDURE sp_gb_plc_IdletimeByIdGet;

GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO




CREATE PROCEDURE [dbo].[sp_gb_plc_IdletimeByIdGet]
@id int
AS
BEGIN
SELECT 
	id,
  ItId, 
	ShiftId, 
	ItEnd,
	ItReason, 
	ItAmount, 
	Comment
FROM 
    IdleTime
WHERE 
    id > @id
ORDER BY id
END

GO





