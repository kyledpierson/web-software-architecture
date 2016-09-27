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
		
		$stmt = $db->prepare("INSERT INTO Users (first_name, last_name, email, user_password, role) VALUES (?,?,?,?,?)");
		$stmt->bindValue(1, $first);
		$stmt->bindValue(2, $last);
		$stmt->bindValue(3, $email);
		$stmt->bindValue(4, $pass);
		$stmt->bindValue(5, $role);
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
		
		$stmt = $db->prepare("INSERT INTO Applicant_Info (timestamp_info, user_id, gpa, major, academic_level) VALUES(NOW(),?,?,?,?)");
		$stmt->bindValue(1, $user_id);
		$stmt->bindValue(2, $gpa);
		$stmt->bindValue(3, $major);
		$stmt->bindValue(4, $level);
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
			$stmt = $db->prepare("SELECT course_info_id FROM Course_Info WHERE dept_name = ? AND course_num = ?");
			$stmt->bindValue(1, $value['dept_name']);
			$stmt->bindValue(2, $value['course_num']);
			$stmt->execute();
		
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$course_info_id = intval($result['course_info_id']);
		
			$stmt = $db->prepare("SELECT course_id FROM Courses WHERE course_info_id = ? AND term = ? AND course_year = ?");
			$stmt->bindValue(1, $course_info_id);
			$stmt->bindValue(2, $value['term']);
			$stmt->bindValue(3, $value['year']);
			$stmt->execute();
		
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
			$course_id = intval($result2['course_id']);
			
			$stmt = $db->prepare("INSERT INTO Courses_Taken (timestamp_taken, user_id, course_id, grade) VALUES(NOW(),?,?,?)");
			$stmt->bindValue(1, $value['user_id']);
			$stmt->bindValue(2, $course_id);
			$stmt->bindValue(3, $value['grade']);
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

