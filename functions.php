<?php
/**
 * preschoolexpansion functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package preschoolexpansion
 */

if ( ! function_exists( 'preschoolexpansion_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function preschoolexpansion_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on preschoolexpansion, use a find and replace
	 * to change 'preschoolexpansion' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'preschoolexpansion', get_template_directory() . '/languages' );

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
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'preschoolexpansion' ),
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
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'preschoolexpansion_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // preschoolexpansion_setup
add_action( 'after_setup_theme', 'preschoolexpansion_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function preschoolexpansion_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'preschoolexpansion_content_width', 640 );
}
add_action( 'after_setup_theme', 'preschoolexpansion_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function preschoolexpansion_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'preschoolexpansion' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'preschoolexpansion_widgets_init' );
/**
 * Output the image path of the object
 * 
 * @param type $relative_path  
 * @return type
 */
function preschoolexpansion_theme_image($relative_path) { 
  return get_template_directory_uri() . '/' . $relative_path;
}
/**
 * Output the template part related to the field.
 * 
 * @param type $filename
 * @param type $section_id
 * @return null
 * 
 */
function preschoolexpansion_render_section_template($filename, $section_id) { 
  get_template_part("template-parts/${filename}", "${section_id}");
}

/**
 * Enqueue scripts and styles.
 */
function preschoolexpansion_scripts() {
	wp_enqueue_style( 'preschoolexpansion-style', get_stylesheet_uri() );

	wp_enqueue_script( 'preschoolexpansion-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'preschoolexpansion-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'preschoolexpansion_scripts' );


/**
 * Register the Splash Page Admin Page, just below the Pages section, with the pages icon
 */
function register_splash_menu_page() { 
  add_menu_page('Splash Pages', 'Splash Page', 'edit_pages', 'preschoolexpansion_splashpage_editor', 'splash_menu_page', 'dashicons-admin-page', 21);
}
add_action('admin_menu', 'register_splash_menu_page');


// TODO: Clean this code up so HTML is NOT displayed within the calls. Yuck!
// TODO: Render the data in the splash page
/**
 * The Splash Page Menu Callback function
 * See the settings api for the data is stored. https://codex.wordpress.org/Settings_API
 * And the settings code generator at http://wpsettingsapi.jeroensormani.com/
 */
function splash_menu_page() {
  ?>
  <form action='options.php' method='post'>
  <h2>Splash Menu</h2>
  <?php
  settings_fields('preschoolExpansionSplashEditor');
  do_settings_sections('preschoolExpansionSplashEditor');
  submit_button();
  ?>
  </form>
  <?php
}



function preschoolexpansion_api_init() { 
  
    // Register our setting so that $_POST handling is done for us and
  // our callback function just has to echo the input
  register_setting('preschoolExpansionSplashEditor', 'preschoolexpansion_settings');
  
  // Add section to the preschoolexpansion_splashpage_editor
  add_settings_section(
		'preschoolexpansion_splash_page_editor_section',
		__( 'Splash Page Editor', 'preschoolexpansion_textdomain' ),
		'preschoolexpansion_splash_page_editor_section',
		'preschoolExpansionSplashEditor'
	);
  
  // Add the field with the names and function to use for our settings
  // and put in in our section
	add_settings_field(
		'preschoolexpansion_text_field_0',
		__( 'Section 1 Title', 'preschoolexpansion_textdomain' ),
		'preschoolexpansion_text_field_0_render',
		'preschoolExpansionSplashEditor',
		'preschoolexpansion_splash_page_editor_section'
	);

	add_settings_field(
		'preschoolexpansion_textarea_field_1',
		__( 'Section 1 Content', 'preschoolexpansion_textdomain' ),
		'preschoolexpansion_textarea_field_1_render',
		'preschoolExpansionSplashEditor',
		'preschoolexpansion_splash_page_editor_section'
	);

	add_settings_field(
		'preschoolexpansion_text_field_2',
		__( 'Section 2 Title', 'preschoolexpansion_textdomain' ),
		'preschoolexpansion_text_field_2_render',
		'preschoolExpansionSplashEditor',
		'preschoolexpansion_splash_page_editor_section'
	);

	add_settings_field(
		'preschoolexpansion_textarea_field_3',
		__( 'Section 2 Content', 'preschoolexpansion_textdomain' ),
		'preschoolexpansion_textarea_field_3_render',
		'preschoolExpansionSplashEditor',
		'preschoolexpansion_splash_page_editor_section'
	);

	add_settings_field(
		'preschoolexpansion_text_field_4',
		__( 'Section 3 Title', 'preschoolexpansion_textdomain' ),
		'preschoolexpansion_text_field_4_render',
		'preschoolExpansionSplashEditor',
		'preschoolexpansion_splash_page_editor_section'
	);

	add_settings_field(
		'preschoolexpansion_textarea_field_5',
		__( 'Section 3 Content', 'preschoolexpansion_textdomain' ),
		'preschoolexpansion_textarea_field_5_render',
		'preschoolExpansionSplashEditor',
		'preschoolexpansion_splash_page_editor_section'
	);
  
  

  
 
} // preschoolexpansion_api_init

add_action('admin_init', 'preschoolexpansion_api_init');

// ------------------------------------------------------------------
// Settings section callback function
// ------------------------------------------------------------------
//
// This function is needed if we added a new section. This function 
// will be run at the start of our section
function preschoolexpansion_splash_page_editor_section() {
  echo __("The PEG Grant Splash Page Content", "preschoolexpansion_textdomain");
}

 // ------------------------------------------------------------------
 // Callback functions for our editor field settings
 // ------------------------------------------------------------------
 //
function preschoolexpansion_text_field_0_render(  ) {

	$options = get_option( 'preschoolexpansion_settings' );
	echo('<input type="text" name="preschoolexpansion_settings[preschoolexpansion_text_field_0]" value="');
        echo $options['preschoolexpansion_text_field_0']; 
        echo('">');

}


function preschoolexpansion_textarea_field_1_render(  ) {

	$options = get_option( 'preschoolexpansion_settings' );
	echo('<textarea cols="40" rows="5" name="preschoolexpansion_settings[preschoolexpansion_textarea_field_1]">');
        echo $options['preschoolexpansion_textarea_field_1']; 
 	echo('</textarea>');

}


function preschoolexpansion_text_field_2_render(  ) {

	$options = get_option( 'preschoolexpansion_settings' );
	
	echo('<input type="text" name="preschoolexpansion_settings[preschoolexpansion_text_field_2]" value="');
        echo $options['preschoolexpansion_text_field_2'];
        echo('">');

}


function preschoolexpansion_textarea_field_3_render(  ) {

	$options = get_option( 'preschoolexpansion_settings' );
	
	echo('<textarea cols="40" rows="5" name="preschoolexpansion_settings[preschoolexpansion_textarea_field_3]">');
        echo $options['preschoolexpansion_textarea_field_3'];
 	echo('</textarea>');
	
}


function preschoolexpansion_text_field_4_render(  ) {

	$options = get_option( 'preschoolexpansion_settings' );
        // echo the content
        echo('<input type="text" name="preschoolexpansion_settings[preschoolexpansion_text_field_4]" value="'); 
        echo $options['preschoolexpansion_text_field_4']; 
        echo('">');

}


function preschoolexpansion_textarea_field_5_render(  ) {

	$options = get_option( 'preschoolexpansion_settings' );
        echo('<textarea cols="40" rows="5" name="preschoolexpansion_settings[preschoolexpansion_textarea_field_5]">');
        echo $options['preschoolexpansion_textarea_field_5'];
        echo('</textarea>');

}

/**
 * Load custom classes
 */
require get_template_directory() . '/classes/custom_fields.class.php';
require get_template_directory() . '/classes/splash_page.class.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

