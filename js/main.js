/* 
global Instafeed 
global jQuery
global Google
global Waypoints
global objectFitElements
*/

(function($){
    
    //--------- fallback per CSS objectFit ------------
    if ('objectFit' in document.documentElement.style === false) {
          var elements = '.image-fit-cover, '
                         + '.band-image, '
                         + '.gallery-size-tiled-gallery .gallery-item .gallery-icon, '
                         + 'body.page #main > article .post-thumbnail, '
                         + '.post-list, '
                         + '.carousel-cell';
          
          if(typeof objectFitElements != 'undefined'){
            elements = elements + ' ,' + objectFitElements;
          }
          
          $(elements).each(function () {
            var $container = $(this),
                imgUrl = $container.find('img').prop('currentSrc') || $container.find('img').prop('src');
            if (imgUrl) {
              $container.css('backgroundImage', 'url(' + imgUrl + ')');
              $container.addClass('compat-object-fit');
            }  
          });
    }
    
    if((typeof Instafeed != 'undefined') && $('#instafeed').length && (typeof instafeedOptions != 'undefined')){
      var instafeed = new Instafeed(instafeedOptions);
      instafeed.run();    
    }

    
    $( '#menu-toggle' ).on('click.gazelle', function(){
      $('body').toggleClass('menu-toggled-on');
    });
    
    $('.search-toggle').on('click.gazelle',function(){
      $('body').toggleClass('search-toggled-on');
    });
    
    $('.waypoints-sticky').each(function(){
      new Waypoint.Sticky({ 
        element: this
      })      
    });
    
    $('.band, .gallery-item').addClass('dimmable dimmed').waypoint({
      handler: function(direction) {
        if(direction == 'down'){
          $(this.element).removeClass('dimmed');
        }
      },
      offset: '70%'
    }); 
    
    $('body.home').waypoint({
      handler: function(direction) {
          $('.site-branding').toggleClass('visible', (direction == 'down'));
      },
      offset: '-25%'
    });     
    
    if(document.createElement("input").placeholder != undefined){
      $("#page form :input").each(function(index, elem) {
          if($(elem).attr('type') == 'radio') return 1;
          var eId = $(elem).attr("id");
          var label = null;
          if (eId && (label = $(elem).parents("form").find("label[for="+eId+"]")).length == 1) {
              if(label.hasClass('noph')) { return 1; }
              $(elem).attr("placeholder", $(label).text().replace('(', ' ('));
              $(label).addClass('screen-reader-text');
          }
       });   
    }
    
    
    $('.gallery-item').each(function(){
    
      var $img = $(this).find('img'); 
      var ratio = parseInt($img.attr('width')) / (parseInt($img.attr('height'))*0.7);
      
      $(this).addClass('picture-ratio-'+Math.round(ratio));
       
    });
    
    $('.map-directions h4').click(function(){
      $(this).parents('.map-directions').toggleClass('open');
    });
    
    $('.collapsible').collapse({
      open: function() {  this.slideDown(200); },
      close: function() { this.slideUp(200); },
    });
    
    $('.accordion').collapse({
      open: function() {  this.slideDown(200); },
      close: function() { this.slideUp(200); console.log('close accordion'); },
      accordion: true
    });    
    
  
  $(function() {
      /* global imgPrtc */
      if((typeof imgPrtc == 'undefined') || (!imgPrtc)) return;
     
      var pImg, overlay = $('<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" />');

      overlay
        .css({position: 'absolute', display: 'none' })
        .on('mouseleave mouseout touchend', function() { overlay.hide().appendTo('body'); })
        .on('click dblclick', function(e){ pImg.trigger(e.type); });   
      
      $(document.body).on('mouseenter.imgprtc touchstart.imgprtc', 'img', function(e) {
          
          if( this === overlay[0])  return true;
          
          pImg = $(this);
          
          var pos = {zIndex: 1};
          
          pImg.parents().each(function(){
          	var $elem = $(this); 
          	if ( $elem.css( "position" ) !== "static" ) {
            	pos.zIndex = parseInt( $elem.css( "zIndex" ), 10 ) || 0;
            	if((Math.pow(2,31)-pos.zIndex) <= 1){ $elem.css( "zIndex", --pos.zIndex); }
            }
          });          
          
          $.extend( pos, pImg.position(), {width: pImg.outerWidth(), height: pImg.outerHeight()});
          
          overlay.insertAfter(pImg).css(pos).show();
      });
  });        
    
})(jQuery);


