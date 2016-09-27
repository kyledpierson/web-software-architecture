/**
 *
 *  Author: H. James de St. Germain
 *  Date:   Spring 2014
 *
 *  Read a json object and display it on the screen
 *  
 *  TAKE NOTE OF:
 *    1) dataType  html vs json
 *        can convert html to object with JSON.parse function
 *             see solution 1
 *        why do this if you can simply state the returned data is json?
 *             see solution 2
 *               (note only do one of these)
 *          
 *    2)  use of object syntax on response variable 
 */

/*
 *  Function get_and_display_json
 *
 * this function will 
 * 
 *   1) use AJAX to
 *
 *   2) query the server for a Javascript Object in JSON format
 *
 *   3) display the Object in a human readable table format.
 *
 *
 *  Please Note: the use of serialize to transmit user typed form data to the server
 *
 */
function get_and_display_json(  )
{

    $.ajax(
        {
            type:'POST',
            url:  "send_json.php",
            data: $('#myform').serialize(),
            dataType: "html",                 // The type of data that is getting returned.
                       // Solution 2: change dataType from "html" to "json"
            /**
             * display the json object
             */
            success: function(response)
            {
                var jContent = $( "#content" ); // put data here
                alert(response);
                //response = JSON.parse(response);
                // Solution 1: uncomment the above line 
                var html = 
                        "<table border='1'>" +
                        "  <tbody>  " +
                        "    <tr>" +
                        "      <td>" +
                        response.name +
                        "      </td>" +
                        "    </tr>  " +
                        "    <tr>" +
                        "      <td>" +
                        response.phone +
                        "      </td>" +
                        "    </tr>  " +
                        "    <tr>" +
                        "      <td>" +
                        response.address +
                        "      </td>" +
                        "    </tr>  " +
                        "  </tbody> " +
                        "</table>";
                
                jContent.html(html);

            },

            /**
             * What to do if there is an error
             * 
             */
            error: function( response, options, error )
            {
                var jContent = $( "#content" );
                jContent.html( "<h2>Error - Only a programmer can fix this!! </h3>"  );
            }

        });

    return false;
}
