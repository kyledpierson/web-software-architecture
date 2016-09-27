/*
 * Written by Kyle Pierson and Norman Gifford
 * Includes all server-side code for the Farkle game
 */
 
// Initialize socket.io stuff
var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);
app.use(express.static(__dirname));

// Called when the node server is started, default port is 3000
http.listen(4540, function()
{
  console.log('listening on port 4540');
});

// Keeps track of the players in the game lobby
var players = [];

/* A map of sockets to games
 * This is used to determine what game a player is in when something
 * is received from their socket
 */
var games = {};

// The current room, each game will have a unique room
var room = 1;

// When a socket connects, the index.html file is sent
app.get('/', function(req, res)
{
	res.sendfile('index.html');
});

/*
 * This includes the functions that are called when certain
 * commands are received from the user.
 */
io.on('connection', function(socket)
{
	// A string of player names for the lobby
	var players_string = "";
	var i = 0;
	
	// Informs the newly entered socket of the game lobby
	for(i = 0; i < players.length; i++)
	{
		players_string += (players[i].getName() + '\n');
	}
	io.emit('lobby', players_string);
	
	// This function is called when a player joins the game lobby
	socket.on('join', function(username)
	{
		socket.join(room);
		players.push(new Player(username, socket.id, room));
		
		// If there are at least four players in the game lobby
		if(players.length > 1)
		{
			// Make a new game with the players in the lobby
			var game = new Game(players, room);
			
			// Map each player to the previously made game
			for(i = 0; i < players.length; i++)
			{
				games[players[i].getSocket()] = game;
			}
			
			// Send the game command with all players names
			console.log('Starting a game with ' + players[0].getName() + ' and ' + players[1].getName());
			io.to(game.getRoom()).emit('game', players[0].getName(), players[1].getName());
			
			// Loop through the players, set the player numbers
			// and tell the players what their numbers are
			for(i = 0; i < players.length; i++)
			{
				var play_num = (i + 1);
				players[i].setNum(play_num);
				
				console.log('Sending ' + players[i].getName() + ' a player number of ' + play_num);
				io.to(players[i].getSocket()).emit('playernum', play_num);
			}
			
			// Tells player 1 that it is his or her turn
			console.log('Sending turn command to player 1');
			io.to(game.getRoom()).emit('turn', 1);
			
			// Prepare a new room and reset the game lobby
			room += 1;
			players = [];
		}
		
		// Inform all players of the new lobby
		players_string = '';
		for(i = 0; i < players.length; i++)
		{
			players_string += (players[i].getName() + '\n');
		}
		io.emit('lobby', players_string);
	});
	
	// This is processed when the client wants to roll the dice
	socket.on('roll', function(num)
	{
		try
		{
		console.log('Roll function called, rolling ' + num + ' dice');
		var game = games[socket.id];
		
		// Get the player number of the player rolling the dice
		// (for debugging purposes)
		var cur_players = game.getPlayers();
		var player_num = 0;
		for(var sock in cur_players)
		{
			if(socket.id == cur_players[sock].getSocket())
				player_num = cur_players[sock].getNum();
		}
		
		// Make an array to hold the rolled dice
		var dieResults = [];
		var dice_string = '';
		for(var i = 0; i < num; i++)
		{
			dieResults[i] = Math.floor(Math.random() * 6) + 1;
			dice_string += (dieResults[i] + ' ');
		}
		
		// Send the dice to all players, along with the number of the player who rolled
		console.log('Sending dice ' + dice_string + ' rolled by player ' + player_num);
		io.to(game.getRoom()).emit('dice', player_num, dieResults);
		}
		catch(exc)
		{
		}
	});
	
	// This function is executed when a player wants to bank his or her score
	socket.on('keep', function(score)
	{
		try
		{
		// Get the game of this player, update the sccore, and send out the new scores
		var game = games[socket.id];
		var new_scores = game.finishTurn(socket.id, score);
		io.to(game.getRoom()).emit('score', new_scores);
		
		// Get the name of the player who has updated his or her score
		// (used for debugging purposes)
		var cur_players = game.getPlayers();
		var name = '';
		for(var sock in cur_players)
		{
			if(socket.id == cur_players[sock].getSocket())
				name = cur_players[sock].getName();
		}
		
		console.log('Keep function called, ' + name + ' is keeping a score of ' + score);
		
		// Advance the turn
		var next_player = (game.advTurn() + 1);
		
		// A value of 0 if the game is over
		if(next_player == 0)
		{
			var winners = game.getWinners();
			
			// Remove the association of sockets to games
			for(var sock in cur_players)
			{
				delete games[sock];
			}
			
			var winner_string = "";
			for(i = 0; i < winners.length; i++)
				winner_string += winners[i] + ", ";
			
			console.log('Game is over, winners are ' + winner_string);
			console.log('Sending winner array to all sockets in the game');
			io.to(game.getRoom()).emit('end', winners);
		}
		
		// Otherwise, the value is the next player's number
		else
		{
			console.log('Sending turn command to player ' + next_player);
			io.to(game.getRoom()).emit('turn', next_player);
		}
		}
		catch(exc)
		{
		}
	});
	
	/*
	socket.on('leave', function()
	{
		var remove = -1;
		for(var i = 0; i < players.length; i++)
		{
			if(players[i].getSocket() == socket.id)
				remove = i;
		}
		
		if(remove != -1)
		{
			socket.leave(players[remove].getRoom());
			delete players[remove];
			
			players_string = '';
			for(i = 0; i < players.length; i++)
			{
				players_string += (players[i].getName() + '\n');
			}
			io.emit('lobby', players_string);
		}
		else
		{
			var game = games[socket.id];
			var winners = game.getWinners();
			
			var cur_players = game.getPlayers();
			for(var i = 0; i < cur_players; i++)
			{
				var sock = cur_players[i].getSocket();
				delete games[sock];
			}
			
			io.to(game.getRoom()).emit('end', winners);
		}
	});
	*/
	
	socket.on('disconnect', function()
	{
		var remove = -1;
		for(var i = 0; i < players.length; i++)
		{
			if(players[i].getSocket() == socket.id)
				remove = i;
		}
		
		if(remove != -1)
		{
			socket.leave((players[remove]).getRoom());
			players.splice(remove, 1);
			
			players_string = '';
			for(i = 0; i < players.length; i++)
			{
				players_string += (players[i].getName() + '\n');
			}
			io.emit('lobby', players_string);
		}
		else if(socket.id in games)
		{
			var game = games[socket.id];
			
			var cur_players = game.getPlayers();
			for(var i = 0; i < cur_players; i++)
			{
				var sock = cur_players[i].getSocket();
				delete games[sock];
			}
			
			io.to(game.getRoom()).emit('quit');
		}
	});
});



