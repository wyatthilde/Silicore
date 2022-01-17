
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ProdTotalUpdate.sql
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
DROP PROCEDURE [dbo].[sp_gb_plc_ProdTotalUpdate]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_gb_plc_ProdTotalUpdate] 
AS
BEGIN
	SET NOCOUNT ON;
	declare @ptId int
	IF (Select max( PtId ) from dbo.ProdTotal) IS NOT NULL
		BEGIN
		set @ptId = (Select max( PtId ) from dbo.ProdTotal)
		END
	ELSE
		BEGIN
		set @ptId = 0
		END
	Insert into SilicorePLC.dbo.ProdTotal 
	SELECT 
		oprPT.Id as PtID,
		oprPT.ShiftId,
		oprPT.TotalVal,
		opcCS.TotalDesc,
		opcCS.ProdType		
	From  OpenPlantRuntime.dbo.tblProdTotal as oprPT, OpenPlantConfig.dbo.tblConfigScale as opcCS
	Where oprPT.ConfigScaleId = opcCS.Id and
		  oprPT.Id > @ptID
END
GO





