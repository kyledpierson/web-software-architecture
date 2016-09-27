<?php

require_once "../../Models/db.php";

$key = $_POST['key'];

$comments = getComments($key);

echo $comments . "<button id='" . $key . "'onclick='hide_me(" . $key . ")'>Hide Comment</button>";

?>