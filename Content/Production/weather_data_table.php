<?php
/* * *****************************************************************************************************************************************
 * File Name: weather_data_table.php
 * Project: Silicore
 * Description: File displays weather data in a dataTable and graph format for Production using Weather Underground API.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 05/17/2018|zthale|KACE:23050 - Initial creation
 * 05/18/2018|zthale|KACE:23050 - Weather table added.
 * 05/21/2018|zthale|KACE:23050 - Weather graph added.
 * 06/04/2018|zthale|KACE:23044 - Added embedded <style> properties to fix minor CSS issues with text being cut-off from header, and font decreasing in size w/ Bootstrap.
 * **************************************************************************************************************************************** */

    require_once('../../Includes/security.php');
	require_once ('../../Includes/Security/dbaccess.php');

	$json_string = file_get_contents("../../Includes/JSON/weatherData.json");
	$parsed_json = json_decode($json_string, true);

   //open connection to mysql db
   $dbc = databaseConnectionInfo();
   
   $connection = mysqli_connect($dbc['silicore_hostname'], $dbc['silicore_username'], $dbc['silicore_pwd'], $dbc['silicore_dbname']) or die("Error " . mysqli_error($connection));

   //fetch table rows from mysql db
   $sql = "CALL sp_gb_plc_RainfallSummaryGet";
	$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
	$chart_data = '';
	while($row = mysqli_fetch_array($result))
	{
    $dateMonth = date("F" , strtotime($row['date_data']));
	$chart_data .= "{    Date:'".$row["date_data"]."',
                          Month:'".$dateMonth."',
						Rainfall:".$row["Rainfall"].",
					   Wind:".$row["wind"].",
					   AverageHighTemp:".$row["avg_high_temp"].", 
						AverageLowTemp:".$row["avg_low_temp"]."}, ";

	}
	$chart_values = substr($chart_data, 0, -2);
  
  //echo "<pre>";
  //var_dump($chart_values);
  //echo "</pre>";
?>

<!DOCTYPE html>
<html>
      <head>
            <title>Rainfall, Wind & Temperature | Vista Sand</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
            <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"defer="defer"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
            <script>
                    $(document).ready(function() 
                    {
                      $('#weatherDataTable').DataTable(); // $('#weatherDataTable').DataTable();
                                                        // $('#weatherDataTable').DataTable({bFilter: false}); // Removes search bar
                                                        // $('#weatherDataTable').DataTable({bFilter: false, bInfo: false}); Removes search bar and count of entries display.
                                                        // $('#weatherDataTable').DataTable({bFilter: false, bInfo: false, bLengthChange: false}); Removes search bar, count of entries display, and showing # of entries dropdown.
                                                        // Further documentation notes, see... https://datatables.net/
                    });
            </script>
            
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link href="../../Content/QC/datastyles.css" rel="stylesheet">
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
      </head>

      <body>
              <div class="header">
                    <h2>Rainfall, Wind & Temperature | Vista Sand</h2>
                    <h3>Granbury, Texas</h3>  
                    <hr />
              </div><br>

               <div class="container">
                     <h4>Weather</h4>
                      <p>*Note: Mouse-over a dotted time period to view monthly calculated results.</p>
                              <br />
                              <div id="chart"></div><br><br>
                      <h4>Rainfall</h4>
                              <div id="rainbar"></div><br><br>

                        <table class="table table-sm table-striped table-hover dt-responsive" id='weatherDataTable' name='weatherDataTable' style="width: 100%;"> 
                      <h4>Table</h4>
                            <thead>
                              <tr>
                                <th>Date</th>
                                <th>Rainfall</th>
                                <th>Wind</th>
                                <th>High Temp</th>
                                <th>Low Temp</th>
                              </tr>
                            </thead>

                            <tbody>
                            <?php
                              foreach ($parsed_json as $item)
                              {
                                $date = new datetime($item['date']);
                                $date = $date->format('Y-m-d');
                                echo "<tr>"
                                    //."<td>". $item['id'] ."</td>"
                                    ."<td>". $date ."</td>"
                                    ."<td>". $item['rainfall'] ."</td>"
                                    ."<td>". $item['wind'] ."</td>"
                                    ."<td>". $item['high_temp'] ."</td>"
                                    ."<td>". $item['low_temp'] ."</td>"
                                    ."</tr>";
                              };
                            ?>
                            </tbody>

                            <tfoot>
                            </tfoot>
                      </table><br /><br /><br />
               </div>

              <script>
                        Morris.Line({
                        element : 'chart',
                        data:[<?php echo $chart_values; ?>],
                        xkey:'Date',
                        ykeys:['Rainfall', 'Wind', 'AverageHighTemp','AverageLowTemp'],
                        labels:['(Monthly Sum) Rainfall', '(Monthly Avg.) Wind', '(Monthly Avg.) High Temperature','(Monthly Avg.) Low Temperature'],
                        hideHover:'auto'
                        //stacked:true
                        });
                        
                        Morris.Bar({
                        element : 'rainbar',
                        data:[<?php echo $chart_values; ?>],
                        xkey:'Month',
                        ykeys:['Rainfall'],
                        labels:['(Monthly Sum) Rainfall'],
                        parseTime:false,
                        hideHover:'auto'
                        //stacked:true
                        });
              </script>
      </body>
</html>