
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_DowntimeUpdate.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/12/2018|whildebrandt|KACE:20499 - Shannon Looper Sproc to get data from ESP table.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('sp_gb_plc_DowntimeUpdate') IS NOT NULL 
	DROP PROCEDURE 'sp_gb_plc_DowntimeUpdate'; 
CREATE PROCEDURE [dbo].[sp_gb_plc_DowntimeUpdate]
AS
BEGI
	SET NOCOUNT ON;
	declare @dtId int
	IF (Select max( DtId ) from dbo.Downtime) IS NOT NULL
		BEGIN
		set @dtId = (Select max( DtId ) from dbo.Downtime)
		END
	ELSE
		BEGIN
		set @dtId = 0
		END
	Insert into SilicorePLC.dbo.Downtime  
	SELECT 
		oprDTR.Id as DtID,
		oprDTR.ShiftId,
		oprDTR.DtEnd,
		oprDTR.DtAmount,
		oprDTRTx.DtDesc as DtReason,
		oprDTR.DeviceName,
		oprDTR.Comment
	From  OpenPlantRuntime.dbo.tblDTReason as oprDTR, OpenPlantRuntime.dbo.tblDTReasonText as oprDTRTx
	Where oprDtr.DtReasonId = oprDTRTx.Id and
		  oprDTR.Id > @dtID
END
GO



