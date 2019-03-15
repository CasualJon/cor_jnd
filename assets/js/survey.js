//Variable for survey control data
var surveyControl = new Array();

//Fetching screen width
var screenWidth = window.innerWidth
  || document.documentElement.clientWidth
  || document.body.clientWidth;
var imgWidth;
//Limit to about 1/3
imgWidth = screenWidth / 3.4;
if (imgWidth > 300) imgWidth = 460;

//Vars to handle left and right charts
var chartA = document.getElementById('chart_a');
var chartB = document.getElementById('chart_b');

//Selection of chart info
var timerDone = false;
var choiceMade = false;
var choice = null;
var confidenceSelected = false;
var confidence = 0;
var continueButton = document.getElementById('continue_button');

//Make a file-wide var to hold the Begin Button element
$(document).ready(function(){
  //Require at least 4 seconds (4,000ms) of time on the education screen
  setTimeout(completeTimer, 4000);
});

var seconds = 0;
var interval = setInterval(function() {
  document.getElementById('num_seconds').innerHTML = ++seconds;
}, 1000);

//Get the information to load onto the survey page from the server
fetchSurveyControl();


//Update the view based on check input
$(".image-checkbox").on("click", function (e) {
  $(this).toggleClass('image-checkbox-checked');
  var $checkbox = $(this).find('input[type="checkbox"]');
  $checkbox.prop("checked",!$checkbox.prop("checked"));

  if ($(this).attr('id') == "container_a") {
    var checkA = document.getElementById('check_a');
    var selA = document.getElementById('sel_a');
    if (checkA.checked) {
      choiceMade = true;
      selA.hidden = false;
      choice = "A";
    }
    else {
      choiceMade = false;
      selA.hidden = true;
      choice = null;
    }
    var checkB = document.getElementById('check_b');
    var selB = document.getElementById('sel_b');
    var containerB = document.getElementById('container_b');
    if (checkB.checked) {
      checkB.checked = false;
      containerB.classList.remove("image-checkbox-checked");
      selB.hidden = true;
    }
  }
  else {
    var checkB = document.getElementById('check_b');
    var selB = document.getElementById('sel_b');
    if (checkB.checked) {
      choiceMade = true;
      selB.hidden = false;
      choice = "B";
    }
    else {
      choiceMade = false;
      selB.hidden = true;
      choice = null;
    }
    var checkA = document.getElementById('check_a');
    var selA = document.getElementById('sel_a');
    var containerA = document.getElementById('container_a');
    if (checkA.checked) {
      checkA.checked = false;
      containerA.classList.remove("image-checkbox-checked");
      selA.hidden = true;
    }
  }

  e.preventDefault();
  evalConidentSelect();
});

//completeTimer()
function completeTimer() {
  timerDone = true;
  evalContinueButton()
} //END completeTimer()

//evalConidentSelect()
function evalConidentSelect() {
  var confidentSelect = document.getElementById("confident_select");
  if (choiceMade) {
    confidentSelect.setAttribute("style", "");
  }
  else {
    confidentSelect.setAttribute("style", "display: none");
  }
  evalContinueButton();
} //END evalConidentSelect()

//setConfidence()
function setConfidence(opt) {
  if (confidence > 0) {
    var oldName = "conf" + confidence;
    var oldBtn = document.getElementById(oldName);
    oldBtn.setAttribute("style", "");
  }
  var newName = "conf" + opt;
  var newBtn = document.getElementById(newName);
  newBtn.setAttribute("style", "background: #0F82E6; color: #FFFFFF;");
  confidence = opt;
  confidenceSelected = true;
  evalContinueButton();
} //END setConfidence()

//evalContinueButton()
function evalContinueButton() {
  if (timerDone && choiceMade && confidenceSelected) {
    continueButton.setAttribute("style", "");
    continueButton.disabled = false;
  }
  else {
    continueButton.setAttribute("style", "display: none");
    continueButton.disabled = true;
  }
} //END evalContinueButton()


//-------------------------------------------------------------------------------
//fetchSurveyControl()
//Function to make an Ajax call to a php file that will pull data from the
//server via ./support_php_files/sql_interact.php
function fetchSurveyControl() {
  jQuery.ajax({
    type:     "POST",
    url:      '../../support_files/sql_interact.php',
    dataType: 'json',
    data:     {functionname: 'get_survey_control', arguments: null},
    error:    function(a, b, c) {
                console.log("jQuery.ajax could not execute php file.");
              },
    success:  function(obj) {
                if (!('error' in obj)) {
                  surveyControl = obj;
                  //Callback
                  renderNextQuestion();
                }
                else {
                  console.log(obj.error);
                }
              }
  });

  return;
}  //END fetchSurveyControl()


//renderNextQuestion()
//Function that takes surveyControl object information to build
function renderNextQuestion() {
  console.log(surveyControl);

  //If survey responds that an intervention is next or the survey is completed,
  //redirect to appropriate pages via window.location
  if ('intervention' in surveyControl) {
    location.replace("../../intervention1.php");
    return;
  }
  else if ('complete' in surveyControl) {
    location.replace("../../thank_you.php");
    return;
  }

  //Set the header information
  var qNum = surveyControl.survey.curr_question + 1;
  document.getElementById("question_title").innerHTML = "Question " + qNum;

  var left = document.getElementById("opt_a");
  left.setAttribute("src", surveyControl.question_path[0]);
  left.setAttribute("width", imgWidth);

  var right = document.getElementById("opt_b");
  right.setAttribute("src", surveyControl.question_path[1]);
  right.setAttribute("width", imgWidth);
} //END renderNextQuestion()


//executeUserSelection()
function executeUserSelection() {
  //Args: 0 - choice
  //      1 - confidence
  //      2 - seconds in question
  var args = [choice, confidence, seconds];
  jQuery.ajax({
    type:     "POST",
    url:      '../../support_files/sql_interact.php',
    dataType: 'json',
    data:     {functionname: 'get_next_question', arguments: args},
    error:    function(a, b, c) {
                console.log("jQuery.ajax could not execute php file.");
              },
    success:  function(obj) {
                if (!('error' in obj)) {
                  surveyControl = obj;
                  //Callback
                  // renderNextQuestion();
                  location.reload();
                }
                else {
                  console.log(obj.error);
                }
              }
  });
} //END executeUserSelection()
