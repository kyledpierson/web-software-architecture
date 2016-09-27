// JavaScript Document

function get_comments( key )
{
	data = "key=" + key;
    $.ajax(
	{
	    type:     'POST',
	    url:      'Models/get_comments.php',
	    data:     data,
	    dataType: 'html',  		      // The type of data that is getting returned.
	    
	    beforeSend: function()
	    {
	    },
	    
	    success: function(response)
	    {
	    	var jContent = $( "#" + key );
	    	jContent.html( response );
	    },
	    
	    error: function( response, options, error )
	    {
	    	// something went wrong
	    	var jContent = $( "#" + key );
	    	jContent.html( "<p>Error</p>"  );
	    	console.log('Error message: ' + response.statusText );
	    	console.log('Error message: ' + options );
	    	console.log('Error message: ' + error );
	    }

	});
}

function hide_me( key )
{
	$('#' + key).html("<button id='" + key + "' onclick='return get_comments(" + key + ")'>Show Comments</button>");
}
