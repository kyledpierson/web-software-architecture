/*
 * Written by Kyle Pierson
 * Ammended by Alfred Norm Gifford and Andrew Johnson
 */

// Called to join a game
function join()
{
	var mess = $('#m').val()
	socket.emit('join', mess);
	$('#m').val('');
	$('#join').html('');
	return false;
}

// Asks server to roll a certain number of dice
function roll(num)
{
    numDiceRolled = num;
	socket.emit('roll', num);
}

// Tells the server client wants to keep / bank a given number of points
function keep(score)
{
	socket.emit('keep', score);
}
