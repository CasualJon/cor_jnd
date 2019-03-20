<?php
  //Session, control vars and database connection settings
  session_start();
  require './php_includes/control_variables.php';
  require './php_includes/db.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Experiment main page.">
    <meta name="author" content="UW-Madison Graphics Group">
    <?php include './php_includes/favicon.html'; ?>

    <title>UW-Madison Graphics</title>
    <?php include './assets/css/styleIn.html'; ?>
  </head>

  <body>
    <div class="container">
      <?php
        if ($_SESSION['admin'] === 1) {
          echo '
            <div class="row">
              <div class="col-md-12 admin-banner">
                <h2>Admin Mode</h2>
              </div>
            </div>
          ';
        }
      ?>

      <div class="row">
        <div class="col-md-12">
          <h3>Feedback #3 <span class="semi_transp">(of 5)</span></h3>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <hr />

      <div class="row">
        <div class="col-md-12">
          <h4><u>Correlation</u></h4>
        </div> <!-- /column -->
      </div> <!-- /row -->

      <div class="row">
        <div class="col-md-6 text-center">
          <div class="img-feedback">
            <img src="./assets/img/examples/edu_3/xy_data_practice_xp3a_yp3a_scatter.png" id="edu_a"/>
            <i class="far fa-check-circle" style="color: green"></i>
          </div>
        </div> <!-- /column -->
        <div class="col-md-6 text-center">
          <div class="img-feedback">
            <img src="./assets/img/examples/edu_3/xy_data_practice_xp3_yp3_scatter.png" id="edu_b"/>
            <i class="far fa-times-circle" style="color: red"></i>
          </div>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <br />

      <div class="row">
        <div class="col-md-12">
          <?php
            //A was the correct option for Background Question 3
            if ($_GET['sel'] == "A") {
              echo '
                <h4>Nice work!</h4>
                <p>
                  You are correct.
                </p>
                <p>
                  Here, the plot on the left has a correlation of 0.6 while the
                  plot on the right has a correlation of 0.3.
                </p>
              ';
            }
            else {
              echo '
                <h4>Not quite.</h4>
                <p>
                  Remember that data which is <i>more correlated</i> will
                  resemble a straight line at a 45-degree angle from the bottom
                  left. So, even if two plots have an overall trend moving from
                  bottom left to top right, a higher correlation value will be
                  more tightly packed and try to span corner-to-corner.
                </p>
                <p>
                  Here, the plot on the left has a correlation of 0.6 while the
                  plot on the right has a correlation of 0.3.
                </p>
              ';
            }
          ?>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <br /><br />

      <div class="row">
        <div class="col-md-12 text-center">
          <button class="btn btn-lg btn-outline-danger" onclick="executeUserSelection(4)" id="continue_button" disabled>
            <b style="font-size: 38px">Continue</b>
          </button>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <br />

      <?php
        if ($_SESSION['admin'] === 1) {
          echo "<hr /><p>";
          var_dump($_SESSION);
          echo "<p>";
        }
      ?>

    </div> <!-- /container -->
    <?php include './assets/js/universal.html'; ?>
    <script src="./assets/js/feedback.js"></script>
  </body>
</html>