function submitCourseApps(&$courseApps)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		foreach($courseApps as $value)
		{
			$stmt = $db->prepare("SELECT course_info_id FROM Course_Info WHERE dept_name = ? AND course_num = ?");
			$stmt->bindValue(1, $value['dept_name']);
			$stmt->bindValue(2, $value['course_num']);
			$stmt->execute();
			
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$course_info_id = intval($result['course_info_id']);
			
			$stmt = $db->prepare("INSERT INTO Course_Applications (timestamp_app, user_id, course_info_id, essay) VALUES(NOW(),?,?,?)");
			$stmt->bindValue(1, $value['user_id']);
			$stmt->bindValue(2, $course_info_id);
			$stmt->bindValue(3, $value['essay']);
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

// Returns an array of the applicants information
function getAppInfo($user_id, &$appInfo)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$statement = $db->prepare("SELECT * FROM Applicant_Info WHERE user_id = '$user_id' ORDER BY timestamp_info DESC LIMIT 1");
		$statement->execute();
		
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		
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
		
		$statement = $db->prepare("SELECT course_info_id FROM Course_Applications WHERE user_id = '$user_id' GROUP BY course_info_id");
		$statement->execute();
		
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$mult_course_id = $row['course_info_id'];
			
			$statement = $db->prepare("SELECT dept_name, course_num FROM Course_Info WHERE course_info_id = '$mult_course_id'");
			$statement->execute();
			
			$result2 = $statement->fetch(PDO::FETCH_ASSOC);
			$cs_key = $result2['dept_name'] . " " . $result2['course_num'];
			$classApps[$cs_key] = Array();
			
			$classApps[$cs_key]['dept_name'] = $result2['dept_name'];
			$classApps[$cs_key]['course_num'] = $result2['course_num'];
			
			$statement = $db->prepare("SELECT essay FROM Course_Applications WHERE user_id = '$user_id' AND course_info_id = '$mult_course_id'
			ORDER BY timestamp_app DESC LIMIT 1");
			$statement->execute();
			
			$result3 = $statement->fetch(PDO::FETCH_ASSOC);
			$classApps[$cs_key]['essay'] = $result3['essay'];
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
		
		$statement = $db->prepare("SELECT course_id FROM Courses_Taken WHERE user_id = $user_id GROUP BY course_id;");
		$statement->execute();
		
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		$count = 0;
		foreach($result as $row)
		{
			$mult_course_id = $row['course_id'];
			$statement = $db->prepare("SELECT grade FROM Courses_Taken WHERE user_id = $user_id AND course_id = $mult_course_id
				ORDER BY timestamp_taken DESC LIMIT 1");
			$statement->execute();
				
			$result2 = $statement->fetch(PDO::FETCH_ASSOC);
			$classesTaken[$count]['grade'] = $result2['grade'];
					
			$statement = $db->prepare("SELECT * FROM Courses WHERE course_id = '$mult_course_id'");
			$statement->execute();
				
			$result3 = $statement->fetch(PDO::FETCH_ASSOC);
			$classesTaken[$count]['term'] = $result3['term'];
			$classesTaken[$count]['year'] = $result3['course_year'];
			$instructor_id = $result3['user_id'];
			
			$statement = $db->prepare("SELECT dept_name, course_num FROM Course_Info WHERE course_info_id = " . $result3['course_info_id']);
			$statement->execute();
		
			$result4 = $statement->fetch(PDO::FETCH_ASSOC);
			$classesTaken[$count]['dept_name'] = $result4['dept_name'];
			$classesTaken[$count]['course_num'] = $result4['course_num'];
			
			$statement = $db->prepare("SELECT first_name, last_name FROM Users WHERE user_id = '$instructor_id'");
			$statement->execute();
		
			$result5 = $statement->fetch(PDO::FETCH_ASSOC);
			$classesTaken[$count]['teacher_first'] = $result5['first_name'];
			$classesTaken[$count]['teacher_last'] = $result5['last_name'];
			
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
		
	$stmt = $db->prepare("SELECT course_info_id FROM Courses WHERE user_id = '$user_id' AND term = 'Fall' AND course_year = 2015");
	$stmt->execute();
	
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
		$course_id = $row['course_id'];
		$course_info_id = $row['course_info_id'];
		
		$stmt = $db->prepare("SELECT dept_name, course_num FROM Course_Info WHERE course_info_id = '$course_info_id'");
		$stmt->execute();
		
		$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
		$cs_key = $result2['dept_name'] . " " . $result2['course_num'];
		$course_info[$cs_key] = Array();
		
		$stmt = $db->prepare("SELECT user_id FROM Course_Applications WHERE course_info_id = '$course_info_id' GROUP BY user_id");
		$stmt->execute();
		
		$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result3 as $row)
		{
			$applicant_id = $row['user_id'];
			
			$stmt = $db->prepare("SELECT first_name, last_name FROM Users WHERE user_id = '$applicant_id'");
			$stmt->execute();
			
			$result4 = $stmt->fetch(PDO::FETCH_ASSOC);
			$name_key = $result4['first_name'] . " " . $result4['last_name'];
			$course_info[$cs_key][$name_key] = Array();
			
			$course_info[$cs_key][$name_key]['user_id'] = $applicant_id;
			$course_info[$cs_key][$name_key]['recommend'] = '';
			$course_info[$cs_key][$name_key]['course'] = $course_id;
			
			$stmt = $db->prepare("SELECT recommendation FROM Recommend WHERE user_id = '$applicant_id' AND course_id = '$course_id'");
			$stmt->execute();
			
			$result6 = $stmt->fetch(PDO::FETCH_ASSOC);
			$course_info[$cs_key][$name_key]['recommend'] = $result6['recommendation'];
			
			$stmt = $db->prepare("SELECT essay FROM Course_Applications WHERE user_id = '$applicant_id' AND course_info_id = '$course_info_id'
				ORDER BY timestamp_app DESC LIMIT 1");
			$stmt->execute();
			
			$result5 = $stmt->fetch(PDO::FETCH_ASSOC);
			$essay = $result5['essay'];
			
			$course_info[$cs_key][$name_key]['essay'] = $essay;
			
			$stmt = $db->prepare("SELECT * FROM Assignments WHERE user_id = '$applicant_id' AND course_id = '$course_id'");
			$stmt->execute();
			
			if($result6 = $stmt->fetch(PDO::FETCH_ASSOC))
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

function getClasses(&$class_info)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT * FROM Courses INNER JOIN Course_Info ON Courses.course_info_id = Course_Info.course_info_id
			WHERE term = 'Fall' AND course_year = 2015");
		$stmt->execute();
	
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$course_id = $row['course_id'];
			$course_info_id = $row['course_info_id'];
			$teacher_id = $row['user_id'];
			$class_key = $row['dept_name'] . " " . $row['course_num'];
			$credits = $row['credits'];
			$course_details = $row['course_details'];
			
			$class_info[$class_key] = Array();
			$class_info[$class_key]['credits'] = $credits;
			$class_info[$class_key]['details'] = $course_details;
			
			$stmt = $db->prepare("SELECT first_name, last_name FROM Users WHERE user_id = '$teacher_id'");
			$stmt->execute();
			
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
			$teacher_name = $result2['first_name'] . " " . $result2['last_name'];
			$class_info[$class_key]['teacher'] = $teacher_name;
			$class_info[$class_key]['applied'] = Array();
			$class_info[$class_key]['assign'] = Array();
			
			$stmt = $db->prepare("SELECT first_name, last_name FROM Users INNER JOIN Course_Applications ON Users.user_id = Course_Applications.user_id
				WHERE Course_Applications.course_info_id = '$course_info_id'");
			$stmt->execute();
			
			$result4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result4 as $row3)
			{
				$ta_apply_name = $row3['first_name'] . " " . $row3['last_name'];
				
				array_push($class_info[$class_key]['applied'], $ta_apply_name);
			}
			
			$stmt = $db->prepare("SELECT first_name, last_name FROM Users INNER JOIN Assignments ON Users.user_id = Assignments.user_id
				WHERE Assignments.course_id = '$course_id'");
			$stmt->execute();
			
			$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result3 as $row2)
			{
				$ta_assign_name = $row2['first_name'] . " " . $row2['last_name'];
				
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
			
			$stmt = $db->prepare("SELECT first_name, last_name FROM Users WHERE user_id = '$user_id'");
			$stmt->execute();
			
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
			$app_key = $result2['first_name'] . " " .$result2['last_name'];
			$apps[$app_key] = Array();
			$apps[$app_key]['applied'] = Array();
			$apps[$app_key]['assigned'] = Array();
			
			$stmt = $db->prepare("SELECT course_info_id FROM Course_Applications WHERE user_id = '$user_id' GROUP BY course_info_id");
			$stmt->execute();
			
			$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result3 as $row2)
			{
				$course_info_id = $row2['course_info_id'];
				
				$stmt = $db->prepare("SELECT dept_name, course_num FROM Course_Info WHERE course_info_id = '$course_info_id'");
				$stmt->execute();
				
				$result4 = $stmt->fetch(PDO::FETCH_ASSOC);
				$class_val = $result4['dept_name'] . " " . $result4['course_num'];
				
				array_push($apps[$app_key]['applied'], $class_val);
			}
			
			$stmt = $db->prepare("SELECT * FROM (Assignments INNER JOIN Courses ON Assignments.course_id = Courses.course_id)
				INNER JOIN Course_Info ON Courses.course_info_id = Course_Info.course_info_id WHERE Courses.user_id = '$user_id'");
			$stmt->execute();
			
			$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($result5 as $row3)
			{
				$assign_class_val = $row3['dept_name'] . $row3['course_num'];
				array_push($apps[$app_key]['assigned'], $assign_class_val);
			}
		}
		$db->commit();
	}
	catch(PDOException $e)
	{
		reportDBError($e);
	}
}

function commitRecommends(&$changes)
{
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("INSERT INTO Recommend(user_id, course_id, recommendation) VALUES (?,?,?)");
		$stmt->bindValue(1, $changes['user_id']);
		$stmt->bindValue(2, $changes['course']);
		$stmt->bindValue(3, $changes['recommend']);
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
   	require "Views/error.php";
   	exit();
}

?>
