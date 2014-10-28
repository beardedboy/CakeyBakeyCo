var Touch = ( function() {

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

  //---------------------------------------------------------------------------

  //  PUBLIC METHODS

  //---------------------------------------------------------------------------

  function Start(evt){
    evt.preventDefault();

    if(evt.touches && evt.touches.length > 1) {
      return;
    }

    startingPos = getGesturePointFromEvent(evt);
    //console.log("start: " + startingPoint.x);

    // Add the move and end listeners
    if (window.PointerEventsSupport) {
      // Pointer events are supported.
      document.addEventListener(pointerMoveName, move, true);
      document.addEventListener(pointerUpName, end, true);
    } else {
      // Add Touch Listeners
      document.addEventListener('touchmove', move, true);
      document.addEventListener('touchend', end, true);
      //document.addEventListener('touchcancel', cancel, true);

      // Add Mouse Listeners
      document.addEventListener('mousemove', move, true);
      document.addEventListener('mouseup', end, true);
    }

  }; // END START METHOD


  return {
  };

}());
