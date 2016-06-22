<?php
/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

namespace Silverback\WP\Themes\Gazelle;

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

//Automagically append Namespaces
function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1 ){
	\add_action($tag, __NAMESPACE__.'\\'.$function_to_add, $priority, $accepted_args);
}

function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1 ){
	\add_filter($tag, __NAMESPACE__.'\\'.$function_to_add, $priority, $accepted_args);
}

function wp_enqueue_cdn_script($package, $files, $deps = array(), $version='latest', $in_footer=true ){
	
	if(is_array($files)){
		$template = '//cdn.jsdelivr.net/g/%1$s@%3$s(%2$s)';
		$files = implode('+', $files);
	} else {
		$template = '//cdn.jsdelivr.net/%1$s/%3$s/%2$s';		
	}

	wp_enqueue_script($package, sprintf($template, $package, $files, $version), $deps, null, $in_footer);
}

function &get_config(){
    
    static $config = null;
    
    $file = locate_template('config.ini', false);
    
    if(empty($config) && file_exists($file)){
        $config = parse_ini_file($file, true);
    }
    
    return $config;
}

function add_options(){
	
	$config = &get_config();
	
	if(isset($config['sendgrid'])) {
		foreach($config['sendgrid'] as $name=>$value){
		    add_option('sendgrid_'.$name, $value);
		}
	}
}

add_action("after_switch_theme", 'add_options');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own twentysixteen_setup() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Sixteen, use a find and replace
	 * to change 'twentysixteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentysixteen', get_template_directory() . '/languages' );
	load_theme_textdomain( 'gazelle', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 *  @since Twenty Sixteen 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 400, 300, true );
	
	add_image_size( 'square-thumbs', 150, 150, true );
	add_image_size( 'band', 880, 520, true );	
	add_image_size( 'page-cover', 1320, 9999, true ); 
	add_image_size( 'tiled-gallery', 9999, 1040 );
	add_image_size( 'full-width', 1920, 9999 ); 
	add_image_size( 'retina', 2880, 9999 );
	

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'gazelle' ),
		'social'  => __( 'Social Links Menu', 'gazelle' ),
		'footer' => __( 'Footer Menu', 'gazelle' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	/*
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );
	*/

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css') );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}

add_action( 'after_setup_theme', 'setup' );


function gallery_image_sizes($sizes) {
	
	$sizes['tiled-gallery'] = __( "Tiled Gallery", 'gazelle');
	
	return $sizes;
}

add_filter('image_size_names_choose', 'gallery_image_sizes');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function content_width() {
	$GLOBALS['content_width'] = apply_filters( 'twentysixteen_content_width', 1320 );
}
add_action( 'after_setup_theme', 'content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentysixteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	/*
	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'twentysixteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'twentysixteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	*/
}
add_action( 'widgets_init', 'widgets_init' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function scripts() {
	// Add custom fonts, used in the main stylesheet.
	/*
	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );
	*/
	
	// Theme stylesheet.
	wp_enqueue_style( 'gazelle-style', get_template_directory_uri().'/style.css' );

	/*
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie', 'conditional', 'lt IE 10' );
	*/
	
	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'gazelle-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'gazelle-ie8', 'conditional', 'lt IE 9' );
	
	/*
	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'twentysixteen-html5', 'conditional', 'lt IE 9' );
	*/
	
    $config = &get_config();
    
	$loaded_deps = array();
	
    wp_enqueue_style('google-font', 'https://fonts.googleapis.com/css?family=Lato:400,300,700,400italic');
    wp_enqueue_style('icons-pack',  get_template_directory_uri().'/icons/style.css');
    wp_enqueue_style('flickity', '//cdn.jsdelivr.net/flickity/1.2/flickity.min.css');

    if(isset($config['fonts_com'])){
    	wp_enqueue_style('theme-fonts', '//fast.fonts.net/cssapi/'.$config['fonts_com']['api_key'].'.css');
    }

    wp_enqueue_cdn_script('waypoints', array('jquery.waypoints.min.js', 'shortcuts/sticky.min.js'), array('jquery'));
    wp_enqueue_cdn_script('jquery.collapse', 'jquery.collapse.js', array('jquery'), '1.1');
    wp_enqueue_cdn_script('flickity', 'flickity.pkgd.min.js', array(), '1.2');

	if(isset($config['instagram']) && apply_filters('show_instagram_footer', is_front_page())) {
		wp_enqueue_script('instafeed', '//cdn.jsdelivr.net/instafeed.js/1.4/instafeed.min.js', null, null, true);
		wp_localize_script( 'instafeed', 'instafeedOptions', $config['instagram']);		
		
		$loaded_deps[] = 'instafeed';
	}

    if(isset($config['iubenda']) && (false===WP_DEBUG)) {
	    wp_enqueue_script('iubenda', '//cdn.iubenda.com/iubenda.js', null, null, true);
	    wp_enqueue_script('iubenda-cookie', '//cdn.iubenda.com/cookie_solution/safemode/iubenda_cs.js'); 
	    
		wp_add_inline_script('iubenda-cookie', 
			"var _iub = _iub || [];
			_iub.csConfiguration = {
			  siteId: '".$config['iubenda']['siteId']."',
			  cookiePolicyId: '".$config['iubenda']['cookiePolicyId']."',
			  lang: '".substr(get_bloginfo('language'),0,2)."',
			  callback: {
			    onConsentGiven: function(){
			      dataLayer.push({'event': 'iubenda_consent_given'});
			    }
			  }
			};",
			'before'
		);	    
    }
    
    
    if(is_home()){
    	wp_enqueue_cdn_script('masonry', 'masonry.pkgd.min.js', array(), '4.1');
    	wp_enqueue_cdn_script('history.js', 'history.js', array('jquery'), '1.8' );
    	wp_enqueue_script('jquery.history.js', 'https://cdn.jsdelivr.net/history.js/1.8.0b2/history.adapter.jquery.js', array('jquery'), null );
    	
    	wp_enqueue_script('mason', get_template_directory_uri(). '/js/mason.js', array('masonry'), null, true );
    	wp_enqueue_script('filters', get_template_directory_uri(). '/js/filters.js', array('jquery','history.js'), null, true );
	}
   
    if(isset($config['googlemaps']['api_key'])) {
    	wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$config['googlemaps']['api_key'].'&libraries=places&callback=initMaps', array('maps-controller'), null, true);
    	wp_enqueue_script('maps-controller', get_template_directory_uri(). '/js/maps.js', array(), null, true );
    }

	wp_enqueue_script( 'gazelle-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'gazelle-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160412' );
	}
	
	wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160412', true );
    wp_enqueue_script('gazelle', get_template_directory_uri(). '/js/main.js', $loaded_deps + array('waypoints'), null, true );

	wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'gazelle' ),
		'collapse' => __( 'collapse child menu', 'gazelle' ),
	) );
}

