
(function($) {
    'use strict';

    jQuery(window).on('load', function() {
        //Preloader
        setTimeout(function() {
            jQuery('body').addClass('loaded');
        }, 100);
    });

    //Fixed header on scroll
jQuery(window).scroll(function() {  	
var scroll = jQuery(window).scrollTop(); 
        if (scroll >= 200) {
            jQuery('.header').addClass('animated slideInDown sticked');
        } else {
            jQuery('.header').removeClass('animated slideInDown sticked');
        }
    });

    //Success Stories Carousel
    var owl = jQuery('.owl-carousel');
    if (owl.length) {
        owl.owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: false,
            dots: true,
            autoplay: false
        });
    };

    //Checkbox custom
    jQuery('.customCheckbox input[type="checkbox"]').each(function() {
        jQuery(this).parent().append("<span data-check=''></span>");
    });

    //Radio button custom
    jQuery('.customRadio input[type="radio"]').each(function() {
        jQuery(this).parent().append("<span data-radio=''></span>");
    });

    //Fire on Resize
    jQuery(window).on('resize load', function() {
        //functions here

    });

    //Avoid pinch zoom on iOS
    document.addEventListener('touchmove', function(event) {
        if (event.scale !== 1) {
            event.preventDefault();
        }
    }, false);
})(jQuery);


jQuery('.home-slider').slick({
  autoplay:true,
  autoplaySpeed:3000,
  arrows:false,
  dots: true,
  slidesToShow:1,
  slidesToScroll:1,
  speed: 1000,
  });

// ===== Scroll to Top ==== 
jQuery('#return-to-top').click(function() {      // When arrow is clicked
    jQuery('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});

jQuery(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 700) {
        jQuery(".top-scroll").addClass("show-button-bottom-to-top");
    } else {
        jQuery(".top-scroll").removeClass("show-button-bottom-to-top");
    }
});

/////////////////////////////////////////////////////////////////////////
jQuery('.card-header').click(function() {
    jQuery('.card-header').removeClass('active');
    jQuery(this).closest('.card-header').addClass('active');

	
});

//////////////////////////////////////////////////////////////////
$.fn.filestyle = function (options) {
  var settings = $.extend(
    {
      fieldText: 'No File Selected',
      buttonText: 'Select File',
      wrapClass:   'file',
      wrapContent: '<div class="file"></div>',
      fakeContent: '<div class="fake"><button></button><input type="text" disabled="disabled" class="filename" /></div>'
    },
    options
  );

  // init 
  $(this).wrap(settings.wrapContent)
  .after(settings.fakeContent)
  .on('change.file', function () {
    var val = $(this).val().split('\\');
    $(this).next().find('.filename').val(val.slice(-1)[0]);
  });

  $(this).next().find('.filename').val(settings.fieldText);
  $(this).next().find('button').text(settings.buttonText);

  return this;
};

$('[type="file"]').filestyle({
  fieldText: 'No file selected', // german translation
  buttonText: 'Browse'
});


//////////////////////////////////////////////////////////
jQuery('.caps').on('keypress', function(event) {

		var $this = jQuery(this),

		thisVal = $this.val(),

		FLC = thisVal.slice(0, 1).toUpperCase();

		con = thisVal.slice(1, thisVal.length);

		jQuery(this).val(FLC + con);

	});

//////////////////////// ////////////////////////////////////////
    // Wow 
    var wow = new WOW({
      boxClass: 'wow', // animated element css class (default is wow)
      animateClass: 'animated', // animation css class (default is animated)
      offset: 0, // distance to the element when triggering the animation (default is 0)
      mobile: true, // trigger animations on mobile devices (default is true)
      live: true, // act on asynchronously loaded content (default is true)
      callback: function (box) {
          // the callback is fired every time an animation is started
          // the argument that is passed in is the DOM node being animated
      },
      scrollContainer: null // optional scroll container selector, otherwise use window
  });
  wow.init(); 

//////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function() {
	//var PhoneNumber = '';
    jQuery('.currency').click(function() {
        jQuery(this).addClass('active_currencies');
    });
});
////////////////////////////////////////////////////////////////////////////
if ($('.inner_for_scroll').length) {
    (function($){
        jQuery(window).on("load",function(){
            jQuery(".inner_for_scroll").mCustomScrollbar();
        });
    })(jQuery);
}
if ($('.chatboxout').length) {
    (function($){
        jQuery(window).on("load",function(){
            jQuery(".chatboxout").mCustomScrollbar();
        });
    })(jQuery);
}
if ($('.individuats_people_listing').length) {
    (function($){
        jQuery(window).on("load",function(){
            jQuery(".individuats_people_listing").mCustomScrollbar();
        });
    })(jQuery);
}
if ($('.add_in_group_pleople_listing').length) {
    (function($){
        jQuery(window).on("load",function(){
            jQuery(".add_in_group_pleople_listing").mCustomScrollbar();
        });
    })(jQuery);
}
if ($('.modal-body').length) {
    (function($){
        jQuery(window).on("load",function(){
            jQuery(".modal-body").mCustomScrollbar();
        });
    })(jQuery);
}
///////////////////////////////////////////////////////////////////////

jQuery(document).ready(function(){
    jQuery(".save-post").click(function(){
        jQuery(this).toggleClass("changeimg");		
    });
    jQuery(".pinned").click(function(){
        jQuery(this).toggleClass("pinneded");		
    });
    jQuery(".watchlist").click(function(){
        jQuery(this).toggleClass("watchlist_select");		
    });
	jQuery("td a i").click(function(){
        jQuery(this).toggleClass("watchlist_select");		
    });
   jQuery("#otp_password").click(function(){
        jQuery(".modal-backdrop").addClass("show_zindex");		
    });

   /* Jquery More Validation */  
  jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z\s]+$/i.test(value);
  }, "Only alphabetical characters");

	
});

/* Google Place Api */   
    var placeSearch, autocomplete;
    function initAutocomplete() 
      {      
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']}); 
        autocomplete.addListener('place_changed', fillInAddress);        
      }

    function fillInAddress() 
    {        
        var place = autocomplete.getPlace();
        var City , Country;
        //console.log( place );       
        $( place.address_components ).each(function( item , value )
          {            
			console.log(value);
          /* City */
            if( value.types[0] == 'administrative_area_level_2' )
            {
              City = value.long_name;			  
              $('input[name="City"]').val( value.long_name );
            }
			else if(value.types[0] == 'administrative_area_level_1')
			{
				City = value.long_name;			  
				$('input[name="City"]').val( value.long_name );
			}

          /* Country */
          if( value.types[0] == 'country' )
            {
               Country = value.long_name;
               $('input[name="Country"]').val( value.long_name );
            }
         
          });
        $( '#autocomplete' ).val( City + ' , ' +Country );
      }