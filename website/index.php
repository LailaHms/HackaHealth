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
        <div class="row1">
        <div class="col align-self-start">
          <?php
            $connectFile = "tmp/connect.txt";
            if (!file_exists($connectFile)){
              echo ' <button type="button" id="connect" class="btn btn-outline-success">Connect</button>';
            }
            else{
              echo '<button type="button" id="disconnect" class="btn btn-outline-danger">Disconnect</button>';
            }
          ?>
        </div>
        <div class="col align-self-end center">
            <button type="button" class="btn btn-outline-secondary">Settings</button>  
        </div>
      </div>
      <div class="row2">
        <div class="col-sm align-self-start center">
            Strength<br/>
            <input id="strength" type="range"/>
        </div>
      </div>
      <div class="row3">
        <div class="col-sm align-self-start center">
            Speed<br/>
            <input id="speed" type="range"/>
        </div>
      </div>
      <div class="row2">
        <div class="col-sm align-self-start center">
            Min-Max Position<br/>
            Min<input id="min" type="range"/><br/>
            Max<input id="max" type="range"/>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <scirpt>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script>
      $( "#min" ).change(function() {
        link = 'updateSettings.php?minPosition=' + $(this).val();
        $.ajax({ url: link });
      });
      $( "#max" ).change(function() {
        link = 'updateSettings.php?maxPosition=' + $(this).val();
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
      $( "#dicconnect" ).click(function() {
        $.ajax({ url: 'stopDevice.php' });
      });
    </script>
  </body>
</html>