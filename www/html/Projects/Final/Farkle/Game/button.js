

/**
 *  Author:   H. James de St. Germain
 *  Date:     Fall 2007
 *            Spring 2015 - Converted to JS
 *  Course:   CS 1410-EAE
 *
 *  Button Object
 *
 *  Description:
 *
 *      This class creates a Sprite that acts as a GUI button
 *
 *      Everything is built from scratch, including how to handle mouse over, clicks
 *      etc.  This should be contrasted with the Labeled_Button class which
 *      relies primarily on the built in "SimpleButton" class.
 *
 *  Data Members:
 *      title: what to put on the button
 *      value: an numerical identifier for the button for
 *             use with a single event handler function handling
 *             multiple buttons
 *      text_field_ : the button title text
 *      callback_function_ : the function to execute upon click
 */


//
// Inheritance
//
Button_Sprite.prototype = Object.create( PIXI.Graphics.prototype );
Button_Sprite.prototype.constructor = Button_Sprite;

/**
 * Constructor for a Button:
 *
 *   my_title  : what to put on the button
 *   my_id     : an integer identifier for button (can be used to distinguish multiple similar buttons)
 *   my_width  : how wide the button should be
 *   my_height : how tall the button should be
 *   call_back : an event handling function to process the button click
 *   use_images : if true, use images, else draw the button
 *
 */
function Button_Sprite( gui_container, my_width, my_height, call_back, my_id, use_face, dieNumber )
{

    //
    // Initialization (Note: placed after function definition so we can use them)
    //
    PIXI.Graphics.call(this); // super.Sprite

   


    /**
     * Create the basic look of the button (The default look)
     * which is used when ever the button is not being used
     */
    var create_default_display_list = function ( e )
    {
       
            this.addChild(default_sprite);
            //this.addChild(text_field_); // always on top
            this.removeChild(over_sprite);
            this.removeChild(down_sprite);

            //text_field_.position.x = (default_sprite.width  - text_field_.width)/2;
            //text_field_.position.y = (default_sprite.height - text_field_.height)/2;



    }.bind(this);

    /**
     * Change the look when the mouse is down on the button
     */
    var create_mouse_down_display_list = function( e )
    {
	

            this.addChild(down_sprite);
            this.removeChild(default_sprite);
            this.removeChild(over_sprite);
          


    }.bind(this);

    /**
     * Change the look when the mouse is over the button
     */
    var create_mouse_over_display_list = function( e )
    {

	
            this.addChild(over_sprite);
            this.removeChild(default_sprite);
            this.removeChild(down_sprite);
           

    }.bind(this);


    /**
     * change the identifier for the button
     */
    this.set_value = function ( the_value )
    {
        this.value = the_value;
    };

    /**
     * get the identifier for the button
     */
    this.get_value = function( )
    {
        return this.value;
    };

    /**
     * change title
     */
    this.set_title = function( new_title )
    {
        text_field_.setText( new_title );
    };

    /**
     * change callback
     */
    this.change_click_function = function( callback )
    {
        callback_function_ = callback;

        // mouse release
        this.mouseup = this.touchend =
            function(e)
        {
            create_default_display_list();
            callback_function_(e);

        }.bind(this);

    };


    /** for debugging purposes-->shows at top of variable data to make sure the object is a button sprite */
    this.AAA = "I am a button";

    /**
     *  title (a String) : What to put on the button
     *  value (an int)   : a unique integer identifier for the button
     */
    //var title = my_title;
    var value = my_id;
    //var text_field_ = new PIXI.Text("hello", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});


    var use_face_ = use_face;
    var die_Number = dieNumber;

    if(die_Number == 0)
    {
        var texture = PIXI.Texture.fromImage("../Game/Pictures/shaker.png");
        var default_sprite = new PIXI.Sprite(texture);

        var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedShaker.png");
        var over_sprite = new PIXI.Sprite(texture);


        var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedShaker.png");
        var down_sprite = new PIXI.Sprite(texture);
    }

    if(die_Number == 1)
    {
        if (use_face)
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/oneFace.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedOneFace.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedOneFace.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
        else
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/die1.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie1.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie1.png");
            var down_sprite = new PIXI.Sprite(texture);
        }

    }
    if(die_Number == 2)
    {
        if (use_face)
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/twoFace.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedTwoFace.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedTwoFace.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
        else
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/die2.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie2.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie2.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
    }
    if(die_Number == 3)
    {
        if (use_face)
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/threeFace.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedThreeFace.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedThreeFace.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
        else
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/die3.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie3.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie3.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
    }
    if(die_Number == 4)
    {
        if (use_face)
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/fourFace.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedFourFace.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedFourFace.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
        else
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/die4.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie4.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie4.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
    }
    if(die_Number == 5)
    {
        if (use_face)
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/fiveFace.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedFiveFace.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedFiveFace.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
        else
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/die5.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie5.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie5.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
    }
    if(die_Number == 6)
    {
        if (use_face)
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/sixFace.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedSixFace.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedSixFace.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
        else
        {
            var texture = PIXI.Texture.fromImage("../Game/Pictures/die6.png");
            var default_sprite = new PIXI.Sprite(texture);

            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie6.png");
            var over_sprite = new PIXI.Sprite(texture);


            var texture = PIXI.Texture.fromImage("../Game/Pictures/selectedDie6.png");
            var down_sprite = new PIXI.Sprite(texture);
        }
    }
    

    

    default_sprite.interactive = false;
    over_sprite.interactive = false;
    down_sprite.interactive = false;

    /** by definition, a button is created "on" a GUI */
    gui_container.addChild(this);

    /** the function which gets executed when the button is pressed*/
    var callback_function_ = call_back;

    /** allow this object to be used as a button */
    this.interactive = true;
    this.buttonMode = true;

    /** set the title */
    //this.set_title( title );
    //this.set_value( my_id );


    //
    // EVENT Setup
    //

    this.change_click_function( call_back );

    this.mouseover = create_mouse_over_display_list;
    this.mouseout   = create_default_display_list;
    this.mousedown = this.touchstart = create_mouse_down_display_list;


    // initial state
    create_default_display_list();

    this.width=my_width;
    this.height=my_height;
}

/**
 * prepare the preloader assets for this file
 */
Button_Sprite.prepare_preload = function( loader )
{
    loader.set_preload_images("../Game/Pictures",
                                    ["die1.png","die2.png","die3.png", "die4.png", "die5.png", "die6.png", "selectedDie1.png", "selectedDie2.png", "selectedDie3.png", "selectedDie4.png", "selectedDie5.png", "selectedDie6.png", "oneFace.png", "twoFace.png", "threeFace.png", "fourFace.png", "fiveFace.png", "sixFace.png", "selectedOneFace.png", "selectedTwoFace.png", "selectedThreeFace.png", "selectedFourFace.png", "selectedFiveFace.png", "selectedSixFace.png", "shaker.png", "selectedShaker.png"]);
};



