
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RuntimeUpdate.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/12/2018|whildebrandt|KACE:20499 - Get runtime data from esp table.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO
DROP PROCEDURE [dbo].[sp_gb_plc_RuntimeUpdate]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_gb_plc_RuntimeUpdate]
AS
BEGIN
	SET NOCOUNT ON;
	declare @rtId int
	IF (Select max( RtId ) from dbo.Runtime) IS NOT NULL
		BEGIN
		set @rtId = (Select max( RtId ) from Runtime)
		END
	ELSE
		BEGIN
		set @rtId = 0
		END
	Insert into SilicorePLC.dbo.Runtime
	SELECT 
		oprPR.Id as RtID,
		oprPR.ShiftId,
		oprPR.Runtime,
		opcDR.RuntimeDesc,
		opcDR.RuntimeTag
	From  OpenPlantRuntime.dbo.tblRuntime as oprPR, OpenPlantConfig.dbo.tblConfigDeviceRuntime as opcDR
	Where oprPR.ConfigRuntimeId = opcDR.Id and
		  oprPR.Id > @rtID    
END
GO





