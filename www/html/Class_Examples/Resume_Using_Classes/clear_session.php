<?php

/**
 *
 * Author: H. James de St. Germain
 * Date: Spring 2014
 *
 * This page allows the session to be destroyed to start over 
 * Often used for debug purposes.
 *
 */


require("Helpers/helper_functions.php");

load_session($resume, $navigation_bar);

$navigation_bar->set_current_page("clear");

session_destroy();

echo build_html_page_header("Clear Session", "");

echo "<body>";

echo "<h2> Session should be cleared </h2>";

echo $navigation_bar;

echo "</body></html>";

