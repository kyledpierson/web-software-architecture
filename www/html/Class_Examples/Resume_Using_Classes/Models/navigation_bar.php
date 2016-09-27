<?php
/**
 *
 * Author: H. James de St. Germain
 * Date: Spring 2014
 * 
 * This code represents a person
 * 
 */


class Navigation_Bar
{
	private $current_page;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->current_page = "resume";
	}
	
	/**
	 * set the current page
	 */
	public function set_current_page( $page )
	{
		// verify valid pages
		if ($page == "contact" || $page == "position" ||  $page == "employment" || $page == "resume" || $page == "clear")
		{
			$this->current_page = $page;
		}      
		else
		{
			error_log("tried to set an invalid page as the current navigation page!\n"); 
		}
		
	}
	

	/**
	 * Print a concise (for debugging) string representation of the resume object
	 *
	 * @return string
	 */
	public function __toString()
	{
		
		
		if ($this->current_page == "contact")     $current_contact  = 'class="current"'; else $current_contact  = "";
		if ($this->current_page == "position")    $current_position = 'class="current"'; else $current_position = "";
		if ($this->current_page == "employment")  $current_employ   = 'class="current"'; else $current_employ   = "";
		if ($this->current_page == "resume")      $current_resume   = 'class="current"'; else $current_resume   = "";
		if ($this->current_page == "clear")       $current_clear    = 'class="current"'; else $current_clear   = "";
		
		return 
		"
		  <div id='navigation_bar'>
				<a $current_contact  href='contact_information.php'> Contact Information   </a> &middot;
				<a $current_employ   href='employment_history.php'>  Employment History    </a>&middot;
				<a $current_resume   href='display_resume.php'>      Display Resume        </a>&middot;
				<a $current_clear    href='clear_session.php'>       Clear Session (Debug) </a>&middot;

				<hr/>
		  </div>
		";
	}



}