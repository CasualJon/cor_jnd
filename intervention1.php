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
        <div class="col-md-10">
          <h3>Practice #1 <span class="semi_transp">(of 5)</span></h3>
        </div> <!-- /column -->
        <div class="col-md-2">
          <h3>
            Seconds: <span class="semi_transp" id="num_seconds">0</span>
          </h3>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <hr />

      <div class="row">
        <div class="col-md-12">
          <p>
            In these first five examples, we'll explore some background
            context about the concept of correlation.
          </p>
          <br />

          <h4><u>What is Correlation?</u></h4>
          <p>
            Correlation is a statistical measure that describes if and to
            what degree pairs of variables (X,Y) are related. More specifically,
            correlation illustrates the magnitude of the <u><i>linear</i></u>
            relationship between two continuous variables. Correlation can range
            from -1 (perfect negative linear relationship) to 1 (perfect positive
            relationship) with 0 indicating no linear relationship.
            Note however that a correlation of or close to 0 does not necessarily
            mean X and Y are not related but only indicates they are not
            <u><i>linearly</i></u> related.
          </p>
          <p>
            Here, your variables are demonstrated by the 2 axes of the of the
            chart: the horizontal (X) and the vertical (Y). All variable pairs
            in this experiment have correlations from 0 to 1 (no negative
            correlations). Higher correlation means that there is a stronger link
            between the horizontal and the vertical values of individual points.
            A point with a lower horizontal value will generally have a lower
            vertical value if the variables are strongly correlated. Similarly,
            as one variable increases, so should the other.
          </p>
          <!-- <p>
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
          </p> -->
          <!-- <p>
            Correlation is a relationship between two or more things. As a
            technique in statistics, correlation can can show whether -
            and how strongly - pairs of variables are related. For example,
            height and weight are related in that taller people tend to be
            heavier than shorter people.
          </p>
          <p>
            Here, your variables are demonstrated by the 2 axes of the of the
            chart: the horizontal and the vertical. Higher correlation means
            that there is a stronger link between the horizontal and the vertical
            values of individual points. A point with a lower horizontal value
            will generally have a lower vertical value if the variables are strongly
            correlated. Similarly, as one variable increases, so should the other.
          </p> -->
          <br />
          <h5>Click on the visualization that appears to have the larger correlation:</h5>
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
        <div class="col-md-12 text-center" id="confident_select" style="display: none">
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
        </div> <!-- /column -->
      </div> <!-- /row -->

      <div class="row">
        <div class="col-md-12 text-center">
          <button class="btn btn-lg btn-outline-danger" onclick="executeUserSelection(1)" id="continue_button" style="display: none" disabled>
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
