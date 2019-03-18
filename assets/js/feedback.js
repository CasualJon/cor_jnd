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
document.getElementById('edu_b').setAttribute("width", imgWidth);

//Selection of chart info
var timerDone = false;
var continueButton = document.getElementById('continue_button');

//Make a file-wide var to hold the Begin Button element
$(document).ready(function(){
  //Require at least 3 seconds (3,000ms) of time on the education screen
  setTimeout(completeTimer, 3000);
});

//completeTimer()
function completeTimer() {
  timerDone = true;
  evalContinueButton()
} //END completeTimer()

//evalContinueButton()
function evalContinueButton() {
  if (timerDone) continueButton.disabled = false;
  else continueButton.disabled = true;
} //END evalContinueButton()


//executeUserSelection()
function executeUserSelection(num) {
  var next = "";
  if (num == 6) next = "../../survey.php";
  else next = "../../intervention" + num + ".php";
  location.replace(next);
} //End executeUserSelection()
