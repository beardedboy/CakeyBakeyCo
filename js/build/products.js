var Products = (function($) {

  var settings = {
        dropdowns: $('.single_product_info_desc_container-dropdown')
      },
      publicSettings = {}

  //****** PUBLIC METHODS *********************************************** //

  publicSettings.init = function(){

    for(var i = 0; i < settings.dropdowns.length; i++){
      settings.dropdowns[i].addEventListener("click", containerChange, true);
    }

    $('.attachment-shop_thumbnail').on('click', function(){
        var photo_fullsize =  $(this).attr('src').replace('-90x90','');
        $('.woocommerce-main-image').attr('src', photo_fullsize);
        return false;
    });


    /* Copy of a function from woocommerce/assets/js/frontend/woocommerce.js
       altered to find element through a custom css class.
    */
    $( document ).on( 'click', '.plus, .minus', function() {
      // Get values
      var $qty    = $( this ).closest( '.product_quantity' ).find( '.qty' ),
        currentVal  = parseFloat( $qty.val() ),
        max     = parseFloat( $qty.attr( 'max' ) ),
        min     = parseFloat( $qty.attr( 'min' ) ),
        step    = $qty.attr( 'step' );

      // Format values
      if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
      if ( max === '' || max === 'NaN' ) max = '';
      if ( min === '' || min === 'NaN' ) min = 0;
      if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

      // Change the value
      if ( $( this ).is( '.plus' ) ) {

        if ( max && ( max == currentVal || currentVal > max ) ) {
          $qty.val( max );
        } else {
          $qty.val( currentVal + parseFloat( step ) );
        }

      } else {

        if ( min && ( min == currentVal || currentVal < min ) ) {
          $qty.val( min );
        } else if ( currentVal > 0 ) {
          $qty.val( currentVal - parseFloat( step ) );
        }

      }

      // Trigger change event
      $qty.trigger( 'change' );
    });

  };

  //****** PRIVATE METHODS ********************************************** //

  /* Function to reveal/hidden a content box on single product page whilst
     also changing alternating the +/- icons next to the titles */

  function containerChange(){
    var title = this.querySelector('.single_product_info_desc_title');
    var content = this.querySelector('.single_product_info_desc_content');
  
    Helper.toggleClass(content, 'visuallyhidden');
    if(Modernizr.data) {
      if(title.dataset.iconafter == 'g') {
        title.dataset.iconafter = 'B';
      }
      else {
        title.dataset.iconafter = 'g';
      }
    }
    else {
      var attr = title.getAttribute('data-iconafter');
      if(attr == 'g') {
        title.setAttribute('data-iconafter', 'B');
      } 
      else{
        title.setAttribute('data-iconafter', 'g');
      }
    }
  };


  return publicSettings;


})(jQuery);

Products.init();