/* global jQuery */ 
/* global google */ 
/* global markerIcon */ 

var mapStyle = /* inizio stile */ [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":60}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"lightness":30}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ef8c25"},{"lightness":40}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#b6c54c"},{"lightness":40},{"saturation":-40}]},{}] /* fine stile */; 

function initMaps() {
    
    (function($){ 
        $('.map-container').trigger('maps-ready');
    })(jQuery);
    
}    

(function($){

    $('.map-container').on('maps-ready', function(){
        
        var $mapContainer = $(this);
        var $map = $mapContainer.find('.google-map');
        
        if(!$map.length){
            $map = $('<div class="google-map"/>');
            $mapContainer.prepend($map);            
        }
        
        var mapCenter = new google.maps.LatLng($mapContainer.data('mapLat'), $mapContainer.data('mapLng')); 
        
        var map = new google.maps.Map($map[0], {
            styles: mapStyle,
            center: mapCenter,
            zoom: $mapContainer.data('mapZoom') || 14
        });    
        
        var marker = new google.maps.Marker({
            position: mapCenter,
            icon: (typeof markerIcon !== 'undefined') ? markerIcon : '/wp-content/themes/gazelle/img/marker_4.png',
            map: map,
            title: $mapContainer.data('mapTitle') || ''
        });             
        
        var directionsTarget = $mapContainer.find('.map-directions');         
        
        if(directionsTarget.length){
            
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var directionsService = new google.maps.DirectionsService;               
            
            directionsDisplay.setMap(map);
            directionsDisplay.setPanel(directionsTarget[0]);
            
            $map.on('show-directions', function(event, request) {
                
                var params = { //defaults
                    destination: mapCenter, 
                    travelMode: google.maps.TravelMode.DRIVING 
                };
                
                $.extend(params, request);
                
                directionsService.route(params, function(response, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                      directionsDisplay.setDirections(response);
                      $mapContainer.addClass('has-directions');
                    } else {
                      window.alert('Destination not found: ' + status);
                    }
                });                   

            }); 
        }
        
        if(typeof google.maps.places != 'undefined'){
            $('.gmaps-autocomplete').each(function(){
                    var atc = new google.maps.places.Autocomplete(this, {types: ['geocode']});
                    // atc.addListener('place_changed', function(){
                    //     $('.gmap-directions-form').trigger('submit');
                    // });
            });        
        }
 
    });

    $('.gmap-directions-form').on('submit change', function(e){
        var form  = $(this);
        
        var targetMap  = $(form.data('targetMap') || '.google-map');
        
        var data = {};
        $(form.serializeArray()).each( function(index, obj){
            data[obj.name] = obj.value;
        });
        
        if(data.origin){
            targetMap.trigger('show-directions', [data]);
        }
        
        e.preventDefault();
    });
    
    $('.preload-directions').on('click', function(e){
        var self = $(this);
        var form  = $(self.data('targetForm') || '.gmap-directions-form');        
        
        $('.gmaps-directions-origin', form).val(self.val());
        
        form.trigger('submit');
        
        e.preventDefault();
    });    

    $('.map-locker .map-lock').click(function(){
        $(this).parents('.map-locker').toggleClass('locked').toggleClass('unlocked');
    });    
    
})(jQuery);