/*
 * Written by Norm Gifford
 * Ammended by Kyle Pierson
 * 
 * A class to represent the game objects
 */
function Game(playerObjects, game_room)
{
	// Keeps track of the players in the game
	this.players = {};
	
	// The room and number of the current player
	this.room = game_room;
	this.current_player = 0;
	this.end_player = -1;
	
	// Loop through the players and add them to the player map
	for(var i = 0; i < playerObjects.length; i++)
	{
		(this.players)[playerObjects[i].getSocket()] = playerObjects[i];
	}
}

Game.prototype =
{
	constructor: Game,
	
	// Finish the turn of the player with the socket, adding the score
	finishTurn: function(socket, score)
	{
		// Update the score of the player
		var score = (this.players)[socket].updateScore(score);
		
		// If this player has a score greater than 1000, set the end player to this player
		// Used to loop through all players one more time until reaching this player (the
		// end player) again.
		if(score > 10000 && this.end_player == -1)
			this.end_player = this.current_player;
		
		// Return all scores of the players
		var scores = [];
		var i = 0;
		for(var key in this.players)
		{
			scores[i] = this.players[key].getScore();
			i++;
		}
			
		return scores;
	},
	
	// Returns the player map
	getPlayers: function()
	{
		return this.players;
	},
	
	// Returns the room of this game
	// Used for socket emitting purposes
	getRoom: function()
	{
		return this.room;
	},
	
	// Advances the turn by one, and loops around if at 3
	// If the next player is the player who first scored over 1000 points,
	// this method returns a -1 to indicate that the game is over
	advTurn: function()
	{
		this.current_player++;
		
		if(this.current_player == Object.keys(this.players).length)
		{
			this.current_player = 0;
		}
			
		if(this.current_player == this.end_player)
		{
			return -1;
		}
		else
		{
			return this.current_player;
		}
	},
	
	// Gets the winner(s) of the game
	// If more than one player have the same high score, they are both winners
	getWinners: function()
	{
		// Set the initial high score to -1
		var max_score = -1;
		var winners = [];
		
		// Loop through the players
		for(var socket in (this.players))
		{
			var cur_player = (this.players)[socket];
			
			// If this player has a high score
			if(cur_player.getScore() > max_score)
			{
				// He/she is a winner (winner array is cleared, and this person is added as the sole winner)
				winners = [];
				winners[0] = cur_player.getName();
				max_score = cur_player.getScore();
			}
			
			// Otherwise, if he/she tied the high score, he/she is added to the winner array
			else if(cur_player.getScore() == max_score)
			{
				winners.push(cur_player.getName());
			}
		}
		
		// Return the winner array
		return winners;
	}
}



/*
 * Written by Norm Gifford
 * Ammended by Kyle Pierson
 */
function Player(name, socket, room)
{
	// Variables associated with the player
	this.name = name;
	this.score = 0;
	this.socket = socket;
	this.room = room;
	this.num = 0;
}

Player.prototype =
{
	constructor: Player,
	
	// Updates the score of the player
	updateScore:function(turnScore)
	{
		this.score += turnScore;
		return this.score;
	},
	
	// Gets the name of the player
	getName: function()
	{
		return this.name;
	},
	
	// Gets the score of the player
	getScore: function()
	{
		return this.score;
	},
	
	getSocket: function()
	{
		return this.socket;
	},
	
	getRoom: function()
	{
		return this.room;
	},
	
	// Sets the player number
	setNum: function(num)
	{
		this.num = num;
	},
	
	// Gets the player number
	getNum: function()
	{
		return this.num;
	}
}