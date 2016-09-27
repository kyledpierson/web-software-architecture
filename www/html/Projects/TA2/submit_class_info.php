
	// Submits class info when given class number as value (referenced from process.php which references ta_application_form

	$grade = $_GET['grade' . $value];
	$term = $_GET['term' . $value];
	$year = $_GET['year' . $value];

	$query = "
	SELECT course_info_id FROM Course_Info WHERE dept_name = CS AND course_num = '$value'
	";

	$statement = $db->prepare( $query );
	$statement->execute(  );

	$result = $statement->fetch(PDO::FETCH_ASSOC);
	$course_info_id = $result[course_info_id];

	$query = "
	SELECT course_id FROM Courses WHERE course_info_id = '$course_info_id' AND term = '$term' AND course_year = '$year'
	";

	$statement = $db->prepare( $query );
	$statement->execute(  );

	$result = $statement->fetch(PDO::FETCH_ASSOC);
	$course_id = $result[course_id];

	$query = "
	INSERT INTO Courses_Taken (timestamp_taken, user_id, course_id, grade, valid_taken)
	VALUES (NOW(), '$userid', '$course_id', '$grade', 1)
	";

	$statement = $db->prepare( $query );
	$statement->execute(  );
