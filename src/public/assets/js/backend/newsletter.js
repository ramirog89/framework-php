var newsletter = {

    settings : {
        'newsletter' : '#newsletterSubmit',
        'newsletterclosebutton' : '#newsletterClose'
    },

    methods : {

        open: function( triggerClass ) {
            return triggerClass.bind('click', function(){
                $('#newsletter').dialog('open');
            });
        },

        close: function( triggerClass ) {
            return triggerClass.bind('click', function(){
                $('#newsletter').dialog('close');
            });
        },

        send : function(){}
    
    },

    init : function() {
        $('#newsletter').dialog({
            width: 650,
            modal: true,
            resizable: false,
            autoOpen: false,
            draggable: false,
            position: ['middle', 100],
            create: function(event, ui) {
                $('.ui-widget-header').remove();
            }
        });

        this.methods.open( $(this.settings.newsletter) );
        this.methods.close( $(this.settings.newsletterclosebutton) );
    }

};

newsletter.init();

