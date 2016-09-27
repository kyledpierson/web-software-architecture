// Written by Rory Savage


// Ammended by Andrew Johnson and Kyle Pierson

// Global variables - used in other .js files
var myPlayerNumber; // My player number
var numActiveDice;
var numDiceRolled;
var currentRoundPoints = 0; // Number of points for the current round
var numPlayers;
var myturn = 0; // 0 if not my turn, 1 if my turn

//Local variables
var currentRollPoints; // Number of points for this roll

var stage;  // pixi stage - the drawing area
var renderer;   // create a renderer instance
var button2;
var faceForDieOne;
var faceForDieTwo;
var faceForDieThree;
var faceForDieFour;
var faceForDieFive;
var faceForDieSix;
var cubeForDieOne;
var cubeForDieTwo;
var cubeForDieThree;
var cubeForDieFour;
var cubeForDieFive;
var cubeForDieSix;
var playersScoresNumArray;
var shaker1; // clickable shaker
var shaker2; // shaker image, not clickable
var currentPlayerScore;
var bankPoints;
var currentScoreTextField = new PIXI.Text("Points", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var rollCount = 0;
var p1text_field_ = new PIXI.Text("Player1", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var p2text_field_ = new PIXI.Text("Player2", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var p3text_field_ = new PIXI.Text("Player3", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var p4text_field_ = new PIXI.Text("Player4", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var p1Scoretext_field_ = new PIXI.Text("0", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var p2Scoretext_field_ = new PIXI.Text("0", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var p3Scoretext_field_ = new PIXI.Text("0", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var p4Scoretext_field_ = new PIXI.Text("0", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var pointsScore = new PIXI.Text("0", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
var p1PositionY=(window.innerHeight)-(window.innerHeight);
var p2PositionY=(window.innerHeight)-(window.innerHeight)+100;
var p3PositionY=(window.innerHeight)-(window.innerHeight)+200;
var p4PositionY=(window.innerHeight)-(window.innerHeight)+300;
var players = [p1text_field_, p2text_field_, p3text_field_, p4text_field_];
var namePositionsY = [p1PositionY, p2PositionY, p3PositionY, p4PositionY];
var scores = [p1Scoretext_field_, p2Scoretext_field_, p3Scoretext_field_, p4Scoretext_field_];
var face = [faceForDieOne, faceForDieTwo, faceForDieThree, faceForDieFour, faceForDieFive, faceForDieSix]; // selected dice - only shows face
var cube = [cubeForDieOne, cubeForDieTwo, cubeForDieThree, cubeForDieFour, cubeForDieFive, cubeForDieSix]; // Active / rolled dice - shows whole dice
var faceCallBack = [cubefaceone, cubefacetwo, cubefacethree, cubefacefour, cubefacefive, cubefacesix];
var cubeCallBack = [diefaceOne, diefaceTwo, diefaceThree, dicefaceFour, diefaceFive, diefaceSix];
var facePositionY = (window.innerHeight)-100;
var lockRoll = true;
var col = window.innerWidth/2;
var col2Start = col;
var playersCol = col/2;
var scoreX = playersCol+(playersCol/2);
var playerRows = window.innerHeight/7;
var xScale = (window.innerWidth)/1010;
var yScale = (window.innerHeight)/741;
var cubeScale = Math.min(xScale, yScale);
var scene1 = new PIXI.DisplayObjectContainer();
var farklebutton;
//scene1.addChild(new Button_Sprite( stage, 418, 70, bank_points, 30, false, 7));
//var texture = PIXI.Texture.fromImage("http://www.transparenttextures.com/patterns/buried.png");


var savedDice = [0,0,0,0,0,0];

/*
 Call currentplayer to indicate current player on the stage
 */
function currentPlayer(currentPlayer)
{
    var temp = currentPlayer;
    var previousPlayer = temp-1;
    if (previousPlayer == 0)
    {
        previousPlayer = numPlayers;
    }
    var prevTextField = players[previousPlayer-1];
    var prevScore = scores[previousPlayer-1];
    var currTextField = players[currentPlayer-1];
    var currScore = scores[currentPlayer-1];
    currentPlayerScore = playersScoresNumArray[currentPlayer-1];

    prevTextField.setStyle({font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});
    prevScore.setStyle({font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});

    currTextField.setStyle({font:"60pt Arial", align:"center", fill:"red", dropShadow:"true"});
    currScore.setStyle({font:"60pt Arial", align:"center", fill:"red", dropShadow:"true"});

    for(var i = 0; i < 6; i ++)
    {
        stage.removeChild(face[i]);
        stage.removeChild(cube[i]);
    }
}

function setPlayerNames(playerNames)
{
	
    for(var i = 0; i<numPlayers; i++)
    {
        if(playerNames[i]!="")
        {
            players[i].setText(playerNames[i]);
        }
        players[i].position.y = (window.innerHeight)-(window.innerHeight) +((i*100) * yScale);
        players[i].scale.x = cubeScale;
        players[i].scale.y = cubeScale;
        players[i].size = cubeScale;
        stage.addChild(players[i]);
    }
}

function setScores(playerScores)
{
    playersScoresNumArray = [];
    for(var i = 0; i<numPlayers; i++)
    {
        playersScoresNumArray.push(playerScores[i]);
        scores[i].setText(playerScores[i]);
        scores[i].position.y = (window.innerHeight)-(window.innerHeight) +((i*100) * yScale);
        scores[i].position.x = scoreX;
        scores[i].scale.x = cubeScale;
        scores[i].scale.y = cubeScale;
        stage.addChild(scores[i]);
    }
}

/*
 Callback functions for buttons. Based on position, not value of die.
 Face functions add the button to the "selected" dice, and removes the button from rolled dice. add value to savedDice array.
 Cube functions remove the button from "selected" dice, add to rolled dice. Remove value from savedDice array.
 */
function diefaceOne()
{
    stage.removeChild(cube[0]);
    numActiveDice -= 1;
    stage.addChild(face[0]);
    savedDice[0] = face[0].get_value();
    calculateCurrentScore();
}

function cubefaceone()
{
    numActiveDice += 1;
    stage.addChild(cube[0]);
    stage.removeChild(face[0]);
    savedDice[0] = 0;
    calculateCurrentScore();
}

function diefaceTwo()
{
    stage.removeChild(cube[1]);
    numActiveDice -=1;
    stage.addChild(face[1]);
    savedDice[1] = face[1].get_value();
    calculateCurrentScore();
}

function cubefacetwo()
{
    numActiveDice +=1;
    stage.addChild(cube[1]);
    stage.removeChild(face[1]);
    savedDice[1] = 0;
    calculateCurrentScore();
}

function diefaceThree()
{
    stage.removeChild(cube[2]);
    numActiveDice -=1;
    stage.addChild(face[2]);
    savedDice[2] = face[2].get_value();
    calculateCurrentScore();
}

function cubefacethree()
{
    numActiveDice +=1;
    stage.addChild(cube[2]);
    stage.removeChild(face[2]);
    savedDice[2] = 0;
    calculateCurrentScore();
}

function dicefaceFour()
{
    stage.removeChild(cube[3]);
    numActiveDice -=1;
    stage.addChild(face[3]);
    savedDice[3] = face[3].get_value();
    calculateCurrentScore();
}

function cubefacefour()
{
    numActiveDice +=1;
    stage.addChild(cube[3]);
    stage.removeChild(face[3]);
    savedDice[3] = 0;
    calculateCurrentScore();
}

function diefaceFive()
{
    stage.removeChild(cube[4]);
    numActiveDice -=1;
    stage.addChild(face[4]);
    savedDice[4] = face[4].get_value();
    calculateCurrentScore();
}

function cubefacefive()
{
    numActiveDice +=1;
    stage.addChild(cube[4]);
    stage.removeChild(face[4]);
    savedDice[4] = 0;
    calculateCurrentScore();
}

function diefaceSix()
{
    stage.removeChild(cube[5]);
    numActiveDice -=1;
    stage.addChild(face[5]);
    savedDice[5] = face[5].get_value();
    calculateCurrentScore();
}

function cubefacesix()
{
    stage.addChild(cube[5]);
    numActiveDice +=1;
    stage.removeChild(face[5]);
    savedDice[5] = 0;
    calculateCurrentScore();
}
function pressedFarkle()
{
    stage.removeChild(farklebutton);
    savedDice = [0, 0, 0, 0, 0, 0];
    currentRollPoints = 0;
    currentRoundPoints = 0;
    keep(0);
}

// Send current round's points, update text field to show it
function current_points(points)
{
    currentScoreTextField.position.y = (window.innerHeight)-(window.innerHeight)+(400 * yScale);
    currentScoreTextField.scale.x = cubeScale;
    currentScoreTextField.scale.y = cubeScale;
    stage.addChild(currentScoreTextField);
    pointsScore.position.y = (window.innerHeight)-(window.innerHeight)+(400 * yScale);
    pointsScore.position.x = scoreX;
    pointsScore.scale.x = cubeScale;
    pointsScore.scale.y = cubeScale;
    pointsScore.setText(points);
    stage.addChild(pointsScore);
    // bankPoints = new Button_Sprite( stage, 418, 70, bank_points, 30, false, 7);
    // scene1.visible = false; //stage.removeChild(bankPoints);

    // If it's my turn, and meets criteria, then add the 'bankpoints' button
    if(myturn == 1)
    {
        if(points >= 500 || (currentPlayerScore >= 500 && points > 0))
        {
            scene1.visible = true;
            // stage.addChild(bankPoints);
            currentPlayerScore = 0;
        }
    }

    // bankPoints.scale.x = 2.5*cubeScale;
    // bankPoints.scale.y = 2*cubeScale;
    // bankPoints.position.y = (window.innerHeight)-(window.innerHeight)+(500 * yScale);

}

/*
 Calculate max possible score for number of dice selected
 */
function calculateCurrentScore() {
    var array = [];

    var dicevaluesstring = "";
    for(var i = 0; i < 6; i ++)
    {
        if(savedDice[i] != 0 )
        {
            array.push(savedDice[i]);
            dicevaluesstring += savedDice[i] + " ";
        }
    }
    //alert(dicevaluesstring);
    currentRollPoints = tallyScore(array);
    //alert("Score is: " + currentRollPoints);
    current_points(currentRoundPoints + currentRollPoints);
    if(currentRollPoints > 0)
    {
        lockRoll = false;
    }
}

/*
 Bank current score of points
 */
function bank_points()
{
    scene1.visible = false; //stage.removeChild(bankPoints);
    var temp = currentRoundPoints +currentRollPoints;
    savedDice = [0, 0, 0, 0, 0, 0];
    currentRollPoints = 0;
    keep(temp);
}

/*
 Roll the specified number of dice
 */
function rollActiveDice()
{
    savedDice = [0, 0, 0, 0, 0, 0];
    if (!lockRoll) {
        if (numActiveDice == 0) {
            numActiveDice = 6;
            currentRoundPoints += currentRollPoints;
            roll(numActiveDice);
            //savedDice = [];
            currentRollPoints = 0;
        }
        else if (numActiveDice < numDiceRolled) {
            currentRoundPoints += currentRollPoints;
            //savedDice = [];
            currentRollPoints = 0;
            roll(numActiveDice);
        }
        else {
            keep(0);
            currentRollPoints = 0;
            currentRoundPoints = 0;
        }
    }
}

function activeShaker()
{
    //lockRoll = false; // allows "roll" to be clicked on
    shaker1 = new Button_Sprite( stage, 20, 20, rollActiveDice, 50, false,0);

    shaker1.position.x = (window.innerWidth)-(300 * xScale);
    shaker1.position.y =  (window.innerHeight)-(300 * yScale);
    shaker1.scale.x = cubeScale;
    shaker1.scale.y = cubeScale;


}

// Rolls 6 dice - only called by current player
function roll_dice(dice)
{
    //scene1.visible = false; //stage.removeChild(bankPoints);
    if (!farkle_test(dice))
    {
        savedDice = [0, 0, 0, 0, 0, 0];

        if (!lockRoll) {
            // Remove dice from previous roll
            for(var i = 0; i<6; i++)
            {
                stage.removeChild(cube[i]);
                stage.removeChild(face[i]);
            }

            //alert("In Roll_dice and roll is not locked");
            var i = 0;
            for (; i < dice.length; i++) {
                if (dice[i] > 0) {
                    //alert("Die rolled is a: " + dice[i]); // has correct value of the die
                    face[i] = new Button_Sprite(stage, 20, 20, faceCallBack[i], dice[i], true, dice[i]);
                    face[i].set_value(dice[i]);
                    face[i].position.x = 50 + ((i * 100) * xScale);
                    face[i].position.y = playerRows * 6; //facePositionY / yScale;
                    face[i].scale.x = 0.25 * cubeScale;
                    face[i].scale.y = 0.25 * cubeScale;
                    stage.removeChild(face[i]);

                    cube[i] = new Button_Sprite(stage, 20, 20, cubeCallBack[i], dice[i], false, dice[i]);
                    cube[i].position.x = (window.innerWidth / 2) + (window.innerWidth / 4) + (((i % 2) * (100)) * xScale);
                    cube[i].position.y = (window.innerHeight) - (window.innerHeight) + ((i * 50) * yScale);
                    cube[i].scale.y = 0.25 * cubeScale;
                    cube[i].scale.x = 0.25 * cubeScale;
                }
                else {
                    stage.removeChild(face[i]);
                    stage.removeChild(cube[i]);
                }


            }
            for (; i < 6; i++)
            {
                stage.removeChild(face[i]);
                stage.removeChild(cube[i]);
            }
            lockRoll = true;
            rollCount++;
        }
    }
    else
    {
        //Farkle
        lockRoll = true;
        scene1.visible = false;
        for(var i = 0; i<6; i++)
            {
                stage.removeChild(cube[i]);
                stage.removeChild(face[i]);
            }

        farklebutton = new FarkleButton_Sprite( stage, "Farkle!!", (window.innerWidth/2), (window.innerHeight/3), pressedFarkle, 0, dice);
        farklebutton.position.x = (window.innerWidth)/4;
        farklebutton.position.y = (window.innerHeight)- (window.innerHeight);
        // var outputString = "";
        // for (var i = 0; i < dice.length; i++)
        // {
        //     outputString += dice[i] + " ";

        // }
        // alert("Farkle" + "\n" + outputString);
        // savedDice = [0, 0, 0, 0, 0, 0];
        // currentRollPoints = 0;
        // currentRoundPoints = 0;
        // keep(0);
    }
    numDiceRolled = dice.length;
}

/*
 Sets up visitor mode for other players
 */
function otherPlayer() {
    scene1.visible = false; //stage.removeChild(bankPoints);
    currentPlayerScore = 0;
    // Remove current player stuff
    stage.removeChild(shaker1);
    for (var i = 0; i < 6; i++) {
        stage.removeChild(cube[i]);
        stage.removeChild(face[i]);
    }
    stage.removeChild(currentScoreTextField);
    stage.removeChild(pointsScore);
    scene1.visible = false; //stage.removeChild(bankPoints);

    // Add the "other player" stuff
    shaker2 = new PIXI.Sprite(setTexture(0));
    shaker2.position.x = (window.innerWidth)-(300 * xScale);
    shaker2.position.y = (window.innerHeight)-(300 * yScale);
    shaker2.scale.x = cubeScale;
    shaker2.scale.y = cubeScale;
    stage.addChild(shaker2);
}

/*
 Call when roll and not the current player's turn
 */
function otherPlayersRoll(dice)
{
    scene1.visible = false; //stage.removeChild(bankPoints);
    //var texture = PIXI.Texture.fromImage("../Button/button.png");
    stage.removeChild(shaker1);
    for(var i = 0; i<6; i++)
    {
        stage.removeChild(cube[i]);
        stage.removeChild(face[i]);
    }

    stage.removeChild(currentScoreTextField);
    stage.removeChild(pointsScore);
    scene1.visible = false; //stage.removeChild(bankPoints);
    shaker2 = new PIXI.Sprite(setTexture(0));
    shaker2.position.x = (window.innerWidth)-(300 * xScale);
    shaker2.position.y = (window.innerHeight)-(300 * yScale);
    shaker2.scale.x = cubeScale;
    shaker2.scale.y = cubeScale;
    stage.addChild(shaker2);
    for(var i = 0; i<6; i++)
    {
        if(dice[i] != 0)
        {
            cube[i] = new PIXI.Sprite(setTexture(dice[i]));
            cube[i].position.x = (window.innerWidth/2)+(window.innerWidth/4)+(((i%2)*(100)) * xScale);
            cube[i].position.y = (window.innerHeight)-(window.innerHeight)+((i*50) * yScale);
            cube[i].scale.y = 0.25 * cubeScale;
            cube[i].scale.x = 0.25 * cubeScale;
            stage.addChild(cube[i]);
        }
    }
}

function setTexture(dieNumber)
{
    if(dieNumber == 0)
    {
        var texture = PIXI.Texture.fromImage("/Game/Pictures/shaker.png");
        return texture;
    }
    if(dieNumber == 1)
    {
        var texture = PIXI.Texture.fromImage("/Game/Pictures/die1.png");
        return texture;
    }
    if(dieNumber == 2)
    {
        var texture = PIXI.Texture.fromImage("/Game/Pictures/die2.png");
        return texture;
    }
    if(dieNumber == 3)
    {
        var texture = PIXI.Texture.fromImage("/Game/Pictures/die3.png");
        return texture;
    }
    if(dieNumber == 4)
    {
        var texture = PIXI.Texture.fromImage("/Game/Pictures/die4.png");
        return texture;
    }
    if(dieNumber == 5)
    {
        var texture = PIXI.Texture.fromImage("/Game/Pictures/die5.png");
        return texture;
    }
    if(dieNumber == 6)
    {
        var texture = PIXI.Texture.fromImage("/Game/Pictures/die6.png");
        return texture;
    }
}

//
// this function is called before every browser/canvas repaint
// approximately 30 or 60 times per second
//
// by putting requestAnimFrame(animate) in here, we cause an animation loop
//
function animate()
{
    requestAnimFrame(animate);

    renderer.render(stage);     // render the stage
}

function loadGame()
{
    /* Set up stage */
    //background-color: #007500;
	//background-image: url("http://www.transparenttextures.com/patterns/pool-table.png");
/* This is mostly intended for prototyping; please download the pattern and re-host for production environments. Thank you! */
    
    //var texture = PIXI.Texture.fromImage("http://www.transparenttextures.com/patterns/pool-table.png");
    // stage = new PIXI.Stage(texture);
    stage = new PIXI.Stage(0x007500);
    stage.alpha = 0.5;
    stage.interactive = true;
    
    // var background = new PIXI.Sprite(texture);
//     background.position.x = (window.innerWidth)-(300 * xScale);
//     background.position.y = (window.innerHeight)-(300 * yScale);
//     background.width = 100;
//     background.height = 200;
//     stage.addChild(background);
    
    
    
    
    
    //scene1.addChild(
    bankPoints = new Button_Sprite( stage, 418, 70, bank_points, 30, false, 7);
    scene1.addChild(bankPoints);
    bankPoints.scale.x = 2.5*cubeScale;
    bankPoints.scale.y = 2*cubeScale;
    scene1.position.y = (window.innerHeight)-(window.innerHeight)+(500 * yScale);
    stage.addChild(scene1);
    scene1.visible = false;
    var texture = PIXI.Texture.fromImage("Game/Pictures/pool-table.png");
	var background = new PIXI.Sprite(texture);
	background.scale.x = 5.75*xScale;
	background.scale.y = 3.5*yScale;
	stage.addChild(background);
    renderer = PIXI.autoDetectRenderer(window.innerWidth, window.innerHeight, null);
    document.body.appendChild(renderer.view);     // add the renderer view element to the DOM
    requestAnimFrame( animate );
    
    

    var loader = new PIXI.AssetLoader([	"/Game/Pictures/die1.png",
        "/Game/Pictures/die2.png",
        "/Game/Pictures/die3.png",
        "/Game/Pictures/die4.png",
        "/Game/Pictures/die5.png",
        "/Game/Pictures/die6.png",
        "/Game/Pictures/selectedDie1.png",
        "/Game/Pictures/selectedDie2.png",
        "/Game/Pictures/selectedDie3.png",
        "/Game/Pictures/selectedDie4.png",
        "/Game/Pictures/selectedDie5.png",
        "/Game/Pictures/selectedDie6.png",
        "/Game/Pictures/oneFace.png",
        "/Game/Pictures/twoFace.png",
        "/Game/Pictures/threeFace.png",
        "/Game/Pictures/fourFace.png",
        "/Game/Pictures/fiveFace.png",
        "/Game/Pictures/sixFace.png",
        "/Game/Pictures/selectedOneFace.png",
        "/Game/Pictures/selectedTwoFace.png",
        "/Game/Pictures/selectedThreeFace.png",
        "/Game/Pictures/selectedFourFace.png",
        "/Game/Pictures/selectedFiveFace.png",
        "/Game/Pictures/selectedSixFace.png",
        "/Game/Pictures/shaker.png",
        "/Game/Pictures/selectedShaker.png",
    	"Game/Pictures/pool-table.png"]);
    // loader.onComplete = activeShaker();
    loader.load();

}

