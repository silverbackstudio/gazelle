/* 
global Instafeed 
global jQuery
global Google
global Waypoints
*/

(function($){
    
    //--------- fallback per CSS objectFit ------------
    if ('objectFit' in document.documentElement.style === false) {
          $('.image-fit-cover, .band-image, .gallery-size-tiled-gallery .gallery-item .gallery-icon, body.page #main > article .post-thumbnail').each(function () {
            var $container = $(this),
                imgUrl = /*$container.find('img').prop('currentSrc') ||*/ $container.find('img').prop('src');
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

    
    $( '#menu-toggle' ).on('click', function(){
      $('body').toggleClass('menu-toggled-on');
    });
    
    $('.search-toggle').click(function(){
      $('body').toggleClass('search-toggled-on');
    });
    
    $('.waypoints-sticky').each(function(){
      new Waypoint.Sticky({
        element: this,
        handler: function(direction) {
          $('.site-branding').toggleClass('stuck', direction == 'down');
        }
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
        return;
        var pixelSource = '/wp-content/uploads/t.gif';
        var preload = new Image();
        preload.src = pixelSource;
        var icnt = $('<div id="ggphtprtc"></div>');
        icnt.appendTo('body');
        $('img').live('mouseenter touchstart', function(e) {
            var img = $(this);
            if (img.hasClass('ggphtprtc')) return;
            var pos = img.offset();
            var overlay = $('<img class="ggphtprtc" src="' + pixelSource + '" width="' + img.width() + '" height="' + img.height() + '" />')
                            .css({position: 'absolute', zIndex: 99, left: pos.left, top: pos.top})
                            .appendTo(icnt)
                            .bind('mouseleave', function() {
                                setTimeout(function(){ overlay.remove(); }, 0, $(this));
                            });
            if ('ontouchstart' in window) $(document).one('touchend', function(){ setTimeout(function(){ overlay.remove(); }, 0, overlay); });
        });
    });    
})(jQuery);


