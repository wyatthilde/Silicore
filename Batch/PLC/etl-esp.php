<?php
/* * *****************************************************************************************************************************************
 * File Name: etl-esp.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/24/2017|kkuehn|KACE:16787 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
//require_once('security.php');
//require_once ('Security/dbaccess.php');
ini_set('max_execution_time', 1200); //300 seconds = 5 minutes

$debug = 0; // Set to 0 when not debugging


if ($debug)
{
  //set variable for tracking execution time (start)
  $StartTimestamp = microtime(true);
}

//set batch variable to bypass user authentication
$isBatch = 1;

// set static conn strings instead of includes:
//connect to mysql database
//$mysqliConn = mysqli_connect("localhost", "vistadw_vista", "Baylor22", "vistadw_vistasand") or die("Error: " . mysqli_error($mysqliConn));
$mysqliConn = mysqli_connect("localhost", "webdev", "Vista1!", "silicore_site") or die("Cannot connect to silicore database.");

/* turn autocommit on */
mysqli_autocommit($mysqliConn, TRUE);
//Start funtctions
//
//gets short date with time
function getDtShort($dt) {
	$output = substr(date("YmdHi", strtotime($dt)), 0, 11); 
	
	return $output;
}
//gets short date without time
function getDateShort($date) {
	$output = substr(date("Ymd", strtotime($date)), 0, 8); 
	
	return $output;
}

