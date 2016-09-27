<?php

/**
 *
 * Author: H. James de St. Germain
 * Date: Spring 2014
 * 
 * This is a resume genereator program.
 * 
 * This is the page that allows the user to enter employment history
 * 
 */

require("Helpers/helper_functions.php");

load_session($resume, $navigation_bar);



$navigation_bar->set_current_page("employment");


// If this was a submission
if ( isset($_REQUEST['save'] ) )
{
	// Get parameters
	$beg = getParam('beg', array());
	$end = getParam('end', array());
	$job = getParam('job', array());

	// Trim arrays to the same length and save to session
	$length = min(count($beg), count($end), count($job));
	$beg_array = array_slice($beg, 0, $length);
	$end_array = array_slice($end, 0, $length);
	$job_array = array_slice($job, 0, $length);
	
	$resume->jobs->set_jobs( $beg_array, $end_array, $job_array);
}


$jobs_java_script = $resume->jobs->build_java_script();


$other =
'
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>
/* global holding the block of HTML form that we replicate for each job*/
var job_block;

$(function () {

	// Make the X button delete the block of controls in which it appears.
	$("input[value=\'X\']").click(function ()
	{$(this).parents(".block").remove();});

	// Make the "Add Job" button add a new block of controls
	$("input[value=\'Add Job\']").click(function ()
	{addJob(\'\', \'\', \'\', false, false, false);});

	// Clone, then remove, the existing block of controls
	job_block = $(".block").clone(true);
	$(".block").remove();

	// PHP inserts zero or more addJob(...) calls before the page is served
		' .
		$jobs_java_script . '
});

// Add a new block of controls after initializing them properly.
function addJob (beg, end, job, sErr, eErr, jErr) {
	newBlock = job_block.clone(true);
	newBlock.find("input[name=\'beg[]\']").val(beg);
	newBlock.find("input[name=\'end[]\']").val(end);
	newBlock.find("textarea[name=\'job[]\']").append(job);
	if (sErr) newBlock.find(".beg").attr("class", "error");
	if (eErr) newBlock.find(".end").attr("class", "error");
	if (jErr) newBlock.find(".job").attr("class", "error");
	$("#job_list").append(newBlock);
}
</script>
';


echo build_html_page_header( "Employment History", $other );

echo "

<body>
  $navigation_bar
  <h2>Employment History</h2>

  <p>Please enter your employment history.  You can provide information on
     any number of jobs you have held.</p>


  <div id='history'>
    <form method='post'>

      <div id='job_list'>
       <table class='block'>
        <tr>
           <td class='beg'>Start Date</td>
           <td><input class='date' type='text' name='beg[]'/></td>
           <td class='remove' rowspan='2'><input type='button' value='X'/></td>
         </tr>
         <tr>
          <td class='end'>End Date</td>
          <td><input class='date' type='text' name='end[]'/></td>
         </tr>
         <tr>
          <td class='job'>Job</td>
          <td colspan='2'><textarea class='info' name='job[]'></textarea></td>
         </tr>
      </table>
    </div>

    <p>
      <input type='button' value='Add Job'/>
      <input type='submit' name='save' value='Save'/>
    </p>

    </form>
  </div>

  </body>
</html>
";


