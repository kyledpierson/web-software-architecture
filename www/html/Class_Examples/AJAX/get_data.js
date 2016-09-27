/**
 *
 *  Author: H. James de St. Germain
 *  Date:   Spring 2014
 *
 *  Make an AJAX request for data
 *  
 *  Of interest:
 *  
 *     1) type: post, get
 *     2) url - php page to "consult"
 *     3) data - have to put the data in a form that php needs
 *               this form is "name=value&name2=value&...
 *     4) dataType - expected return type
 *     5) beforeSend - function to set up date
 *     6) success    - function to handle updating the page
 *     7) error      - function to handle errors
 *     8) complete   - function to call after everything is done.
 *     9) return false - to disable submit
 *     
 *     
 */

//
// 
//
function find_data(  )
{

    $.ajax(
	{
	    type:'POST',
	    url:  $("input[name=cause_error]").is(':checked') ? "asdf" : "get_data.php",
	    data: $('#form_id').serialize(),
	    dataType: "html",  		      // The type of data that is getting returned.
	    
	    /**
	     * What to do before the ajax request is sent. Perhaps gather
	     * page information, prep form, etc.
	     */
	    beforeSend: function()
	    {
    		var check_box = $("input[name=before_send]");
    		
    		if (check_box.is(':checked'))
    		{
    			alert ( "prepping AJAX call with data: " + $('#form_id').serialize() );
    		}

	    },
	    
	    /**
	     * What to do when the data is successfully retreived
	     */
	    success: function(response)
	    {
    		var check_box = $("input[name=on_success]");
    		
    		if (check_box.is(':checked'))
    		{
    			alert ( "Data Rerturned Successfully!" );
    		}

	    	var jContent = $( "#content" ); // put data here
	    	jContent.html( response );

	    },

	    /**
	     * What to do after the transaction is complete.
	     */
	    complete: function()
	    {
		  
	    },

	    /**
	     * What to do if there is an error
	     * 
	     */
	    error: function( response, options, error )
	    {
	    	// something went wrong
	    	var jContent = $( "#content" );
	    	jContent.html( "<h2>Error - Only a programmer can fix this!! </h3>"  );
	    	console.log('Jim, error message: ' + response.statusText );
	    	console.log('Jim, error message: ' + options );
	    	console.log('Jim, error message: ' + error );
	    }

	});

    // if this is associated with a submit button, return false to
    // disable a page submit
    return false;
}