$(function(){
    $("#background-btn").click(function(){
        modifyBackground();
    });

    $("#canvas-btn").click(function(){
        modifyCanvas();
    });

    $("#dataplot-btn").click(function(){
        modifyDataplot();
    });

    apiChart.render();
});

function modifyBackground(){
    //to be implemented
}

function modifyCanvas(){
    //to be implemented
}

function modifyDataplot(){
    //to be implemented
}


$(function(){
 
            
      $.ajax({
        url: '../../Includes/QC/performanceChartData.json',
        type: 'GET',
        success : function(data) {
          chartData = data;
          var chartProperties = {
            "caption": "QC Performance Chart",
            "xAxisName": "Test",
            "yAxisName": "Number",
            "rotatevalues": "1",
            "theme": "zune"
          };
		  
		  
          apiChart = new FusionCharts({
            type: 'pie2d',
            renderAt: 'chart-container',
            width: '550',
            height: '350',
            dataFormat: 'json',
            dataSource: {
              "chart": chartProperties,
              "data": chartData
            }
          });
          apiChart.render();
        }
      });
    });
