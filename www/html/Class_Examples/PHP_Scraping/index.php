 
<?php

  /**
   *    Author: H. James de St. Germain
   *    Date:   Spring 2015
   *
   *    This php file opens the UofU web site to pull class data from CS
   *
   *    WARNING!!!! 
   *
   *      As with all scraping, this file assumes many things about the
   *    page being scraped.  If any of these change the scraper will have to
   *    be modified.  The following are main areas of concern:
   *
   *    1)  the table of course info is the first table in the document
   *    2)  the dept, num, section, name, etc. are in specific columns of a
   *        given table row: 1,2,3,4
   *
   *  A mroe useful page would provide ids for the elements containing the data so
   *  we could pull the info without having to determine rows/cols/etc.
   */


//
// open a socket to the acs web page
//
$fp = fsockopen("www.nba.com", 80, $errno, $errstr, 5);

//
// prepare the GET requerst to pull the data.
//  (simulate a web browser)
//
$out = "GET /standings/team_record_comparison/conferenceNew_Std_Div.html HTTP/1.1\r\n";
$out .= "Host: www.nba.com\r\n";
$out .= "Connection: Close\r\n\r\n";

//
// Send GET request
//
fwrite($fp, $out);

//
// check for success
//
if (!$fp)
  {
    $content = " offline ";
  }
else
  {
    //
    // pull the entire web page and concat it up in a single "page" variable
    //
    $page = "";
    while (!feof($fp))
      {
	$page .= fgets($fp, 1000);
      }
    fclose($fp);

    $doc = new DOMDocument();
    $doc->loadHTML( $page );

    $table = $doc->getElementsByTagName('table');
    $rows = $table->item(0)->getElementsByTagName('tr');

    $content = 0;
    foreach ($rows as $row)
      {
	$cells = $row->getElementsByTagName('td');
	foreach ($cells as $cell)
	  {
	    $content .= $cell->nodeValue; 
	  }
	$content .= "<br/>";
      }
    
  }

///////////////////////////////////////////////////////////
//
// Build The Web Page
//
//  MVC (Model/Controll above, View below)
//

?>

<!DOCTYPE xhtml>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="author" content="H. James de St. Germain">
    <link href="start.css" rel="stylesheet" type="text/css"/>
    <link href="print.css" rel="stylesheet" type="text/css"/>

    <title>Retrieve NBA Stats</title>
</head>

   <body>

    <div id="rightside">
      <div id="topics_header">
    <h2> NBA Stats </h2>

       <?php echo $content; ?>

     </div>
   </div>

  </body>
</html>