
/**
 * V6
 *
 * Author:   Zachary
 * Modifed:  Germain - Spring 2014
 *
 * This program controls the lights out game functionality
 *
 * Things of note:
 *
 *  1) Many things probably not described here
 *  2) use of \ for multiline strings
 *
 */


//
// List of Global variables
//

//True if the game is in play mode; false if in setup mode.
var inPlayMode = true;


// 
// This function builds the table via code, instead of having the HTML
// file contain it.
//
//
// It also ties the Javascript functions to the appropriate buttons
//
$(function ()
  {
    // Add the 25 buttons to the gameboard
    var board = "<table>";
    for (var r = 0; r < 5; r++)
      {
        var row = "<tr>";
        for (var c = 0; c < 5; c++)
          {
            row += "<td><input type='button'/></td>";
          }
        row += "</tr>";
        board += row;
      }
    board += "      <tr>               \
                      <td colspan=5><hr/></td> \
                    </tr>";

    board += "</table>";
    $("#gameboard").append(board);

    // Tie the setup button to the setup() function
    $("#setup").click(setup);

    // Tie the randomize button to the randomize() function'
    $("[value='Randomize']").click(randomize);

    // Tie the gameboard buttons to the play function
    $("#gameboard input").click(function ()
                                {play(this);});

  });

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
      var button = $("#gameboard input").get(r*5+c);
      play(button);
    }
}


// Called when the Setup button is clicked.
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
      var button = $("#gameboard input").get(r*5+c);
      var color = (button.style.backgroundColor == "yellow") ? "black" : "yellow";
      button.style.backgroundColor = color;
    }
}

// Sets the color of the button at the specified index to black
function clear (r, c)
{
  if (r >= 0 && r < 5 && c >= 0 && c < 5)
    {
      var button = $("#gameboard input").get(r*5+c);
      $(button).css("background-color", "black");
    }
}



