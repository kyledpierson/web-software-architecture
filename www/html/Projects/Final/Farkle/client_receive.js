/*
 * Written by Kyle Pierson
 * Ammended by Andrew Johnson
 */

var socket;

$(function ()
{
    socket = io();

    socket.on('lobby', function(msg)
    {
        $('#lobby').html(msg);
    });

    /*
    New game has started - initialize game
     */
    socket.on('game', function(_p1, _p2)
    {

        //TODO - add players 3 and 4
        var arr = [
            _p1,
            _p2,
            "Player 3",
            "Player 4"
        ];
        numPlayers = 2;

        $('#main').html(""); // Remove game lobby html
        loadGame(); //Starts canvas, loads images, etc
        setPlayerNames(arr); //initializes player names
        arr = [0,0,0,0];
        setScores(arr); // initializes scores to 0
    });

    /*
     Turn means it is this player's current turn
     */
    socket.on('turn', function(_playernum) {
        currentRoundPoints = 0;
        currentPlayer(_playernum);// Update current player
        if(myPlayerNumber == _playernum) {
            myturn = 1;

            current_points(0);
            activeShaker();
            //roll(6);
            lockRoll = false;
        }
        else {
            myturn = 0;
            otherPlayer();
        }

        numActiveDice = 0;
        currentRoundPoints = 0;
        currentRollPoints = 0;
    });

    socket.on('playernum', function(num)
    {
        myPlayerNumber = num;
    });

    // takes array of the dice, rolls them
    socket.on('dice', function(_playernum, dice)
    {
        stage.removeChild(bankPoints);
        if(myPlayerNumber == _playernum) {
            //alert("Dice received and player is me");
            lockRoll = false;
            roll_dice(dice);
        }
        else {
            otherPlayersRoll(dice);
        }

    });

    socket.on('score', function(scores)
    {
        setScores(scores);
    });
	
	 socket.on('quit', function()
    {
		alert("A player has left the game unexpectedly");
		location.reload();
	});


    socket.on('end', function(winners)
    {
		var winner_string = "";
		
		if(winners.length == 1)
			winner_string = "The winner is... ";
		else
			winner_string = "The winners are... ";
			
        for(var i = 0; i < winners.length; i++)
        {
            winner_string += (winners[i] + " ");
        }
		
		winner_string += '!';

		//alert("Game over, winners are " + winner_string);
		//location.reload();
        
        //stage.remove(); // Remove Stage
		while(stage.children[0]) { stage.removeChild(stage.children[0]); }
		stage = new PIXI.Stage(0x000000);
		
		var display = "<div id='game'><h1>Winner Page</h1>"
    		+ "<p id='winners'>" + winner_string + "</p><br><a href='index.html'><button id='join_button'>New Game</button></a></div>";
        $('#main').html(display); // Show winners page
    });
});
