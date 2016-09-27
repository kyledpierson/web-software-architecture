<?php

require_once "../../Models/db.php";

$class_info = $_POST['class'];
$pos = strpos($class_info, '-');
$class = substr($class_info, 0, $pos);
$year = substr($class_info, $pos + 1, 4);
$term = substr($class_info, $pos + 5);

$action = $_POST['action'];
$name = $_POST['name'];

updateAssignments($term, $year, $class, $action, $name);

echo $action;

?>