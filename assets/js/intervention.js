//Fetching screen width
var screenWidth = window.innerWidth
  || document.documentElement.clientWidth
  || document.body.clientWidth;
var imgWidth;
//Limit to about 1/3
imgWidth = screenWidth / 3.4;
if (imgWidth > 300) imgWidth = 460;
//Set image witdth for this education image
document.getElementById('edu_a').setAttribute("width", imgWidth);
document.getElementById('container_a').setAttribute("width", imgWidth);
document.getElementById('edu_b').setAttribute("width", imgWidth);
document.getElementById('container_b').setAttribute("width", imgWidth);

//Selection of chart info
var timerDone = false;
var choiceMade = false;
var choice = null;
var confidenceSelected = false;
var confidence = 0;
var continueButton = document.getElementById('continue_button');

//Make a file-wide var to hold the Begin Button element
$(document).ready(function(){
  //Require at least 6 seconds (6,000ms) of time on the education screen
  setTimeout(completeTimer, 6000);
});

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
  evalContinueButton();
});

//completeTimer()
function completeTimer() {
  timerDone = true;
  evalContinueButton()
} //END completeTimer()

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
  if (timerDone && choiceMade && confidenceSelected) continueButton.disabled = false;
  else continueButton.disabled = true;
} //END evalContinueButton()


//executeUserSelection()
function executeUserSelection(num) {
  //Args: 0 educational example number
  //      1 choice
  //      2 confidence
  var args = [num, choice, confidence];
  jQuery.ajax({
    type:     "POST",
    url:      '../../support_files/sql_interact.php',
    dataType: 'json',
    data:     {functionname: 'education_example', arguments: args},
    error:    function(a, b, c) {
                console.log("jQuery.ajax could not execute php file.");
              },
    success:  function(obj) {
                if (!('error' in obj)) {
                  if ('next' in obj) {
                    location.replace(obj.next);
                  }
                }
                else {
                  console.log(obj.error);
                }
              }
  });
} //END executeUserSelection()
