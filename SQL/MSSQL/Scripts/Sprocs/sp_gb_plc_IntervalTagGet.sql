
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_IntervalTagGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/11/2017|whildebrandt|KACE:16787 - Created sproc to return tags on a date
 *
 ******************************************************************************************************************************************/


USE [DataForTransfer]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

IF OBJECT_ID('sp_gb_plc_IntervalTagGet') IS NOT NULL 
	DROP PROCEDURE 'sp_gb_plc_IntervalTagGet'; 

CREATE PROCEDURE [dbo].[sp_gb_plc_IntervalTagGet]
@timestamp datetime
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
        ad.TagTimestamp >= @timestamp

    UNION 

    SELECT 
        ad.TableIndex, ad.TagItemID, ad.TagValue, ad.TagTimestamp, 60 interval_seconds 
    FROM 
        TOPServerAnalogData1MinuteInterval ad 
    WHERE 
        ad.TagQuality = 192 and 
        ad.TagTimestamp >= @timestamp
    )t  
ORDER BY TagTimestamp
END

GO





