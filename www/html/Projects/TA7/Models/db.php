<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Contains all functions needed for communicating with the database, including submitting information and getting data

-->

<?php

// Opens and returns a DB connection
function openDBConn()
{
	require 'db_config.php';
	
   	// Connect to the data base and select it.
	$db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
	$db->query('SET NAMES "utf8"');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	return $db;
}

// Registers a new user
function submitUser($first, $last, $email, $pass, $role)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("INSERT INTO Users (first_name, last_name, email, user_password, role)
							  VALUES (:first,:last,:email,:pass,:role)");
		$stmt->bindValue(':first', $first);
		$stmt->bindValue(':last', $last);
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':pass', $pass);
		$stmt->bindValue(':role', $role);
		$stmt->execute();
		$userid = intval($db->lastInsertId());
		
		$db->commit();
		return true;
	}
	catch(PDOException $e)
	{
		if($e->getCode()== 23000)
		{
			return false;
		}
		reportDBError($e);
	}
}

function submitAppInfo($user_id, $gpa, $major, $level)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("INSERT INTO Applicant_Info (timestamp_info, user_id, gpa, major, academic_level)
							  VALUES(NOW(),:user_id,:gpa,:major,:level)");
		$stmt->bindValue(':user_id', $user_id);
		$stmt->bindValue(':gpa', $gpa);
		$stmt->bindValue(':major', $major);
		$stmt->bindValue(':level', $level);
		$stmt->execute();
		
		$db->commit();
	}
	catch(PDOException $e)
	{
		$db->rollback();
		reportDBError($e);
	}
}

function submitCoursesTaken(&$coursesTaken)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		foreach($coursesTaken as $value)
		{
			$stmt = $db->prepare("SELECT course_info_id, course_id FROM
								  Course_Info NATURAL JOIN Courses
								  WHERE dept_name = :dept_name AND course_num = :course_num AND term = :term AND course_year = :year");
			$stmt->bindValue(':dept_name', $value['dept_name']);
			$stmt->bindValue(':course_num', $value['course_num']);
			$stmt->bindValue(':term', $value['term']);
			$stmt->bindValue(':year', $value['year']);
			$stmt->execute();
		
			if($result2 = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$course_id = intval($result2['course_id']);
				
				$stmt = $db->prepare("INSERT INTO Courses_Taken (timestamp_taken, user_id, course_id, grade)
									  VALUES(NOW(),:user_id,:course_id,:grade)");
				$stmt->bindValue(':user_id', $value['user_id']);
				$stmt->bindValue(':course_id', $course_id);
				$stmt->bindValue(':grade', $value['grade']);
				$stmt->execute();
			}
		}
		
		$db->commit();
	}
	catch(PDOException $e)
	{
		$db->rollback();
		reportDBError($e);
	}
}

function submitCourseApps(&$courseApps)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		foreach($courseApps as $value)
		{
			$stmt = $db->prepare("SELECT course_info_id FROM Course_Info
								  WHERE dept_name = :dept_name AND course_num = :course_num");
			$stmt->bindValue(':dept_name', $value['dept_name']);
			$stmt->bindValue(':course_num', $value['course_num']);
			$stmt->execute();
			
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$course_info_id = intval($result['course_info_id']);
			
			$stmt = $db->prepare("INSERT INTO Course_Applications (timestamp_app, user_id, course_info_id, essay)
								  VALUES(NOW(),:user_id,:course_info_id,:essay)");
			$stmt->bindValue(':user_id', $value['user_id']);
			$stmt->bindValue(':course_info_id', $course_info_id);
			$stmt->bindValue(':essay', $value['essay']);
			$stmt->execute();
		}
		
		$db->commit();
	}
	catch(PDOException $e)
	{
		$db->rollback();
		reportDBError($e);
	}
}

