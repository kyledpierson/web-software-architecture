
/**
 * V4
 *
 * Author:   Zachary
 * Modifed:  Germain - Spring 2014
 *
 * This program controls the lights out game functionality
 *
 *
 */

//True if the game is in play mode; false if in setup mode.
var inPlayMode = true;


//Called when one of the 25 gameboard buttons is clicked.
function play (row, col)
{

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
      var row = Math.floor(Math.random()*5);
      var col = Math.floor(Math.random()*5);
      play(row,col);
    }
}


//Called when the Setup button is called.
function setup ()
{
  inPlayMode = !inPlayMode;
  var button = document.getElementById("setup");
  button.value = (inPlayMode)?"Enter Setup":"Exit Setup";
}

//Toggles the color of the button at the specified index
function toggle (r, c)
{
  if (r >= 0 && r < 5 && c >= 0 && c < 5)
    {
      var row = document.getElementsByTagName("tr")[r];
      var td = row.getElementsByTagName("td")[c];
      var button = td.getElementsByTagName("input")[0];
      if (button.style.backgroundColor == "yellow")
        {
          button.style.backgroundColor = "black";
        }
      else
        {
          button.style.backgroundColor = "yellow";
        }
    }
}

// Sets the color of the button at the specified index to black
function clear (r, c)
{
  if (r >= 0 && r < 5 && c >= 0 && c < 5)
    {
      var row = document.getElementsByTagName("tr")[r];
      var td = row.getElementsByTagName("td")[c];
      var button = td.getElementsByTagName("input")[0];
      button.style.backgroundColor = "black";
    }
}
