<?php
/*******************************************************************************************************************************************
 * File Name: esp_lane_granbury.php
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

header("Refresh: 3;url='/Config/IT/esp_lane_granbury.php'");
date_default_timezone_set('America/Chicago');

// Initialize db connection
$db = new mysqli( '192.168.30.9', 'vistasands', '17Gr4nb8rY10', 'RailtronixDB');
if(mysqli_connect_errno()) {
	die('Database connect failed: '.mysqli_connect_error());
}

$sql = "SELECT 'Lane 1' AS lane,p.id,e.auto_id,e.product_id,e.silo_id,R.RFID_Ln1 AS RFID,e.tare,e.target_net,p.loadstatus,e.loadstatus_2
		FROM esplane1 e, esplane1_plc p, RFID R
		UNION
		SELECT 'Lane 2' AS lane,p.id,e.auto_id,e.product_id,e.silo_id,R.RFID_Ln2 AS RFID,e.tare,e.target_net,p.loadstatus,e.loadstatus_2
		FROM esplane2 e, esplane2_plc p, RFID R
		UNION
		SELECT 'Lane 3' AS lane,p.id,e.auto_id,e.product_id,e.silo_id,R.RFID_Ln3 AS RFID,e.tare,e.target_net,p.loadstatus,e.loadstatus_2
		FROM esplane3 e, esplane3_plc p, RFID R
		UNION
		SELECT 'Lane 4' AS lane,p.id,e.auto_id,e.product_id,e.silo_id,R.RFID_Ln4 AS RFID,e.tare,e.target_net,p.loadstatus,e.loadstatus_2
		FROM esplane4 e, esplane4_plc p, RFID R";


$results = mysqli_query($db, $sql) or die("Error while extracting lane information from the Railtronix database on 192.168.30.9. Mysql error: " . mysqli_error($db));

//echo('<link type="text/css" rel="stylesheet" href="../includes/debug.css">');

//echo('<table class="tableDebug"><th>Current ESP Lanes Status</th>');
//
//------------------------------------------------------------------------------------------------ END PHP -----
?>

<link type="text/css" rel="stylesheet" href="esp_lane.css">

<table class="tableESPLaneReader">
	<th colspan="10">Current Granbury ESP Lanes Status</th>
		<tr>
			<td class="tableESPLaneReaderCellHeader">Lane</td>
			<td class="tableESPLaneReaderCellHeader">ID</td>
			<td class="tableESPLaneReaderCellHeader">Auto ID</td>
			<td class="tableESPLaneReaderCellHeader">Product ID</td>
			<td class="tableESPLaneReaderCellHeader">Silo ID</td>
			<td class="tableESPLaneReaderCellHeader">RFID</td>
			<td class="tableESPLaneReaderCellHeader">Tare</td>
			<td class="tableESPLaneReaderCellHeader">Target Net</td>
			<td class="tableESPLaneReaderCellHeader">Load Status</td>
			<td class="tableESPLaneReaderCellHeader">Load Status 2</td>
		</tr>
	
<?php while($report = mysqli_fetch_object($results)) { ?>
		<tr>
			<td class="tableESPLaneReaderCellBoldHighlight"><?php echo $report->lane; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->id; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->auto_id; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->product_id; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->silo_id; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->RFID; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->tare; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->target_net; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->loadstatus; ?></td>
			<td class="tableESPLaneReaderCellBold"><?php echo $report->loadstatus_2; ?></td>
		</tr>	
<?php } ?>
	
</table>
<div class="tableESPLaneDefault">Last refreshed: <?php echo date('Y-m-d H:i:s'); ?></div>