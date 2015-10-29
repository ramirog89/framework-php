$(document).ready(function(){
    (function($) {
        
      var allPanels = $('.accordion > dd').hide(),
          trigger   = $('.accordion > dt > h2');

      trigger.click(function() {
        if (!$(this).hasClass('selected')) {
            trigger.removeClass('selected');
            $(this).addClass('selected');
            allPanels.slideUp();
            $(this).parent().next().slideDown();
            return false;
        } else {
            trigger.removeClass('selected');
            allPanels.slideUp();
            return false;

        }
      });


      $(".fancy").fancybox({
          helpers : {
              title : {
                  type : 'over'
              }
          }
      });

    })(jQuery);

});

$(".customScrollBox").mCustomScrollbar({
    horizontalScroll: true,
    scrollButtons:{
        enable: true
    },
    set_width: 1124,
    set_height: 460
});
