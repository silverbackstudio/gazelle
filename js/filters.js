(function($){
    
    $(' .blog .taxonomy-ajax-filter li.cat-item-all').addClass('current-cat');
    
    $('ul[data-filter="ajax"] > li').on('click', function(e){
        
        var $term = $(this);
        var destination = $('a', $term).attr('href');
        var $filter = $term.parents('ul[data-filter="ajax"]');
        var target = $filter.data('filterTarget');
        
        if(History.pushState({action:'ajax-filter', container: target }, null, destination)){
            e.preventDefault();
        }
    
    });
    
    History.Adapter.bind(window,'statechange', function () { 
        
    		var State = History.getState();
    	    var target = State.data.container;
            
            if(State.data.action == 'ajax-filter'){
                var $filter = $('ul[data-filter="ajax"]');
                var $trigger = $('a[href="'+State.url+'"]', $filter).parents('li');
                
                $('li', $filter).removeClass('current-cat');
                $trigger.addClass('current-cat');
            }	
    
            $(target)
                .addClass('loading')
                .load(State.url + ' ' + target + ' > .hentry', 
                    function(response){
                        $(target).removeClass('loading').trigger('contentupdated', [[],response] );
                        
                        var title = response.match(/<title[^>]*>(.*)<\/title[^>]*>/gmi).shift().replace(/<\/?title[^>]*>/gi, '') || document.getElementsByTagName("title")[0].innerHTML;
                        if(title){
                            $('title').text(title);
                        }
                        
                        if(typeof initializeGmap !== 'undefined' ){
                            initializeGmap();
                        }
                    }
                );
    });  

})(jQuery);