function siloInventoryIsHourFirstReading($siloId, $dt) {
	$mysqliConn = mysqli_connect("localhost", "webdev", "Vista1!", "silicore_site") or die("Cannot connect to silicore database.");
	
	$dtTopOfHour = date("Y-m-d", strtotime($dt)).' '.substr(date("H", strtotime($dt)), 0, 10).':00:00';
	
	$reportSql = mysqli_query($mysqliConn, '
	select 
		count(id) record_count 
	from 
		prod_inventory_silos 
	where 
		dt >= "'.$dtTopOfHour.'" and 
		silo_id = "'.$siloId.'" 
	') or die("Error: " . mysqli_error($mysqliConn));
	
	while($report = mysqli_fetch_array($reportSql)) {
		$recordCount = $report['record_count'];
	}
	
	if ($recordCount > 0) {
		return 0;
	} else {
		return 1;
	}
}
function getShiftInfo($dt, $dayStartTime = "06:00", $nightStartTime = "18:00") {
	$hour = date("H", strtotime($dt));
	
	if ($hour >= date("H", strtotime($nightStartTime))) {
		$outputArray['shift_start_dt'] = date("Y-m-d", strtotime($dt)).' '.$nightStartTime;
		$outputArray['shift_date'] = date("Y-m-d", strtotime($dt));
		$outputArray['shift'] = "Night";
	} elseif ($hour >= date("H", strtotime($dayStartTime))) {
		$outputArray['shift_start_dt'] = date("Y-m-d", strtotime($dt)).' '.$dayStartTime;
		$outputArray['shift_date'] = date("Y-m-d", strtotime($dt));
		$outputArray['shift'] = "Day";
	} else {
		$outputArray['shift_start_dt'] = date("Y-m-d", strtotime('-1 day', strtotime($dt))).' '.$nightStartTime;
		$outputArray['shift_date'] = date("Y-m-d", strtotime('-1 day', strtotime($dt)));
		$outputArray['shift'] = "Night";
	}
	
	$outputArray['dt'] = $dt;
	
	return $outputArray;
}
function defaultOWPProductionData($date, $shift, $currentDt) {
	$mysqliConn = mysqli_connect("localhost", "webdev", "Vista1!", "silicore_site") or die("Cannot connect to silicore database.");
	
	$userId = 0;
	$plantId = 4;
	$uptime = 0;
	$tons = array(6 => 0, 7 => 0, 8 => 0);
	$uptimePercent = round($uptime / 12, 4);
	$downtimeReason = "";
	$downtime = 12 - $uptime;
	$downtimeMinutes = round($downtime * 60);
	$downtimePercent = round($downtime / 12, 4);
	
	foreach ($tons as $productId => $value) {	
		//check to see if we already have a sample for this date/time, location, and specific location (gate no, etc.)
		$reportSql = mysqli_query($mysqliConn, 'select id from prod_plant_production where plant_id = "'.$plantId.'" and shift = "'.$shift.'" and product_id = "'.$productId.'" and shift_date = "'.$date.'" limit 1') or die("Error" . mysqli_error($mysqliConn)."<br>");
		
		if (mysqli_num_rows($reportSql) == 0) {
			//insert the main sample data
     
			mysqli_query($mysqliConn, 
              'insert into prod_plant_production ('
              . 'plant_id, shift_date, shift, product_id, tons, uptime, uptime_percent, downtime_minutes, downtime, downtime_percent, downtime_reason, create_dt, edit_dt, user_id) '
              . 'values ("'.$plantId.'", "'.$date.'", "'.$shift.'", "'.$productId.'", "'.$value.'", '.$uptime.', '.$uptimePercent.', '.$downtimeMinutes.', '.$downtime.', '.$downtimePercent.', "'.$downtimeReason.'", "'.$currentDt.'", "'.$currentDt.'", "'.$userId.'")') 
              or die("Error: ". mysqli_error($mysqliConn)."<br>");
		}
	}
}
//End funtions
//connect to mssql database
try
{
//  $dbcreds = databaseConnectionInfo();
  $connarray = array
    (
      "Database" => 'DataForTransfer',
      "Uid" => 'sa',
      "PWD" =>'esp'
    );
  $mssqlcon = sqlsrv_connect('192.168.97.19',$connarray);
}
catch (Exception $e)
  {
    echo("Error while trying to get data" . $e);   
  }
//mssql_connect('192.168.97.19','sa','esp') or die(sendErrorEmail("Failed to connect to Microsoft SQL database over VPN tunnel."));
//mssql_select_db("DataForTransfer") or die(sendErrorEmail(sqlsrv_errors())); 

//////////////////step 1, update the warehouse with the production information from the ESP system
// ShiftId > 9799 and ShiftId < 9857
$reportSql = sqlsrv_query($mssqlcon, 
'select 
	Id, PtId, ShiftId, TotalVal, TotalDesc, ProdType
from 
	ProdTotal
where 
	ShiftId >= (select max(ShiftId) - 32 from ProdTotal)
order by ShiftId
') or die(sendErrorEmail(sqlsrv_errors()));

while($report = sqlsrv_fetch_array($reportSql)) {
	$productId = 0;
	$tagId = 'null';
	$tag = $report['TotalDesc'];

	$reportSql2 = mysqli_query($mysqliConn, 'select id from prod_auto_plant_analog_tags where tag = "'.$tag.'" limit 1') or die("Error: " . mysqli_error($mysqliConn));
	while($report2 = mysqli_fetch_array($reportSql2)){
		$tagId = '"'.$report2['id'].'"';
	}
	
	$reportSql2 = mysqli_query($mysqliConn, 'select id from prod_products where tag = "'.$tag.'" limit 1') or die("Error: " . mysqli_error($mysqliConn));
	while($report2 = mysqli_fetch_array($reportSql2)){
		$productId = $report2['id'];
	}
	
	$id = $report['Id'];
	$ptId = $report['PtId'];
	$shiftId = $report['ShiftId'];
	$value = $report['TotalVal'];
	//$description = $report['TotalDesc'];
	$productType = $report['ProdType'];
	
	//if ($shiftId < 1831 || $shiftId > 1838) {
		$reportSql2 = mysqli_query($mysqliConn, 'select id from prod_auto_plant_production where shift_id = "'.$shiftId.'" and tag_id = '.$tagId.' and product_id = "'.$productId.'" limit 1') or die("Error: " . mysqli_error($mysqliConn));
		
		if (mysqli_num_rows($reportSql2) == 0) {
			//insert the record
			// KACE: 12206 - Replacing 'or die()' with a proper try/catch to gracefully fail, dump the variables to an email, and continue execution.
			//               Adding new exception wrapper function to top of page for global use. Should move it to a global script for inclusion and use in other cron scripts.
      $ExceptionDump = "Exception caught while trying to insert data into prod_auto_plant_production at line 69. Current variables:<br />" .
        "shiftId=" . $shiftId . "<br />" .  
        "value=" . $value . "<br />" .
        "tagId=" . $tagId .  "<br />" .
        "tag=" . $tag .  "<br />" .
        "productId=" . $productId . "<br />" .
        "productType=" . $productType . "<br /><br />" .
        "mysqli_error: ";
			try
			{
				mysqli_query($mysqliConn, 'insert into prod_auto_plant_production (shift_id, tons, tag_id, tag, product_id, product)'
                . ' values ("'.$shiftId.'", "'.$value.'", '.$tagId.', "'.$tag.'", "'.$productId.'", "'.$productType.'")');
			} 
			catch (Exception $ex) 
			{
				sendErrorEmail($ex);
			}
			// Removed the following DB call for KACE: 12206; above ^^^ think about concatenating all of the catches together for one email instead of many (for performance)		
			/*
			 $varDump01 = "Error on line 90! current variables:<br />" .
        "shiftId=" . $shiftId . "<br />" .  
        "value=" . $value . "<br />" .
        "tagId=" . $tagId .  "<br />" .
        "tag=" . $tag .  "<br />" .
        "productId=" . $productId . "<br />" .
        "productType=" . $productType . "<br /><br />" .
        "mysqli_error: ";
			mysqli_query($mysqliConn, 'insert into prod_auto_plant_production (shift_id, tons, tag_id, tag, product_id, product) values ("'.$shiftId.'", "'.$value.'", '.$tagId.', "'.$tag.'", "'.$productId.'", "'.$productType.'")') 
        or die(sendErrorEmail($varDump01 . mysqli_error($mysqliConn)));
			*/
		} else {
			while($report2 = mysqli_fetch_array($reportSql2)){
				//update the record
				mysqli_query($mysqliConn, 'update prod_auto_plant_production set shift_id = "'.$shiftId.'", tons = "'.$value.'", tag_id = '.$tagId.', tag = "'.$tag.'", product_id = "'.$productId.'", product = "'.$productType.'" where id = "'.$report2['id'].'"') or die(sendErrorEmail("line 55 " . mysqli_error($mysqliConn)));
			}		
		}
	//}
}
//////////////////end step 1

//////////////////step 2, update the warehouse with the run time information from the ESP system
// ShiftId > 9799 and ShiftId < 9857
$reportSql = sqlsrv_query($mssqlcon, 
"select 
	Runtimes.Id, RtId, Runtimes.ShiftId, Runtime, RuntimeDescription, Tag, StartDate, EndDate
from 
	Runtimes
join 
  Shift
ON 
	Shift.ShiftId = Runtimes.ShiftId 
where 
	Shift.StartDate >= '2017-10-30'
order by ShiftId
") or die(sqlsrv_errors());

while($report = sqlsrv_fetch_array($reportSql)) {
	$id = $report['Id'];
	$shiftId = $report['ShiftId'];
	$durationMinutes = $report['Runtime'];
  if($durationMinutes >= 59000)
    {
    $duration = 999.9;
    }
    else
    {
      $duration = round($durationMinutes / 60, 2);
    }

	$device = $report['RuntimeDescription'];
	$tagId = 'null';
	$tag = $report['Tag'];
  $today = date("Y-m-d H:i:s");
  $startDate = $report['StartDate']->format('Y-m-d H:i:s');
  $yesterdayDate = date('Y-m-d H:i:s', strtotime('-1 days'));
	$reportSql2 = mysqli_query($mysqliConn, 'select id from prod_auto_plant_analog_tags where tag = "'.$tag.'" limit 1') 
          or die("Error: " . mysqli_error($mysqliConn));
	while($report2 = mysqli_fetch_array($reportSql2)){
		$tagId = '"'.$report2['id'].'"';
	}
	echo 'insert into gb_plc_runtime (shift_id, duration_minutes, duration, device, tag_id, tag, create_dt)'
          . ' values ("'.$shiftId.'", "'.$durationMinutes.'", "'.$duration.'", "'.$device.'", '.$tagId.', "'.$tag.'", "'.$startDate.'")
				 ON DUPLICATE KEY UPDATE shift_id = "'.$shiftId.'" <br>';
	//insert the record
	mysqli_query($mysqliConn, 'insert into gb_plc_runtime (shift_id, duration_minutes, duration, device, tag_id, tag, create_dt)'
          . ' values ("'.$shiftId.'", "'.$durationMinutes.'", "'.$duration.'", "'.$device.'", '.$tagId.', "'.$tag.'", "'.$startDate.'")
				 ON DUPLICATE KEY UPDATE shift_id = "'.$shiftId.'"') 
          or die( "Error: shiftID = " . $shiftId . " duration = ". $duration . " duration Minutes = " . $durationMinutes ." " . mysqli_error($mysqliConn));
}
//////////////////end step 2

////////////////////step 3, update the warehouse with the down time information from the ESP system$dt3DaysAgo
//// '2015-10-05 00:00:00.000'
//$dt3DaysAgo = date('Y-m-d H:i:s', strtotime('-3 days'));
//$reportSql = sqlsrv_query($mssqlcon,
//'select 
//	DtId, ShiftId, DtEnd, DtAmount, DtReason, DeviceName, Comment, case when DtReason like \'Scheduled%\' then 1 else 0 end is_scheduled 
//from 
//	DownTime
//where 
//	DtEnd >= \''.$dt3DaysAgo.'\' 
//order by DtEnd
//') or die(sendErrorEmail(sqlsrv_errors()));
//
//$i = 0;
//while($report = sqlsrv_fetch_array($reportSql)) {
//	$i++;
//	
//	$id = $report['DtId'];
//	$shiftId = $report['ShiftId'];
//	$endDt = "" . $report['DtEnd']->format('Y-m-d H:i:s') . "";
//	$durationMinutes = $report['DtAmount'];
//	$reason = $report['DtReason'];
//	$deviceName = $report['DeviceName'];
//	$comment = $report['Comment'];
//	$isScheduled = $report['is_scheduled'];	
//		
//	$startDt = date("Y-m-d H:i:s", strtotime($endDt) - ($durationMinutes * 60));
//	$endDtShort = substr(date("YmdHi", strtotime($endDt)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins
//
//	$duration = round($durationMinutes / 60, 2);
//	
//  
//	//insert the record
//	mysqli_query($mysqliConn, 'insert into prod_auto_plant_downtime'
//          . ' (id, shift_id, start_dt, end_dt, end_dt_short, duration_minutes, duration, reason, device_name, comments, is_scheduled)'
//          . ' values ("'.$id.'", "'.$shiftId.'", "'.$startDt.'", "'.$endDt.'", "'.$endDtShort.'", "'.$durationMinutes.'", "'.$duration.'", "'.$reason.'", "'.$deviceName.'", "'.$comment.'", "'.$isScheduled.'")
//				 ON DUPLICATE KEY UPDATE id = "'.$id.'", shift_id = "'.$shiftId.'", start_dt = "'.$startDt.'", end_dt = "'.$endDt.'", end_dt_short = "'.$endDtShort.'", duration_minutes = "'.$durationMinutes.'", duration = "'.$duration.'", reason = "'.$reason.'", device_name = "'.$deviceName.'", comments = "'.$comment.'", is_scheduled = "'.$isScheduled.'"') or die('Error: ' .mysqli_error($mysqliConn));
//}
////////////////////end step 3
//
////////////////////step 4, update the warehouse with the idle time information from the ESP system
//// '2015-10-05 00:00:00.000'
//$reportSql = sqlsrv_query($mssqlcon,
//'select 
//	ItId, ShiftId, ItEnd, ItAmount, ItReason, Comment
//from 
//	IdleTime
//where 
//	ItEnd >= \''.$dt3DaysAgo.'\'
//order by ItEnd
//') or die(sendErrorEmail(sqlsrv_errors()));
//
//$i = 0;
//while($report = sqlsrv_fetch_array($reportSql)) {
//	$i++;
//	
//	$id = $report['ItId'];
//	$shiftId = $report['ShiftId'];
//	$endDt = date_format($report['ItEnd'], 'Y-m-d H:i:s');
//	$durationMinutes = $report['ItAmount'];
//	$reason = $report['ItReason'];
//	$comment = $report['Comment'];
//		
//	$startDt = date("Y-m-d H:i:s", strtotime($endDt) - ($durationMinutes * 60));
//	$endDtShort = substr(date("YmdHi", strtotime($endDt)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins
//
//	$duration = round($durationMinutes / 60, 2);
//	//echo $id.' '.$startDt.' '.$endDt.' '.$durationMinutes.' '.$duration.'<br />';
//	
//	//insert the record
//	mysqli_query($mysqliConn, 'insert into prod_auto_plant_idletime (id, shift_id, start_dt, end_dt, end_dt_short, duration_minutes, duration, reason, comments) values ("'.$id.'", "'.$shiftId.'", "'.$startDt.'", "'.$endDt.'", "'.$endDtShort.'", "'.$durationMinutes.'", "'.$duration.'", "'.$reason.'", "'.$comment.'")
//				 ON DUPLICATE KEY UPDATE id = "'.$id.'", shift_id = "'.$shiftId.'", start_dt = "'.$startDt.'", end_dt = "'.$endDt.'", end_dt_short = "'.$endDtShort.'", duration_minutes = "'.$durationMinutes.'", duration = "'.$duration.'", reason = "'.$reason.'", comments = "'.$comment.'"') or die("Error: " . mysqli_error($mysqliConn));
//}
////////////////////end step 4
//
////////////////////step 5, update the warehouse with shift information from the ESP system
//	//ShiftId > 9799 and ShiftId < 9857
//$reportSql = sqlsrv_query($mssqlcon,
//'select 
//	Id, ShiftId, ProdAreaId, ProdArea, StartDate, EndDate, OperatorName, TimeMin
//from 
//	Shift
//where 
//  ShiftId >= (select max(ShiftId) - 32 from Shift)  
//order by ShiftId
//') or die(sendErrorEmail("Error! Unable to get shift information from VISTASQL1:DataForTransfer:Shift. MSSQL Error: " . sqlsrv_errors()));
//
//while($report = sqlsrv_fetch_array($reportSql)) {
//	$id = $report['Id'];
//	$shiftId = $report['ShiftId'];
//	$prodAreaId = $report['ProdAreaId'];
//	$prodArea = $report['ProdArea'];
//	$startDt = date_format($report['StartDate'], 'Y-m-d H:i:s');
//	$operator = $report['OperatorName'];
//  if($report['TimeMin'] != null && $report['TimeMin'] != "")
//    {
//    	$durationMinutes = $report['TimeMin'];
//    }
//  else
//    {
//      $durationMinutes = 0;
//    }
//	$duration = round($durationMinutes / 60, 2);
//	
//	$startDtShort = getDtShort($startDt);
//	
//	if ($report['EndDate'] != null && $report['EndDate'] != "") {
//		//$endDt = strtotime($endDt);
//		//$endDt = '"'.date("Y-m-d H:i:s", mktime(date("H", $endDt), round(date("i", $endDt), -1), 0, date("m", $endDt), date("d", $endDt), date("Y", $endDt))).'"';
//		$endDt = date_format($report['EndDate'], 'Y-m-d H:i:s');
//		$endDtShort = substr(date("YmdHi", strtotime($endDt)), 0, 11);
//		$endDt = '"'.$endDt.'"';
//	} else {
//		$endDt = "null";
//		$endDtShort = "null";
//	}
//	
//	switch ((int)$prodAreaId) {
//		case 1: // Wet Plant #2 (New)
//			$plantId = 3;
//			break;
//		case 5: // Carrier 1 (100T)
//			$plantId = 6;
//			break;
//		case 6: // Rotary 1 (new rotary)
//			$plantId = 7;
//			break;
//		case 8: // Carrier 2 (200T)
//			$plantId = 8;
//			break;
//		default:
//			// Do nothing, fall out of switch
//	}
//	
//	$shiftInfo = getShiftInfo($startDt, "04:30", "15:30"); 
//	$shiftDate = $shiftInfo['shift_date'];
//	$shift = $shiftInfo['shift'];
//	$dateShort = getDateShort($shiftDate);
//	
//	$reportSql2 = mysqli_query($mysqliConn, 'select sum(duration_minutes) downtime_minutes from prod_auto_plant_downtime where shift_id = "'.$shiftId.'"') 
//          or die("Error: " . mysqli_error($mysqliConn));
//	
//	while($report2 = mysqli_fetch_array($reportSql2)){
//		$downtime = round($report2['downtime_minutes'] / 60, 2);
//	}
//
//	$reportSql2 = mysqli_query($mysqliConn, 'select sum(duration_minutes) idletime_minutes from prod_auto_plant_idletime where shift_id = "'.$shiftId.'"')
//          or die("Error: " . mysqli_error($mysqliConn));
//	
//	while($report2 = mysqli_fetch_array($reportSql2)){
//		$idletime = round($report2['idletime_minutes'] / 60, 2);
//	}
//	
//	$uptime = $duration - $downtime - $idletime;
//	
//	if ($duration > 0) {
//		$uptimePercent = round($uptime / $duration, 4);
//		$downtimePercent = round($downtime / $duration, 4);
//		$idletimePercent = round($idletime / $duration, 4);
//	} else {
//		$uptimePercent = 0;
//		$downtimePercent = 0;
//		$idletimePercent = 0;
//	}
//
//	//insert the record
//	//if ($shiftId < 1831 || $shiftId > 1838) {
//		mysqli_query($mysqliConn, 'insert into prod_auto_plant_shifts (id, prod_area_id, prod_area, plant_id, date, shift, date_short, start_dt, start_dt_short, end_dt, end_dt_short, operator, duration_minutes, duration, uptime, uptime_percent, downtime, downtime_percent, idletime, idletime_percent) values ("'.$shiftId.'", "'.$prodAreaId.'", "'.$prodArea.'", "'.$plantId.'", "'.$shiftDate.'", "'.$shift.'", "'.$dateShort.'", "'.$startDt.'", "'.$startDtShort.'", '.$endDt.', '.$endDtShort.', "'.$operator.'", "'.$durationMinutes.'", "'.$duration.'", "'.$uptime.'", "'.$uptimePercent.'", "'.$downtime.'", "'.$downtimePercent.'", "'.$idletime.'", "'.$idletimePercent.'")
//					 ON DUPLICATE KEY UPDATE id = "'.$shiftId.'", prod_area_id = "'.$prodAreaId.'", prod_area = "'.$prodArea.'", date = "'.$shiftDate.'", shift = "'.$shift.'", start_dt = "'.$startDt.'", start_dt_short = "'.$startDtShort.'", end_dt = '.$endDt.', end_dt_short = '.$endDtShort.', duration_minutes = "'.$durationMinutes.'", duration = "'.$duration.'", uptime = "'.$uptime.'", uptime_percent = "'.$uptimePercent.'", downtime = "'.$downtime.'", downtime_percent = "'.$downtimePercent.'", idletime = "'.$idletime.'", idletime_percent = "'.$idletimePercent.'"') 
//            or die("error : " . mysqli_error($mysqliConn));
//		
//		//check for duplicate shift rows as defined by shift duration being less than or equal to 10 minutes
//		if ($endDt != "null" && $durationMinutes <= 10) {
//			mysqli_query($mysqliConn, 'update prod_auto_plant_shifts set is_removed = 1 where id = "'.$shiftId.'"') or die("Error: " . mysqli_error($mysqliConn));
//		}
//	//}
//}
//
////set 0 production values at 6am and 6pm for the Old Wet Plant
//defaultOWPProductionData($yesterdayDate, "Day", $today);
//defaultOWPProductionData($yesterdayDate, "Night", $today);
////////////////////end step 5
//
////////////////////step 6, update the warehouse with the analog information from the ESP system
////TagQuality of 192 is a good data read within the PLC
//// '2015-10-05 00:00:00.000'$dt3DaysAgo
//$reportSql = sqlsrv_query($mssqlcon,
//'select 
//	TableIndex, TagItemID, TagValue, TagTimestamp, interval_seconds 
//from 
//	( 
//	select 
//		ad.TableIndex, ad.TagItemID, ad.TagValue, ad.TagTimestamp, \'600\' interval_seconds 
//	from 
//		TOPServerAnalogData10MinuteInterval ad 
//	where 
//		ad.TagQuality = 192 and 
//		ad.TagTimestamp >= \''.$dt3DaysAgo.'\' 
//	union 
//	select 
//		ad.TableIndex, ad.TagItemID, ad.TagValue, ad.TagTimestamp, \'60\' interval_seconds 
//	from 
//		TOPServerAnalogData1MinuteInterval ad 
//	where 
//		ad.TagQuality = 192 and 
//		ad.TagTimestamp >= \''.$dt3DaysAgo.'\' 
//	) t 
//order by TagTimestamp 
//') or die(sendErrorEmail(sqlsrv_errors()));
//
//$i = 0;
//while($report = sqlsrv_fetch_array($reportSql)) {
//	$i++;
//	
//	//$id = $report['TableIndex'];
//	$intervalSeconds = $report['interval_seconds'];
//	$tagPlc = $report['TagItemID'];
//	
//	$reportSql2 = mysqli_query($mysqliConn, 'select id from prod_auto_plant_analog_tags where tag_plc = "'.$tagPlc.'" limit 1') or die("Error: " . mysqli_error($mysqliConn));
//	
//	if (mysqli_num_rows($reportSql2) == 0) {
//		$tagId = "null";
//	} else {
//		while($report2 = mysqli_fetch_array($reportSql2)){
//			$tagId = '"'.$report2['id'].'"';
//		}
//	}
//	
//	$analogValue = round($report['TagValue'], 4);
//		
//	//round the date/time stamp to the nearest minute or 10 minutes, depending on the interval
//	$analogDtStamp = date_format($report['TagTimestamp'], 'Y-m-d H:i:s');
//	
////	if( $intervalSeconds == "60" ) {
////		$analogDt = date("Y-m-d H:i:s", mktime(date("H", $analogDtStamp), date("i", $analogDtStamp), 0, date("m", $analogDtStamp), date("d", $analogDtStamp), date("Y", $analogDtStamp)));
////	} else {
////		$analogDt = date("Y-m-d H:i:s", mktime(date("H", $analogDtStamp), round(date("i", $analogDtStamp), -1), 0, date("m", $analogDtStamp), date("d", $analogDtStamp), date("Y", $analogDtStamp)));
////	}
//	
////	$analogDtShort = substr(date("YmdHi", strtotime($analogDt)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins
//  $analogDtShort = getDtShort($analogDtStamp);
//	//convert product descriptions to product ids
//	if ($analogValue == "100M") {
//		$analogValue = 1;
//	} elseif ($analogValue == "40/70") {
//		$analogValue = 2;
//	}
//	
//	//mysqli_query($mysqliConn, 'insert into prod_auto_plant_analog_data (id, tag_id, tag_plc, value, dt, dt_short, interval_seconds) values ("'.$id.'", '.$tagId.', "'.$tagPlc.'", "'.$analogValue.'", "'.$analogDt.'", "'.$analogDtShort.'", "'.$intervalSeconds.'") 
//	//			ON DUPLICATE KEY UPDATE id = "'.$id.'", tag_plc = "'.$tagPlc.'", tag_id = '.$tagId.', interval_seconds = "'.$intervalSeconds.'" 
//	//			') or die("Error: " . mysqli_error($mysqliConn));
//	
//	mysqli_query($mysqliConn, 'insert into prod_auto_plant_analog_data (tag_id, tag_plc, value, dt, dt_short, interval_seconds) values ('.$tagId.', "'.$tagPlc.'", "'.$analogValue.'", "'.$analogDtStamp.'", "'.$analogDtShort.'", "'.$intervalSeconds.'") 
//				ON DUPLICATE KEY UPDATE tag_id = '.$tagId.', tag_plc = "'.$tagPlc.'", value = "'.$analogValue.'", dt = "'.$analogDtStamp.'", interval_seconds = "'.$intervalSeconds.'" 
//				') or die("Error: " . mysqli_error($mysqliConn));
//				 
//  if ($i == 1){ $minDt = $analogDtStamp;}
//} 
//
//
//
//
//
//
//
//
//
//
//
//
///* $reportSql = sqlsrv_query('
//select 
//	ad.Id, ad.Device, ad.AnalogTag, ad.AnalogType, ad.Units, ad.AnalogValue, ad.AnalogTime
//from 
//	AnalogData ad
//where 
//	ad.AnalogTime >= \''.$dt3DaysAgo.'\'
//order by ad.AnalogTime
//') or die(sendErrorEmail(sqlsrv_errors()));
//
//$i = 0;
//while($report = sqlsrv_fetch_array($reportSql)) {
//	$i++;
//	
//	$id = $report['Id'];
//	$device = $report['Device'];
//	$analogTag = $report['AnalogTag'];
//	$analogType = $report['AnalogType'];
//	$units = $report['Units'];
//	$analogValue = round($report['AnalogValue'], 4);
//		
//	//round the date/time stamp to the nearest 10 minutes
//	$analogDtStamp = strtotime($report['AnalogTime']);
//	$analogDt = date("Y-m-d H:i:s", mktime(date("H", $analogDtStamp), round(date("i", $analogDtStamp), -1), 0, date("m", $analogDtStamp), date("d", $analogDtStamp), date("Y", $analogDtStamp)));
//	$analogDtShort = substr(date("YmdHi", strtotime($analogDt)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins
//	
//	mysqli_query($mysqliConn, 'insert into prod_auto_plant_analogs (id, device, tag, type, units, value, dt, dt_short) values ("'.$id.'", "'.$device.'", "'.$analogTag.'", "'.$analogType.'", "'.$units.'", "'.$analogValue.'", "'.$analogDt.'", "'.$analogDtShort.'")
//				ON DUPLICATE KEY UPDATE id = "'.$id.'"
//				') or die("Error: " . mysqli_error($mysqliConn));
//				 
//	if ($i == 1) $minDt = $analogDt;
//} */
//
//
//
////pull out the inventory records and insert them into the inventory table
//if (strlen($minDt) > 0) {
//	$reportSql = mysqli_query($mysqliConn, '
//	select 
//		t.dt, t.dt_short, so.site_id, t.silo_id, so.capacity_pounds, so.cone_pounds, max(t.product_id) product_id, max(t.volume) volume 
//	from
//		(
//		select 
//			dt, dt_short, case when at.tag = "SILO1_PROD_temp" then 1 when at.tag = "SILO2_PROD_temp" then 2 when at.tag = "SILO6_PROD_temp" then 6 when at.tag = "SILO7_PROD_temp" then 7 end silo_id, value product_id, null volume
//		from 
//			prod_auto_plant_analog_data ad join prod_auto_plant_analog_tags at on ad.tag_id = at.id  
//		where 
//			tag in ("SILO1_PROD_temp", "SILO2_PROD_temp", "SILO6_PROD_temp", "SILO7_PROD_temp") and
//			dt > "'.$minDt.'"
//		union
//		select 
//			dt, dt_short, case when at.tag = "SILO1_LVL_temp" then 1 when at.tag = "SILO2_LVL_temp" then 2 when at.tag = "SILO6_LVL_temp" then 6 when at.tag = "SILO7_LVL_temp" then 7 end silo_id, null product_id, ad.value volume
//		from 
//			prod_auto_plant_analog_data ad join prod_auto_plant_analog_tags at on ad.tag_id = at.id  
//		where 
//			tag in ("SILO1_LVL_temp", "SILO2_LVL_temp", "SILO6_LVL_temp", "SILO7_LVL_temp") and
//			dt > "'.$minDt.'"
//		) t join prod_silos so on t.silo_id = so.id 
//	group by 
//		t.dt, t.dt_short, t.silo_id, so.capacity_pounds 
//	having 
//		max(t.product_id) is not null and
//		max(t.volume) is not null
//	order by t.dt, t.silo_id
//	') or die("Error: " .mysqli_error($mysqliConn));
//	
//	while($report = mysqli_fetch_array($reportSql)) {
//		$dt = $report['dt'];
//		$dtShort = substr(date("YmdHi", strtotime($dt)), 0, 11);
//		$date = date("Y-m-d", strtotime($dt));
//		$time = date("H:i:s", strtotime($dt));
//		
//		$siteId = $report['site_id'];
//		$siloId = $report['silo_id'];
//		$productId = round($report['product_id']);
//		$volume = round(floatval($report['volume']) / 100, 4);
//		$capacityPounds = $report['capacity_pounds'];
//		$conePounds = $report['cone_pounds'];
//		$cylinderPounds = $report['capacity_pounds'] - $report['cone_pounds'];
//		
//		if ($volume > 0) {
//			$pounds = $volume * $cylinderPounds + $conePounds;
//		} else {
//			$ticketPounds = 0;
//			
//			$silosRoutedArray = array();
//			$siloProductIdArray = array();
//			$sandRouteArray = array();
//			$silosRoutedArray = array();
//			$siloProductCount = 0;
//			$conePoundsRoutedArray = array();
//			echo 'select tons, dt as dt_previous from prod_inventory_silos '
//              . 'where dt < "'.$dt.'" and volume > 0 and site_id = "'.$siteId.'" '
//              . 'and silo_id = "'.$siloId.'" order by dt desc limit 1';
//			//find the previous timestamp and silo/cone pounds for a reference point
//			$reportSql2 = mysqli_query($mysqliConn, 'select tons, dt as dt_previous from prod_inventory_silos '
//              . 'where dt < "'.$dt.'" and volume > 0 and site_id = "'.$siteId.'" '
//              . 'and silo_id = "'.$siloId.'" order by dt desc limit 1') 
//              or die("Error: " . mysqli_error($mysqliConn));
//		
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$conePounds = $report2['tons'] * 2000; //convert the last tons recorded to pounds
//
//            $dtPrevious = $report2['dt_previous'];
//
//			}
//			
//			//calculate the weight that has been ticketed and deduct it from the cone/hopper pounds
//			$reportSql2 = mysqli_query($mysqliConn, 'select sum(net_pounds) ticket_pounds from prod_tickets where dt between "'.$dtPrevious.'" and "'.$dt.'" and site_id = "'.$siteId.'" and silo_id = "'.$siloId.'" and void_status_code <> "V"') or die("Error: " . mysqli_error($mysqliConn));
//		
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$ticketPounds = $report2['ticket_pounds'];
//			}
//			
//			//calculate the pounds going into the silo cones
//			$reportSql2 = mysqli_query($mysqliConn, '
//			select 
//				if(tag_id = 167, 2, 1) product_id, max(value) - min(value) tons 
//			from 
//				prod_auto_plant_analog_data 
//			where 
//				dt between "'.$dtPrevious.'" and "'.$dt.'" and 
//				tag_id in (166,167,184) 
//			group by product_id 
//			') or die("Error: " . mysqli_error($mysqliConn));
//		
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$productIdRouted = $report2['product_id'];
//				
//				if ($report2['tons'] > 0) {
//					$conePoundsRoutedArray[$productIdRouted] = $report2['tons'] * 2000; //convert it to pounds
//				} else {
//					$conePoundsRoutedArray[$productIdRouted] = 0;
//				}
//			}
//			
//			//find the product in the silos
//			$reportSql2 = mysqli_query($mysqliConn, '
//			select 
//				silo_id, product_id 
//			from
//				prod_inventory_silos si 
//			where 
//				site_id = 10 and 
//				dt = "'.$dtPrevious.'" 
//			') or die("Error: " . mysqli_error($mysqliConn));
//		
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$siloIdProduct = $report2['silo_id'];
//				$siloProductIdArray[$siloIdProduct] = $report2['product_id'];
//			}
//			
//			//find the silo the sand is being routed to
//			$reportSql2 = mysqli_query($mysqliConn, '
//			select 
//				tag_id, value 
//			from 
//				prod_auto_plant_analog_data 
//			where 
//				dt = "'.$dtPrevious.'" and 
//				tag_id in (219,220,221,222,223,224,225,226,227,228,229,230) 
//			') or die("Error: " . mysqli_error($mysqliConn));
//		
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$tagId = $report2['tag_id'];
//				$sandRouteArray[$tagId] = $report2['value'];
//			}
//			
//			//Bucket Elevator 160 (BE160_AUX)
//			if ($sandRouteArray[219] == 1) {
//				if ($sandRouteArray[223] == 1) { //if DV170_OLS is on, sand is flowing to silo 1
//					$silosRoutedArray[1] = $siloProductIdArray[1];
//				} elseif ($sandRouteArray[228] == 1) { //if SV17_OLS is on, sand is flowing to silo 3
//					$silosRoutedArray[3] = $siloProductIdArray[3];
//				}
//			}
//			
//			//Bucket Elevator 200 (BE2000_AUX)
//			if ($sandRouteArray[220] == 1) {
//				//sand is flowing to silo 2
//				$silosRoutedArray[2] = $siloProductIdArray[2];
//			}
//			
//			//Bucket Elevator 300 (BE300_AUX)
//			if ($sandRouteArray[221] == 1) {
//				if ($sandRouteArray[226] == 1) { //if FG300_OLS is on, sand is flowing to silo 6
//					$silosRoutedArray[6] = $siloProductIdArray[6];
//				} elseif ($sandRouteArray[225] == 1) { //if FG300_CLS is on, sand is flowing to silo 7
//					$silosRoutedArray[7] = $siloProductIdArray[7];
//				}
//			}
//			
//			//calculate the number of silos involved in the routing of this product
//			foreach($silosRoutedArray as $key => $siloProductId) {
//				if($siloProductId == $productId) {
//					$siloProductCount++;
//				}
//			}
//			
//			//calculate final pounds going into the silo cone (splitting the produced tons evenly over the applicable silos
//			$conePoundsProduced = $conePoundsRoutedArray[$productId] / $siloProductCount;
//			
//			$pounds = $conePounds + $conePoundsProduced - $ticketPounds;
//			//$pounds = $conePounds - $ticketPounds;
//			
//			//echo $siloId.' '.$dt.' '.$productId.' '.$siloProductCount.' '.$conePoundsRoutedArray[$productId].' '.$conePounds.' + '.$conePoundsProduced.' - '.$ticketPounds.' = '.$pounds.'<br />';
//		}
//		
//		
//		if ($pounds < 0) { //cannot have negative amount of product
//			$tons = 0;
//			$loads = 0;
//		} else {
//			$tons = round($pounds / 2000, 2);
//			$loads = round($pounds / 2000 / 25, 1);
//		}
//		
//		$isHourFirstReading = siloInventoryIsHourFirstReading($siloId, $dt);
//		
//		//echo $dt.' '.$siloId.'<br />';
//		
//		$reportSql2 = mysqli_query($mysqliConn, 'select id from prod_inventory_silos where dt = "'.$dt.'" and site_id = "'.$siteId.'" and silo_id = "'.$siloId.'" limit 1') or die("Error: " . mysqli_error($mysqliConn));
//		
//		if (mysqli_num_rows($reportSql2) > 0) {
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$inventorySiloId = $report2['id'];
//			}
//		} else {
//			$inventorySiloId = 'null';
//		}
//		
//		//mysqli_query($mysqliConn, 'insert into prod_inventory_silos (id, date, time, dt, dt_short, site_id, silo_id, product_id, volume, tons, loads, is_hour_first_reading) values ('.$inventorySiloId.', "'.$date.'", "'.$time.'", "'.$dt.'", "'.$dtShort.'", "'.$siteId.'", "'.$siloId.'", "'.$productId.'", "'.$volume.'", "'.$tons.'", "'.$loads.'", "'.$isHourFirstReading.'")
//		//on duplicate key update id = '.$inventorySiloId.', date = "'.$date.'", time = "'.$time.'", dt = "'.$dt.'", dt_short = "'.$dtShort.'", site_id = "'.$siteId.'", silo_id = "'.$siloId.'", product_id = "'.$productId.'", volume = "'.$volume.'", tons = "'.$tons.'", loads = "'.$loads.'"') or die("Error: " . mysqli_error($mysqliConn));
//		mysqli_query($mysqliConn, 'insert into prod_inventory_silos (id, date, time, dt, dt_short, site_id, silo_id, product_id, volume, tons, loads, is_hour_first_reading) values ('.$inventorySiloId.', "'.$date.'", "'.$time.'", "'.$dt.'", "'.$dtShort.'", "'.$siteId.'", "'.$siloId.'", "'.$productId.'", "'.$volume.'", "'.$tons.'", "'.$loads.'", "'.$isHourFirstReading.'")
//		on duplicate key update id = '.$inventorySiloId.'') or die("Error: " . mysqli_error($mysqliConn));
//		//make sure we are reporting inventory counts from silos 3, 4, & 5 - get the latest one if not reported already
//		$inventoryCheckSql = mysqli_query($mysqliConn, 'select date, time, silo_id from prod_inventory_silos where dt = "'.$dt.'" and silo_id in (3,4,5)') or die("Error: " . mysqli_error($mysqliConn));
//		
//		if (mysqli_num_rows($inventoryCheckSql) == 0) {
//			//keep silo 3 invetory data in sync
//			$inventoryCheckSql2 = mysqli_query($mysqliConn, 'select date, time, silo_id, product_id, tons, loads from prod_inventory_silos where dt < "'.$dt.'" and silo_id in ("3") order by date desc, time desc limit 1') or die("Error: " . mysqli_error($mysqliConn));
//			
//			while($inventoryCheck2 = mysqli_fetch_array($inventoryCheckSql2)) {
//				//$isHourFirstReading = siloInventoryIsHourFirstReading(3, $dt);
//				
//				mysqli_query($mysqliConn, 'insert into prod_inventory_silos (date, time, dt, dt_short, silo_id, product_id, tons, loads) values ("'.$date.'", "'.$time.'", "'.$dt.'", "'.$dtShort.'", "'.$inventoryCheck2['silo_id'].'", "'.$inventoryCheck2['product_id'].'", "'.$inventoryCheck2['tons'].'", "'.$inventoryCheck2['loads'].'")') or die("Error: " . mysqli_error($mysqliConn));
//			}
//			
//			
//			
//			
//			//keep silo 4 invetory data in sync
//			$inventoryCheckSql2 = mysqli_query($mysqliConn, 'select date, time, silo_id, product_id, tons, loads from prod_inventory_silos where dt < "'.$dt.'" and silo_id in ("4") order by date desc, time desc limit 1') or die("Error: " . mysqli_error($mysqliConn));
//			
//			while($inventoryCheck2 = mysqli_fetch_array($inventoryCheckSql2)) {
//				//$isHourFirstReading = siloInventoryIsHourFirstReading(4, $dt);
//				
//				mysqli_query($mysqliConn, 'insert into prod_inventory_silos (date, time, dt, dt_short, silo_id, product_id, tons, loads) values ("'.$date.'", "'.$time.'", "'.$dt.'", "'.$dtShort.'", "'.$inventoryCheck2['silo_id'].'", "'.$inventoryCheck2['product_id'].'", "'.$inventoryCheck2['tons'].'", "'.$inventoryCheck2['loads'].'")') or die("Error: " . mysqli_error($mysqliConn));
//			}
//			
//			
//			
//			
//			//keep silo 5 invetory data in sync
//			$inventoryCheckSql2 = mysqli_query($mysqliConn, 'select date, time, silo_id, product_id, tons, loads from prod_inventory_silos where dt < "'.$dt.'" and silo_id in ("5") order by date desc, time desc limit 1') or die("Error: " . mysqli_error($mysqliConn));
//			
//			while($inventoryCheck2 = mysqli_fetch_array($inventoryCheckSql2)) {
//				//$isHourFirstReading = siloInventoryIsHourFirstReading(5, $dt);
//				
//				mysqli_query($mysqliConn, 'insert into prod_inventory_silos (date, time, dt, dt_short, silo_id, product_id, tons, loads) values ("'.$date.'", "'.$time.'", "'.$dt.'", "'.$dtShort.'", "'.$inventoryCheck2['silo_id'].'", "'.$inventoryCheck2['product_id'].'", "'.$inventoryCheck2['tons'].'", "'.$inventoryCheck2['loads'].'")') or die("Error: " . mysqli_error($mysqliConn));
//			}
//		}
//	}
//}
////end pull out the inventory records and insert them into the inventory table
//
//
//
////update production total for wet plant cyclone tons per shift		
//$checkSql = mysqli_query($mysqliConn, '
//select id, date, shift, start_dt, uptime
//from
//	prod_auto_plant_shifts
//where
//	plant_id = 3 and 
//	is_removed = 0 and 
//	date >= "'.$date30DaysAgo.'"
//order by id
//') or die("Error: " . mysqli_error($mysqliConn));
//
//while($reportCheck = mysqli_fetch_array($checkSql)){
//	$shiftId = $reportCheck['id'];
//	$shiftDate = $reportCheck['date'];
//	$shift = $reportCheck['shift'];
//	$shiftStartDt = $reportCheck['start_dt'];
//	$shiftUptime = $reportCheck['uptime'];
//	
//	$reportSql = mysqli_query($mysqliConn, '
//	select max(avg_stph_cy12) avg_stph_cy12, max(avg_stph_cy34) avg_stph_cy34
//	from
//	(
//		select 
//			avg(stph) avg_stph_cy12, 0 avg_stph_cy34 
//		from 
//			prod_qc_samples 
//		where 
//			shift_date = "'.$shiftDate.'" and 
//			shift = "'.$shift.'" and
//			location_id = 31 and 
//			is_removed = 0 and 
//			test_type_id = 2 and 
//			void_status_code <> "V" 
//		union
//		select 
//			0 avg_stph_cy12, avg(stph) avg_stph_cy34 
//		from 
//			prod_qc_samples 
//		where 
//			shift_date = "'.$shiftDate.'" and 
//			shift = "'.$shift.'" and
//			location_id = 32 and
//			is_removed = 0 and 
//			test_type_id = 2 and 
//			void_status_code <> "V" 
//	) t
//	') or die("Error: " . mysqli_error($mysqliConn));
//	
//	while($report = mysqli_fetch_array($reportSql)) {		
//		$plantProductionProductId = 15; //tails product id
//		
//		$avgCyclones12Stph = $report['avg_stph_cy12'];
//		$avgCyclones34Stph = $report['avg_stph_cy34'];
//		
//		//tons calculation
//		$shiftTailsTons = round(($avgCyclones12Stph + $avgCyclones34Stph) * $shiftUptime);
//		
//		$reportSql2 = mysqli_query($mysqliConn, 'select tag_id, tag, description from prod_products where id = "'.$plantProductionProductId.'" limit 1') or die("Error: " . mysqli_error($mysqliConn));
//		
//		while($report2 = mysqli_fetch_array($reportSql2)) {
//			if (strlen($$report2['tag_id']) > 0) {
//				$plantProductionTagId = '"'.$report2['tag_id'].'"';
//			} else {
//				$plantProductionTagId = "null";
//			}
//			
//			$plantProductionTag = $report2['tag'];
//			$plantProductionProductDesc = $report2['description'];
//		}
//		
//		$reportSql2 = mysqli_query($mysqliConn, 'select p.id from prod_auto_plant_production p where p.product_id = "'.$plantProductionProductId.'" and p.shift_id = "'.$shiftId.'" and p.tag = "'.$plantProductionTag.'" limit 1') or die("Error: " . mysqli_error($mysqliConn));
//		
//		if(mysqli_num_rows($reportSql2) > 0) {
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$plantProductionId = $report2['id'];
//			}
//		} else {
//				$plantProductionId = "null";
//		}
//
//		//insert/update the record
//		mysqli_query($mysqliConn, 'insert into prod_auto_plant_production (id, shift_id, tons, tag_id, tag, product_id, product) values ('.$plantProductionId.', "'.$shiftId.'", "'.$shiftTailsTons.'", "'.$plantProductionTagId.'", "'.$plantProductionTag.'", "'.$plantProductionProductId.'", "'.$plantProductionProductDesc.'")
//		on duplicate key update shift_id = "'.$shiftId.'", tons = "'.$shiftTailsTons.'", tag_id = "'.$plantProductionTagId.'", tag = "'.$plantProductionTag.'", product_id = "'.$plantProductionProductId.'", product = "'.$plantProductionProductDesc.'"') or die(sendErrorEmail("line 694 " . mysqli_error($mysqliConn)));
//		
//		//calculate tons represented for each cyclone 1 and 2 sample
//		if ($avgCyclones12Stph > 0) {
//			$reportSql2 = mysqli_query($mysqliConn, '
//			select 
//				id, dt 
//			from 
//				prod_qc_samples 
//			where 
//				shift_date = "'.$shiftDate.'" and 
//				shift = "'.$shift.'" and 
//				location_id = 31 and 
//				stph is not null and 
//				is_removed = 0 and 
//				test_type_id = 2 and 
//				void_status_code <> "V" 
//			order by dt
//			') or die("Error: " . mysqli_error($mysqliConn));
//			
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$sampleId = $report2['id'];
//				$sampleDt = $report2['dt'];
//				
//				$reportSql3 = mysqli_query($mysqliConn, '
//				select 
//					dt
//				from 
//					prod_qc_samples
//				where 
//					dt < "'.$sampleDt.'" and 
//					location_id = 31 and 
//					is_removed = 0 and 
//					test_type_id = 2 and 
//					void_status_code <> "V"
//				order by dt desc
//				limit 1
//				') or die("Error: " . mysqli_error($mysqliConn));
//				
//				while($report3 = mysqli_fetch_array($reportSql3)) {
//					$previousSampleDt = $report3['dt'];
//				}
//				
//				$reportSql3 = mysqli_query($mysqliConn, '
//				select 
//					dt.id dt_id, 0 it_id, dt.start_dt, dt.end_dt 
//				from 
//					prod_auto_plant_downtime dt join prod_auto_plant_shifts s on dt.shift_id = s.id
//				where 
//					s.plant_id = 3 and 
//					dt.start_dt between "'.$previousSampleDt.'" and "'.$sampleDt.'" 
//				union
//				select 
//					0 dt_id, it.id it_id, it.start_dt, it.end_dt 
//				from 
//					prod_auto_plant_idletime it join prod_auto_plant_shifts s on it.shift_id = s.id
//				where 
//					s.plant_id = 3 and 
//					it.start_dt between "'.$previousSampleDt.'" and "'.$sampleDt.'" 
//				') or die("Error: " . mysqli_error($mysqliConn));
//				
//				$downOrIdleTime = 0;
//				
//				while($report3 = mysqli_fetch_array($reportSql3)) {
//					if(strtotime($report3['end_dt']) > strtotime($sampleDt)) {
//						$downOrIdleEndDt = $sampleDt;
//					} else {
//						$downOrIdleEndDt = $report3['end_dt'];
//					}			
//					
//					$downOrIdleTime += (strtotime($downOrIdleEndDt) - strtotime($report3['start_dt'])) / 60 / 60;
//				}
//				
//				$time = (strtotime($sampleDt) - strtotime($previousSampleDt)) / 60 / 60;
//				$uptime = $time - $downOrIdleTime;
//				$tonsRepresented = round($avgCyclones12Stph * $uptime);
//				$tphRepresented = round($tonsRepresented / $uptime, 1);
//				
//				if ($tonsRepresented > 0) {
//					mysqli_query($mysqliConn, 'update prod_qc_samples set tons_represented = "'.$tonsRepresented.'", tph_represented = "'.$tphRepresented.'" where id = "'.$sampleId.'"') or die("Error: " . mysqli_error($mysqliConn));
//				}
//			}
//			
//			unset($previousSampleDt);
//		}
//		//end calculate tons represented for each cyclone 1 and 2 sample
//		
//		//calculate tons represented for each cyclone 3 and 4 sample
//		if ($avgCyclones34Stph > 0) {
//			$reportSql2 = mysqli_query($mysqliConn, '
//			select 
//				id, dt 
//			from 
//				prod_qc_samples 
//			where 
//				shift_date = "'.$shiftDate.'" and 
//				shift = "'.$shift.'" and 
//				location_id = 32 and 
//				stph is not null and 
//				is_removed = 0 and 
//				test_type_id = 2 and 
//				void_status_code <> "V" 
//			order by dt
//			') or die("Error: " . mysqli_error($mysqliConn));
//			
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$sampleId = $report2['id'];
//				$sampleDt = $report2['dt'];
//				
//				$reportSql3 = mysqli_query($mysqliConn, '
//				select 
//					dt
//				from 
//					prod_qc_samples
//				where 
//					dt < "'.$sampleDt.'" and 
//					location_id = 32and 
//					is_removed = 0 and 
//					test_type_id = 2 and 
//					void_status_code <> "V"
//				order by dt desc
//				limit 1
//				') or die("Error: " . mysqli_error($mysqliConn));
//				
//				while($report3 = mysqli_fetch_array($reportSql3)) {
//					$previousSampleDt = $report3['dt'];
//				}
//				
//				$reportSql3 = mysqli_query($mysqliConn, '
//				select 
//					dt.id dt_id, 0 it_id, dt.start_dt, dt.end_dt 
//				from 
//					prod_auto_plant_downtime dt join prod_auto_plant_shifts s on dt.shift_id = s.id
//				where 
//					s.plant_id = 3 and 
//					dt.start_dt between "'.$previousSampleDt.'" and "'.$sampleDt.'" 
//				union
//				select 
//					0 dt_id, it.id it_id, it.start_dt, it.end_dt 
//				from 
//					prod_auto_plant_idletime it join prod_auto_plant_shifts s on it.shift_id = s.id
//				where 
//					s.plant_id = 3 and 
//					it.start_dt between "'.$previousSampleDt.'" and "'.$sampleDt.'" 
//				') or die("Error: " . mysqli_error($mysqliConn));
//				
//				$downOrIdleTime = 0;
//				
//				while($report3 = mysqli_fetch_array($reportSql3)) {
//					if(strtotime($report3['end_dt']) > strtotime($sampleDt)) {
//						$downOrIdleEndDt = $sampleDt;
//					} else {
//						$downOrIdleEndDt = $report3['end_dt'];
//					}			
//					
//					$downOrIdleTime += (strtotime($downOrIdleEndDt) - strtotime($report3['start_dt'])) / 60 / 60;
//				}
//				
//				$time = (strtotime($sampleDt) - strtotime($previousSampleDt)) / 60 / 60;
//				$uptime = $time - $downOrIdleTime;
//				$tonsRepresented = round($avgCyclones34Stph * $uptime);
//				$tphRepresented = round($tonsRepresented / $uptime, 1);
//				
//				//echo 'shift id: '.$shiftId.' sample id: '.$sampleId.' '.$sampleDt.' '.$previousSampleDt.' ('.$time.' - '.$downOrIdleTime.') * '.$avgCyclones34Stph.' = '.$tonsRepresented.'<br />';
//							
//				if ($tonsRepresented > 0) {
//					mysqli_query($mysqliConn, 'update prod_qc_samples set tons_represented = "'.$tonsRepresented.'", tph_represented = "'.$tphRepresented.'" where id = "'.$sampleId.'"') or die("Error: " . mysqli_error($mysqliConn));
//				}
//			}
//			
//			unset($previousSampleDt);
//		}
//		//end calculate tons represented for each cyclone 3 and 4 sample
//	}
//}
////end update production total for cyclone tons per shift
//
////add in the carrier production tons based on the feed tons, inventory levels and loads sold
//$checkSql = mysqli_query($mysqliConn, '
//select distinct shift_id 
//from
//	prod_auto_plant_production
//where 
//	shift_id > (
//			select max(p.shift_id) shift_id
//			from 
//				prod_auto_plant_production p,
//				prod_products pr,
//				prod_auto_plant_shifts s
//			where 
//				p.shift_id = s.id and 
//				p.product_id = pr.id and 
//				pr.id in (13, 14) and 
//				s.end_dt is not null
//			)
//	and product_id in (11, 12)
//order by shift_id
//') or die("Error: " . mysqli_error($mysqliConn));
//
///*$checkSql = mysqli_query($mysqliConn, '
//select distinct shift_id 
//from
//	prod_auto_plant_production
//where 
//	shift_id > (
//			select max(p.shift_id) shift_id
//			from 
//				prod_auto_plant_production p,
//				prod_products pr,
//				prod_auto_plant_shifts s
//			where 
//				p.shift_id = s.id and 
//				p.product_id = pr.id and 
//				pr.id in (13, 14) and 
//				s.end_dt is not null
//			)
//	and product_id in (11, 12)
//	or (shift_id > 1587 and product_id in (11,12))
//order by shift_id
//') or die("Error: " . mysqli_error($mysqliConn));*/
//
//while($reportCheck = mysqli_fetch_array($checkSql)){
//	$lastShiftId = $reportCheck['shift_id'];
//	
//	$reportSql = mysqli_query($mysqliConn, 'select sum(feed_coarse_tons) feed_coarse_tons, sum(feed_fine_tons) feed_fine_tons
//	from
//	(
//		select if(p.product_id = 11, tons, 0) feed_coarse_tons, if(p.product_id = 12, tons, 0) feed_fine_tons
//		from 
//			prod_auto_plant_production p,
//			prod_products pr,
//			prod_auto_plant_shifts s
//		where 
//			p.shift_id = s.id and 
//			p.product_id = pr.id and 
//			p.shift_id = "'.$lastShiftId.'" and 
//			pr.id in (11, 12) and 
//			s.end_dt is not null
//	) t
//	') or die("Error: " . mysqli_error($mysqliConn));
//	
//	while($report = mysqli_fetch_array($reportSql)){
//		$feedCoarseTons = $report['feed_coarse_tons'];
//		$feedFineTons = $report['feed_fine_tons'];
//	}
//	
//	$reportSql = mysqli_query($mysqliConn, '
//	select max(s.id) id, max(s.start_dt_short) start_dt_short, max(s.end_dt_short) end_dt_short
//	from 
//		prod_auto_plant_production p,
//		prod_products pr,
//		prod_auto_plant_shifts s
//	where 
//		p.shift_id = s.id and 
//		p.product_id = pr.id and 
//		p.shift_id = "'.$lastShiftId.'" and 
//		pr.id in (11, 12) and 
//		s.end_dt is not null
//	') or die("Error: " . mysqli_error($mysqliConn));
//	
//	while($report = mysqli_fetch_array($reportSql)){
//		$shiftId = $report['id'];
//		$shiftStartDtShort = $report['start_dt_short'];
//		$shiftEndDtShort = $report['end_dt_short'];
//	}
//
//	$reportSql = mysqli_query($mysqliConn, '
//	select p.product_id, p.tons, s.start_dt, s.end_dt
//	from 
//		prod_auto_plant_production p,
//		prod_products pr,
//		prod_auto_plant_shifts s
//	where 
//		p.shift_id = s.id and 
//		p.product_id = pr.id and 
//		s.start_dt_short = "'.$shiftStartDtShort.'" and 
//		s.end_dt_short = "'.$shiftEndDtShort.'" and 
//		pr.id in (10) and 
//		s.end_dt is not null
//	order by start_dt desc
//	limit 1
//	') or die("Error: " . mysqli_error($mysqliConn));
//	
//	while($report = mysqli_fetch_array($reportSql)){
//		$rotaryTonsProduced = $report['tons'];
//	}
//
//	$reportSql = mysqli_query($mysqliConn, '
//	select sum(4070_tons_start) 4070_tons_start, sum(4070_tons_end) 4070_tons_end, sum(100_tons_start) 100_tons_start, sum(100_tons_end) 100_tons_end
//	from
//	(
//		(
//		select id, silo_id, product_id, dt, if(product_id = 2, tons, 0) 4070_tons_start, 0 4070_tons_end, 0 100_tons_start, 0 100_tons_end
//		from 
//			prod_inventory_silos
//		where 
//			site_id = 10 and 
//			dt_short <= "'.$shiftStartDtShort.'" 
//		order by dt_short desc
//		limit 7
//		)
//	union
//		(
//		select id, silo_id, product_id, dt, 0 4070_tons_start, if(product_id = 2, tons, 0) 4070_tons_end, 0 100_tons_start, 0 100_tons_end
//		from 
//			prod_inventory_silos
//		where 
//			site_id = 10 and 
//			dt_short <= "'.$shiftEndDtShort.'" 
//		order by dt_short desc
//		limit 7
//		)
//	union
//		(
//		select id, silo_id, product_id, dt, 0 4070_tons_start, 0 4070_tons_end, if(product_id = 1, tons, 0) 100_tons_start, 0 100_tons_end
//		from 
//			prod_inventory_silos
//		where 
//			site_id = 10 and 
//			dt_short <= "'.$shiftStartDtShort.'" 
//		order by dt_short desc
//		limit 7
//		)
//	union
//		(
//		select id, silo_id, product_id, dt, 0 4070_tons_start, 0 4070_tons_end, 0 100_tons_start, if(product_id = 1, tons, 0) 100_tons_end
//		from 
//			prod_inventory_silos
//		where 
//			site_id = 10 and 
//			dt_short <= "'.$shiftEndDtShort.'" 
//		order by dt_short desc
//		limit 7
//		)
//	) t
//	') or die("Error: " . mysqli_error($mysqliConn));
//
//	while($report = mysqli_fetch_array($reportSql)){
//		$tons4070Start = $report['4070_tons_start'];
//		$tons4070End = $report['4070_tons_end'];
//		$tons100Start = $report['100_tons_start'];
//		$tons100End = $report['100_tons_end'];
//	}
//	
//	$reportSql = mysqli_query($mysqliConn, 'select sum(4070_tons_sold) 4070_tons_sold, sum(100_tons_sold) 100_tons_sold from
//	(
//	select 
//		distinct ticket_no, if(p.product_id = 2, net_tons, 0) 4070_tons_sold, 0 100_tons_sold
//	from 
//		prod_tickets t,
//		prod_purchase_orders p
//	where
//		t.po_id = p.id and
//		t.void_status_code <> "V" and 
//		t.silo_id in (1,2,3,4,5,6,7) and 
//		t.dt_short between "'.$shiftStartDtShort.'" and "'.$shiftEndDtShort.'"
//	union
//	select 
//		distinct ticket_no, 0 4070_tons_sold, if(p.product_id = 1, net_tons, 0) 100_tons_sold
//	from 
//		prod_tickets t,
//		prod_purchase_orders p
//	where
//		t.po_id = p.id and
//		t.void_status_code <> "V" and
//		t.silo_id in (1,2,3,4,5,6,7) and 
//		t.dt_short between "'.$shiftStartDtShort.'" and "'.$shiftEndDtShort.'"
//	) t
//	') or die("Error: " . mysqli_error($mysqliConn));
//	
//	while($report = mysqli_fetch_array($reportSql)) {
//		$tons4070Sold = $report['4070_tons_sold'];
//		$tons100Sold = $report['100_tons_sold'];
//	}
//	
//	//put the calculation together
//	$tonsProduced[13] = round($tons4070Sold + ($tons4070End - $tons4070Start));
//	$tonsProduced[14] = round($tons100Sold + ($tons100End - $tons100Start - $rotaryTonsProduced));
//	
//	if ($tonsProduced[13] < 0 || $feedCoarseTons == 0) $tonsProduced[13] = 0;
//	if ($tonsProduced[14] < 0 || $feedFineTons == 0) $tonsProduced[14] = 0;
//	
//	
//	$reportSql = mysqli_query($mysqliConn, '
//	select s.id
//	from 
//		prod_auto_plant_production p,
//		prod_products pr,
//		prod_auto_plant_shifts s
//	where 
//		p.shift_id = s.id and 
//		p.product_id = pr.id and 
//		p.shift_id = "'.$shiftId.'" and 
//		pr.id in (13, 14) and 
//		s.end_dt is not null
//	group by s.id
//	') or die(sendErrorEmail("line 1129" . mysqli_error($mysqliConn)));
//	
//	if (mysqli_num_rows($reportSql) == 0) {
//		$reportSql2 = mysqli_query($mysqliConn, '
//		select id, tag_id, tag, description product 
//		from
//			prod_products
//		where
//			id in (13, 14)
//		') or die(sendErrorEmail("line 1140" . mysqli_error($mysqliConn)));
//		
//		while($report2 = mysqli_fetch_array($reportSql2)) {
//			$productId = $report2['id'];
//			$product = $report2['product'];
//			$tagId = $report2['tag_id'];
//			$tag = $report2['tag'];
//			//insert carrier production numbers
//
//			// KACE: 12206 - Replacing 'or die()' with a proper try/catch to gracefully fail, dump the variables to an email, and continue execution.
//			//               Adding new exception wrapper function to top of page for global use. Should move it to a global script for inclusion and use in other cron scripts.
//			$ExceptionDump = "Exception caught while trying to insert data into prod_auto_plant_production at line 1157. Current variables: <br />" . 
//				"shiftId=" . $shiftId . "<br />" .  
//        "tonsProduced[productId]=" . $tonsProduced[$productId] . "<br />" .
//        "tagId=" . $tagId .  "<br />" .
//        "tag=" . $tag .  "<br />" .
//        "productId=" . $productId . "<br />" .
//        "product=" . $product . "<br /><br />" .
//        "mysqli_error: ";
//			try
//			{				
//				mysqli_query($mysqliConn, 'insert into prod_auto_plant_production (shift_id, tons, tag_id, tag, product_id, product) 
//					values ("'.$shiftId.'", "'.$tonsProduced[$productId].'", "'.$tagId.'", "'.$tag.'", "'.$productId.'", "'.$product.'")')
//				or throw_exception($ExceptionDump . mysqli_error($mysqliConn) . "<br /><br />");
//			} 
//			catch (Exception $ex) 
//			{
//				sendErrorEmail($ex);
//			}
//			/*
//			
//			$varDump02 = "Error on line 1174 while trying to insert into prod_auto_plant_production! current variables:<br />" .
//        "shiftId=" . $shiftId . "<br />" .  
//        "tonsProduced[productId]=" . $tonsProduced[$productId] . "<br />" .
//        "tagId=" . $tagId .  "<br />" .
//        "tag=" . $tag .  "<br />" .
//        "productId=" . $productId . "<br />" .
//        "product=" . $product . "<br /><br />" .
//        "mysqli_error: ";
//			mysqli_query($mysqliConn, 'insert into prod_auto_plant_production (shift_id, tons, tag_id, tag, product_id, product) 
//				values ("'.$shiftId.'", "'.$tonsProduced[$productId].'", "'.$tagId.'", "'.$tag.'", "'.$productId.'", "'.$product.'")') 
//				or die(sendErrorEmail($varDump02 . mysqli_error($mysqliConn)));
//			*/
//		}
//		//echo $shiftId.' Start: '.$shiftStartDtShort.' End: '.$shiftEndDtShort.' 40/70: '.$tons4070Sold.' + ('.$tons4070End.' - '.$tons4070Start.') = '.$tonsProduced[13].'<br />';
//		//echo $shiftId.' Start: '.$shiftStartDtShort.' End: '.$shiftEndDtShort.' 100: '.$tons100Sold.' + ('.$tons100End.' - '.$tons100Start.' - '.$rotaryTonsProduced.') = '.$tonsProduced[14].'<br />';
//	}
//}
////end carrier production calculations
//
//
//
////start total inventory calculations
////inventory known stockpile survey date
//$firstStockpileSurveyDate = "2013-08-03";
//
//$checkSql = mysqli_query($mysqliConn, '
//select distinct p.shift_id, s.date, s.shift, s.plant_id, s.start_dt_short, s.end_dt_short, p.product_id 
//from
//	prod_auto_plant_production p join prod_auto_plant_shifts s on p.shift_id = s.id 
//where
//	s.date >= "'.$firstStockpileSurveyDate.'" and  
//	shift_id > (
//			select max(shift_id)
//			from
//				prod_inventory
//			where 
//				product_id in (4, 5, 10, 13, 14) and
//				duration_minutes > 10
//			)
//	and product_id in (4, 5, 10, 13, 14) and 
//	s.duration_minutes > 10 and 
//	s.end_dt is not null 
//order by p.shift_id, p.product_id
//') or die("Error: " . mysqli_error($mysqliConn));
//
//
//while($reportCheck = mysqli_fetch_array($checkSql)){
//	$shiftId = $reportCheck['shift_id'];
//	$shiftDate = $reportCheck['date'];
//	$shift = $reportCheck['shift'];
//	$plantId = $reportCheck['plant_id'];
//	$shiftStartDtShort = $reportCheck['start_dt_short'];
//	$shiftEndDtShort = $reportCheck['end_dt_short'];
//	$productionProductId = $reportCheck['product_id'];
//	$loadoutProductTag = '';
//	$finalProductId = 0;
//	
//	if ($productionProductId == 4) {
//		$loadoutProductTag = "C06_SCL_TOTAL";
//	} elseif ($productionProductId == 5) { 
//		$loadoutProductTag = "C09_SCL_TOTAL";
//	/*}  elseif ($productionProductId == 7) { 
//		$plantId = 4;
//		$loadoutProductTag = "CARRIER_OLD_COARSE";
//	} elseif ($productionProductId == 8 && $plantId == 5) { 
//		$plantId = 4;
//		$loadoutProductTag = "ROTARY_OLD_WASH";
//	} elseif ($productionProductId == 8 && $plantId == 6) { 
//		$plantId = 4;
//		$loadoutProductTag = "CARRIER_OLD_FINE";
//	*/
//	}  elseif ($productionProductId == 13) { 
//		$finalProductId = 2;
//	} elseif ($productionProductId == 10 || $productionProductId == 14) { 
//		$finalProductId = 1;
//	}
//	
//	//get the production tons
//	if ($plantId == 4) {
//		/* $reportSql = mysqli_query($mysqliConn, 'select p.tons
//			from 
//				prod_plant_production p,
//				prod_products pr
//			where 
//				p.product_id = pr.id and 
//				p.date = "'.$shiftDate.'" and 
//				p.shift = "'.$shift.'" and 
//				pr.id = "'.$productionProductId.'"
//			order by p.date
//			limit 1
//		') or die("Error: " . mysqli_error($mysqliConn)); */
//	} else {
//		$reportSql = mysqli_query($mysqliConn, 'select p.tons
//			from 
//				prod_auto_plant_production p join prod_auto_plant_shifts s on p.shift_id = s.id 
//				join prod_products pr on p.product_id = pr.id 				
//			where 
//				p.shift_id = "'.$shiftId.'" and 
//				pr.id = "'.$productionProductId.'" 
//			order by p.shift_id
//			limit 1
//		') or die("Error: " . mysqli_error($mysqliConn));
//	}
//	/* echo 'select p.tons
//			from 
//				prod_auto_plant_production p join prod_auto_plant_shifts s on p.shift_id = s.id 
//				join prod_products pr on p.product_id = pr.id 				
//			where 
//				p.shift_id = "'.$shiftId.'" and 
//				pr.id = "'.$productionProductId.'" 
//			order by p.shift_id
//			limit 1
//		<br />'; */
//	while($report = mysqli_fetch_array($reportSql)){
//		$productionTons = $report['tons'];
//	}
//	
//	
//	//get the net tons for the previous shift
//	$reportSql = mysqli_query($mysqliConn, 'select end_tons tons
//		from 
//			prod_inventory
//		where 
//			shift_id < "'.$shiftId.'" and 
//			product_id = "'.$productionProductId.'"
//		order by shift_id desc
//		limit 1
//	') or die("Error: " . mysqli_error($mysqliConn));
//	
//	while($report = mysqli_fetch_array($reportSql)){
//		$previousTons = $report['tons'];
//	}
//
//	
//	if (strlen($loadoutProductTag) > 0) {
//		//get the loadout tons
//		$reportSql = mysqli_query($mysqliConn, 'select p.tons
//			from 
//				prod_auto_plant_production p join prod_auto_plant_shifts s on p.shift_id = s.id 
//			where 
//				p.shift_id = "'.$shiftId.'" and 
//				p.tag = "'.$loadoutProductTag.'" 
//			order by p.shift_id
//			limit 1
//		') or die("Error: " . mysqli_error($mysqliConn));
//		
//		while($report = mysqli_fetch_array($reportSql)){
//			$loadoutTons = $report['tons'];
//		}
//		
//		$productionTons = round($productionTons * .9); //discount 10% for moisture
//	} elseif ($finalProductId > 0) {
//		//get the loadout tons
//		$reportSql = mysqli_query($mysqliConn, 'select sum(net_tons) tons
//			from 
//				prod_tickets t join prod_purchase_orders p on t.po_id = p.id 
//				join prod_products_final pr on p.product_id = pr.id 
//			where 
//				p.product_id = "'.$finalProductId.'" and 
//				t.site_id = 10 and 
//				t.void_status_code <> "V" and 
//				t.dt_short between "'.$shiftStartDtShort.'" and "'.$shiftEndDtShort.'"
//		') or die("Error: " . mysqli_error($mysqliConn));
//
//		while($report = mysqli_fetch_array($reportSql)){
//			$loadoutTons = $report['tons'];
//		}
//		
//		if ($finalProductId == 1) { //100 Mesh comes from the rotary and carrier, so split the load out tons over the 2 plant/product areas
//			$loadoutTons = $loadoutTons / 2;
//		}
//		
//		$loadoutTons = round($loadoutTons);
//	} 
//	
//	$tonsDelta = round($productionTons - $loadoutTons);
//	$endTons = round($previousTons + $tonsDelta);
//	
//	//echo 'product id: '.$productionProductId.' production tons: '.$productionTons.' - loadout tons: '.$loadoutTons.' + previous tons: '.$previousTons.' = '.$endTons.'<br />';
//	
//	mysqli_query($mysqliConn, 'insert into prod_inventory (shift_id, plant_id, product_id, production_tons, loadout_tons, tons_delta, start_tons, end_tons)
//					values ("'.$shiftId.'", "'.$plantId.'", "'.$productionProductId.'", "'.$productionTons.'", "'.$loadoutTons.'", "'.$tonsDelta.'", "'.$previousTons.'", "'.$endTons.'")') or die("Error: " . mysqli_error($mysqliConn));
//}
////end total inventory calculations
////////////////////end step 6
//
//
//
////////////////////Step 7 update production tons running total and calculate tons represented in samples
//$reportSql = mysqli_query($mysqliConn, '
//select 
//	id, product_id, tons_running_total
//from 
//	prod_auto_plant_production_rt 
//where
//	dt >= "'.$date30DaysAgo.'"
//order by dt
//') or die("Error: " . mysqli_error($mysqliConn));
//
//while($report = mysqli_fetch_array($reportSql)) {
//	$productId = $report['product_id'];
//	
//	if(!isset($tonsRunningTotalArray[$productId])) {
//		$tonsRunningTotalArray[$productId] = $report['tons_running_total'];
//	}
//}
//
//$reportSql = mysqli_query($mysqliConn, '
//select 
//	pr.plant_id, pr.id product_id, ad.tag_id, at.tag, ad.dt, ad.value
//from 
//	prod_auto_plant_analog_data ad join prod_auto_plant_analog_tags at on ad.tag_id = at.id 
//	join prod_products pr on at.id = pr.tag_id 
//where
//	ad.dt >= "'.$date30DaysAgo.'"
//order by ad.dt, pr.id
//') or die("Error: " . mysqli_error($mysqliConn));
//
//while($report = mysqli_fetch_array($reportSql)) {
//	$plantId = $report['plant_id'];
//	$productId = $report['product_id'];
//	$tagId = $report['tag_id'];
//	$tag = $report['tag'];
//	$dt = $report['dt'];
//	
//	$valueDifferenceArray[$productId] = $report['value'] - $valueArray[$productId]; //subtract the current total from the previous total by product
//	
//	if (isset($valueArray[$productId]) && $valueDifferenceArray[$productId] >= 0) {
//		$tonsRunningTotalArray[$productId] += $valueDifferenceArray[$productId];
//		
//		$reportSql2 = mysqli_query($mysqliConn, '
//		select 
//			id 
//		from 
//			prod_auto_plant_production_rt 
//		where
//			plant_id = "'.$plantId.'" and 
//			product_id = "'.$productId.'" and 
//			tag_id = "'.$tagId.'" and 
//			tag = "'.$tag.'" and 
//			dt = "'.$dt.'" 
//		limit 1
//		') or die("Error: " . mysqli_error($mysqliConn));
//		
//		if (mysqli_num_rows($reportSql2) == 0) {
//			mysqli_query($mysqliConn, 'insert into prod_auto_plant_production_rt (plant_id, product_id, tag_id, tag, dt, tons_running_total) values ("'.$plantId.'", "'.$productId.'", "'.$tagId.'", "'.$tag.'", "'.$dt.'", "'.$tonsRunningTotalArray[$productId].'")') or die(sendErrorEmail("line 1340 " . mysqli_error($mysqliConn)));
//		} else {
//			while($report2 = mysqli_fetch_array($reportSql2)) {
//				$id = $report2['id'];
//					
//				mysqli_query($mysqliConn, 'update prod_auto_plant_production_rt set plant_id = "'.$plantId.'", product_id = "'.$productId.'", tag_id = "'.$tagId.'", tag = "'.$tag.'", dt = "'.$dt.'", tons_running_total = "'.$tonsRunningTotalArray[$productId].'" where id = "'.$id.'"') or die(sendErrorEmail("line 1347 " . mysqli_error($mysqliConn)));
//			}
//		}
//	}
//	
//	$valueArray[$productId] = $report['value'];
//}
//
////////////////////step 7 update qc samples
//if (substr($currentMin, -1) == "0") {
//	getUrlContents($rootUrl.'/backoffice/batch/update-qc-samples.php');
//} else {
//	printCompleteMsg($currentTimestamp);
//}
//
//if ($debug)
//{
//  //set variable for tracking execution time (end), send email with results
//  $EndTimestamp = microtime(true);
//  $ElapsedTime = round(($EndTimestamp - $StartTimestamp), 2);
//  sendErrorEmail("[DEBUG]: Time elapsed while running etl-esp.php: " . $ElapsedTime . " seconds");
//}

//========================================================================================== END PHP
?>

<!-- HTML -->