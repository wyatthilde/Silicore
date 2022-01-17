<?php
/*******************************************************************************************************************************************
 * File Name: esp_lanes.php
 * Project: Silicore
 * Description:ESP lane readings page for running diagnostics at loadout.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/06/2018|zthale|KACE:24067 - Initial creation
 * 07/09/2018|zthale|KACE:24067 - Granbury/West Texas tables combined into one page. Table uses Bootstrap and is now responsive, therefore font sizes will change according to page view, and allow horizontal scrolling when necessary. Modified CSS a little.
 ******************************************************************************************************************************************/

//---------------------------------------------------------------------------------------------- BEGIN PHP -----

header("Refresh: 3;url='/Config/IT/esp_lanes.php'");
date_default_timezone_set('America/Chicago');

// Initialize db connection for Granbury
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

$granburyResults = mysqli_query($db, $sql) or die("Error while extracting lane information from the Railtronix database on 192.168.30.9. Mysql error: " . mysqli_error($db));

try
  {
  $db->close();
  } catch (Exception $e) {
    $errorMessage = "Error disconnecting to the MySQL database";
  }
  
  // Initialize db connection for West Texas
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

$westTexasResults = mysqli_query($db, $sql) or die("Error while extracting lane information from the Railtronix database on 192.168.30.9. Mysql error: " . mysqli_error($db));

try
  {
  $db->close();
  } catch (Exception $e) {
    $errorMessage = "Error disconnecting to the MySQL database";
  }
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link type="text/css" rel="stylesheet" href="esp_lanes.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    
    <style>
      body {
        margin-left: 30px;
        margin-right: 30px;
      }
      
      th {
        text-align: center;
      }
    </style>
  </head>

  <body>
    <div class="tableESPLaneDefault">Last updated: <?php echo date('Y-m-d H:i:s'); ?></div><br /><br /><br />

    <div class="table-responsive">
        <table class="table table-sm table-striped table-hover">      
                <thead>  
                  <tr>
                <th colspan="10" id="tableESPLaneReader">Current Granbury ESP Lanes Status</th>
                  </tr>
                <tr>    
                      <th>Lane</th>
                      <th>ID</th>
                      <th>Auto ID</th>
                      <th>Product ID</th>
                      <th>Silo ID</th>
                      <th>RFID</th>
                      <th>Tare</th>
                      <th>Target Net</th>
                      <th>Load Status</th>
                      <th>Load Status 2</th>
                    </tr>
                </thead>

                <tbody>
            <?php while($report = mysqli_fetch_object($granburyResults)) { ?>
                <tr>
                  <td><?php echo $report->lane; ?></td>
                  <td><?php echo $report->id; ?></td>
                  <td><?php echo $report->auto_id; ?></td>
                  <td><?php echo $report->product_id; ?></td>
                  <td><?php echo $report->silo_id; ?></td>
                  <td><?php echo $report->RFID; ?></td>
                  <td><?php echo $report->tare; ?></td>
                  <td><?php echo $report->target_net; ?></td>
                  <td><?php echo $report->loadstatus; ?></td>
                  <td><?php echo $report->loadstatus_2; ?></td>
                </tr>	
            <?php } ?>
                </tbody>
            </table>
    </div><br />

    <div class="table-responsive">
            <table class="table table-sm table-striped table-hover">
              <thead>
                <tr>
                    <th colspan="15" id="tableESPLaneReader">Current West Texas ESP Lanes Status</th>
                </tr>

                <tr>
                  <th>Lane</th>
                  <th>ID</th>
                  <th>Ticket Number</th>
                  <th>Product</th>
                  <th>Silo</th>
                  <th>RFID</th>
                  <th>Tare</th>
                  <th>Target Net</th>
                  <th>Gross Weight</th>
                  <th>Load Status</th>
                  <th>Load Status 2</th>
                </tr> 
            </thead>

            <tbody>
                  <?php while($report = mysqli_fetch_object($westTexasResults)) { ?>
                      <tr>
                        <td><?php echo $report->lane; ?></td>
                        <td><?php echo $report->id; ?></td>
                        <td><?php echo $report->ticket_number; ?></td>
                        <td><?php echo $report->product; ?></td>
                        <td><?php echo $report->silo; ?></td>
                        <td><?php echo $report->RFID; ?></td>
                        <td><?php echo $report->tare; ?></td>
                        <td><?php echo $report->target_net; ?></td>
                        <td><?php echo $report->gross_wt; ?></td>
                        <td><?php echo $report->load_status; ?></td>
                        <td><?php echo $report->load_status_2; ?></td>
                      </tr>	
                  <?php } ?>
            </tbody>
            </table>
    </div>
  </body>
</html>