function submitCourses($year, $term, &$courses)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		foreach($courses as $key=>$value)
		{
			$course_info_id;
			$teacher_id;
			$course_id;
			$courses[$key]['assign'] = Array();
			
			$stmt = $db->prepare("SELECT course_info_id FROM Course_Info
									WHERE course_num = :course_num AND course_details = :course_details");
									
			$stmt->bindValue(':course_num', $value['course_num']);
			$stmt->bindValue(':course_details', $value['details']);

			$stmt->execute();
			if($result = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$course_info_id = $result['course_info_id'];
			}
			else
			{
				$stmt = $db->prepare("INSERT INTO Course_Info (dept_name, course_num, credits, course_details)
										VALUES (:dept_name, :course_num, :credits, :course_details)");
				
				$stmt->bindValue(':dept_name', $value['dept_name']);
				$stmt->bindValue(':course_num', $value['course_num']);
				$stmt->bindValue(':credits', $value['credits']);
				$stmt->bindValue(':course_details', $value['details']);
				
				$stmt->execute();
				$course_info_id = intval($db->lastInsertId());
			}
			
			$stmt = $db->prepare("SELECT user_id FROM Users
									WHERE (first_name LIKE :first_name AND last_name LIKE :last_name) OR email = :email");
			
			$stmt->bindValue(':first_name', '%' . $value['first_name'] . '%');
			$stmt->bindValue(':last_name', '%' . $value['last_name'] . '%');
			$stmt->bindValue(':email', $value['teacher']);
			
			$stmt->execute();
			if($result2 = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$teacher_id = $result2['user_id'];
			}
			else
			{
				$stmt = $db->prepare("INSERT INTO Users (first_name, last_name, email, user_password, role)
										VALUES (:first_name, :last_name, :email, :user_password, :role)");
			
				$stmt->bindValue(':first_name', $value['first_name']);
				$stmt->bindValue(':last_name', $value['last_name']);
				$stmt->bindValue(':email', $value['teacher']);
				$stmt->bindValue(':user_password', 'temp');
				$stmt->bindValue(':role', 1);
				
				$stmt->execute();
				$teacher_id = intval($db->lastInsertId());
			}
			
			$stmt = $db->prepare("SELECT course_id FROM Courses
									WHERE course_info_id = :course_info_id AND user_id = :teacher_id
									AND course_year = :course_year AND term = :term");
									
			$stmt->bindValue(':course_info_id', $course_info_id);
			$stmt->bindValue(':teacher_id', $teacher_id);
			$stmt->bindValue(':course_year', $year);
			$stmt->bindValue(':term', $term);
			$stmt->execute();
			
			if($result3 = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$course_id = $result3['course_id'];
				$stmt = $db->prepare("UPDATE Courses SET enrollment = :enrollment WHERE course_id = :course_id");
				
				$stmt->bindValue(':enrollment', $value['enroll']);
				$stmt->bindValue(':course_id', $course_id);
				
				$stmt->execute();
			}
			else
			{
				$stmt = $db->prepare("INSERT INTO Courses (course_info_id, user_id, term, course_year, enrollment, days, time, location)
				VALUES (:course_info_id, :user_id, :term, :course_year, :enrollment, :days, :time, :location)");
										
				$stmt->bindValue(':course_info_id', $course_info_id);
				$stmt->bindValue(':user_id', $teacher_id);
				$stmt->bindValue(':term', $term);
				$stmt->bindValue(':course_year', $year);
				$stmt->bindValue(':enrollment', $value['enroll']);
				$stmt->bindValue(':days', $value['days']);
				$stmt->bindValue(':time', $value['time']);
				$stmt->bindValue(':location', $value['location']);
				
				$stmt->execute();
				$course_id = intval($db->lastInsertId());
			}
		}
		
		$db->commit();
	}
	catch(PDOException $e)
	{
		$db->rollback();
		reportDBError($e);
	}
}

function resetEnroll($year, $term)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("UPDATE Courses SET enrollment = 0 WHERE course_year = :year AND term = :term");
		$stmt->bindValue(':year', $year);
		$stmt->bindValue(':term', $term);
		
		$stmt->execute();
		$db->commit();
	}
	catch(PDOException $e)
	{
		$db->rollback();
		reportDBError($e);
	}
}

// Returns an array of the applicants information
function getAppInfo($user_id, &$appInfo)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT * FROM Applicant_Info
								   WHERE user_id = :user_id
								   ORDER BY timestamp_info DESC LIMIT 1");
								   
		$stmt->bindValue(':user_id', $user_id);
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$appInfo['gpa'] = $result['gpa'];
		$appInfo['major'] = $result['major'];
		$appInfo['level'] = $result['academic_level'];
		
		$db->commit();
	}
	catch(PDOException $e)
	{
		reportDBError($e);
	}
}

