$(function()
{
	var classes = 1;
	var apps = 1;
	// Make the remove button delete the block of controls in which it appears.
	$("#Remove").click(
	function()
	{
		if(classes > 1)
		{
			$(this).parents(".block").remove();
			$(".block").last().find(".class").attr("disabled", false);
			$(".block").last().find(".grade").attr("disabled", false);
			$(".block").last().find(".term").attr("disabled", false);
			$(".block").last().find(".year").attr("disabled", false);
			$(".block").last().find("#Add").show();
			classes--;
		}
		
	});

	// Make the "Add Class" button add a new block of controls
	$("#Add").click(
	function()
	{
		selected1 = $(this).parents(".block").find(".class").val();
		selected2 = $(this).parents(".block").find(".grade").val();
		selected3 = $(this).parents(".block").find(".term").val();
		selected4 = $(this).parents(".block").find(".year").val();
		
		if(!(selected1 == 'None' || selected2 == 'None' || selected3 == 'None' || selected4 == 'None'))
		{
			classes++;
			$("#message").text("");
			$(this).parents(".block").clone(true, true).appendTo("#Class_List");
			
			$(this).parents(".block").find(".class").attr("disabled", true);
			$(this).parents(".block").find(".grade").attr("name", "grade" + selected1);
			$(this).parents(".block").find(".grade").attr("disabled", true);
			$(this).parents(".block").find(".term").attr("name", "term" + selected1);
			$(this).parents(".block").find(".term").attr("disabled", true);
			$(this).parents(".block").find(".year").attr("name", "year" + selected1);
			$(this).parents(".block").find(".year").attr("disabled", true);
			$(this).parents(".block").find("#Add").hide();
		}
		else
		{
			$("#message").text("To add another class, you must fill out all fields");
		}
	});
	
	$("#Remove_app").click(
	function()
	{
		if(apps > 1)
		{
			$(this).parents(".app_block").remove();
			$(".app_block").last().find(".app").attr("disabled", false);
			$(".app_block").last().find(".essay").attr("disabled", false);
			$(".app_block").last().find("#Add_app").show();
			apps--;
		}
		
	});
	
	// Make the "Add Class" button add a new block of controls
	$("#Add_app").click(
	function()
	{
		selected = $(this).parents(".app_block").find(".app").val();
		
		if(selected != 'None')
		{
			apps++;
			$("#app_message").text("");
			$(this).parents(".app_block").clone(true, true).appendTo("#App_List");
			
			$(this).parents(".app_block").find(".app").attr("disabled", true);
			$(this).parents(".app_block").find(".essay").attr("name", "essay" + selected);
			$(this).parents(".app_block").find(".essay").attr("disabled", true);
			$(this).parents(".app_block").find("#Add_app").hide();
		}
		else
		{
			$("#app_message").text("Please select a class to apply for");
		}
	});
	
	// Make the "Add Class" button add a new block of controls
	$('form').submit(
	function( event )
	{
		if($("#Major").val() == '')
		{
			$("#app_message").text("Please enter your major");
           event.preventDefault();
		   return;
		}

		var gpa = parseFloat($("#GPA").val());
		if(isNaN(gpa) || gpa < 0 || gpa > 4 )
		{
			$("#app_message").text("Please enter a valid GPA between 0 and 4");
           event.preventDefault();
		   return;
		}
		
		selected = $(".block").last().find(".class").val();
		if(selected != 'None')
		{
			$(".block").last().find(".grade").attr("name", "grade" + selected);
			$(".block").last().find(".term").attr("name", "term" + selected);
			$(".block").last().find(".year").attr("name", "year" + selected);
		}
		
		selected = $(".app_block").first().find(".app").val();
        if(selected != 'None')
		{
			selected = $(".app_block").last().find(".app").val();
           $(".app_block").last().find(".essay").attr("name", "essay" + selected);
        }
		else
		{
			$("#app_message").text("Please select a class to apply for");
           event.preventDefault();
		   return;
		}
		
		$(".block").find("#content").children().attr("disabled", false);
		$(".app_block").find("#app_content").children().attr("disabled", false);
	});
});