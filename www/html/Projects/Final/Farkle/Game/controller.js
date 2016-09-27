/**
 * Created by Andrew Johnson
 * Spring 2015
 * CS4540
 */

jQuery(function($)
{
    /**
     * Var IO contains all the connection-specific code.
     */
    var IO = {

        /**
         * Called when page loads - initializes socket, binds events to that socket
         */
        init: function() {
            IO.socket = io.connect();
            IO.bindEvents();
        },

        /**
         * When connected, listen for the following events
         */
        bindEvents : function() {
            IO.socket.on('connected', IO.onConnected );
            IO.socket.on('start', IO.onGameStart );
            IO.socket.on('turn', IO.onTurnChange );
            IO.socket.on('result', IO.resultReceived );
            IO.socket.on('end', IO.onGameEnd);
        },

        /**
         * Successfully connected - cache socket in App
         */
        onConnected : function() {
            App.mySocketId = IO.socket.socket.sessionid;
        },

        onGameStart : function(data) {
            App.Host.gameInit(data);
        },

        onTurnChange : function() {

        },

        resultReceived : function() {

        },

        onGameEnd : function() {

        }
    }

    /**
     * Var App contains all the game-specific code.
     */
    var App = {

        /**
         * the Socket.IO object
         */
        mySocketID : '',

        /**
         * Array of players
         */
        players : {},

        /**
         * init runs when page loads
         */
        init : function() {
            App.cacheElements();
            App.showInitScreen();
            App.bindEvents();
        },

        /**
         * Cache references to various HTML elements
         */
        cacheElements : function() {
            App.doc = $(document);

            //TODO - cache game elements such as canvas location, etc

        },

        /**
         * Loads initial screen
         */
        showInitScreen : function() {
          //TODO - initialize screen, waiting for players
        },

        /**
         * Create click handlers for elements on the page
         */
        bindEvents : function() {
            App.doc.on('click', '#btnjoingame', App.player.onJoinClick);

            //TODO - other clickable features
        },

        /**
         * Initialize game
         */
        gameInit : function() {

        }

        //TODO - more functionality

    }

    IO.init();
    App.init();

});