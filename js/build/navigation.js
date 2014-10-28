var Navigation = ( function($) {

  var settings = {
    nav_open: document.querySelector('.nav_main_btn-menu'),
    nav_close: document.querySelector('.nav_main_btn-close'),
    nav_list: document.querySelector('.nav_main_container'),
    mainbody: document.body,
    footer: document.querySelector('.main_footer'),
    dropdown_links: $('.nav_main_list_item-dropdown'),
    openClass: 'slide-left'
  }

  //****** PUBLIC METHODS ********************************************** //

  function publicInit(){

    //console.log(dropdown_links);

    //for(var i = 0; i < settings.dropdown_links.length; i++){
    // settings.dropdown_links[i].addEventListener("click", function(event){
        //event.preventDefault();
    //    var sublist = $(this).find( ".nav_main_list_item_sublist" );
     //   sublist.toggleClass("sublist-closed");
     // })
    //};

    settings.nav_open.addEventListener("click", function(event){
      event.preventDefault();
      window.requestAnimFrame(onAnimFrame);
      document.body.addEventListener('scroll',function(e){
        e.preventDefault();
      });
      document.body.style.overflowY = "hidden";
    });

    settings.nav_close.addEventListener("click", function(event){
      event.preventDefault();
      window.requestAnimFrame(onAnimFrame);
      document.body.removeEventListener('scroll',function(e){
        return true;
      });
      document.body.style.overflowY = "auto";
    });

    settings.nav_open.addEventListener("touchstart", function(event){
      event.preventDefault();
      window.requestAnimFrame(onAnimFrame);
      document.body.addEventListener('touchmove',function(e){
        e.preventDefault();
      });
      document.body.style.overflowY = "hidden";
    });

    settings.nav_close.addEventListener("touchstart", function(event){
      event.preventDefault();
      window.requestAnimFrame(onAnimFrame);
      document.body.removeEventListener('touchmove',function(e){
        return true;
      });
      document.body.style.overflowY = "auto";
    });
  }


  //****** PRIVATE METHODS ********************************************** //


  function onAnimFrame(){
    Helper.toggleClass(settings.mainbody, settings.openClass);
  }

  function enableTouch(){
    Helper.addClass(settings.nav_list, "touch");
  }

  function runTouch(){

    var pointerDownName = 'MSPointerDown';
    var pointerUpName = 'MSPointerUp';
    var pointerMoveName = 'MSPointerMove';

    if(window.PointerEvent) {
      pointerDownName = 'pointerdown';
      pointerUpName = 'pointerup';
      pointerMoveName = 'pointermove';
    }
    
    // Simple way to check if some form of pointerevents is enabled or not
    window.PointerEventsSupport = false;
    if(window.PointerEvent || window.navigator.msPointerEnabled) {
      window.PointerEventsSupport = true;
    }

    if (window.PointerEventsSupport) {
      // Add Pointer Event Listener
      settings.nav_open.addEventListener(pointerDownName, handleGestureStart, true);
    } else {
      // Add Touch Listener
      settings.nav_open.addEventListener('touchstart', handleGestureStart, true);
    
      // Add Mouse Listener
      settings.nav_open.addEventListener('mousedown', handleGestureStart, true);
    }

     /*function getGesturePointFromEvent(evt) {
        var point = {};

        if(evt.targetTouches) {
          // Prefer Touch Events
          point.x = evt.targetTouches[0].clientX;
          point.y = evt.targetTouches[0].clientY;
        } else {
          // Either Mouse event or Pointer Event
          point.x = evt.clientX;
          point.y = evt.clientY;
        }

        return point;
      }*/

    // Handle the start of gestures
    var handleGestureStart = function(evt) {
      evt.preventDefault();

      if(evt.touches && evt.touches.length > 1) {
        return;
      }


      /*Add the move and end listeners
      if (window.PointerEventsSupport) {
        // Pointer events are supported.
        document.addEventListener(pointerMoveName, this.handleGestureMove, true);
        document.addEventListener(pointerUpName, this.handleGestureEnd, true);
      } else {
        // Add Touch Listeners
        document.addEventListener('touchmove', this.handleGestureMove, true);
        document.addEventListener('touchend', this.handleGestureEnd, true);
        document.addEventListener('touchcancel', this.handleGestureEnd, true);
    
        // Add Mouse Listeners
        document.addEventListener('mousemove', this.handleGestureMove, true);
        document.addEventListener('mouseup', this.handleGestureEnd, true);
      }
    
      initialTouchPos = getGesturePointFromEvent(evt);
      console.log(getGesturePointFromEvent(evt));
      settings.nav_list.style.transition = 'initial';
    }.bind(this);

    this.handleGestureMove = function(evt){
      console.log("brap");
    }.bind(this);


    // Handle end gestures
    this.handleGestureEnd = function(evt) {
      evt.preventDefault();

      if(evt.touches && evt.touches.length > 0) {
        return;
      }

      isAnimating = false;
    
      // Remove Event Listeners
      if (window.PointerEventsSupport) {
        // Remove Pointer Event Listeners
        document.removeEventListener(pointerMoveName, this.handleGestureMove, true);
        document.removeEventListener(pointerUpName, this.handleGestureEnd, true);
      } else {
        // Remove Touch Listeners
        document.removeEventListener('touchmove', this.handleGestureMove, true);
        document.removeEventListener('touchend', this.handleGestureEnd, true);
        document.removeEventListener('touchcancel', this.handleGestureEnd, true);
    
        // Remove Mouse Listeners
        document.removeEventListener('mousemove', this.handleGestureMove, true);
        document.removeEventListener('mouseup', this.handleGestureEnd, true);
      }
    
      updateSwipeRestPosition();*/
    };
  }

  return {
    init: publicInit,
    enableTouch: enableTouch,
    runTouch: runTouch
  };

})(jQuery);



Navigation.init();


//if(Modernizr.touch){
  //Navigation.enableTouch();
  //Navigation.runTouch();
//}