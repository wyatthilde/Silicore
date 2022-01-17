<?php
/*******************************************************************************************************************************************
 * File Name: esp_lane_cresson.php
 * Project: Silicore
 * Description:ESP lane readings page for running diagnostics at loadout.
 * Notes: This page isn't necessary at this point, will revisit later.
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/13/2017|kkuehn|KACE:19117 - Initial creation
 *
 ******************************************************************************************************************************************/

header("Refresh: 3;url='/Config/IT/esp_lane_cresson.php'");
date_default_timezone_set('America/Chicago');

// Initialize db connection
$db = new mysqli( '192.168.2.10', 'esplaneuser', '151006lane', 'railtronixdb');
if(mysqli_connect_errno()) {
	die('Database connect failed: '.mysqli_connect_error());
}

/*
$sql = "SELECT 'ESP Lane 1' AS lane, id,product_id,tare,target_net,load_status,silo_id,AutoId,loadstatus_2
		FROM ESPlane1
		UNION
		SELECT 'ESP Lane 2' AS lane, id,product_id,tare,target_net,load_status,silo_id,AutoId,loadstatus_2
		FROM ESPlane2
		UNION
		SELECT 'ESP Lane 3' AS lane, id,product_id,tare,target_net,load_status,silo_id,AutoId,loadstatus_2
		FROM ESPlane3";
 */

$sql = "SELECT 'ESP Lane 1' AS lane, esplane1_prod AS product
		FROM esplane1
		UNION
		SELECT 'ESP Lane 2' AS lane, esplane2_prod AS product
		FROM esplane2
		UNION
		SELECT 'ESP Lane 3' AS lane, esplane3_prod AS product
		FROM esplane3";


$results = mysqli_query($db, $sql);
?>
<style>
table{
    border-collapse: collapse;
    border-spacing: 0;
	margin:0px;padding:0px;
}

thead > tr > th {
	font-weight:bold;
	
}

td, th{
	vertical-align:middle;
	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:center;
	padding:7px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}

</style>
<table>
	<thead>
		<tr>
			<th>Lane</th>
			<th>Product</th>
		</tr>
	</thead>
	<tbody>

<?php while($report = mysqli_fetch_object($results)) { ?>
		<tr>
			<td><?php echo $report->lane; ?></td>
			<td><?php echo $report->product; ?></td>
		</tr>	
<?php } ?>

	</tbody>
</table>
<br />
<em>Last refreshed: <?php echo date('Y-m-d H:i:s'); ?></em>