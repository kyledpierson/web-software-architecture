<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>AJAX Gender Example</title>

<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="gender_example.js"></script>
</head>

<body>

    <p>Search the DB for any student for whom the Gender is not known.</p>


    <form>
        <input id="find_all_check_box"   type="checkbox" 
               name="find_all"           value="find_all"> Show All Students </input> 
        <input id="allow_modification"   type="checkbox" 
               name="allow_modification" value="true"> Allow Modifications </input>
        <p>
            <button onclick="return find_gender()">Find Gender</button>
        </p>
    </form>

    <div id="content_gender"></div>

</body>