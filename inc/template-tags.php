<?php
/**
 * Custom Twenty Sixteen template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

if ( ! function_exists( 'twentysixteen_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own twentysixteen_entry_meta() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_meta() {
	if ( 'post' === get_post_type() ) {
		$author_avatar_size = apply_filters( 'twentysixteen_author_avatar_size', 49 );
		printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			_x( 'Author', 'Used before post author name.', 'twentysixteen' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		twentysixteen_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'twentysixteen' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'post' === get_post_type() ) {
		twentysixteen_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'twentysixteen' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'twentysixteen_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own twentysixteen_entry_date() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'twentysixteen' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

if ( ! function_exists( 'twentysixteen_entry_taxonomies' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own twentysixteen_entry_taxonomies() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_taxonomies() {
	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentysixteen' ) );
	if ( $categories_list && twentysixteen_categorized_blog() ) {
		printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Categories', 'Used before category names.', 'twentysixteen' ),
			$categories_list
		);
	}

	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'twentysixteen' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Tags', 'Used before tag names.', 'twentysixteen' ),
			$tags_list
		);
	}
}
endif;

if ( ! function_exists( 'twentysixteen_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * Create your own twentysixteen_post_thumbnail() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_post_thumbnail($size=null) {
	
	global $_wp_additional_image_sizes;
	
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	
	if(empty($size)){
		$size = (isset($_wp_additional_image_sizes['page-cover']) && is_page()) ? 'page-cover' : 'post-thumbnail';
	}	

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail($size); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( $size, array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'twentysixteen_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own twentysixteen_excerpt() function to override in a child theme.
	 *
	 * @since Twenty Sixteen 1.0
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function twentysixteen_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) : ?>
			<div class="<?php echo $class; ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo $class; ?> -->
		<?php endif;
	}
endif;

if ( ! function_exists( 'twentysixteen_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * Create your own twentysixteen_excerpt_more() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentysixteen_excerpt_more() {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentysixteen_excerpt_more' );
endif;

if ( ! function_exists( 'twentysixteen_categorized_blog' ) ) :
/**
 * Determines whether blog/site has more than one category.
 *
 * Create your own twentysixteen_categorized_blog() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function twentysixteen_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'twentysixteen_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'twentysixteen_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so twentysixteen_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so twentysixteen_categorized_blog should return false.
		return false;
	}
}
endif;

/**
 * Flushes out the transients used in twentysixteen_categorized_blog().
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'twentysixteen_categories' );
}
add_action( 'edit_category', 'twentysixteen_category_transient_flusher' );
add_action( 'save_post',     'twentysixteen_category_transient_flusher' );

if ( ! function_exists( 'twentysixteen_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Twenty Sixteen 1.2
 */
function twentysixteen_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

//Fallback ACF
if(!function_exists('the_field')){
	
	function get_field($field_name, $post_id=null){
		return get_post_meta($field_name, $post_id?:get_the_ID(), true);
	}
	
	function the_field($field_name, $post_id=null){
		echo get_field($field_name, $post_id);
	}
	
}

function hide_email($email)
{ 
	$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
	
  $key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
  
  for ($i=0;$i<strlen($email);$i+=1) $cipher_text .= $key[strpos($character_set,$email[$i])];
  
  $script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
  $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
  $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
  $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
  $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
  
  return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
}

add_shortcode('hide_email', function($atts, $content){
	return hide_email($content);
});

if (!function_exists('strip_first_gallery')){
	// toglie la prima galleria nel contenuto (da utilizzare con un filtro)
	function strip_first_gallery( $content ) {
	    $matches = array();
	    
	    if ( preg_match( '/' . get_shortcode_regex(array('gallery')) . '/s', $content, $matches ) ) {
	        $pos = strpos( $content, $matches[0] );
	        
	        if(false !== $pos) {
	            return substr_replace( $content, '', $pos, strlen( $matches[0] ) );
	        }
	    }
	
	    return $content;
	}
}

if (!function_exists('post_begins_with_gallery')){
	function post_begins_with_gallery($content=null){
		if(is_null($content)){
			$content = get_the_content();
		}
		
	    return preg_match('/^(' . get_shortcode_regex(array('gallery')) . ')/s',  trim(strip_tags($content)) );
	}
}


