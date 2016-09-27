/**
 *   Original code by Gurpreet
 *   - http://techie-notebook.blogspot.com/2012/08/pretty-fractal-trees-using-html-5.html
 *
 *   Modified by H. James de St. Germain
 */

/**
 * Some basic control variables
 * 
 */
var draw_flowers = false;
var draw_apples = false;
var apple_color = 'red';
var flower_color = 'white';
var tree_buffer; // where to draw tree

/**
 * Build the tree and transfer it to "the_canvas"
 * 
 * Width and Height are the size of the window
 * 
 * Note: the tree height is not contrained by theses, but probably should be.
 */
function draw_tree(width, height)
{

	tree_buffer = document.createElement('canvas');
	tree_buffer.width = width;
	tree_buffer.height = height;

	var max_length = document.getElementById("tree_seg_length").value;
	document.getElementById("slider_value").innerHTML = max_length;

	clear_canvas(tree_buffer);

	if (tree_buffer.getContext)
	{
		var context = tree_buffer.getContext('2d');
		drawFractalTree(context, width, height);
	}
	else
	{
		alert("HTML5 Canvas isn't supported by your browser!");
	}

	tree_transfer();

}

/**
 * Copy tree buffer to viewable screen
 */
function tree_transfer()
{
	clear_canvas();
	var main_canvas = document.getElementById('the_canvas');
	main_canvas.getContext('2d').drawImage(tree_buffer, 0, 0);

}

/**
 * Top level of drawing tree (start recursion)
 */
function drawFractalTree(context, window_width, window_height)
{
	draw_branch(context, window_width / 2, window_height, -90, 11);
}

/**
 * Recursive drawing of branches
 */
function draw_branch(context, x1, y1, angle, depth)
{
	var max_length = +(document.getElementById("tree_seg_length").value);
	var BRANCH_LENGTH = random(0, max_length);

	if (depth != 0)
	{
		var x2 = x1 + (cos(angle) * depth * BRANCH_LENGTH);
		var y2 = y1 + (sin(angle) * depth * BRANCH_LENGTH);
		drawLine(context, x1, y1, x2, y2, depth);
		draw_branch(context, x2, y2, angle - random(15, 20), depth - 1);
		draw_branch(context, x2, y2, angle + random(15, 20), depth - 1);

		if (depth < 6 && depth > 1)
		{
			if (draw_apples && random(1, 30) == 1)
			{
				draw_circle(context, x1, y1, 6, apple_color);
			}
		}
	}
	else
	{
		if (draw_flowers)
		{
			draw_circle(context, x1, y1, 3, flower_color);
		}
	}
}

/**
 * Helper function to draw a line between two points
 * 
 * Has some "tree knowledge" in it that should be removed and sent in as
 * parameters.
 */

function drawLine(context, x1, y1, x2, y2, thickness)
{
	context.fillStyle = '#000';

	if (thickness > 6)
	{
		context.strokeStyle = 'rgb(139,126, 102)'; // Brown
	}
	else
	{
		context.strokeStyle = 'rgb(34,139,34)'; // Green
	}

	context.lineWidth = thickness * 1.5;
	context.beginPath();

	context.moveTo(x1, y1);
	context.lineTo(x2, y2);

	context.closePath();
	context.stroke();
}

/**
 * Helper function to draw a circle
 * 
 */
function draw_circle(context, x, y, radius, color)
{
	context.fillStyle = '#000';

	context.beginPath();
	context.arc(x, y, radius, 0, 2 * Math.PI, false);
	context.fillStyle = color;
	context.fill();
	context.lineWidth = 1;
	context.strokeStyle = '#003300';
	context.stroke();
}

/**
 * cos using angles instead of radians
 */
function cos(angle)
{
	return Math.cos(deg_to_rad(angle));
}

/**
 * sin using angles instead of radians
 */
function sin(angle)
{
	return Math.sin(deg_to_rad(angle));
}

/**
 * convert between degrees and radians
 */
function deg_to_rad(angle)
{
	return angle * (Math.PI / 180.0);
}

/**
 * random number between min and max inclusive
 */
function random(min, max)
{
	return min + Math.floor(Math.random() * (max + 1 - min));
}

/**
 * Clear the canvas
 */
function clear_canvas(canvas)
{
	if (typeof canvas === 'undefined') // default parameter
	{
		canvas = document.getElementById('the_canvas');
	}

	canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
}

/**
 * Toggle Flowers
 */
function toggle_flowers()
{
	draw_flowers = !draw_flowers;
	clear_canvas();
	redraw_tree();
}

/**
 * Toggle Flowers
 */
function toggle_apples()
{
	draw_apples = !draw_apples;
	clear_canvas();
	redraw_tree();
}
