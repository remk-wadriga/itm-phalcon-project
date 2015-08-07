/**
 * Created by Developer on 06-08-2015.
 */

Accordion = {

    leftMenuID: '#left_menu_accordion',

    init: function(data){
        if(data !== undefined){
            $.each(data, function(index, value){
                if(LeftMenu[index] !== undefined){
                    LeftMenu[index] = value;
                }
            });
        }

        Accordion.setAutoFunctions();
        Accordion.setHandlers();
    },

    setAutoFunctions: function(){
        Accordion.initLeftMenuPlugin();
    },

    setHandlers: function(){

    },


    // Auto functions

    initLeftMenuPlugin: function(){
        $(Accordion.leftMenuID).metisMenu();
    }

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