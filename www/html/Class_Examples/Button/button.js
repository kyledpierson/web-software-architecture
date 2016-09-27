

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
function Button_Sprite( gui_container, my_title, my_width, my_height, call_back, my_id, use_images )
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
	if (! use_images_)
	{
            this.clear();
            this.lineStyle(2, 0xCCCCCC);
	    
            var colors = [0xF0D0D0, 0xA01030];
            var alphas = [100, 100];
            var ratios = [0, 255];
            
	    //      this.beginGradientFill("linear",colors,alphas,ratios);
            this.lineStyle(2,0xffffff);
            this.beginFill(0xFFFF0B, 1);
            this.drawRoundedRect(0, 0, 100, 50, 0);
            this.endFill();
	}
	else
	{
            this.addChild(default_sprite);
	    this.addChild(text_field_); // always on top
            this.removeChild(over_sprite);
            this.removeChild(down_sprite);

	    text_field_.position.x = (default_sprite.width  - text_field_.width)/2;
	    text_field_.position.y = (default_sprite.height - text_field_.height)/2;

	}


    }.bind(this);
    
    /**
     * Change the look when the mouse is down on the button
     */
    var create_mouse_down_display_list = function( e )
    {
	if (! use_images_)
	{

            this.clear();
            this.lineStyle(2, 0xCCCCCC);
	    
            var colors = [0xFAD4DB*.9, 0xEC748B*.9, 0xC13A59*.9, 0xA81230*.9];
            var alphas = [100, 100, 100, 100];
            var ratios = [0, 126, 127, 255];
            
	    //      this.beginGradientFill("radial",colors,alphas,ratios);
            this.beginFill();
            this.drawRoundedRect(0, 0, 100, 50, 0);
            this.endFill();
	}
	else
	{
	    
            this.addChild(down_sprite);
            this.removeChild(default_sprite);
            this.removeChild(over_sprite);
	    this.addChild(text_field_); // always on top            

	    text_field_.position.x = (default_sprite.width  - text_field_.width)/2 + 10;
	    text_field_.position.y = (default_sprite.height - text_field_.height)/2 + 10;

	}
	    
        
    }.bind(this);
    
    /**
     * Change the look when the mouse is over the button
     */
    var create_mouse_over_display_list = function( e )
    {
	if ( use_images_)
	{
            this.addChild(over_sprite);
            this.removeChild(default_sprite);
            this.removeChild(down_sprite);
	    this.addChild(text_field_); // always on top

	    text_field_.position.x = (default_sprite.width  - text_field_.width)/2;
	    text_field_.position.y = (default_sprite.height - text_field_.height)/2;

	}
	else
	{
	    
            this.clear();
            this.lineStyle(3, 0x000000);
	    
            var colors = [0xD0D0D0, 0x901030];
            var alphas = [100, 100];
            var ratios = [0, 255];
            
	    //      this.beginGradientFill("linear",colors,alphas,ratios);
            this.lineStyle(2,0xffffff);
            this.beginFill( 0xdddddd, 1);
            this.drawRoundedRect(0, 0, 100, 50, 0);
            this.endFill();
	}

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
    var title = my_title;
    var value = my_id;
    var text_field_ = new PIXI.Text("hello", {font:"60pt Arial", align:"center", fill:"white", dropShadow:"true"});

    text_field_.scale.x = .5;
    text_field_.scale.y = .5;

    var texture = PIXI.Texture.fromImage("button.png");
    var default_sprite = new PIXI.Sprite(texture);

    var texture = PIXI.Texture.fromImage("button_over.png");
    var over_sprite = new PIXI.Sprite(texture);

    var texture = PIXI.Texture.fromImage("button_down.png");
    var down_sprite = new PIXI.Sprite(texture);

    var use_images_ = use_images;

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
    this.set_title( title );
    this.set_value( my_id );


    //
    // EVENT Setup
    //
    
    this.change_click_function( call_back );

    this.mouseover = create_mouse_over_display_list;
    this.mouseout   = create_default_display_list;
    this.mousedown = this.touchstart = create_mouse_down_display_list;

    this.width=my_width;
    this.height=my_height;
    
    this.scale.x = my_width / 359; // FIXME: use actual size of images
    this.scale.y = my_height / 113;

    // initial state
    create_default_display_list();

    if ( use_images )
    {
	//FIXME: DUE to a BUG in PIXI, if all children of a sprite aren't loaded at start
	//       the first time they are shown, they will shake (jump to 0,0 and back)
	this.addChild(over_sprite);
	this.addChild(down_sprite);
	this.addChild(default_sprite);
	this.addChild(text_field_);
    }


}

