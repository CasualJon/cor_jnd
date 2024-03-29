<?php
  //Database informaiton for mysqli access
  $db_name = "";
  $db_user = "";
  $db_pass = "";

  //Directory information for the images the classifier/user will evaluate
  $img_source = "./assets/img/trial/";
  $num_questions = 30;

  //Intervention config: whether/when to show. 0 = before start, 12 = before 13
  $intervention_trigger = true;
  $intervention_count = 0;

  //Engagement check string data
  $engagement_string_check = ["09", "9ah", "9bh", "9ch"];

  //Max allowable survey time in seconds (3600 = 60 min)
  $max_allowed_time = 3600;
?>
