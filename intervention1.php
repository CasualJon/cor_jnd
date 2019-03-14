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
          <h3>Background #1 <span class="semi_transp">(of 3)</span></h3>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <hr />

      <div class="row">
        <div class="col-md-12">
          <p>
            In these first three examples, we'll provide some background
            context about concepts you will be asked to explore in the experiment.
          </p>
          <br />

          <h4><u>Correlation Definition</u></h4>
          <p>
            The magnitude of Cor(X,Y) measures the strength of the linear relationship
            between X and Y. You can calculate correlation using the following
            equation (note that this is not required for the experiment but only
            used for definition purposes).
          </p>
          <img src="./assets/img/examples/cor_def.png" width="400" />
          <br><br>

          <p>
            Correlation can also be thought of as the ratio of the covariance
            (mean value of the product of the deviations of two variates from their
            respective means) to the standard deviation of the variables.
          </p><br>

          <p>Cor(X,Y) can range from -1 to 1, and the stronger the linear relationship
            between Y and X the closer |Cor(X,Y)| to 1.  Note, however, that
            Cor(X,Y) = 0 does not necessarily mean Y and X are not related but
            only indicates they are not linearly related.
          </p>
          <!-- <p>
            Correlation is a statistical technique that can show whether -
            and how strongly - pairs of variables are related. For example,
            height and weight are related in that taller people tend to be
            heavier than shorter people.
          </p>
          <p>
            Here, your variables are demonstrated by the 2 axes of the of the
            chart: the horizontal and the vertical. Higher correlation means
            that as one increases, so should the other.
          </p> -->
          <br />
          <h5>Select the chart that shows a higher correlation:</h5>
        </div> <!-- /column -->
      </div> <!-- /row -->

      <div class="row">
        <div class="col-md-6 text-center">
          <label class="image-checkbox" id="container_a">
            <img src="./assets/img/examples/edu_1/xy_data_practice_xp1_yp1_scatter.png" id="edu_a"/>
            <input type="checkbox" id="check_a" name="image[]" value="" />
            <i class="fa fa-check" id="sel_a" hidden></i>
          </label>
        </div> <!-- /column -->
        <div class="col-md-6 text-center">
          <label class="image-checkbox" id="container_b">
            <img src="./assets/img/examples/edu_1/xy_data_practice_xp1a_yp1a_scatter.png" id="edu_b"/>
            <input type="checkbox" id="check_b" name="image[]" value="" />
            <i class="fa fa-check" id="sel_b" hidden></i>
          </label>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <br />

      <div class="row">
        <div class="col-md-12 text-center">
          <p>
            On a scale of 1 <small class="semi_transp">(very unsure)</small> to
            7 <small class="semi_transp">(very sure)</small>, how confident
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

          <button class="btn btn-lg btn-outline-danger" onclick="executeUserSelection(1)" id="continue_button" disabled>
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
    <script src="./assets/js/intervention.js"></script>
  </body>
</html>
