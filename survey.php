<?php
  //Session, control vars and database connection settings
  session_start();
  require './php_includes/control_variables.php';
  require './php_includes/db.php';
  if (!isset($_SESSION['exp_data'])) {
    require './php_includes/survey_setup.php';
  }

  if (!isset($_SESSION['exp_data']) || empty($_SESSION['exp_data'])) {
    $_SESSION['message'] = "An error occurred in configuring the survey data.";
    header("location: ./error.php");
    exit;
  }

  //Set SESSION variables to track survey control
  if (!isset($_SESSION['survey'])) {
    $_SESSION['survey']['begin_time'] = time();
    $_SESSION['survey']['intervention_comp'] = false;
    $_SESSION['survey']['curr_question'] = 0;
    $_SESSION['survey']['score'] = 0;
    $_SESSION['survey']['response'] = array();
  }
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

      <!-- Survey header information (updated by JS) -->
      <div class="row">
        <div class="col-md-10">
          <h3>
            <span id="question_title"></span>
            <span class="semi_transp">(of 21)</span>
          </h3>
        </div> <!-- /column -->
        <div class="col-md-2">
          <h3>
            Seconds: <span class="semi_transp" id="num_seconds">0</span>
          </h3>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <hr />

      <!-- Survey question data -->
      <div class="row">
        <div class="col-md-12">
          <h5>Select the chart that shows a higher correlation:</h5>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <div class="row">
        <div class="col-md-6 text-center">
          <label class="image-checkbox" id="container_a">
            <img id="opt_a"/>
            <input type="checkbox" id="check_a" name="image[]" value="" />
            <i class="fa fa-check" id="sel_a" hidden></i>
          </label>
        </div> <!-- /column -->
        <div class="col-md-6 text-center">
          <label class="image-checkbox" id="container_b">
            <img id="opt_b"/>
            <input type="checkbox" id="check_b" name="image[]" value="" />
            <i class="fa fa-check" id="sel_b" hidden></i>
          </label>
        </div> <!-- /column -->
      </div> <!-- /row -->

      <div class="row">
        <div class="col-md-12 text-center" id="confident_select" style="display: none">
          <p>
            On a scale of 1 <small class="semi_transp">(not at all)</small> to
            7 <small class="semi_transp">(very much)</small>, how confident
            are you that your choice is correct?
          </p>
          <div class="btn-group btn-group-lg">
            <button type="button" class="btn" onclick="setConfidence(1)" id="conf1">1</button>
            <button type="button" class="btn" onclick="setConfidence(2)" id="conf2">2</button>
            <button type="button" class="btn" onclick="setConfidence(3)" id="conf3">3</button>
            <button type="button" class="btn" onclick="setConfidence(4)" id="conf4">4</button>
            <button type="button" class="btn" onclick="setConfidence(5)" id="conf5">5</button>
            <button type="button" class="btn" onclick="setConfidence(6)" id="conf6">6</button>
            <button type="button" class="btn" onclick="setConfidence(7)" id="conf7">7</button>
          </div>
          <br /><br />
        </div> <!-- /column -->
      </div> <!-- /row -->

      <div class="row">
        <div class="col-md-12 text-center">
          <button class="btn btn-lg btn-outline-danger" onclick="executeUserSelection(1)" id="continue_button" style="display: none" disabled>
            <b style="font-size: 38px">Continue</b>
          </button>
        </div> <!-- /column -->
      </div> <!-- /row -->

      <?php
        if ($_SESSION['admin'] === 1) {
          echo "<hr /><p>";
          var_dump($_SESSION);
          echo "<p>";
        }
      ?>

    </div> <!-- /container -->
    <?php include './assets/js/universal.html'; ?>
    <script src="./assets/js/survey.js"></script>
  </body>
</html>