// Returns a two-dimensional array of the classes taken by the user
function getClassApps($user_id, &$classApps)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT course_info_id FROM Course_Applications
								   WHERE user_id = :user_id GROUP BY course_info_id");
								   
		$stmt->bindValue(':user_id', $user_id);
		$stmt->execute();
		
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$mult_course_id = $row['course_info_id'];
			
			$stmt = $db->prepare("SELECT dept_name, course_num FROM Course_Info
									   WHERE course_info_id = :course_info_id");
									   
			$stmt->bindValue(':course_info_id', $mult_course_id);
			$stmt->execute();
			
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
			$cs_key = $result2['dept_name'] . " " . $result2['course_num'];
			$classApps[$cs_key] = Array();
			$classApps[$cs_key]['dept_name'] = $result2['dept_name'];
			$classApps[$cs_key]['course_num'] = $result2['course_num'];
			
			$stmt = $db->prepare("SELECT essay FROM Course_Applications
									   WHERE user_id = :user_id AND course_info_id = :course_info_id
									   ORDER BY timestamp_app DESC LIMIT 1");
									   
			$stmt->bindValue(':user_id', $user_id);
			$stmt->bindValue(':course_info_id', $mult_course_id);
			$stmt->execute();
			
			$result3 = $stmt->fetch(PDO::FETCH_ASSOC);
			$classApps[$cs_key]['essay'] = $result3['essay'];
			
			$stmt = $db->prepare("SELECT Courses.course_id AS course_id, probable FROM Courses INNER JOIN Assignments
									ON Courses.course_id = Assignments.course_id
									WHERE course_info_id = :course_info_id AND Assignments.user_id = :user_id
									AND term = 'Fall' AND course_year = 2015");
									   
			$stmt->bindValue(':course_info_id', $mult_course_id);
			$stmt->bindValue(':user_id', $user_id);
			$stmt->execute();
			
			if($result4 = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				if(intval($result4['probable']) == 0)
				{
					$classApps[$cs_key]['status'] = "Assigned!";
				}
				else
				{
					$classApps[$cs_key]['status'] = "Under Serious Consideration";
				}
			}
			else
			{
				$classApps[$cs_key]['status'] = "Applied";
			}
		}
		
		$db->commit();
	}
	catch(PDOException $e)
	{
		return NULL;
		reportDBError($e);
	}
}

