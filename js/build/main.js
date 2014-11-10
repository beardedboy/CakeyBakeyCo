var global = (function(){
    Modernizr.addTest('data', function () {
      var elem = document.createElement('div');
      return !!elem.dataset;
  });
})();


var Helper = (function(){

  // Shim for requestAnimationFrame from Paul Irishpaul ir
  // http://www.paulirish.com/2011/requestanimationframe-for-smart-animating/
  window.requestAnimFrame = (function(){
    return  window.requestAnimationFrame  ||
            window.webkitRequestAnimationFrame    ||
            window.mozRequestAnimationFrame       ||
            function( callback ){
              window.setTimeout(callback, 1000 / 60);
            };
  })();

  //Function to toggle a class on an element
  function toggleClass(element, cls){
    if( document.documentElement.classList ){
      element.classList.toggle(cls);
    }
    else{
      var rx = new RegExp(cls,'');
      if(rx.test(element.className)){
        element.className = element.className.replace(rx,'');
      }
      else{
        element.className += " "+cls;
      }
    }
  }
  //Function to add a class to an element
  function addClass(element,cls){
    if( document.documentElement.classList ){
      if( !element.classList.contains(cls) ){
        element.classList.add(cls);
      }
    }
    else{
      var rx = new RegExp(cls,'');
      if( !rx.test(element.className) ){
        element.className += " "+cls;
      }
    }
  }

  //Function to remove a class from an element
  function removeClass(element,cls){
    if( document.documentElement.classList ){
      if( element.classList.contains(cls) ){
        element.classList.remove(cls);
      }
    }
    else{
      var rx = new RegExp(cls,'');
      if(rx.test(element.className)){
        element.className -= cls;
      }
    }
  }

  //Function checks if browser supports SVG and if it doesn't replaces all svg images on the page with png extension
  function modSVG(){
    if (!Modernizr.svg) {
        var imgs = document.getElementsByTagName('img');
        var endsWithDotSvg = /.*\.svg$/
        var i = 0;
        var l = imgs.length;
        for(; i != l; ++i) {
            if(imgs[i].src.match(endsWithDotSvg)) {
                imgs[i].src = imgs[i].src.slice(0, -3) + 'png';
            }
        }
    }
  }

  return {
    toggleClass: toggleClass,
    addClass: addClass,
    removeClass: removeClass,
    modSVG: modSVG
  };

})();

Helper.modSVG();


var Touch = (function(){
  
  var list = document.querySelectorAll('.nav_main_list, .carousel');

  function enableTouch(){
      Helper.addClass(list, "touch");
  }

  return{
    enable: enableTouch
  }

})();

$('.checkout_input_item_content').addClass('hidden');
