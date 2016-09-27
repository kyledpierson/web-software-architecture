<?php

require_once "../../Models/db.php";

$assign_info = Array();
$class_info = $_POST['class'];
$pos = strpos($class_info, '-');
$class = substr($class_info, 0, $pos);
$year = substr($class_info, $pos + 1, 4);
$term = substr($class_info, $pos + 5);

getAssignments($term, $year, $class, $assign_info);
	
$output_one = "<label id='lbl'>Showing All Students Who Have Applied to TA " . $class . " For " . $term . " " . $year . "</label>";
$output .= "<br><table><tr><th>Name</th><th>Status</th><th>Update Status</th></tr>";
$identifier = 0;

foreach($assign_info['assigned'] as $value)
{
	$output .= "<tr id=\"" . $identifier . "\"><td>" . $value . "</td><td class='status'>Assigned</td><td>"
		. "<form>"
		. "<select name='update_ta' class='update_ta' onchange='return update_ta_table(\"" . $value . "\"," . $identifier . ")'>"
		. "<option value='Assigned' selected>Assigned</option>"
		. "<option value='Probable'>Probable</option>"
		. "<option value='Unassigned'>Unassigned</option>"
		. "</select></form></td></tr>";
		
	$identifier += 1;
}

foreach($assign_info['probable'] as $value)
{
	$output .= "<tr id=\"" . $identifier . "\"><td>" . $value . "</td><td class='status'>Probable</td><td>"
		. "<form>"
		. "<select name='update_ta' class='update_ta' onchange='return update_ta_table(\"" . $value . "\"," . $identifier . ")'>"
		. "<option value='Assigned'>Assigned</option>"
		. "<option value='Probable' selected>Probable</option>"
		. "<option value='Unassigned'>Unassigned</option>"
		. "</select></form></td></tr>";
	
	$identifier += 1;
}

foreach($assign_info['applied'] as $value)
{
	$output .= "<tr id=\"" . $identifier . "\"><td>" . $value . "</td><td class='status'>Unassigned</td><td>"
	. "<form>"
		. "<select name='update_ta' class=\"update_ta\" onchange='return update_ta_table(\"" . $value . "\"," . $identifier . ")'>"
		. "<option value='Assigned'>Assigned</option>"
		. "<option value='Probable'>Probable</option>"
		. "<option value='Unassigned' selected>Unassigned</option>"
		. "</select></form></td></tr>";
	
	$identifier += 1;
}

$output .= "</table>";
	
if($identifier == 0)
{
	echo $output_one . "<br><label id='lbl'>None</label>";
}
else
{
	echo $output_one . $output;
}

echo "<script>

</script>";

?>