// Returns a two-dimensional array of class applications for the user
function getClassesTaken($user_id, &$classesTaken)
{
	try
    {
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT course_id FROM Courses_Taken
								   WHERE user_id = :user_id
								   GROUP BY course_id;");
								   
		$stmt->bindValue(':user_id', $user_id);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$count = 0;
		foreach($result as $row)
		{
			$mult_course_id = $row['course_id'];
			$stmt = $db->prepare("SELECT grade, term, course_year, dept_name, course_num, course_details, first_name, last_name FROM
									   ((Courses_Taken INNER JOIN Courses ON Courses_Taken.course_id = Courses.course_id)
									   NATURAL JOIN Course_Info)
									   INNER JOIN Users ON Courses.user_id = Users.user_id
									   WHERE Courses_Taken.user_id = :user_id AND Courses_Taken.course_id = :course_id
									   ORDER BY timestamp_taken DESC LIMIT 1");
									   
			$stmt->bindValue(':user_id', $user_id);
			$stmt->bindValue(':course_id', $mult_course_id);
			$stmt->execute();
				
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
			$classesTaken[$count]['grade'] = $result2['grade'];
			$classesTaken[$count]['term'] = $result2['term'];
			$classesTaken[$count]['year'] = $result2['course_year'];			
			$classesTaken[$count]['dept_name'] = $result2['dept_name'];
			$classesTaken[$count]['course_num'] = $result2['course_num'];
			$classesTaken[$count]['teacher_first'] = $result2['first_name'];
			$classesTaken[$count]['teacher_last'] = $result2['last_name'];
			
			$count++;
		}
		
		$db->commit();
   }
   catch(PDOException $e)
	{
		reportDBError($e);
	}
}

function getPossibleTAs($user_id, &$course_info)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT course_id, course_info_id FROM Courses
							  WHERE user_id = :user_id AND term = 'Fall' AND course_year = 2015");
		$stmt->bindValue(':user_id', $user_id);
		$stmt->execute();
		
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$course_id = $row['course_id'];
			$course_info_id = $row['course_info_id'];
			
			$stmt = $db->prepare("SELECT dept_name, course_num FROM Course_Info
								  WHERE course_info_id = :course_info_id");
			
			$stmt->bindValue(':course_info_id', $course_info_id);
			$stmt->execute();
			
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
			$cs_key = $result2['dept_name'] . " " . $result2['course_num'];
			$course_info[$cs_key] = Array();
			
			$stmt = $db->prepare("SELECT user_id FROM Course_Applications
								  WHERE course_info_id = :course_info_id
								  GROUP BY user_id");
								  
			$stmt->bindValue(':course_info_id', $course_info_id);
			$stmt->execute();
			$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($result3 as $row)
			{
				$applicant_id = $row['user_id'];	
				
				$stmt = $db->prepare("SELECT first_name, last_name, essay FROM
									  (Users NATURAL JOIN Course_Applications)
									  WHERE Users.user_id = :applicant_id AND Course_Applications.course_info_id = :course_info_id");
									  
				$stmt->bindValue(':applicant_id', $applicant_id);
				$stmt->bindValue(':course_info_id', $course_info_id);
				$stmt->execute();
				
				$result4 = $stmt->fetch(PDO::FETCH_ASSOC);
				$name_key = $result4['first_name'] . " " . $result4['last_name'];
				$course_info[$cs_key][$name_key] = Array();
				$course_info[$cs_key][$name_key]['user_id'] = $applicant_id;
				$course_info[$cs_key][$name_key]['course'] = $course_id;
				$course_info[$cs_key][$name_key]['essay'] = $result4['essay'];
				
				$stmt = $db->prepare("SELECT recommendation FROM Recommend WHERE user_id = :applicant_id AND course_id = :course_id");
				$stmt->bindValue(':applicant_id', $applicant_id);
				$stmt->bindValue(':course_id', $course_id);
				$stmt->execute();
				
				$result5 = $stmt->fetch(PDO::FETCH_ASSOC);
				$course_info[$cs_key][$name_key]['recommend'] = $result5['recommendation'];
				
				$stmt = $db->prepare("SELECT * FROM Assignments
									  WHERE user_id = :applicant_id AND course_id = :course_id");
									  
				$stmt->bindValue(':applicant_id', $applicant_id);
				$stmt->bindValue(':course_id', $course_id);
				$stmt->execute();
				
				if($stmt->fetch(PDO::FETCH_ASSOC))
					$course_info[$cs_key][$name_key]['assign'] = 'Yes';
				else
					$course_info[$cs_key][$name_key]['assign'] = 'No';
			}
		}
	$db->commit();
   }
   catch(PDOException $e)
	{
		reportDBError($e);
	}
}

function getAppClasses(&$classes)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT * FROM Course_Info
								GROUP BY dept_name, course_num, credits, course_details");
					  
		$stmt->execute();
		
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$class_key = $row['dept_name'] . ' ' . $row['course_num'];
			array_push($classes, $class_key);
		}
	}
	catch(PDOException $e)
	{
		reportDBError($e);
	}
}

function getClasses($term, $year, &$class_info)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT * FROM
							  Courses INNER JOIN Course_Info ON Courses.course_info_id = Course_Info.course_info_id
							  WHERE term = :term AND course_year = :year");
		
		$stmt->bindValue(':term', $term);
		$stmt->bindValue(':year', $year);				  
		$stmt->execute();
	
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$course_id = $row['course_id'];
			$course_info_id = $row['course_info_id'];
			$teacher_id = $row['user_id'];
			
			$class_key = $row['dept_name'] . " " . $row['course_num'];
			$class_info[$class_key] = Array();
			$class_info[$class_key]['credits'] = $row['credits'];
			$class_info[$class_key]['details'] = $row['course_details'];
			$class_info[$class_key]['enroll'] = $row['enrollment'];
			$class_info[$class_key]['days'] = $row['days'];
			$class_info[$class_key]['time'] = $row['time'];
			$class_info[$class_key]['location'] = $row['location'];
			
			$stmt = $db->prepare("SELECT first_name, last_name FROM Users
								  WHERE user_id = :teacher_id");
								  
			$stmt->bindValue(':teacher_id', $teacher_id);
			$stmt->execute();
			
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
			$class_info[$class_key]['teacher'] = $result2['first_name'] . " " . $result2['last_name'];
			$class_info[$class_key]['assign'] = Array();
			
			$stmt = $db->prepare("SELECT first_name, last_name FROM
								  Users NATURAL JOIN Assignments
								  WHERE Assignments.course_id = :course_id");
			$stmt->bindValue(':course_id', $course_id);					  
			$stmt->execute();
			
			$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result3 as $row3)
			{
				$ta_assign_name = $row3['first_name'] . " " . $row3['last_name'];
				array_push($class_info[$class_key]['assign'], $ta_assign_name);
			}
		}
		$db->commit();
	}
	catch(PDOException $e)
	{
		reportDBError($e);
	}
}

