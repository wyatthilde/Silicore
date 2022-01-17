
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ShiftUpdate.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/12/2018|whildebrandt|KACE:20499 - Gets shift data from ESP table.
 *
 ******************************************************************************************************************************************/
USE [SilicorePLC]
GO
DROP PROCEDURE [dbo].[sp_gb_plc_ShiftUpdate]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_gb_plc_ShiftUpdate] 
AS
BEGIN
	SET NOCOUNT ON;
	declare @shiftId int
	IF (Select max( ShiftId ) from dbo.Shifts) IS NOT NULL
		BEGIN
		set @shiftId = (Select max( ShiftId ) from dbo.Shifts)
		END
	ELSE
		BEGIN
		set @shiftId = 0
		END
	Insert into SilicorePLC.dbo.Shifts 
	SELECT 
		oprShift.Id as ShiftID,
		oprShift.ProdAreaId ,
		opcPA.ProdArea,
		oprShift.StartDate,
		oprShift.EndDate,
		oprShift.OperatorName,
		oprShift.TimeMin
	From  OpenPlantRuntime.dbo.tblShift as oprShift, OpenPlantConfig.dbo.tblConfigProdArea as opcPA
	Where oprShift.ProdAreaId = opcPA.Id and
		  oprShift.Id > @shiftID 
	UPDATE SilicorePLC.dbo.Shifts
	 set EndDate = oprShift.EndDate
	 from OpenPlantRuntime.dbo.tblShift as oprShift
	 where ShiftId = oprShift.Id and
		   oprShift.EndDate is not null and
		   SilicorePLC.dbo.Shifts.EndDate is null
	UPDATE SilicorePLC.dbo.Shifts
	 set TimeMin = oprShift.TimeMin
	 from OpenPlantRuntime.dbo.tblShift as oprShift
	 where ShiftId = oprShift.Id and
	       oprShift.TimeMin is not null and
		   SilicorePLC.dbo.Shifts.TimeMin is null
END
GO





