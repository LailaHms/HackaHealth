<!DOCTYPE html>
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
        <div class="col align-self-center">
          <center>
          <?php
              echo '<button type="button" id="calibrate" class="btn btn-danger">Calibrate</button>';
          ?>
        </center>
        </div>
        <div class="col align-self-end" style="text-align: right;">
            <?php
                echo '<button type="button" id="plot" class="btn btn-info">Plots</button>';
            ?>
          <img src="res/gears.png" style="width:30%;">
          <!-- <button type="button" class="btn btn-outline-secondary">Settings</button>  -->
        </div>
      </div>
      <div class="row row2">
        <div class="col-sm align-self-start">

        </div>
        <div class="col-sm align-self-center center">
            <img src="res/strong.png" style="width:80%;"/><br/>
        </div>
        <div class="col align-self-end">
        </div>
      </div>
      <div class="row row2">
        <div class="col-sm align-self-center center">
          Strength<br/>
          <input id="strength" type="range" style="width: 80%;"/>
        </div>
      </div>
      <div class="row row3">
        <div class="col-sm align-self-start">

        </div>
        <div class="col-sm align-self-center center">
            <img src="res/speedometer.svg" style="width:80%;"/><br/>
        </div>
        <div class="col align-self-end">
        </div>
      </div>
      <div class="row row3">
        <div class="col-sm align-self-center center">
          Speed<br/>
          <input id="speed" type="range" style="width: 80%;"/>
        </div>
      </div>
      <div class="row row2">

        <div class="col-sm align-self-start center positions">

          <div class="arms">
            <img src="res/arm1.png" id="arm1" style="width:10%; position: absolute; z-index: 2;">
            <img src="res/hand.png" id="hand1" style="width:13%; position: absolute;  z-index: 1;">
            <img src="res/arm2.png" id="arm2" style="width:10%; position: absolute; z-index: 2;">
            <img src="res/hand.png" id="hand2" style="width:13%; position: absolute;  z-index: 1;">
            <img src="res/arm3.png" id="arm3" style="width:10%; position: absolute; z-index: 2;">
            <img src="res/hand.png" id="hand3" style="width:13%; position: absolute;  z-index: 1;">
          </div>
          <div style="margin-top: ">
            Position<br/>
            Min<input id="min" type="range" style="width: 80%;"/><br/>
            Ref<input id="ref" type="range" style="width: 80%;"/><br/>
            Max<input id="max" type="range" style="width: 80%;"/>
          </div>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script>
      $(function() {
          var div = $('.arms');
          var width = div.width();

          div.css('height', width*0.5);
          $("#arm1").css('top','5px');
          $("#hand1").css('top',$("#arm1").position().top + $("#arm1").height() * 0.85+'px');
          $("#arm1").css('left',width/20+'px');
          $("#hand1").css('left',width/21+'px');
          $("#hand1").css('-webkit-transform-origin','25% 0%');
          $("#hand1").css('transform', 'rotate(-'+ $("#min").val() + 'deg)');
          $("#arm2").css('top','5px');
          $("#hand2").css('top',$("#arm1").position().top + $("#arm1").height() * 0.85+'px');
          $("#arm2").css('left',width/2 - width/10+'px');
          $("#hand2").css('left',width/2 - width/10+'px');
          $("#hand2").css('-webkit-transform-origin','25% 0%');
          $("#hand2").css('transform', 'rotate(-'+ $("#ref").val() + 'deg)');
          $("#arm3").css('top','5px');
          $("#hand3").css('top',$("#arm1").position().top + $("#arm1").height() * 0.85+'px');
          $("#arm3").css('left',width*2/3 + width/20 +'px');
          $("#hand3").css('left',width*2/3+ width/20+'px');
          $("#hand3").css('-webkit-transform-origin','25% 0%');
          $("#hand3").css('transform', 'rotate(-'+ $("#max").val() + 'deg)');
      });
      function updateMin(){
        if(parseFloat($('#min').val()) > parseFloat($("#ref").val())){
          $("#ref").val($('#min').val());
          $("#hand2").css('transform', 'rotate(-'+ $('#min').val() + 'deg)');
        }
        if(parseFloat($('#min').val()) > parseFloat($("#max").val())){
          $("#max").val($('#min').val());
          $("#hand3").css('transform', 'rotate(-'+ $('#min').val() + 'deg)');
        }
        $("#hand1").css('transform', 'rotate(-'+ $('#min').val() + 'deg)');
      }
      function updateRef(){
        if(parseFloat($('#ref').val()) > parseFloat($("#max").val())){
          $("#max").val($('#ref').val());
          $("#hand3").css('transform', 'rotate(-'+ $('#ref').val() + 'deg)');
        }
        if(parseFloat($('#ref').val()) < parseFloat($("#min").val())){
          $("#min").val($('#ref').val());
          $("#hand1").css('transform', 'rotate(-'+ $('#ref').val() + 'deg)');
        }
        $("#hand2").css('transform', 'rotate(-'+ $('#ref').val() + 'deg)');
      }
      function updateMax(){
        if(parseFloat($('#max').val()) < parseFloat($("#ref").val())){
          $("#ref").val($('#max').val());
          $("#hand2").css('transform', 'rotate(-'+ $('#max').val() + 'deg)');
        }
        if(parseFloat($('#min').val()) > parseFloat($("#max").val())){
          $("#min").val($('#max').val());
          $("#hand3").css('transform', 'rotate(-'+ $('#max').val() + 'deg)');
        }
        $("#hand3").css('transform', 'rotate(-'+ $('#max').val() + 'deg)');
      }
      $( "#min" ).change(function() {
        updateMin();
        link = 'updateSettings.php?minPosition=' + $(this).val();
        $.ajax({ url: link });
      });
      $( "#max" ).change(function() {
        updateMax();
        link = 'updateSettings.php?maxPosition=' + $(this).val();
        $.ajax({ url: link });
      });
      $( "#ref" ).change(function() {
        updateRef();
        link = 'updateSettings.php?refPosition=' + $(this).val();
        $.ajax({ url: link });
      });
      $( "#speed" ).change(function() {
        link = 'updateSettings.php?speed=' + $(this).val();
        $.ajax({ url: link });
      });
      $( "#strength" ).change(function() {
        link = 'updateSettings.php?strength=' + $(this).val();
        $.ajax({ url: link });
      });
      $( "#connect" ).click(function() {
        $.ajax({ url: 'startDevice.php' });
      });
      $( "#calibrate" ).click(function() {
        window.location.href='calibrate.php'
      });
      $( "#plot" ).click(function() {
        window.location.href='plot.php'
      });
      $( "#dicconnect" ).click(function() {
        $.ajax({ url: 'stopDevice.php' });
      });
    </script>
  </body>
</html>
