
(function($) {
 "use strict";
 
 $('.pre-colors-list li a').on("click",function() {
            $.stylesheets.add($(this).attr('href'));
            return false;
        });
		
	
	 $('.bg-pattrens-list li a').on("click",function() {
            $.stylesheets.add($(this).attr('href'));
            return false;
        });
		

		
$(function(){
	
	$('.btn-close').on("click",function(){

		if($('.btn-close').hasClass("show")){
		
			$('#style-selector').animate({left: "-=320"},function(){
				
				$('.btn-close').toggleClass("show");
				
				
				
			});						
		}else{
			$('#style-selector').animate({left: "0"},function(){
				$('.btn-close').toggleClass("show");
				
				
				
			});			
		} 
	});
	
	

});



$(function(){
	
	$('.demo-close').on("click",function(){

		if($('.demo-close').hasClass("show")){
		
			$('#demo-selector').animate({right: "-=365"},function(){
				
				$('.demo-close').toggleClass("show");
				
				
				
				
			});						
		}else{
			$('#demo-selector').animate({right: "0"},function(){
				$('.demo-close').toggleClass("show");
				
				
			});			
		} 
	});
	
	

});



})(jQuery);



//Master Sliders

// Slide 1

(function($) {
"use strict";
	var slider = new MasterSlider();
 //adds Arrows navigation control to the slider.
	slider.control('arrows');
slider.control('bullets');
	
	slider.setup('masterslider2' , {
		 width:1600,    // slider standard width
		 height:750,   // slider standard height
		 space:0,
		 speed:45,
		 layout:'fillwidth',
		 loop:true,
		 preload:0,
		 autoplay:true,
		 view:"parallaxMask"
	});
})(jQuery);


//=============================

(function($) {
 "use strict";
	var slider = new MasterSlider();
	// adds Arrows navigation control to the slider.
	slider.control('arrows');
	slider.control('bullets');
	
	slider.setup('masterslider' , {
		 width:1600,    // slider standard width
		 height:600,   // slider standard height
		 space:0,
		 speed:45,
		 layout:'fillwidth',
		 loop:true,
		 preload:0,
		 autoplay:true,
		 view:"parallaxMask"
	});
})(jQuery);


//=====================================


(function($) {
 "use strict";
	var slider = new MasterSlider();
	// adds Arrows navigation control to the slider.
	slider.control('arrows');
	slider.control('bullets');
	
	slider.setup('masterslider3' , {
		 width:1170,    // slider standard width
		 height:550,   // slider standard height
		 space:0,
		 speed:45,
		 layout:'false',
		 loop:true,
		 preload:0,
		 autoplay:true,
		 view:"parallaxMask"
	});
})(jQuery);




// index Gallery


	
// index Testmonials

$(document).ready(function() {
    $('#myCarousel').carousel({
	    interval: 10000
	})
});

