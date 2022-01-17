
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_IntervalTagByIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/11/2017|whildebrandt|KACE:16787 - Created a sproc to get tags by id from top server.
 *
 ******************************************************************************************************************************************/

USE [DataForTransfer]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

IF OBJECT_ID('sp_gb_plc_IntervalTagByIdGet') IS NOT NULL 
	DROP PROCEDURE 'sp_gb_plc_IntervalTagByIdGet'; 

CREATE PROCEDURE [dbo].[sp_gb_plc_IntervalTagByIdGet]
@60id int, @600id int
AS
BEGIN
SELECT 
    TableIndex, TagItemID, TagValue, TagTimestamp, interval_seconds 
FROM 
    ( 
    SELECT 
        ad.TableIndex, ad.TagItemID, ad.TagValue, ad.TagTimestamp, 600 interval_seconds 
    FROM 
        TOPServerAnalogData10MinuteInterval ad 
    WHERE 
        ad.TagQuality = 192 and 
        ad.TableIndex > @600id

    UNION 

    SELECT 
        ad.TableIndex, ad.TagItemID, ad.TagValue, ad.TagTimestamp, 60 interval_seconds 
    FROM 
        TOPServerAnalogData1MinuteInterval ad 
    WHERE 
        ad.TagQuality = 192 and 
        ad.TableIndex > @60id
    )t  
ORDER BY TagTimestamp
END

GO





