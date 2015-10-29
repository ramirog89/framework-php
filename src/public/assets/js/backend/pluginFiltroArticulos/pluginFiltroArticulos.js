var filtro = {
	
	settings : {
		"filtro"    : ".filtro",
		"menuBtns"  : ".filtro .header ul li",
		"actdBtns"  : ".filtro .header ul li.active",
		"container" : ".filtro .container",
		"lista"     : "#filtro-",
		"slider"    : "#slider-range",
		"amountMin" : "#amountMin",
		"amountMax" : "#amountMax",
		"form"      : ".filtro form#formFilter",
		"checkBox"  : ".filtro .checkbox",
		"resetBox"	: ".filtro .buttons input[type='reset']",
		"sbtBttn"	: ".filtro .buttons input[type='submit']",
		"orderby"   : ".filtro .checkbox input[name='order']"
	},
	
	methods : {
		filterSlide : function() {
			var filterFirstPosition = $('.inner_wrapper').position().top + 75;
			
		    $(window).scroll(function() {
		        if(filterFirstPosition >= $(window).scrollTop()) {
		            if($('.filtro').hasClass('fixed')) {
		                $('.filtro').removeClass('fixed');
		                $('.filtro').show();
                        $('#listadoItemsProducto').css({'margin-top' : '10px'});
		                
		            }
		        } else { 
		            if(!$('.filtro').hasClass('fixed')) {
		                $('.filtro').addClass('fixed');
                        $('#listadoItemsProducto').css({'margin-top' : '110px'});
		            }
		        }
		    });
			
			$(window).resize(function() {
				if($('.filtro').hasClass('fixed')) {
					$('.filtro').addClass('fixed');
                        $('#listadoItemsProducto').css({'margin-top' : '110px'});
				}
			});
		},
		select : function( container, list, activedList ) {
			if (!container.hasClass('active')) {
				container.fadeIn('slow').addClass('active');
			}
			
			if (activedList.length > 0) {
				return this.hide( activedList, list );
			} else {
				return this.show( list );
			}
		},
		show : function( item ) {
			$(item).addClass('active')
				   .fadeIn('slow');
		},
		hide : function( hide, show ) {
			local = this; // set this to local to be enable to call "methods.show" inside callback fadeOut event
			$(hide).removeClass('active')
				   .fadeOut('fast', function(){
					   local.show( show );
				   });
		},
		setChecked : function( checkbox ) {

			if (!checkbox.hasClass('checked')) {
				checkbox.addClass('checked').children().attr('checked', true);
			} else {
				checkbox.removeClass('checked').children().attr('checked', false);
			}
			
		},
		resetBoxes : function( checkBoxes, rangeMin, rangeMax, amountMin, amountMax, sliderEl ) {
			
			checkBoxes.parent().find('.checked').removeClass('checked');
			$( amountMin ).val( "$" + rangeMin );
    		$( amountMax ).val( "$" + rangeMax );
    		$( sliderEl ).slider({values: [ rangeMin, rangeMax ]});
    		
		},
		submit : function( form, rangeMin, rangeMax ) {
			checkedInputs  = form.find('.checked input'); // get checked inputs
			rangeSettedMin = parseFloat($('#amountMin').val().match(/[0-9\.]+/)[0]);
			rangeSettedMax = parseFloat($('#amountMax').val().match(/[0-9\.]+/)[0])
			
			arr = {
					"marcas" : [],
					"categorias" : [],
					"talles" : [],
					"colores" : [],
					"order" : []
			};
			
			$(checkedInputs).each(function( index, input ){
				
				name = $(input).attr('name');
				value = $(input).attr('value');
				arr[name].push(value); // push input value (current id) on the list for  
				
			});
			
			parameters = ""; // set url parameters given by the form filter 
			$.each(arr, function( filter , ids ){
			    parameters += '&' 
			    		   + filter 
			    		   + '=' 
			    		   + ids.join(",");				    
			});
			parameters = parameters.substring(1); // delete first & 
			parameters += '&rango=' + rangeMin + ',' + rangeMax + ',' + rangeSettedMin + ',' + rangeSettedMax;
			
			
			baseUrl = window.location.hostname + window.location.pathname; // set baseUrl

			url = baseUrl + "?" + parameters; // set url
			
			return window.location.href = "http://" + url; // redirect
		},
		setInputChecked : function() {
			// Get and parse url parameters to get input ids and mark them as "checked"  
			if (window.location.search.length > 0) {
				$(window.location.search.substring(1).split("&")).each(function( i, e ){
				    a = e.split("=");
				    firstSelector = '#' + a[0] + '-';
				    
				    ids = a[1].split(",");
				    
				    $.each(ids, function( i , v ){
				        selector = firstSelector + v;
				        $(selector).attr('checked', true)
				                   .addClass('checked');
				    });
				});
			}
		}
	},
	
	setUp: function( rangeMin, rangeMax, rangeSettedMin, rangeSettedMax ) {
		// setup vars
		obj = this;
		filtro	  = $( obj.settings.filtro    );
		container = $( obj.settings.container );
		buttons   = $( obj.settings.menuBtns  );
		sliderEl  = $( obj.settings.slider    );
		amountMin = $( obj.settings.amountMin );
		amountMax = $( obj.settings.amountMax );
		checkBox  = $( obj.settings.checkBox  );
		resetBox  = $( obj.settings.resetBox  );
		sbtBttn   = $( obj.settings.sbtBttn   );
		form	  = $( obj.settings.form      );
		orderby   = $( obj.settings.orderby   );
		
		obj.methods.setInputChecked();
		obj.methods.filterSlide();

		form.submit(function( ev ){
			ev.preventDefault();
		});
		
		/**
		 * Stop bubble propagation for ".filter container" 
		 * and be able to navigate inside the filter without hide it 
		 * unless the click event was made in the outer container
		 **/ 
		filtro.click(function( ev ){
			ev.stopPropagation();
		});
		
		// binding events to dom elements
		buttons.click(function( ev ){
			// if any button is actived, just remove the active class;
			$( obj.settings.actdBtns  ).removeClass('active');

			// get the current button and set as active
			current = $(ev.currentTarget);
			current.addClass('active');

			// match the current and active list to be shown
			currentList = $( obj.settings.lista + current.attr('id') );
			activedList = container.find('div.active');
			
			// return select object method
			return obj.methods.select( container, currentList, activedList );
		});
		
		rangeMin = parseInt(rangeMin);
		rangeMax = parseInt(rangeMax);
		
/*
		$( sliderEl ).slider({
	        range: true,
	        min: rangeMin,
	        max: rangeMax,
	        values: [ rangeSettedMin, rangeSettedMax ],
	        slide: function( event, ui ) {
	            $( amountMin ).val( "$" + ui.values[ 0 ] );
        		$( amountMax ).val( "$" + ui.values[ 1 ] );
	        },
	        stop: function( event, ui ) {
	        	return obj.methods.submit( form, rangeMin, rangeMax );
	        }
	    });
*/		
		if (rangeSettedMin == 0) {
			rangeSettedMin = rangeMin;
		}
		$( amountMin ).val( "$" + rangeSettedMin );
		$( amountMax ).val( "$" + rangeSettedMax );
		
		checkBox.parent().click(function( ev ){
			return obj.methods.setChecked( $(this).find('span') );
		});

		orderby.parent().parent().click(function( ev ){
			orderby.parent().removeClass('checked');
			return obj.methods.setChecked( $(this).find('span') );
		});
		
		resetBox.click(function( ev ){
			obj.methods.resetBoxes( checkBox, rangeMin, rangeMax, amountMin, amountMax, sliderEl );
			return obj.methods.submit( form, rangeMin, rangeMax );
		});
		
		sbtBttn.click(function(){
			return obj.methods.submit( form, rangeMin, rangeMax );
		});
		
		$('body').click(function( ev ){
			container.removeClass('active').fadeOut('slow', function(){
				$( obj.settings.actdBtns  ).removeClass('active');
				container.find('div.active').hide().removeClass('active');
			});
		});
		
	}
	
};

filtro.setUp();
