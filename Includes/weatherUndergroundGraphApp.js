/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
  $.ajax({
      url: "http://silicore-dev.vistasand.com/Batch/PLC/gb_plc_weatherUndergroundTransfer.php",
      method: "GET",
      success: function(data) {
        console.log(data);
        var rainfall = [];
        var wind = [];
        var highTemperature = [];
        var lowTemperature = [];
        
        for(var i in data)
        {
          rainfall.push("Rainfall " + data[i].rainfall);
          wind.push("Wind " + data[i].wind);
          highTemperature.push("High Temperature " + data[i].high_temp);
          lowTemperature.push("Low Temperature " + data[i].low_temp);
        }
        
        var chartdata = {
            labels: rainfall, 
            datasets : [
              {
                label: 'Rainfall',
                backgroundColor: 'rgba(200, 200, 200, 0.75)',
                borderColor: 'rgba(200, 200, 200, 0.75)',
                hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                hoverBorderColor: 'rgba(200, 200, 200, 1)',
                data: rainfall
              }
            ]
        };
        
        var ctx = $("#mycanvas");
        
        var barGraph = new Chart(ctx, {
              type: 'bar',
              data: chartdata
        });
        
      },
      error: function(data) {
        console.log(data);
      }
  });
});