add_action( 'wp_enqueue_scripts', 'scripts' );

function add_async_attribute($tag, $handle) {
    
    if ( 'google-maps' === $handle ){
    	return str_replace( ' src', ' async defer src', $tag );
    } elseif('iubenda-cookie' === $handle){
    	return str_replace( ' src', ' async src', $tag );
    }
        
    return $tag;
}

add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

function mce_before_init_insert_formats( $init_array ) {  
    
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Collapse',  
			'block' => 'div',  
			'classes' => 'collapsible',
			'wrapper' => true,
		),
		array(  
			'title' => 'Accordion',  
			'block' => 'div',  
			'classes' => 'accordion',
			'wrapper' => true,
		),		
		array(  
			'title' => '2 Colonne',  
			'block' => 'div',  
			'classes' => 'columns-2',
			'wrapper' => true,
		),				
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'mce_before_init_insert_formats' );  

// Callback function to insert 'styleselect' into the $buttons array
function mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'mce_buttons_2' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if(is_front_page() && has_header_image()) {
		$classes[] = 'has-top-image';
	}
	
	if(is_page() && has_post_thumbnail()) {
		$classes[] = 'has-top-image';
	}	

	return $classes;
}
add_filter( 'body_class', 'body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}


function rm_comments_att( $open, $post_id ) {
    $post = get_post( $post_id );
    if( $post->post_type == 'attachment' ) {
        return false;
    }
    return $open;
}
add_filter( 'comments_open', 'rm_comments_att', 10 , 2 );


function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    
    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;
   
    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

function sitemap_post_types($post_types){
	
	$post_types[] = 'professionista';
	
	return $post_types;
}

add_filter('jetpack_sitemap_post_types', 'sitemap_post_types');

function max_srcset_image_width($size){
	return 2900;
}
add_filter( 'max_srcset_image_width', 'max_srcset_image_width');


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/admin.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];
	$height = $size[1];

	if( '1040' == $height ) { //tiled-gallery signature size
	
		$ratio = round($width / ($height * 0.7));
		
		1 == $ratio && $sizes = '(max-width: 420px) 100vw, (max-width: 1320px) 34vw, 440px';
		2 == $ratio && $sizes = '(max-width: 420px) 100vw, (max-width: 1320px) 67vw, 880px';
		3 == $ratio && $sizes = '(max-width: 1320px) 100vw, 1320px';
		
		return $sizes;
	}

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	/*
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	*/
	
	if ( 'post-thumbnail' === $size ) {
		is_page() && $attr['sizes'] = '(max-width: 1320px) 100vw, 1320px';
	} else if( 'band' === $size) {
		$attr['sizes'] = '(max-width: 910px) 100vw, (max-width: 1320px) 70vw,  900px';
	}  else if( 'badge' === $size) {
		$attr['sizes'] = '(max-width: 910px) 10vw, (max-width: 1320px) 33vw,  440px';
	}
	
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'widget_tag_cloud_args' );

function extend_bloginfo($output, $show){
	
	$config = &get_config();
	
	if(substr( $show, 0, 8 ) == 'contact_') {
		
		$show = substr($show, 8);
		
		$output = isset($config['contact'][$show]) ? $config['contact'][$show] : '';
		
	}
	
	return $output;
}

add_filter( 'bloginfo', 'extend_bloginfo', 9, 2 );


function analytics(){ 
	$config = &get_config(); 
	
	if(!isset($config['google-tag-manager'])){
		return;
	}
	
	?>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WMZXNZ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','<?php echo $config['google-tag-manager']['id']; ?>');</script>
	<!-- End Google Tag Manager -->
<?php }

add_action('wp_head', 'analytics');

function ajax_archives_templates( $template ) {

    $new_template = '';

	if ( is_category()  ) {
		$new_template = locate_template( array( 'home.php', 'index.php' ) );
	} 
	
	if ( '' != $new_template ) {
		return $new_template ;
	}	

	return $template;
}
add_filter( 'template_include',  'ajax_archives_templates', 99 );

function excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'excerpt_length', 999 );