
$('document').ready(function(){

    $('.headerMenu.mobile').click(function(){
        var nav = $('.header .menu nav');
        if (!nav.hasClass('actived') && !nav.hasClass('hide') || nav.hasClass('hide')) {
            nav.show().addClass('actived').removeClass('hide'); 
        } else {
            nav.hide().removeClass('actived').addClass('hide');
        }
    });

	$('#slider').nivoSlider({
		animSpeed: 500,
		pauseTime: 3000,
		startSlide: 0,
		directionNav: true,
		controlNav: false,
		controlNavThumbs: false,
		pauseOnHover: true,
		prevText: 'Prev',
		nextText: 'Next',
	});
	
	var publicVars = publicVars || {};
	
			// Define global vars
		publicVars.$body          = $("body");
		publicVars.$header        = publicVars.$body.find('.site-header');
		publicVars.$footer        = publicVars.$body.find('.site-footer');
		publicVars.$headerTopMenu = publicVars.$header.find('.top-menu');
		publicVars.$mainMenu      = publicVars.$header.find('nav.main-menu');
		publicVars.$mobileMenu	  = publicVars.$body.find('.mobile-menu').first();

		publicVars.$cartCounter	  = publicVars.$body.find('.cart-counter');
		publicVars.$miniCart	  = publicVars.$body.find('.lab-mini-cart');

		publicVars.$loginForm	  = publicVars.$body.find('.login-form-env');

		// Setup Menu
		var subMenuVisibleClass = 'sub-visible';
	
	// Header Search Form
		var $searchForm = publicVars.$header.find('.search-form');

		if($searchForm.length === 1)
		{
			var $searchInput = $searchForm.find('.search-input');

			$searchInput.blur(function()
			{
				if($.trim($searchInput.val()).length === 0)
				{
					$searchForm.removeClass('input-visible');
				}
			});

			$searchForm.on('click', '.search-btn', function(ev)
			{
				if($.trim($searchInput.val()).length === 0)
				{
					ev.preventDefault();

					$searchForm.addClass('input-visible');
					setTimeout(function(){$searchInput.focus();}, 200);
				}
				else
				{
					$searchForm.submit();
				}
			});
		}

        var $grid = $('.imagenes').isotope({
          itemSelector: '.imagen',
          layoutMode : 'fitRows'
        });

        $(".filters li a").on("click", function(){
            var filtro = "." + $(this).attr("data-filter");

            filtro = (filtro == ".*") ? "*" : filtro;
            
            $grid.isotope({
                filter : filtro,
                    masonry: {
                    columnWidth: 200
                  },
        	  layoutMode: 'fitRows'	
            });
        });
});
