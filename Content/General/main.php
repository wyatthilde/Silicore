<?php
/* * *****************************************************************************
 * File Name: main.php
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Oct 30, 2016[1:40:41 PM]
 * Description:  Content file for the Home page
 * Notes: 
 * **************************************************************************** */


//==================================================================== BEGIN PHP
//header("Location: https://silicore.vprop.com/");
require_once('../../Includes/Security/database.php');

$database = new Database();

$sql = "sp_safety_SafeDaysGet()";
$today = date('Y-m-d');
//echo($database->geterror($sql));

$safeDayArry = json_decode($database->get($sql),true);
//print_r($safeDayArry);
$dateGb = date('Y-m-d', strtotime($safeDayArry[0]['gb_date']));
$dateTl = date('Y-m-d', strtotime($safeDayArry[0]['tl_date']));
$dateWt = date('Y-m-d', strtotime($safeDayArry[0]['wt_date']));
$date58 = date('Y-m-d', strtotime($safeDayArry[0]['58_date']));

$daysGb = max(floor((strtotime($today) - strtotime($dateGb))/(60*60*24)),0);
$daysTl = max(floor((strtotime($today) - strtotime($dateTl))/(60*60*24)),0);
$daysWt = max(floor((strtotime($today) - strtotime($dateWt))/(60*60*24)),0);
$days58 = max(floor((strtotime($today) - strtotime($date58))/(60*60*24)),0);

//====================================================================== END PHP
?>

<h2 class="text-center">DAYS SINCE LAST INCIDENT</h2>
<div class="container-fluid">
  <div class="row text-center">
    <div class="col">
      <div class="counter">
        <div class="card shadow">
          <div class="card-body">
            <i class="fa fa-exclamation-triangle fa-2x"></i>
            <p class="font-weight-bold">Granbury</p>
            <h2 class="timer count-title count-number" data-to="<?php echo $daysGb ?>" data-speed="1500"></h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="counter">
        <div class="card shadow">
          <div class="card-body">
            <i class="fa fa-exclamation-triangle fa-2x"></i>
            <p class="font-weight-bold ">58 Acres</p>
            <h2 class="timer count-title count-number" data-to="<?php echo $days58 ?>" data-speed="1500"></h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="counter">
        <div class="card shadow"> 
          <div class="card-body">
            <i class="fa fa-exclamation-triangle fa-2x"></i>
            <p class="font-weight-bold ">Tolar</p>
            <h2 class="timer count-title count-number" data-to="<?php echo $daysTl ?>" data-speed="1500"></h2>
          </div>
        </div>
      </div></div>
    <div class="col">
      <div class="counter">
        <div class="card shadow">   
          <div class="card-body">
            <i class="fa fa-exclamation-triangle fa-2x"></i> 
            <p class="font-weight-bold ">West Texas</p>
            <h2 class="timer count-title count-number" data-to="<?php echo $daysWt ?>" data-speed="1500"></h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  (function ($) {
	$.fn.countTo = function (options) {
		options = options || {};
		
		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 0,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals);
	}
}(jQuery));

jQuery(function ($) {
  // custom formatting example
  $('.count-number').data('countToOptions', {
	formatter: function (value, options) {
	  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
  });
  
  // start all the timers
  $('.timer').each(count);  
  
  function count(options) {
	var $this = $(this);
	options = $.extend({}, options || {}, $this.data('countToOptions') || {});
	$this.countTo(options);
  }
});
  </script>