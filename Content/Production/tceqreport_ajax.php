<?php
/* * *****************************************************************************************************************************************
 * File Name: tceqreport.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2017|nolliff|KACE:17422 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
include('../../Includes/Security/database.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/gb_plc_tagGlobal.php');



if (isset($_POST['start-date']) && !empty($_POST['start-date']))
  {
    $startDate = strtotime(filter_input(INPUT_POST, 'start-date', "first day of this month"));
  }
else
  {
    $startDate = date('Y-01-01');
  }
  
if (isset($_POST['end-date']) && !empty($_POST['end-date']))
  {
    $endDate = filter_input(INPUT_POST, 'end-date');
  }
else
  {
    $endDate = date("Y-m-d", strtotime('last day of previous month'));
  }
   
// <editor-fold defaultstate="collapsed" desc=" PlantIDs ">
$ASSUMED_RATE = .07;
  
$wetPlant2SampleFeedId = 127;
$wetPlant2SampleCoarseId = 3;
$wetPlant2SampleFineId = 4;

$wetPlant2ConveyorFeedId = 4;
$wetPlant2ConveyorCoarseId = 12;
$wetPlant2ConveyorFineId = 16;

$wetPlant2LocationId = 1;

$wetPlant1SampleFeedId = 128;
$wetPlant1SampleCoarseId = 22;
$wetPlant1SampleFineId = 23;

$wetPlant1ConveyorFeedId = 8;
$wetPlant1ConveyorCoarseId = 2;
$wetPlant1ConveyorFineId = 3;

$wetPlant1LocationId = 1;

//Dry Plants
$rotarySampleFeedId = 49;
$rotarySampleOutputId = 50;

$rotaryConveyorFeedId = 18;
$rotaryConveyorOutputId = 26;

$rotaryLocationId = 6;

$carrier100TSampleFeedId = 24;
$carrier100TSampleOutputId = 55;

$carrier100TConveyorFeedId = 28;
$carrier100TConveyorOutputId = 0;

$carrier100TLocationId = 5;

$carrier200TSampleFeedId = 103;
$carrier200TSampleOutputId = 102;

$carrier200TConveyorFeedId = 22;
$carrier200TConveyorOutputId = 24;

$carrier200TLocationId = 8;
// </editor-fold>

$monthArr = MonthGet($startDate);
$jsonMonthArry = json_encode($monthArr);

  function MonthGet($date)
    {
    $monthNum = date('m', strtotime('-1 month')) + 0;

    $dateArry = array();
    for($i=0; $i<$monthNum; $i++)
      {
        $monthNumber = "+" . $i . "months";
        $dateArry[] = date('Y-m-d', strtotime($monthNumber, strtotime($date, strtotime('first day of this month'))));
      }
    return $dateArry;  
  }

//========================================================================================== END PHP
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<!-- HTML -->

<style>


    .card {
        margin-bottom: 1%;
    }

</style>

<script>
    $(function() 
  {   
   $("#start-date").datetimepicker({ timepicker: false, format: 'Y-m-d' });
   $("#end-date").datetimepicker({ timepicker: false, format: 'Y-m-d' });
  });
</script>

<h1>TCEQ Production Report</h1>
<!--<div class="prod-datepicker">
  <form action='tceqreport.php' method='post' >
    <input type="text" id="start-date" value='<?php echo($startDate) ?>'>
    <strong>to</strong>
    <input type="text" id="end-date" value='<?php echo($endDate) ?>'> 
    <input type="submit" value="Submit">
  </form>
</div>-->

<div class="container-fluid" >
  
    <div class="row">
    <div id="rainfallCol" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>Rainfall</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap " style="width:100%" id="rainfallTable">
              <thead class="th-vprop-blue">
                <tr>
                  <th>Month</th>
                  <th>Rainfall(In)</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table> 
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div id="wetPlant1Col" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>Wet Plant 1</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap " style="width:100%" id="wetPlant1Table">
              <thead class="th-vprop-blue">
                <tr>
                  <th>Month</th>
                  <th>Moisture Rate</th>
                  <th>Dry Tons</th>
                  <th>Uptime(hours)</th>
                  <th>Tons/Hour</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <td style="text-color"><i>Max Allowed</i></td>
                  <td>&nbsp;</td>
                  <td>0</td>
                  <td>0</td>       
                  <td>0</td>
                </tr>
              </tfoot>
            </table> 
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div id="wetPlant2Col" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>Wet Plant 2</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap " style="width:100%" id="wetPlant2Table">
              <thead class="th-vprop-blue">
                <tr>
                  <th>Month</th>
                  <th>Moisture Rate</th>
                  <th>Dry Tons</th>
                  <th>Uptime(hours)</th>
                  <th>Tons/Hour</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <td style="text-color"><i>Max Allowed</i></td>
                  <td>&nbsp;</td>
                  <td>0</td>
                  <td>0</td>       
                  <td>0</td>
                </tr>
              </tfoot>
            </table> 
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div id="rotaryCol" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>Rotary</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap " style="width:100%" id="rotaryTable">
              <thead class="th-vprop-blue">
                <tr>
                  <th class="th-vprop-blue">Month</th>
                  <th>Moisture Rate</th>
                  <th>Dry Tons</th>
                  <th>Uptime(hours)</th>
                  <th>Tons/Hour</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <tr>
                  <td style="text-color"><i>Max Allowed</i></td>
                  <td>&nbsp;</td>
                  <td>0</td>
                  <td>0</td>       
                  <td>0</td>
                </tr>
              </tfoot>
            </table> 
          </div>
        </div>
      </div>
    </div>
  


    <div id="carrier200Col" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>200T Carrier</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap " style="width:100%" id="carrier200Table">
              <thead class="th-vprop-blue">
                <tr>
                  <th>Month</th>
                  <th>Moisture Rate</th>
                  <th>Dry Tons</th>
                  <th>Uptime(hours)</th>
                  <th>Tons/Hour</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <td style="text-color"><i>Max Allowed</i></td>
                  <td>&nbsp;</td>
                  <td>0</td>
                  <td>0</td>       
                  <td>0</td>
                </tr>
              </tfoot>
            </table> 
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div id="carrier100Col" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>100T Carrier</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap " style="width:100%" id="carrier100Table">
              <thead class="th-vprop-blue">
                <tr>
                  <th>Month</th>
                  <th>Moisture Rate</th>
                  <th>Dry Tons</th>
                  <th>Uptime(hours)</th>
                  <th>Tons/Hour</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <td style="text-color"><i>Max Allowed</i></td>
                  <td>&nbsp;</td>
                  <td>0</td>
                  <td>0</td>       
                  <td>0</td>
                </tr>
              </tfoot>
            </table> 
          </div>
        </div>
      </div>
    </div>
  </div>



</div>

<script>
$(document).ready(function () {
  
    var rainfallTable = $('#rainfallTable').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      ordering:true,
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        }
      ]
    });
    var wetPlant1Table = $('#wetPlant1Table').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      ordering:true,
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        }
      ]
    });
    var wetPlant2Table = $('#wetPlant2Table').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      ordering:true,
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        }
      ]
    });
    var rotaryTable = $('#rotaryTable').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        }
      ]
    });
    var carrier200TTable = $('#carrier200Table').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        }
      ]
    });
    var carrier100TTable = $('#carrier100Table').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        }
      ]
    });

    $('.dt-buttons').removeClass('btn-group');
    $('.btn').removeClass('btn-secondary');

    TablesLoad();
    
  });
  
  
  function TablesLoad()
  {
     var monthsJSON = <?php echo $jsonMonthArry; ?>;
     //rainfall   
    for(i=0; i<monthsJSON.length; i++)
    {
      var date = new Date(monthsJSON[i]);
      //splits the start and end dates from time
      var startDate = date.toISOString().split('T')[0];
      var endDate = new Date(date.getFullYear(), date.getMonth() + 2, 0).toISOString().split('T')[0];
      var rowName = date.toISOString().split("-")[0]  +"-" + date.toISOString().split("-")[1];
      
      RainfallAjax($('#rainfallTable').DataTable(),'rainfall',rowName,startDate,endDate)
    }

    //wet plant 1
    for(i=0; i<monthsJSON.length; i++)
    {
      var date = new Date(monthsJSON[i]);
      var startDate = date.toISOString().split('T')[0];
      var endDate = new Date(date.getFullYear(), date.getMonth() + 2, 0).toISOString().split('T')[0];
      var rowName = date.toISOString().split("-")[0]  +"-" + date.toISOString().split("-")[1];

      var conveyorId = <?php echo $wetPlant1ConveyorFeedId; ?>;
      var locationId = <?php echo $wetPlant1SampleFeedId; ?>;
      var plantId = <?php echo $wetPlant1LocationId; ?>;
      
      
      TceqAjaxCall($('#wetPlant1Table').DataTable(),'wetPlant1',rowName,startDate,endDate,conveyorId,locationId,plantId)
    } 
    
  //wet plant 2
    for(i=0; i<monthsJSON.length; i++)
    {
      var date = new Date(monthsJSON[i]);
      var startDate = date.toISOString().split('T')[0];
      var endDate = new Date(date.getFullYear(), date.getMonth() + 2, 0).toISOString().split('T')[0];
      var rowName = date.toISOString().split("-")[0]  +"-" + date.toISOString().split("-")[1];

      var conveyorId = <?php echo $wetPlant2ConveyorFeedId; ?>;
      var locationId = <?php echo $wetPlant2SampleFeedId; ?>;
      var plantId = <?php echo $wetPlant2LocationId; ?>;
      
      
      TceqAjaxCall($('#wetPlant2Table').DataTable(),'wetPlant2',rowName,startDate,endDate,conveyorId,locationId,plantId)
    }
    
    //rotary
    for(i=0; i<monthsJSON.length; i++)
    {
      var date = new Date(monthsJSON[i]);
      var startDate = date.toISOString().split('T')[0];
      var endDate = new Date(date.getFullYear(), date.getMonth() + 2, 0).toISOString().split('T')[0];
      var rowName = date.toISOString().split("-")[0]  +"-" + date.toISOString().split("-")[1];

      var conveyorId = <?php echo $rotaryConveyorFeedId; ?>;
      var locationId = <?php echo $rotarySampleFeedId; ?>;
      var plantId = <?php echo $rotaryLocationId; ?>;
      
      
      TceqAjaxCall($('#rotaryTable').DataTable(),'rotary',rowName,startDate,endDate,conveyorId,locationId,plantId)
    }
    
    
        for(i=0; i<monthsJSON.length; i++)
    {
      var date = new Date(monthsJSON[i]);
      var startDate = date.toISOString().split('T')[0];
      var endDate = new Date(date.getFullYear(), date.getMonth() + 2, 0).toISOString().split('T')[0];
      var rowName = date.toISOString().split("-")[0]  +"-" + date.toISOString().split("-")[1];

      var conveyorId = <?php echo $carrier100TConveyorFeedId; ?>;
      var locationId = <?php echo $carrier100TSampleFeedId; ?>;
      var plantId = <?php echo $carrier100TLocationId; ?>;
      
      
      TceqAjaxCall($('#carrier100Table').DataTable(),'carrier100',rowName,startDate,endDate,conveyorId,locationId,plantId)
    }
    
    
        for(i=0; i<monthsJSON.length; i++)
    {
      var date = new Date(monthsJSON[i]);
      var startDate = date.toISOString().split('T')[0];
      var endDate = new Date(date.getFullYear(), date.getMonth() + 2, 0).toISOString().split('T')[0];
      var rowName = date.toISOString().split("-")[0]  +"-" + date.toISOString().split("-")[1];

      var conveyorId = <?php echo $carrier200TConveyorFeedId; ?>;
      var locationId = <?php echo $carrier200TSampleFeedId; ?>;
      var plantId = <?php echo $carrier200TLocationId; ?>;
      
      
      TceqAjaxCall($('#carrier200Table').DataTable(),'carrier200',rowName,startDate,endDate,conveyorId,locationId,plantId)
    }
    
  }
  function TceqAjaxCall(table, jsonRow, rowTitle, startDate, endDate, conveyorId, locationId, plantId)
  {
    $.ajax
            ({
              dataType: "html",
              type: 'POST',
              url: '../../Includes/Production/tceqquery.php',
              data:
                      {
                        start_date: startDate,
                        end_date: endDate,
                        conveyor_id: conveyorId,
                        location_id: locationId,
                        plant_id: plantId,
                        json_row: jsonRow
                      },
              success: function (data)
              {
                //alert(data);
                console.log(data);
                var tceqData = JSON.parse(data);
                console.log(tceqData);
                table.row.add([
                  rowTitle,
                  tceqData.moisture_rate,
                  tceqData.tons,
                  tceqData.uptime_hours,
                  tceqData.tph,

                ]).draw();

              }

            });
  }
  
    function RainfallAjax(table, jsonRow, rowTitle, startDate, endDate)
  {
    $.ajax
            ({
              dataType: "html",
              type: 'POST',
              url: '../../Includes/Production/rainfallquery.php',
              data:
                      {
                        start_date: startDate,
                        end_date: endDate,
                        json_row: jsonRow
                      },
              success: function (data)
              {
                //alert(data);
                console.log(data);
                var rainData = JSON.parse(data);
                console.log(rainData);
                table.row.add([
                  rowTitle,
                  rainData.rainfall,
                ]).draw();

              }

            });
  }
</script>