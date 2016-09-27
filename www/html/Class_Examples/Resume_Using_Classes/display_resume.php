<?php

/**
 *
 * Author: H. James de St. Germain
 * Date: Spring 2014
 * 
 * This is a resume genereator program.
 * 
 * This is the page that shows the "built" resume.
 * 
 * 
 */

require("Helpers/helper_functions.php");

// first prep the "model"
load_session($resume, $navigation_bar);

$navigation_bar->set_current_page("resume");


//then display the results

echo  build_html_page_header('Resume', '')  .
"

  <body>

  $navigation_bar

  $resume

  </body>
</html>
";

