<!DOCTYPE php>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
      <div class="row row1">
      <div class="col align-self-start">
        <?php
          $connectFile = "tmp/connect.txt";
          if (!file_exists($connectFile)){
            echo '<img src="res/wifi_red.png" style="width:20%; margin-right: 10px;">';
            echo '<button type="button" id="connect" class="btn btn-success">Connect</button>';
          }
          else{
            echo '<button type="button" id="disconnect" class="btn btn-danger">Disconnect</button>';
          }
        ?>
      </div>
      <div class="col align-self-center"></div>
      <div class="col align-self-end" style="text-align: right;">
        <?php
            echo '<button type="button" id="return" class="btn btn-danger">Return</button>';
        ?>
        <img src="res/gears.png" style="width:30%;">
        <!-- <button type="button" class="btn btn-outline-secondary">Settings</button>  -->
      </div>
    </div>
      <div class="col-sm align-self-start box2 center">
					<div id="chartContainer" style="height: 300px; width: 100%;"></div>
      </div>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>


<head>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script> $( "#return" ).click(function() {
  window.location.href='index.php'
});</script>


<script> $( "#return" ).click(function() {
  window.location.href='index.php'
});</script>

<script>

window.onload = function () {

var dps = []; // dataPoints
var chart = new CanvasJS.Chart("chartContainer", {
	title :{
		text: "Sensor Readings"
	},
	axisX: {
		title : "Time [seconds]"
	},
	axisY: {
		includeZero: false
	},
	data: [{
		type: "line",
		dataPoints: dps
	}],
});


var xVal = 0;
var yVal = 0;
var num_val = 10;
var updateInterval = 100; //ms
var sampling_freq = 50;
var dataLength = 1000; // number of dataPoints visible at any point
var count = 0;
var sensor_value = 2;

var updateChart = function (text_string, sensor_value,count) {

	count = count || 1;

	lines = text_string.split("\n")

	for(var i = 0; i < lines.length ; i++){
				numbers = lines[i].split(" ")
				yVal = parseFloat(numbers[sensor_value])
				//console.log("line ", i, "row", sensor_value, "value", yVal)

				dps.push({
					x: xVal,
					y: yVal
				});
				xVal += 1/sampling_freq;

				if (dps.length > dataLength) {
					dps.shift();
				}
	}
	console.log(dps.length)



	chart.render();
};


function realtime_plot(sensor_value, count){
	$.ajax({ url: "readEMGvalues.php", complete:function(jqxhr, txt_status){
				text_string = 	jqxhr.responseText
				//console.log(text_string)
				//console.log(sensor_value)
				updateChart(text_string, sensor_value,count);
				//setInterval(function(){updateChart()}, updateInterval);
	}
	});
}

realtime_plot(sensor_value, dataLength)

setInterval(function(){realtime_plot(sensor_value)}, updateInterval);


}
</script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
