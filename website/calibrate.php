
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
      <div class="col-5 col align-self-start">
        <?php
          $connectFile = "tmp/connect.txt";
          if (!file_exists($connectFile)){
            echo '<img src="res/wifi_red.png" style="width:20%; margin-right: 10px;">';
            echo '<button type="button" id="connect" class="btn btn-success">Connect</button>';
          }
          else{
            echo '<img src="res/wifi_green.png" style="width:20%; margin-right: 10px;">';
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
          <h1><center><br />Don't Move <img src = "./Interface/Icons/happy.png"/ style="max-width:10%;width:auto;height:auto;"> </center></h1>
              <center>
              <br />
              <div class=rotating_image>
                  <img src = "./Interface/Icons/hourglass.svg" style="max-width:100%;width:auto;height:auto;" align="center" id = "hourglass">
              </div>
              <br />
            </center>
      </div>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script> $( "#return" ).click(function() {
      window.location.href='index.php'
    });</script>

  </body>
</html>
