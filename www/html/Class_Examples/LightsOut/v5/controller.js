
/**
 * V5
 *
 * Author:   Zachary
 * Modifed:  Germain - Spring 2014
 *
 * This program controls the lights out game functionality
 *
 * Things to note:
 *
 *   1) the use of JQUERY
 *      1) the ".gameboard input" to reference all "nodes" inside of class gameboard
 *                                                                of type input
 *      2) the use pf [value='Ranomize'] to pull out randomize button
 *           Better would be to use id to name button
 */

// 
// This function ties the Javascript functions to the appropriate buttons
//
$(function ()
  {
    // Tie the setup button to the setup() function
    $("#setup").click(setup);

    // Tie the randomize button to the randomize() function
    $("[value='Randomize']").click(randomize);
    // Better: $("[id='RandomizeButton']").click(randomize);

    // Tie the gameboard buttons to the play function
    $(".gameboard input").click(function () {play(this);});

  });

//True if the game is in play mode; false if in setup mode.
var inPlayMode = true;


// Called when one of the 25 gameboard buttons is clicked.
function play (button)
{

  // Figure out the row and column of the button
  var td = $(button).parent();
  var col = td.parent().children().index(td);
  var row = td.parent().parent().children().index(td.parent());

  // In play mode, toggle the button and up to four neighbors
  if (inPlayMode)
    {
      toggle(row, col);
      toggle(row+1, col);
      toggle(row-1, col);
      toggle(row, col+1);
      toggle(row, col-1);
    }
  // In setup mode, toggle just the button
  else
    {
      toggle(row, col);
    }
}


//Called when the randomize button is clicked
function randomize ()
{

  // Clear all the buttons
  for (var row = 0; row < 5; row++)
    {
      for (var col = 0; col < 5; col++)
        {
          clear(row, col);
        }
    }

  // Make 15 moves at random
  for (var moves = 0; moves < 15; moves++)
    {
      var r = Math.floor(Math.random()*5);
      var c = Math.floor(Math.random()*5);
      var button = $(".gameboard input").get(r*5+c);
      play(button);
    }
}


//Called when the Setup button is called.
function setup ()
{
  inPlayMode = !inPlayMode;
  $(this).attr("value", (inPlayMode)?"Enter Setup":"Exit Setup");
}

//Toggles the color of the button at the specified index
function toggle (r, c)
{
  if (r >= 0 && r < 5 && c >= 0 && c < 5)
    {
      var button = $(".gameboard input").get(r*5+c);
      var color = (button.style.backgroundColor == "yellow") ? "black" : "yellow";
      button.style.backgroundColor = color;
    }
}

// Sets the color of the button at the specified index to black
function clear (r, c)
{
  if (r >= 0 && r < 5 && c >= 0 && c < 5)
    {
      var button = $(".gameboard input").get(r*5+c);
      $(button).css("background-color", "black");
    }
}
