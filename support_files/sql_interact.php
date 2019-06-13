<?php
  session_start();
  require '../php_includes/db.php';
  require '../php_includes/control_variables.php';

  //PHP set for functions to call SQL for page, called by Ajax in JS
  header('Content-Type: application/json');
  $result = array();

  //Validate that function & argument parameters were passed in from JS
  if (!isset($_POST['functionname'])) {
    $result['error'] = 'No function name provided.';
  }
  if (!isset($_POST['arguments'])) {
    $result['error'] = 'No function arguments provided.';
  }
  //Execute code via switch
  if (!isset($result['error'])) {
    switch ($_POST['functionname']) {
      case 'get_survey_control':
        $result['survey'] = $_SESSION['survey'];
        $result['question_path'][0] = $img_source.$_SESSION['exp_data'][$_SESSION['survey']['curr_question']][0];
        $result['question_path'][1] = $img_source.$_SESSION['exp_data'][$_SESSION['survey']['curr_question']][1];

        //If interventions are active, and we have not completed the intervention,
        //this is the case to handle starting with an intervention
        if ($intervention_trigger &&
            !$_SESSION['survey']['intervention_comp'] &&
            $_SESSION['survey']['curr_question'] == $intervention_count) {

          $result['intervention'] = true;
        }

        //If the user completed the total number of listed questions
        if ($_SESSION['survey']['curr_question'] >= $num_questions) {
          $result['complete'] = true;
        }
        break;

      case 'get_next_question':
        //Make sure user has not exceeded max_allowed_time
        $now_time = time();
        if ($now_time - $_SESSION['survey']['begin_time'] > $max_allowed_time) {
          //If time exceeded, then set error message and redirect
          $_SESSION['message'] = "We're sorry, but you exceeded the time allowed in completing this survey.";
          header("location: ../error.php");
          exit;
        }

        //Save the data of the user's response to the just-answered question
        if (!is_null($_POST['arguments']) && !empty($_POST['arguments'])) {
          //Get the correctness of the response
          $choice = 0;
          if ($_POST['arguments'][0] == "B") $choice++;
          $usr_correct = 0;
          if (strpos($_SESSION['exp_data'][$_SESSION['survey']['curr_question']][$choice], "h") !== FALSE) $usr_correct += 1;
          $_SESSION['survey']['score'] += $usr_correct;

          //Set the response from the user
          $response_val = array(
            'question#' => $_SESSION['survey']['curr_question'],
            'A' => $_SESSION['exp_data'][$_SESSION['survey']['curr_question']][0],
            'B' => $_SESSION['exp_data'][$_SESSION['survey']['curr_question']][1],
            'correctness' => $usr_correct,
            'confidence' => $_POST['arguments'][1],
            'seconds' => $_POST['arguments'][2],
          );

          array_push($_SESSION['survey']['response'], $response_val);

          //Check if engagement question, file response to field if so
          if (strpos($_SESSION['exp_data'][$_SESSION['survey']['curr_question']][$choice], $engagement_string_check[0]) !== FALSE ||
              strpos($_SESSION['exp_data'][$_SESSION['survey']['curr_question']][$choice], $engagement_string_check[1]) !== FALSE ||
              strpos($_SESSION['exp_data'][$_SESSION['survey']['curr_question']][$choice], $engagement_string_check[2]) !== FALSE ||
              strpos($_SESSION['exp_data'][$_SESSION['survey']['curr_question']][$choice], $engagement_string_check[3]) !== FALSE) {

            if (strpos($_SESSION['exp_data'][$_SESSION['survey']['curr_question']][$choice], "_x309a") !== FALSE) $_SESSION['engagement'][0] = $usr_correct;
            else if (strpos($_SESSION['exp_data'][$_SESSION['survey']['curr_question']][$choice], "_x309b") !== FALSE) $_SESSION['engagement'][1] = $usr_correct;
            else $_SESSION['engagement'][2] = $usr_correct;
          }
        }

        //Increment question counter (how many user has completed)
        $_SESSION['survey']['curr_question']++;

        //If interventions are active and we've just completed the question count
        //required to trigger them, redirect to the intervention page
        if ($intervention_trigger && $_SESSION['survey']['curr_question'] == $intervention_count) {
          $result['intervention'] = true;
        }

        //If the user completed the total number of listed questions
        if ($_SESSION['survey']['curr_question'] == $num_questions) {
          $result['complete'] = true;
        }

        //Return the current survey data and question
        $result['survey'] = $_SESSION['survey'];
        $result['question_path'][0] = $img_source.$_SESSION['exp_data'][$_SESSION['survey']['curr_question']][0];
        $result['question_path'][1] = $img_source.$_SESSION['exp_data'][$_SESSION['survey']['curr_question']][1];
        break;

      case 'education_example':
        $result['next'] = "../../feedback".$_POST['arguments'][0].".php?sel=".$_POST['arguments'][1];
        if ($_POST['arguments'][0] == 5) $_SESSION['survey']['intervention_comp'] = true;
        break;

      case 'file_demographics':
        $query = "UPDATE responses SET gender=?, age=? WHERE internal_identifier=?";
        $demo_stmt = $mysqli->stmt_init();
        $demo_stmt->prepare($query);
        $demo_stmt->bind_param("ssi", $_POST['arguments'][0], $_POST['arguments'][1], $_SESSION['internal_identifier']);
        $demo_stmt->execute();
        $demo_stmt->close();
        break;

      default:
        $result['error'] = "Default case in switch: invalid function call.";
        break;
    }
  }

  if (isset($_POST['functionname'])) unset($_POST['functionname']);
  if (isset($_POST['arguments'])) unset($_POST['arguments']);

  // unset($_SESSION['target_id']);
  echo json_encode($result);
?>
