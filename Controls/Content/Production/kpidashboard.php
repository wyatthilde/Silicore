<?php
/* * *****************************************************************************************************************************************
 * File Name: kpidashboard.php
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/13/2017|kkuehn|KACE:17504 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

echo("kpidashboard content<br /><br />");

//========================================================================================== END PHP
?>

<!-- HTML -->
    
<style>      
#container1, #container2, #container3, #container4 
{
  width:250px; height:200px;
  display: inline-block;
  margin: 1em;
}
</style>
    
    <script src="../../Includes/gaugeSVG/javascript/gaugeSVG.js"></script>
    <script>
      window.onload = function(){
        /*
        var gauge1 = new SilicoreGauge({
			id: "container1"
        });
        
        var gauge2 = new SilicoreGauge({
			id: "container2", 
			value: 49,
			valueColor: "#444488",
			min: 30,
			max: 70,
			minmaxColor: "#444488",
			title: "Gauge 2",
			titleColor: "#8888cc",
			label: "m³/h (passage)",
			labelColor: "#8888cc",
			gaugeWidthScale: 1.25,
			gaugeBorderColor: "#222244",
			gaugeBorderWidth: 1.5,
			gaugeShadowColor: "#444488",
			gaugeShadowScale: 1.35,
			canvasBackColor: "#f8eeff",
			gaugeBackColor: "#ccccff",
			needleColor: "#8888cc",
			lowerActionLimit: -1,
			lowerWarningLimit: -1,
			upperWarningLimit: -1,
			upperActionLimit: -1,
        });
        
        var gauge3 = new SilicoreGauge({
			id: "container3", 
			value: 81, 
			title: "Gauge 3",
			label: "hits/min (beat)",
			min: 20,
			max: 120,
			lowerActionLimit: -1,
			lowerWarningLimit: 60,
			upperWarningLimit: 105,
			upperActionLimit: -1,
			optimumRangeColor: "#88ff88",
			warningRangeColor: "#f4f444"
        });
        */
		
		var gauge4 = new SilicoreGauge({
			id: "container4",
			value: .01,
			title: "Wet Plant 100 Mesh",
			label: "Tons/Hour",
			gaugeWidthScale: 1.0,
			min: 0.0,
			max: 900,
			lowerActionLimit: 650,
			lowerWarningLimit: 720,
			upperWarningLimit: 900,
			upperActionLimit: -1,
			needleColor: "#000000",
			optimumRangeColor: "#78D64B",
			warningRangeColor: "#FFCC00",
			actionRangeColor: "#FF0000"
		});
      
        setInterval(function() {
         // gauge1.refresh(gauge1.randomSampleValue(0, 100));
         // gauge2.refresh(gauge2.randomSampleValue(34, 65), true);          
          //gauge3.refresh(gauge3.randomSampleValue(66, 100), true);
          //gauge4.refresh(gauge4.randomSampleValue(0, 600)/10.0, true);
          gauge4.refresh(gauge4.randomSampleValue(690,750), true);
        }, 2000);
      };
    </script>
    
    <!--
    <div id="container1"></div>
    <div id="container2"></div>
    <p></p>
    <div id="container3"></div>
    -->
    <div id="container4"></div>
    
    
    