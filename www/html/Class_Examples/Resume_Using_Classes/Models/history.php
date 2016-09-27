<?php
/**
 *
 * Author: H. James de St. Germain
 * Date: Spring 2014
 * 
 * This code represents a history of jobs
 * 
 */



class History
{
	public $jobs;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->jobs = array();
	}
	
	
	/**
	 *  add job
	 *
	 */
	function add_job( $beg_date, $end_date, $job_title)
	{
		$this->job[] = new Job($beg_date, $end_date, $job_title);
	}
	
	/**
	 * 
	 * build the java script string for the jobs list
	 * 
	 * @return string
	 */
	function build_java_script()
	{
		$js = "";
		
		for ($i=0; $i< count($this->jobs); $i++)
		{
			$js .= $this->jobs[$i]->build_java_script();
		}
		
		return $js;
	}
	
	/**
	 * set the jobs array based on the input from the form
	 */
	function set_jobs($beg_array, $end_array, $job_array)
	{
		$this->jobs = array();
		for ($i=0; $i<count($beg_array); $i++)
		{
			$this->jobs[] = new Job($beg_array[$i], $end_array[$i], $job_array[$i]);
		}
	}
	
	/**
	 * 
	 * output an html rep of jobs
	 */
	public function __toString()
	{
		$output = 
		"<table border='1'>
		   <thead>  
		     <tr>
		       <th> Title </th>
		       <th> Start Date </th>
		       <th> End date</th>
		     </tr>
		   </thead>
		   <tbody>
	    ";
		
		for ($i=0; $i<count($this->jobs); $i++)
		{
			$output .="<tr><td>{$this->jobs[$i]->title}</td>
			               <td>{$this->jobs[$i]->begin_date}</td>
			               <td>{$this->jobs[$i]->end_date}</td></tr>";
		}
		
		$output .= "</tbody></table>";
		
		return $output;
		
		
	}

	
	
}




class Job
{
	public $begin_date;
	public $end_date;
	public $title;

	/**
	 * Constructor
	 */
	public function __construct($beg, $end, $job)
	{
		$this->begin_date = $beg;
		$this->end_date   = $end;
		$this->title      = $job;
	}

	/**
	 * Compose JavaScript that will create job forms
	 *
	 */
	public function build_java_script()
	{
		$sVal = $this->begin_date;
		$eVal = $this->end_date;
		$jVal = $this->title;
		$jVal = strtr($jVal, array("\r" => "\\r",	"\n" => "\\n"));
		$sErr = 'false'; // check($sVal);
		$eErr = 'false'; // check($eVal);
		$jErr = 'false'; // check($jVal);
		return "addJob('$sVal', '$eVal', '$jVal', $sErr, $eErr, $jErr);\n";
	}


}
