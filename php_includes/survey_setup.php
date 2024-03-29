<?php
  session_start();
  require 'control_variables.php';

  //Build an array with the unique image names (current total is in $num_questions)
  $exp_data = array();
  $build = array();
  for ($i = 0; $i < $num_questions; $i++) {
    $scratch_name = "".$i;
    array_push($build, $scratch_name);
  }

  for ($i = $num_questions - 1; $i >= 0; $i--) {
    //Randomize the directory id to choose from
    $indx = mt_rand(0, $i);
    $folder = $build[$indx];
    array_splice($build, $indx, 1);

    //Randomize which item from the randomized directory will be first
    $optionA = mt_rand(0, 999) % 2;
    $optionB = ($optionA + 1) % 2;

    $full_path = $img_source.$folder."/";
    $sub_path = "".$folder."/";
    $dir_contents = scandir($full_path);

    //Remove the current(.) and parent(..) directories from the array...
    //Default sorting of scandir() returns these as elements 0 & 1
    array_splice($dir_contents, 0, 2);
    $tmp = array();
    array_push($tmp, $sub_path.$dir_contents[$optionA]);
    array_push($tmp, $sub_path.$dir_contents[$optionB]);
    array_push($exp_data, $tmp);
  }

  $_SESSION['exp_data'] = $exp_data;
  $_SESSION['engagement'] = array(0, 0, 0);
?>
