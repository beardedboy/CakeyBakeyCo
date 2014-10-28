var Carousel = (function ($) {

	var settings = {
			container: $( ".carousel" ),
			slides: $(".carousel_list_item"),
			descriptions: $(".carousel_list_item_desc"),
			links: $(".carousel_list_item_link"),
			activeClass: "carousel_list_item-active",
            width:$(".carousel_list_item").width(),
	    	height:$(".carousel_list_item").height(),
	    	aspectRatio: 2.083333,
	    	medmq: window.matchMedia( "(max-width: 47.5em)" ),
	    	transition: 5000,
	    	currentSlide: 0
		},
		publicSettings = {}

//****** PUBLIC METHODS *********************************************** //
	
	publicSettings.init = function(){

		var anim = setInterval(animation, settings.transition);

		if(!settings.medmq.matches){
			centreText(settings.height);
			centerLinks(settings.width);
			resizeContainer(settings.aspectRatio);
		}
		else{
			resizeContainer(settings.aspectRatio);
			resizeImage(true);
		}

		$(window).resize(function(){
			if(!settings.medmq.matches){
				resizeImage(false);
				resizeContainer(settings.aspectRatio);
				linkWrap(settings.medmq, settings.slides);
				centreText(settings.slides.height());
				centerLinks(settings.slides.width());

				settings.container.hover( 
					function(){
						clearInterval(animation);
					}, 
					function(){
						animation = setInterval(animation, settings.transition);
					}
				);

			}
			else{
				resizeImage(true);
				resizeContainer(settings.aspectRatio);
				linkWrap(settings.medmq, settings.slides);
				addImage();
			}
		});

		//Allows user to click on left arrow to go back a slide

		$(".carousel_controls-left").bind("click", leftSlide);
		$(".carousel_controls-right").bind("click", rightSlide);
		if (Modernizr.touch) {   
    		//console.log('Touch Screen');  
		}
	};


//****** PRIVATE METHODS ********************************************** //

	//Centres a slides description in relation to the slide and then displays it.
	function centreText(height) {
		settings.descriptions.each(function(){
			var newHeight = (height - $( this ).height()) / 2;
			$( this ).css( "top", newHeight ).show();
		});
	};
	//Centres the links associated with each slide that has one and then displays it.
	function centerLinks(width){
		settings.links.each(function(){
				var newWidth = (width - $( this ).outerWidth()) / 2;
				if(!settings.medmq.matches){
					$( this ).css("left", newWidth).show();
				}else{
					$( this ).hide();
				}
		});
	}

	/* 
		Adds css class to next slide and removes from previous in order to display the next slide.
	   	A counter is also incremented each time to keep track of the current slide and when it reaches
	   	the end of slides it resets the counter and makes the first slide active again. 
	   	This animation is used when the full website is being viewed.
	*/
	function animation(){
		var nextSlide = settings.currentSlide + 1;
		if(!settings.medmq.matches){
			//console.log("big");
			if(settings.currentSlide < settings.slides.length - 1){	
				settings.slides.eq(nextSlide).addClass(settings.activeClass);
				settings.slides.eq(settings.currentSlide).removeClass(settings.activeClass);
				settings.currentSlide++;
			}
			else{
				settings.currentSlide = 0;
				settings.slides.eq(settings.currentSlide).addClass(settings.activeClass);
				settings.slides.last().removeClass(settings.activeClass);
			}
			//console.log(settings.currentSlide);
		}
		else{
			//console.log("small");
		}
	};


	//Resizes the carousel container's height in proportion to its width
	function resizeContainer(val){
		var resizedWidth = settings.container.width();
		var resizedHeight = resizedWidth / val;
		settings.container.height(resizedHeight);
	};

	function resizeImage(val){
			if(val){
				var resizedWidth = settings.container.width();
				$(".carousel_list_item img").each(function(){
					$(this).width(resizedWidth);
				});
			}
			else{
				$(".carousel_list_item img").each(function(){
					$(this).css("width", "");
				});
			}
	}

	function addImage(){
		var newImage = settings.slides[0];
		console.log(settings.slides);
		settings.slides.append(newImage);
	}

	function removeImage(){}


	//Slides with a link are wrapped in that link if the viewport is below 47.5em.
	function linkWrap(mq, slides){
		var slideLinks =  slides.find('a');

		if(mq.matches){
			slideLinks.each(function(){
				var link = $(this).attr("href");
				if(!$(this).parent().parent().is("a")){
						$(this).parent().wrap('<a href="'+link+'"></a>');
				}
			});
		}
		else{
			slideLinks.each(function(){
				if($(this).parent().parent().is("a")){
					$(this).parent().unwrap();
				}
			});
		}
	};

	function leftSlide(){
		if(settings.currentSlide !== 0){
			$(".carousel_controls-left").unbind("click");
			settings.slides.eq(settings.currentSlide).removeClass("carousel_list_item-active");
			settings.slides.eq(settings.currentSlide).prev().addClass("carousel_list_item-active");
			settings.currentSlide--;
		}
		else{
			settings.slides.eq(settings.currentSlide).removeClass("carousel_list_item-active");
			settings.currentSlide = settings.slides.length - 1;
			settings.slides.eq(settings.currentSlide).addClass("carousel_list_item-active");
		}
		$(".carousel_controls-left").bind("click", leftSlide);
	}

	function rightSlide(){
		if(settings.currentSlide !== settings.slides.length - 1 ){
			$(".carousel_controls-right").unbind("click");
			settings.slides.eq(settings.currentSlide).removeClass("carousel_list_item-active");
			settings.slides.eq(settings.currentSlide).next().addClass("carousel_list_item-active");
			settings.currentSlide++;
		}
		else{
			settings.slides.eq(settings.currentSlide).removeClass("carousel_list_item-active");
			settings.currentSlide = 0;
			settings.slides.eq(settings.currentSlide).addClass("carousel_list_item-active");
		}
		$(".carousel_controls-right").bind("click", rightSlide);
	}

	return publicSettings;

})(jQuery);




/*var mobile = (function(Carousel){

	Carousel.mobile = function(){
		alert("MOBILE");
	}

	return Carousel;

})(Carousel || {});*/

//myFunction();

//if (window.matchMedia( "(min-width: 47.5em)" ).matches){
	Carousel.init();
//}