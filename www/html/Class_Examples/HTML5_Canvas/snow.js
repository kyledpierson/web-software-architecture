/**
 * Author: Created and maintained by Piotr and Oskar. http://jsfiddle.net/loktar/UdyN6/
 *
 * Modified by: H. James de St. Germain
 * Date:  Spring 2014
 *
 *
 *    Note: for cooler snow see: http://codepen.io/Sheepeuh/pen/cFazd
 *
 * Warning:  the call to tree_transfer is a hack to allow both the
 *           tree and the snow to show.  This  should be replaced
 *           with better SE practices (event, function, etc)
 *
 *
 */

/**
 * Control variables
 */
var flakes = []; // array of particles
var snow_buffer; // off screen location to draw snow
var ctx; // off screen buffer context
var flakeCount = 2000; // how many particles
var snow_state = "none"; // control animation (none, on, pause)
var mX = -100;
var mY = -100;

/**
 * Set up the animation request using built in browser functions or our one
 * timeout
 */
(function()
{
	var requestAnimationFrame = window.requestAnimationFrame
			|| window.mozRequestAnimationFrame
			|| window.webkitRequestAnimationFrame
			|| window.msRequestAnimationFrame ||

			function(callback)
			{
				window.setTimeout(callback, 1000 / 60);
			};

	window.requestAnimationFrame = requestAnimationFrame;

})();

/**
 * 
 * Compute the next location of the flakes and then draw them
 * 
 * 
 */
function snow()
{
	if (snow_state == "none")
		return;

	ctx.clearRect(0, 0, snow_buffer.width, snow_buffer.height);

	for (var i = 0; i < flakeCount; i++)
	{
		var flake = flakes[i], x = mX, y = mY, minDist = 150, x2 = flake.x, y2 = flake.y;

		var dist = Math.sqrt((x2 - x) * (x2 - x) + (y2 - y) * (y2 - y)), dx = x2
				- x, dy = y2 - y;

		if (dist < minDist)
		{
			var force = minDist / (dist * dist), xcomp = (x - x2) / dist, ycomp = (y - y2)
					/ dist, deltaV = force / 2;

			flake.velX -= deltaV * xcomp;
			flake.velY -= deltaV * ycomp;

		}
		else
		{
			flake.velX *= .98;
			if (flake.velY <= flake.speed)
			{
				flake.velY = flake.speed;
			}
			flake.velX += Math.cos(flake.step += .05) * flake.stepSize;
		}

		ctx.fillStyle = "rgba(255,255,255," + flake.opacity + ")";
		flake.y += flake.velY;
		flake.x += flake.velX;

		if (flake.y >= snow_buffer.height || flake.y <= 0)
		{
			reset(flake);
		}

		if (flake.x >= snow_buffer.width || flake.x <= 0)
		{
			reset(flake);
		}

		ctx.beginPath();
		ctx.arc(flake.x, flake.y, flake.size, 0, Math.PI * 2);
		ctx.fill();
	}

	tree_transfer();

	var main_canvas = document.getElementById('the_canvas');
	main_canvas.getContext('2d').drawImage(snow_buffer, 0, 0);

	if (snow_state == "pause")
		return;

	requestAnimationFrame(snow);

};

/**
 * Allow the program to turn the snow on or off
 */
function toggle_snow_state()
{
	if (snow_state == "none")
	{
		snow_state = "on";
	}
	else if (snow_state == "on")
	{
		snow_state = "pause";
	}
	else if (snow_state == "pause")
	{
		snow_state = "none";
		tree_transfer();
	}

	snow();

}

/**
 * (reuse the snow flake) put flake back at the top of the screen and reset its
 * parameters so it looks like a new flake
 */
function reset(flake)
{
	flake.x = Math.floor(Math.random() * snow_buffer.width);
	flake.y = 0;
	flake.size = (Math.random() * 3) + 2;
	flake.speed = (Math.random() * 1) + 0.5;
	flake.velY = flake.speed;
	flake.velX = 0;
	flake.opacity = (Math.random() * 0.5) + 0.3;
}

/**
 * 
 * build the snow flakes
 * 
 */
function init_snow(canvas, width, height)
{

	snow_buffer = document.createElement('canvas');
	snow_buffer.width = width;
	snow_buffer.height = height;
	ctx = snow_buffer.getContext("2d");

	for (var i = 0; i < flakeCount; i++)
	{
		var x = Math.floor(Math.random() * snow_buffer.width);
		var y = Math.floor(Math.random() * snow_buffer.height);
		var size = (Math.random() * 3) + 2;
		var speed = (Math.random() * 1) + 0.5;
		var opacity = (Math.random() * 0.5) + 0.3;

		flakes.push(
		{
			speed : speed,
			velY : speed,
			velX : 0,
			x : x,
			y : y,
			size : size,
			stepSize : (Math.random()) / 30,
			step : 0,
			angle : 180,
			opacity : opacity
		});
	}

	snow();

	canvas.addEventListener("mousemove", function(e)
	{
		var main_canvas = document.getElementById('the_canvas');
		var rect = main_canvas.getBoundingClientRect();

		mX = e.clientX - rect.left;
		mY = e.clientY - rect.top;
	});

};

