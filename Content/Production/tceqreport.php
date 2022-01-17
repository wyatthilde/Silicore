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
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');
require_once('../../Includes/Production/gb_plc_tagGlobal.php');



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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<!-- HTML -->
<script type="text/javascript" src=" https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script> 
<!-- Include fusion theme -->
<script type="text/javascript" src=" https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script> 

<style>


    .card {
        margin-bottom: 1%;
    }
    .hidden
    {
      display:none;
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
          <canvas id="rainfall-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
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
          <canvas id="wetplant1-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
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
          <canvas id="wetplant2-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
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
          <canvas id="rotary-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
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
          <canvas id="carrier200-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
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
          <canvas id="carrier100-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
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
        },
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue rainfall-button',
            action: function(){
                $('#rainfall-table-chart-container').toggle();
              }
        },
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
        },
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue wp1-button hidden',
            action: function(){
                $('#wetplant1-table-chart-container').toggle();
              }
        },
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
        },
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue wp2-button hidden',
            action: function(){
                $('#wetplant2-table-chart-container').toggle();
              }
        },
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
        },
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue rotary-button hidden',
            action: function(){
                $('#rotary-table-chart-container').toggle();
              }
        },
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
        },
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue carrier200-button hidden',
            action: function(){
                $('#carrier200-table-chart-container').toggle();
              }
        },
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
        },
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue carrier100-button hidden',
            action: function(){
                $('#carrier100-table-chart-container').toggle();
              }
        },
      ]
    });

    $('.dt-buttons').removeClass('btn-group');
    $('.btn').removeClass('btn-secondary');
    TablesLoad();
    
  });
  
  
  function TablesLoad()
  {
    var monthsJSON = <?php echo $jsonMonthArry; ?>;
    
    $.when($.ajax(RainfallAjax($('#rainfallTable').DataTable(),'rainfall',monthsJSON))).then(function(){
      RainfallChartLoad();
    });
    $.when($.ajax(TceqAjaxCall($('#wetPlant1Table').DataTable(),'wetPlant1',<?php echo $wetPlant1ConveyorFeedId; ?>,<?php echo $wetPlant1SampleFeedId; ?>,<?php echo $wetPlant1LocationId; ?>,monthsJSON))).then(function()
    {
      ChartLoad($('#wetPlant1Table').DataTable(),$('#wetplant1-table-chart-container'));
      $('.wp1-button').removeClass('hidden')
    });

    $.when($.ajax(TceqAjaxCall($('#wetPlant2Table').DataTable(),'wetPlant2',<?php echo $wetPlant2ConveyorFeedId; ?>,<?php echo $wetPlant2SampleFeedId; ?>,<?php echo $wetPlant2LocationId; ?>,monthsJSON))).then(function()
    {
      ChartLoad($('#wetPlant2Table').DataTable(),$('#wetplant2-table-chart-container'));
      $('.wp2-button').removeClass('hidden')
    });

    $.when($.ajax(TceqAjaxCall($('#rotaryTable').DataTable(),'rotary',<?php echo $rotaryConveyorFeedId; ?>,<?php echo $rotarySampleFeedId; ?>,<?php echo $rotaryLocationId; ?>,monthsJSON))).then(function()
    {
      ChartLoad($('#rotaryTable').DataTable(),$('#rotary-table-chart-container'));
      $('.rotary-button').removeClass('hidden')
    });
    
    $.when($.ajax(TceqAjaxCall($('#carrier200Table').DataTable(),'carrier200',<?php echo $carrier200TConveyorFeedId; ?>,<?php echo $carrier200TSampleFeedId; ?>,<?php echo $carrier200TLocationId; ?>,monthsJSON))).then(function()
    {
      ChartLoad($('#carrier200Table').DataTable(),$('#carrier200-table-chart-container'));
      $('.carrier200-button').removeClass('hidden')
    });
    
    $.when($.ajax(TceqAjaxCall($('#carrier100Table').DataTable(),'carrier100',<?php echo $carrier100TConveyorFeedId; ?>,<?php echo $carrier100TSampleFeedId; ?>,<?php echo $carrier100TLocationId; ?>,monthsJSON))).then(function()
    {
      ChartLoad($('#carrier100Table').DataTable(),$('#carrier100-table-chart-container'));
      $('.carrier100-button').removeClass('hidden')
    });


  }
  function TceqAjaxCall(table, jsonRow,conveyorId, locationId, plantId, monthsArry)
  {
    for(i=0; i<monthsArry.length; i++)
    {      
      var date = new Date(monthsArry[i]);
      var startDate = date.toISOString().split('T')[0];
      var endDate = new Date(date.getFullYear(), date.getMonth() + 2, 0).toISOString().split('T')[0];
      var rowDate = date.toISOString().split("-")[0]  +"-" + date.toISOString().split("-")[1];
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
                        row_date : rowDate,
                        json_row: jsonRow
                      },
              success: function (data)
              {
                //alert(data);
                //console.log(data);
                var tceqData = JSON.parse(data);
                //console.log(tceqData);
                table.row.add([
                  tceqData.row_date,
                  tceqData.moisture_rate,
                  tceqData.tons,
                  tceqData.uptime_hours,
                  tceqData.tph,

                ]).draw();
                return tceqData;
              }

            });
        }
  } 
  function RainfallAjax(table, jsonRow, monthsArry)
  {    
    for(i=0; i<monthsArry.length; i++)
    {      
      var date = new Date(monthsArry[i]);
      //splits the start and end dates from time
      var startDate = date.toISOString().split('T')[0];
      var endDate = new Date(date.getFullYear(), date.getMonth() + 2, 0).toISOString().split('T')[0];
      var rowDate = date.toISOString().split("-")[0]  +"-" + date.toISOString().split("-")[1];
      $.ajax
            ({
              dataType: "html",
              type: 'POST',
              url: '../../Includes/Production/rainfallquery.php',
              'language' : {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner"></div>'
              },
              data:
                      {
                        start_date: startDate,
                        end_date: endDate,
                        row_date : rowDate,
                        json_row: jsonRow
                      },
              success: function (data)
              {
                //alert(data);

                var rainData = JSON.parse(data);

                table.row.add([
                  rainData.row_date,
                  rainData.rainfall,
                ]).draw();
                return rainData;
              }

            });
    }
  }
  function RainfallChartLoad()
  {
    var rowCount = $('#rainfallTable').DataTable().rows().count();
    var data = $('#rainfallTable').DataTable().rows().data();
    var chartData = [];
    var labels = [];
    for(i=0;i<rowCount;i++)
      {
        
        labels.push(data[i][0]);
        chartData.push(data[i][1]);
         
        
      }

    var rainfallCanvas = $("#rainfall-table-chart-container");
    var rainfallChart = new Chart(rainfallCanvas, {
       type: 'bar',
      data: {
         labels: labels,
         datasets: [{
             data: chartData,
             backgroundColor: 'rgba(76, 122, 208, 0.2)',
             borderColor: 'rgba(76, 122, 208)',
             borderWidth: 1
         }]
     },
      options: {
         legend: {
             display: false
         },
         title: {
             display: true,
             text: 'Rainfall Per Month(IN)'
         },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
    }); 
    rainfallCanvas.hide();

  }
  
  function ChartLoad(datatable,chartContainer)
  {
    var rowCount = datatable.rows().count();
    var data = datatable.rows().data();
    var chartData = [];
    var labels = [];
    for(i=0;i<rowCount;i++)
      {
        
        labels.push(data[i][0]);
        chartData.push(data[i][2]);
         
        
      }

    var chartCanvas = chartContainer;
    var chart = new Chart(chartCanvas, {
       type: 'bar',
      data: {
         labels: labels,
         datasets: [{
             data: chartData,
             backgroundColor: 'rgba(76, 122, 208, 0.2)',
             borderColor: 'rgba(76, 122, 208)',
             borderWidth: 1
         }]
     },
      options: {
         legend: {
             display: false
         },
         title: {
             display: true,
             text: 'Tons Per Month'
         },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
    }); 
    chartCanvas.hide();
    

  }

</script>