/**
 *
 *  Author: H. James de St. Germain
 *  Date:   Spring 2014
 *
 *  UI Controls to query the DB for students gender
 *  or for all students who do not have a gender set.
 *
 *
 */

//
// Send an AJAX request to the DB to determine which
// students do not have their Gender status set.
//
function find_gender(  )
{

    var data1 = "";
    var data2 = "";

    if  ( $("#find_all_check_box").is(":checked") )
    {
    	data1 = "return_all=All";
    }
    
    if  ( $("#allow_modification").is(":checked") )
    {
    	data2 = "&modify=true";
    }


    $.ajax(
	{
	    type:     'POST',
	    url:      'build_gender_table.php',
	    data:     data1 + data2,
	    dataType: 'html',  		      // The type of data that is getting returned.
	    
	    beforeSend: function()
	    {
//	    	console.log("Jim here: '" + data1 + "', '" + data2 + "'");
	    },
	    
	    success: function(response)
	    {
	    	var jContent = $( "#content_gender" );
	    	jContent.html( response );
	    },
	    
	    error: function( response, options, error )
	    {
	    	// something went wrong
	    	var jContent = $( "#content_gender" );
	    	jContent.html( "<p>Err!! </p>"  );
	    	console.log('Jim, error message: ' + response.statusText );
	    	console.log('Jim, error message: ' + options );
	    	console.log('Jim, error message: ' + error );
	    }

	});

    return false; // no submit action required
}

//
// Send an AJAX request to the DB to change a students
// gender
//
function modify_gender( uid )
{
    
    $.ajax(
	{
	    type:'POST',
	    url: "modify_gender.php",
	    data: $("#form_" + uid).serialize(),

	    dataType: "html",  		      // The type of data that is getting returned.
	    
	    beforeSend: function()
	    {
	    	// alert('here: ' + $("#form_" + uid).serialize());
	    },
	    
	    success: function(response)
	    {
	    	var jContent = $( "#return_info_" + uid );
	    	jContent.html( response );
	    	
	    	var jContent = $( "#td_" + uid );
	    	jContent.html( response );
	    },

	    error: function( response, options, error )
	    {
	    	// something went wrong
	    	var jContent = $( "#return_info_"+uid );
	    	jContent.html( "<p>Err!! </p>"  );
	    	console.log('Jim, error message: ' + response.statusText );
	    	console.log('Jim, error message: ' + options );
	    	console.log('Jim, error message: ' + error );
	    }
	    
	});

    return false;
}




