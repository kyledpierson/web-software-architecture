// JavaScript Document

function find_ta_table()
{
	var assign_class = $("#assign_class").val()
	if(assign_class == 'None')
	{
		$( "#content_ta" ).html("");
		$(".header_ta").attr("style", "display:block");
		return false;
	}
    var data = 'class=' + assign_class;

    $.ajax(
	{
	    type:     'POST',
	    url:      'Models/build_ta_table.php',
	    data:     data,
	    dataType: 'html',  		      // The type of data that is getting returned.
	    
	    beforeSend: function()
	    {
	    },
	    
	    success: function(response)
	    {
	    	var jContent = $( "#content_ta" );
	    	jContent.html( response );
			$(".header_ta").attr("style", "display:none");
	    },
	    
	    error: function( response, options, error )
	    {
	    	// something went wrong
	    	var jContent = $( "#content_ta" );
	    	jContent.html( "<p>Error</p>"  );
	    	console.log('Error message: ' + response.statusText );
	    	console.log('Error message: ' + options );
	    	console.log('Error message: ' + error );
	    }

	});

    return false; // no submit action required
}

function update_ta_table( name, id )
{
	var assign_class = $('#assign_class').val();
    var data = 'class=' + assign_class;
	
	var new_id = '#' + id;
	var status = $(new_id).find('.update_ta').val();
	var action = '&action=' + status;
	var name = '&name=' + name;
	
    $.ajax(
	{
	    type:     'POST',
	    url:      'Models/update_ta_table.php',
	    data:     data + action + name,
	    dataType: 'html',  		      // The type of data that is getting returned.
	    
	    beforeSend: function()
	    {
	    },
	    
	    success: function(response)
	    {
	    	$(new_id).find('.status').html( response );
	    },
	    
	    error: function( response, options, error )
	    {
	    	// something went wrong
	    	var jContent = $( '#content_ta' );
	    	jContent.html( '<p>Error</p>'  );
	    	console.log('Error message: ' + response.statusText );
	    	console.log('Error message: ' + options );
	    	console.log('Error message: ' + error );
	    }

	});

    return false; // no submit action required
	
}