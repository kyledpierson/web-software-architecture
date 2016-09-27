
	$essay = $_GET['Essay'];

	$query = "
	SELECT course_info_id FROM Course_Info WHERE dept_name = CS AND course_num = '$value'
	";
	$statement = $db->prepare( $query );
	$statement->execute(  );

	$result = $statement->fetch(PDO::FETCH_ASSOC);
	$course_info_id = $result[course_info_id];

	$query = "
	INSERT INTO Course_Applications (timestamp_app, user_id, course_info_id, essay, valid_app)
	VALUES (NOW(), '$userid', '$course_info_id', '$essay', 1)
	";
	$statement = $db->prepare( $query );
	$statement->execute(  );
