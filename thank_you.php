<?php
  //Session, control vars and database connection settings
  session_start();
  require './php_includes/control_variables.php';
  require './php_includes/db.php';

  $hit_completion_code = "".$_SESSION['ip_address']."|".$_SESSION['$curr_date'];
  $hit_completion_code = md5($hit_completion_code);
  $done = false;

  if (!isset($_SESSION['done']) && $_SESSION['admin'] != 1) {
    $q1 = false;
    $q2 = false;
    $engaged = 0;
    $data = "".$_SESSION['internal_identifier'].",";
    //Given new difficulty, removing 109 pair from engagement check... $_SESSION['engagement'][0] == 1 &&
    if ($_SESSION['engagement'][0] == 1 && $_SESSION['engagement'][1] == 1 && $_SESSION['engagement'][2] == 1) {
      $engaged = 1;
      $data .= "1,";
    }
    else {
      $data .= "0,";
    }
    $data .= $_SESSION['survey']['score'].",";
    for ($i = 0; $i < sizeof($_SESSION['survey']['response']); $i++) {
      $data .= $_SESSION['survey']['response'][$i]['question#'].",";
      $data .= $_SESSION['survey']['response'][$i]['A'].",";
      $data .= $_SESSION['survey']['response'][$i]['B'].",";
      $data .= $_SESSION['survey']['response'][$i]['correctness'].",";
      $data .= $_SESSION['survey']['response'][$i]['confidence'].",";
      $data .= $_SESSION['survey']['response'][$i]['seconds'].",";
    }
    $result_stmt = $mysqli->stmt_init();
    $query = "INSERT INTO responses (internal_identifier, engaged, total_score, response) VALUES(?, ?, ?, ?)";
    $result_stmt->prepare($query);
    $result_stmt->bind_param("iiis", $_SESSION['internal_identifier'], $engaged, $_SESSION['survey']['score'], $data);
    $q1 = $result_stmt->execute();
    $result_stmt->close();

    $curr_time = date("h:i a");
    $query = "UPDATE workers SET end_time=?, hit_completion_code=? WHERE internal_identifier=?";
    $comp_stmt = $mysqli->stmt_init();
    $comp_stmt->prepare($query);
    $comp_stmt->bind_param("ssi", $curr_time, $hit_completion_code, $_SESSION['internal_identifier']);
    $q2 = $comp_stmt->execute();
    $comp_stmt->close();

    $done = $q1 && $q2;
  }

  if ($done) $_SESSION['done'] = true;
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
    <?php include './assets/css/styleOut.html'; ?>
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
          <h3>Thank you!</h3>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <hr />

      <div class="row">
        <div class="col-md-12">
          <p>
            We're grateful for your participation in this study!<br />
            You correctly identified the plot with a higher correlation value in
            <b><?php echo $_SESSION['survey']['score']; ?></b> of the <b><?php echo $num_questions; ?></b>
            examples. Please note that your MTurk payment is <u><i>not</i></u>
            affected by the number in any way.
          </p>
          <p>
            Your Amazon MTurk HIT Completion Code is below.<br />
            Please be aware that you can only participate in this study a single
            time. Subsequent attempts to work this HIT may jeopardize the
            validity of your completion code.
          </p>

        </div> <!-- /column -->
      </div> <!-- /row -->
      <br /><br />

      <div class="row">
        <div class="col-md-12">
          <h4>Additonal Details</h4>
          <p>
            It is not required, but it can help us interpret the results of this
            experiment if you choose to provide the basic information below.
          </p>
        </div> <!-- /column -->
      </div> <!-- /row -->

      <div class="row">
        <div class="col-md-4">

          <section id="demographics">
            <h5>Gender</h5>
            <div class="row">
              <!-- <div class="col-md-4"> -->
                <select class="form-control" id="gender">
                  <option value="0"></option>
                  <option value="Female">Female</option>
                  <option value="Male">Male</option>
                  <option value="TransFemale">TransFemale</option>
                  <option value="TransMale">TransMale</option>
                  <option value="NonBinary">Non-Binary</option>
                  <option value="Other">Other</option>
                  <option value="Decline">Prefer not to say</option>
                </select>
              <!-- </div> /column -->
            </div> <!-- /row -->

            <h5>Age</h5>
            <div class="row">
              <!-- <div class="col-md-4"> -->
                <select class="form-control" id="age">
                  <option value="0"></option>
                  <option value="18:24">18-24 years old</option>
                  <option value="25:34">25-34 years old</option>
                  <option value="35:44">35-44 years old</option>
                  <option value="45:54">45-54 years old</option>
                  <option value="55:64">55-64 years old</option>
                  <option value="65:74">65-74 years old</option>
                  <option value="gt75">75 years or older</option>
                </select>
              <!-- </div> /column -->
            </div> <!-- /row -->
          </section>
        </div> <!-- /column -->
        <div class="col-md-4 offset-1">
          <br /><br />
          <button class="btn btn-lg btn-outline-danger" id="save_button" onclick="fileDemographics()" disabled>
            <b style="font-size: 38px">Save</b>
          </button>
        </div> <!-- /column -->
      </div> <!-- /row -->
      <br /><br />

      <div class="row">
        <div class="col-md-12">
          <h4>Amazon MTurk HIT Completion Code: </h4>
          <input type="text" class="copy_code" id="hit_comp_code" style="color: #000000" value=<?php echo "\"".$hit_completion_code."\"" ?> />
          <button type="button" class="btn" onclick="copyTextToClipboard()">Copy Code</button>
          <br /><br />

          <p>
            Thanks again,<br />
             University of Wisconsin-Madison Graphics Group
           </p>
          <img src="./assets/img/UWMGG.png" alt="" />

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
    <script src="./assets/js/thank_you.js"></script>
  </body>
</html>