function getApplicants(&$apps)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT user_id FROM Applicant_Info GROUP BY user_id");
		$stmt->execute();
	
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$user_id = $row['user_id'];
			
			$stmt = $db->prepare("SELECT first_name, last_name FROM Users WHERE user_id = :user_id");
			$stmt->bindValue(':user_id', $user_id);
			$stmt->execute();
			
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
			$app_key = $result2['first_name'] . " " .$result2['last_name'];
			$apps[$app_key] = Array();
			$apps[$app_key]['applied'] = Array();
			$apps[$app_key]['probable'] = Array();
			$apps[$app_key]['assigned'] = Array();
			
			$stmt = $db->prepare("SELECT course_info_id FROM Course_Applications
								  WHERE user_id = :user_id
								  GROUP BY course_info_id");
								  
			$stmt->bindValue(':user_id', $user_id);
			$stmt->execute();
			
			$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result3 as $row3)
			{
				$course_info_id = $row3['course_info_id'];
				
				$stmt = $db->prepare("SELECT dept_name, course_num FROM Course_Info WHERE course_info_id = :course_info_id");
				$stmt->bindValue(':course_info_id', $course_info_id);
				$stmt->execute();
				
				$result4 = $stmt->fetch(PDO::FETCH_ASSOC);
				$class_val = $result4['dept_name'] . " " . $result4['course_num'];
				array_push($apps[$app_key]['applied'], $class_val);
			}
			
			$stmt = $db->prepare("SELECT * FROM (Assignments INNER JOIN Courses ON Assignments.course_id = Courses.course_id)
								  INNER JOIN Course_Info ON Courses.course_info_id = Course_Info.course_info_id
								  WHERE Assignments.user_id = :user_id");
								  
			$stmt->bindValue(':user_id', $user_id);
			$stmt->execute();
			
			$result6 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result6 as $row6)
			{
				$assign_class_val = $row6['dept_name'] . " " . $row6['course_num']
					. " (" . $row6['term'] . " " . $row6['course_year'] . ")";
				if($row6['probable'] == 1)
				{
					array_push($apps[$app_key]['probable'], $assign_class_val);
				}
				else
				{
					array_push($apps[$app_key]['assigned'], $assign_class_val);
				}
			}
		}
		$db->commit();
	}
	catch(PDOException $e)
	{
		reportDBError($e);
	}
}


function getComments($key)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT comments FROM Evaluations WHERE eval_id = :key");
		$stmt->bindValue(':key', $key);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['comments'];
	}
	catch(PDOException $e)
	{
		reportDBError($e);
	}
}

function getEvaluations(&$eval_info)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT first_name, last_name, dept_name, course_num, term, course_year, score, comm_score, eval_id
								FROM (((Users NATURAL JOIN Assignments)
								INNER JOIN Courses ON Assignments.course_id = Courses.course_id)
								NATURAL JOIN Course_Info)
								NATURAL JOIN Evaluations");
									  
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$key = $row['eval_id'];
			$eval_info[$key]['ta'] = $row['first_name'] . " " . $row['last_name'];
			$eval_info[$key]['class'] = $row['dept_name'] . " " . $row['course_num'];
			$eval_info[$key]['term'] = $row['term'] . " " . $row['course_year'];
			$eval_info[$key]['performance'] = $row['score'];
			$eval_info[$key]['communication'] = $row['comm_score'];
			$eval_info[$key]['comments'] = $row['comments'];
		}
		$db->commit();
	}
	catch(PDOException $e)
	{
		$db->rollBack();
		reportDBError($e);
	}
}


