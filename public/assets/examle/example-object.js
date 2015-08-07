Example = {

    init: function(data){
        if(data !== undefined){
            $.each(data, function(index, value){
                if(Example[index] !== undefined){
                    Example[index] = value;
                }
            });
        }

        Example.setAutoFunctions();
        Example.setHandlers();
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