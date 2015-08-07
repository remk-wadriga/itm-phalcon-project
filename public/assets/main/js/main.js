/**
 * Created by Developer on 04-08-2015.
 */

Main = {

    init: function(data){
        if(data !== undefined){
            $.each(data, function(index, value){
                if(Main[index] !== undefined){
                    Main[index] = value;
                }
            });
        }

        Main.setAutoFunctions();
        Main.setHandlers();
    },

    setAutoFunctions: function(){

    },

    setHandlers: function(){

    }


    // Auto functions

    // END Auto functions


    // Event handlers

    // END Event handlers


    // Event handlers

    // END Event handlers


    // Public functions

    // END Public functions


    // Private functions

    // END Private functions

};