function get_post_type_description($post_type=null) {
	
	if(empty($post_type)){
    	$post_type = get_query_var( 'post_type' );
	}
	
    if ( is_array( $post_type ) )
        $post_type = reset( $post_type );
 
    $post_type_obj = get_post_type_object( $post_type );	
	
	return $post_type_obj?$post_type_obj->description:'';
}

function the_language_switcher() {
	if (function_exists('mlp_show_linked_elements')) {
		mlp_show_linked_elements(array( 'link_text'=> 'language_short', 'display_flag'=> FALSE, 'show_current_blog' => true ));
	}
}

function directions_map_shortcode($atts, $content){ 
		$atts = shortcode_atts( array( 'lat' => '43.7773577', 'lng' => '11.252326900000071', 'zoom'=>'14' ), $atts, 'directions_map' ); 
		
		ob_start();
		?>
	<div id="directions">
		<form id="ask-directions" class="gmap-directions-form" data-target-map="#reach-us .google-map">
			
			<label for="directionsOrigin"><?php _e('Directions','gazelle'); ?></label>
			<input type="text" id="directionsOrigin" class="gmaps-directions-origin gmaps-autocomplete"  name="origin"/>
			<button type="submit" class="submit"><span class="screen-reader-text"><?php _e('Get route','gazelle'); ?></span></button>
			
			<div class="travel-modes gmaps-travel-modes">
				<input type="radio" id="travelModeWalking" name="travelMode" value="WALKING" checked="checked"  />
				<label for="travelModeWalking" class="icon-directions_walk"><span  class="screen-reader-text" ><?php _e('Walking','gazelle'); ?></span></label>
				<input type="radio" id="travelModeDriving" name="travelMode" value="DRIVING" />
				<label for="travelModeDriving" class="icon-directions_car"><span  class="screen-reader-text" ><?php _e('Driving','gazelle'); ?></span></label>				
				<input type="radio" id="travelModeTransit" name="travelMode" value="TRANSIT" />
				<label for="travelModeTransit" class="icon-directions_transit"><span  class="screen-reader-text" ><?php _e('Transit','gazelle'); ?></span></label>					
			</div>
		</form>
		<div class="quick-directions">
			<button id="centralstation" data-target-form="#ask-directions" class="preload-directions" value="Santa Maria Novella, Firenze"><?php _e('Station','gazelle'); ?></button
			><button id="citycenter" data-target-form="#ask-directions" class="preload-directions" value="Duomo, Firenze"><?php _e('Duomo','gazelle'); ?></button>
		</div>
	</div>
	<div class="map-container" id="reach-us" data-map-lng="<?php echo esc_attr($atts['lng']); ?>" data-map-lat="<?php echo esc_attr($atts['lat']); ?>">
		<div class="map-locker locked">
			<div class="google-map"></div>
			<div class="map-lock">
				<span class="unlock-label"><?php _e('Unlock map','gazelle'); ?></span>
				<span class="lock-label"><?php _e('Lock map','gazelle'); ?></span>
			</div>
		</div>
		<div class="map-directions">
			<h4 class="action-button"><?php _e('Show Route','gazelle'); ?></h4>
		</div>
	</div>	
<?php return ob_get_clean();
}

add_shortcode('directions_map', 'directions_map_shortcode');

function css_crossfade($selector, $count, $showtime=4, $transition=2 ){
	
	static $instance = 0; $instance++;
	
	$duration = ($showtime+$transition)*$count; ?>
	<style type="text/css">
		@keyframes crossfade<?php echo $instance ?> {
			0%, <?php echo ceil($showtime/$duration*100); ?>%, 100%  { opacity:1; }
			<?php echo ceil(1/$count*100); ?>%, <?php echo 100-ceil(($transition/$duration)*100); ?>% { opacity:0; }
		}
		
		<?php echo $selector; ?> {
			animation: crossfade<?php echo $instance ?> <?php echo ($showtime*$count); ?>s ease-in-out infinite;
		}
		
		<?php for($i=1; $i<=$count; $i++): ?>
		<?php echo $selector; ?>:nth-of-type(<?php echo $i ?>) { animation-delay: <?php echo $showtime*($count-$i) ?>s; }
		<?php endfor; ?>
	</style>	
	<?php
}