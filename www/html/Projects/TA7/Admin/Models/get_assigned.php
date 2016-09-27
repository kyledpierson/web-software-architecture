<?php

function show_assign()
{
//if(isset($_REQUEST['assign_class']) && $_REQUEST['assign_class'] != 'None')
//{
	$selected = 'CS 2100';
	$assign_table = "<table><tr><th>Name</th><th>Status</th><th>Action</th></tr>";
	
	$value = $this->classes[$selected];
	
	foreach($value['assign'] as $key)
	{
		$assign_table .= "<tr><td>" . $key . "</td><td>Assigned</td><td>Choose</td></tr>";
	}
//}
	
return $assign_table;
}

?>