function getAssignments($term, $year, $class, &$assign_info)
{
	try
	{
		$course_num = substr($class, 3);
		$assign_info['assigned'] = Array();
		$assign_info['probable'] = Array();
		$assign_info['applied'] = Array();
		
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT course_id, course_info_id FROM
									  Course_Info NATURAL JOIN Courses
									  WHERE course_num = :course_num AND course_year = :course_year AND term = :term");
									  
		$stmt->bindValue(':course_num', $course_num);
		$stmt->bindValue(':course_year', $year);
		$stmt->bindValue(':term', $term);
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$course_id = $result['course_id'];
		$course_info_id = $result['course_info_id'];
	
		$stmt = $db->prepare("SELECT first_name, last_name, probable FROM
									  Users NATURAL JOIN Assignments
									  WHERE course_id = :course_id");
		$stmt->bindValue(':course_id', $course_id);			  
		$stmt->execute();
		
		$result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result2 as $row)
		{
			$ta_assign_name = $row['first_name'] . " " . $row['last_name'];
			
			if($row['probable'] == 0)
			{	
				array_push($assign_info['assigned'], $ta_assign_name);
			}
			else
			{	
				array_push($assign_info['probable'], $ta_assign_name);
			}
		}
		
		$stmt = $db->prepare("SELECT first_name, last_name FROM
									  Users NATURAL JOIN Course_Applications
									  WHERE course_info_id = :course_info_id AND user_id NOT IN
									  (SELECT user_id FROM Users NATURAL JOIN Assignments WHERE course_id = :course_id)");
				
		$stmt->bindValue(':course_info_id', $course_info_id);
		$stmt->bindValue(':course_id', $course_id);
		$stmt->execute();					  
		$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result3 as $row2)
		{
			$ta_assign_name = $row2['first_name'] . " " . $row2['last_name'];
			array_push($assign_info['applied'], $ta_assign_name);
		}
	}
	catch(PDOException $e)
	{
		reportDBError($e);
	}
}

function updateAssignments($term, $year, $class, $action, $name)
{
	try
	{
		$course_num = substr($class, 3);
		$pos = strpos($name, ' ');
		$first_name = substr($name, 0, $pos);
		$last_name = substr($name, $pos + 1);
		
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT course_id, course_info_id FROM
									  Course_Info NATURAL JOIN Courses
									  WHERE course_num = :course_num AND course_year = :course_year AND term = :term");
									  
		$stmt->bindValue(':course_num', $course_num);
		$stmt->bindValue(':course_year', $year);
		$stmt->bindValue(':term', $term);
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$course_id = intval($result['course_id']);
		$course_info_id = $result['course_info_id'];
		
		$stmt = $db->prepare("SELECT user_id FROM Users WHERE first_name = :first_name AND last_name = :last_name"); 
		
		$stmt->bindValue(':first_name', $first_name);
		$stmt->bindValue(':last_name', $last_name);
		$stmt->execute();
		
		$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_id = intval($result2['user_id']);
		
		$stmt = $db->prepare("DELETE FROM Assignments WHERE user_id = :user_id AND course_id = :course_id");
		
		$stmt->bindValue(':user_id', $user_id);
		$stmt->bindValue(':course_id', $course_id);
		$stmt->execute();
		
		if($action == 'Assigned')
		{
			$stmt = $db->prepare("INSERT INTO Assignments (user_id, course_id, probable)
									VALUES (:user_id, :course_id, 0)");
									  
			$stmt->bindValue(':course_id', $course_id);
			$stmt->bindValue(':user_id', $user_id);
			$stmt->execute();
		}
		else if($action == 'Probable')
		{
			$stmt = $db->prepare("INSERT INTO Assignments (user_id, course_id, probable)
									VALUES (:user_id, :course_id, 1)");
									  
			$stmt->bindValue(':course_id', $course_id);
			$stmt->bindValue(':user_id', $user_id);
			$stmt->execute();
		}
		
		$db->commit();
	}
	catch(PDOException $e)
	{
		$db->rollBack();
		reportDBError($e);
	}
}

function commitRecommends(&$changes)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("INSERT INTO Recommend(user_id, course_id, recommendation)
							  VALUES (:user_id,:course,:recommend)");
		$stmt->bindValue('user_id', $changes['user_id']);
		$stmt->bindValue('course', $changes['course']);
		$stmt->bindValue('recommend', $changes['recommend']);
		$stmt->execute();

		$db->commit();
	}
	catch(PDOException $e)
	{
		$db->rollBack();
		reportDBError($e);
	}
}

// Logs and reports a database error
function reportDBError($exception)
{
	echo $exception;
   	require "../Views/error.php";
   	exit();
}

?>
