
<?php if( function_exists('have_rows') && have_rows('content_band') ): ?>

	<?php	while ( have_rows('content_band') ) : the_row(); ?>
				
		<?php if( get_row_layout() == 'image_abstract_button' ): ?>
		
			<section class="band image-abstract-button" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
    			
    			<?php if(get_sub_field('image')): ?>
    			<div class="band-image main-band-content"><?php
    			 echo wp_get_attachment_image(get_sub_field('image'), 'band'); 
    			?></div><?php
    			 endif;    			
    			?><div class="secondary-band-content">
	    			<?php if(get_sub_field('title') || get_sub_field('subtitle')): ?>
	    			<header class="section-header band-header">
	    			    <?php if(get_sub_field('title')): ?>
	    				<h2 class="section-title"><?php the_sub_field('title'); ?></h2>
	    				<?php endif; ?>
	    				<?php if(get_sub_field('subtitle')): ?>
	    				<p class="section-subtitle subtitle"><?php the_sub_field('subtitle'); ?></p>
	    				<?php endif; ?>
	    			</header>
	    			<?php endif; ?>
	
	    			<div class="section-content band-content"><?php the_sub_field('content'); ?></div>
	    			
	    			<?php if(get_sub_field('button_link') && get_sub_field('button_label')): ?>
	    			<div class="band-action ">
		    			<a class="action-button band-button" href="<?php the_sub_field('button_link'); ?>"><?php the_sub_field('button_label'); ?></a>
	    			</div>
	    			<?php endif; ?>
	    			
    			</div>
			</section>
			
		<?php elseif( get_row_layout() == 'map_abstract' ): ?>
		
			<section class="band map-abstract" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
    			<?php if($latlng = get_sub_field('mappa')): ?>
    			<div class="band-map main-band-content map-container map-locker locked" data-map-lng="<?php echo esc_attr($latlng['lng']); ?>" data-map-lat="<?php echo esc_attr($latlng['lat']); ?>">
	  			    <div id="map" class="google-map" ></div>
	    			<div class="map-lock">
	                    <span class="unlock-label"><?php _e('Unlock map', 'gazelle'); ?></span>
	                    <span class="lock-label"><?php _e('Lock map', 'gazelle'); ?></span>
	                </div>
                </div>
                <?php endif; 			    
 			    ?><div class="secondary-band-content">
	 			    <?php if(get_sub_field('title') || get_sub_field('subtitle')): ?>
	    			<header class="section-header band-header">
	    			    <?php if(get_sub_field('title')): ?>
	    				<h2 class="section-title"><?php the_sub_field('title'); ?></h2>
	    				<?php endif; ?>
	    				<?php if(get_sub_field('subtitle')): ?>
	    				<p class="section-subtitle subtitle"><?php the_sub_field('subtitle'); ?></p>
	    				<?php endif; ?>
	    			</header>
	    			<?php endif; ?>
	                
	    			<div class="section-content band-content"><?php the_sub_field('content'); ?></div>
    			</div>
			</section>		
			
		<?php elseif( get_row_layout() == 'galleria_e_testo' ): ?>
		
			<section class="band gallery-and-text" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
    			<?php if($gallery = get_sub_field('gallery', false, false)): ?>
    			<div class="band-gallery main-band-content js-flickity" data-flickity-options='{ "cellAlign": "left", "pageDots": false, "imagesLoaded": true, "autoPlay": true }'>
    				<?php foreach( $gallery as $image_id ): ?> 
		                <div class="carousel-cell">
		                    <?php echo wp_get_attachment_image($image_id, 'band'); ?> 
		                </div>
		            <?php endforeach; ?>
                </div>
                <?php endif; 			    
 			    ?><div class="secondary-band-content">
	 			    <?php if(get_sub_field('title') || get_sub_field('subtitle')): ?>
	    			<header class="section-header band-header">
	    			    <?php if(get_sub_field('title')): ?>
	    				<h2 class="section-title"><?php the_sub_field('title'); ?></h2>
	    				<?php endif; ?>
	    				<?php if(get_sub_field('subtitle')): ?>
	    				<p class="section-subtitle subtitle"><?php the_sub_field('subtitle'); ?></p>
	    				<?php endif; ?>
	    			</header>
	    			<?php endif; ?>
	                
	    			<div class="section-content band-content"><?php the_sub_field('content'); ?></div>
	    			
	    			<?php if(get_sub_field('button_link') && get_sub_field('button_label')): ?>
	    			<div class="band-action ">
		    			<a class="action-button band-button" href="<?php the_sub_field('button_link'); ?>"><?php the_sub_field('button_label'); ?></a>
	    			</div>
	    			<?php endif; ?>	    			
    			</div>
			</section>	
			
		<?php elseif( get_row_layout() == 'title_text' ): ?>
		
			<section class="band title-text" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
 			    <?php if(get_sub_field('title')): ?>
    			<header class="section-header band-header">
    				<h2 class="section-title"><?php the_sub_field('title'); ?></h2>
    			</header>
    			<?php endif; ?>
    			<div class="section-content band-content"><?php the_sub_field('content'); ?></div>
			</section>			
		
		<?php elseif( get_row_layout() == 'editor_html' ): ?>
		
			<section class="band editor-html">
    			<div class="section-content band-content"><?php the_sub_field('content'); ?></div>
			</section>
			
		<?php elseif( get_row_layout() == 'image_only' ): ?>
		
			<section class="band image-only" id="image-band-<?php echo get_sub_field('image'); ?>">
    			<div class="band-image">
    			<?php echo wp_get_attachment_image(get_sub_field('image'), 'large'); ?>
    			</div>
			</section>			
		
   		<?php endif; ?>

    <?php 	endwhile; ?>

<?php endif; ?>