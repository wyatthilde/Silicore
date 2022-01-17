<?php
/*******************************************************************************************************************************************
 * File Name: esp_lane_westtexas.php
 * Project: Silicore
 * Description:ESP lane readings page for running diagnostics at loadout.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/13/2017|kkuehn|KACE:19117 - Initial creation
 *
 ******************************************************************************************************************************************/

//---------------------------------------------------------------------------------------------- BEGIN PHP -----

header("Refresh: 3;url='/Config/IT/esp_lane_westtexas.php'");
date_default_timezone_set('America/Chicago');

// Initialize db connection
$db = new mysqli( '192.168.11.7', 'esp', 'qFgVGd3SHwG4', 'RailtronixDB');
if(mysqli_connect_errno()) {
	die('Database connect failed: '.mysqli_connect_error());
}

$sql = "SELECT 'Lane 1' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.gross_wt,a.load_status,l.load_status_2
		FROM chkin_1 c,chkin_1_esp k,lane_1 l, lane_1_esp a
		UNION
		SELECT 'Lane 2' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.gross_wt,a.load_status,l.load_status_2
		FROM chkin_2 c,chkin_2_esp k,lane_2 l, lane_2_esp a
		UNION
		SELECT 'Lane 3' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.gross_wt,a.load_status,l.load_status_2
		FROM chkin_3 c,chkin_3_esp k,lane_3 l, lane_3_esp a
                UNION
                SELECT 'Lane 4' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.gross_wt,a.load_status,l.load_status_2
		FROM chkin_4 c,chkin_4_esp k,lane_4 l, lane_4_esp a
                UNION
		SELECT 'Lane 5' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.gross_wt,a.load_status,l.load_status_2
		FROM chkin_5 c,chkin_5_esp k,lane_5 l, lane_5_esp a
		UNION
		SELECT 'Lane 6' AS lane,c.id,l.ticket_number,c.product,k.silo,k.rfid AS RFID,a.tare,l.target_net,a.gross_wt,a.load_status,l.load_status_2
		FROM chkin_6 c,chkin_6_esp k,lane_6 l, lane_6_esp a";


$results = mysqli_query($db, $sql) or die("Error while extracting lane information from the Railtronix database on 192.168.30.9. Mysql error: " . mysqli_error($db));

//echo('<link type="text/css" rel="stylesheet" href="../includes/debug.css">');

//echo('<table class="tableDebug"><th>Current ESP Lanes Status</th>');
//
//------------------------------------------------------------------------------------------------ END PHP -----
?>

<link type="text/css" rel="stylesheet" href="esp_lane.css">

<table class="tableESPLaneReader">
	<th colspan="15">Current West Texas ESP Lanes Status</th>
		<tr>
			<td class="tableESPLaneReaderCellHeader">Lane</td>
			<td class="tableESPLaneReaderCellHeader">ID</td>
			<td class="tableESPLaneReaderCellHeader">Ticket Number</td>
			<td class="tableESPLaneReaderCellHeader">Product</td>
			<td class="tableESPLaneReaderCellHeader">Silo</td>
			<td class="tableESPLaneReaderCellHeader">RFID</td>
			<td class="tableESPLaneReaderCellHeader">Tare</td>
			<td class="tableESPLaneReaderCellHeader">Target Net</td>
                        <td class="tableESPLaneReaderCellHeader">Gross Weight</td>
			<td class="tableESPLaneReaderCellHeader">Load Status</td>
			<td class="tableESPLaneReaderCellHeader">Load Status 2</td>
		</tr>
	
<?php while($report = mysqli_fetch_object($results)) { ?>
		<tr>
			<td class="tableESPLaneReaderCellBoldHighlight"><?php echo $report->lane; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->id; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->ticket_number; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->product; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->silo; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->RFID; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->tare; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->target_net; ?></td>
                        <td class="tableESPLaneReaderCellBold"><?php echo $report->gross_wt; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->load_status; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->load_status_2; ?></td>
		</tr>	
<?php } ?>
	
</table>
<div class="tableESPLaneDefault">Last refreshed: <?php echo date('Y-m-d H:i:s'); ?></div>