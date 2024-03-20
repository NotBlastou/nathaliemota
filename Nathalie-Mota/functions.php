<?php

function my_theme_enqueue_scripts() {

    wp_enqueue_script('jquery');

    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);

}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');


function nathalie_mota_theme_enqueue() {

    $css_version = wp_get_theme()->get('Version') . '.' . filemtime(get_template_directory() . '/assets/css/main.css');
    wp_enqueue_style( 'nathalie-mota-style', get_template_directory_uri() . '/assets/css/main.css', array(), $css_version );   
    
    
    

    wp_enqueue_script( 'nathalie-mota-scripts', get_theme_file_uri( '/assets/js/scripts.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/scripts.js'), true );    
    

    if (!is_front_page()) {
        wp_enqueue_script( 'nathalie-mota-scripts-lightbox-ajax', get_theme_file_uri( '/assets/js/lightbox-ajax.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-ajax.js'), true );
    };  
    

    if (is_front_page()) {
        wp_enqueue_script( 'nathalie-mota-scripts-filtres', get_theme_file_uri( '/assets/js/filtres.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/filtres.js'), true );   
        wp_enqueue_script( 'nathalie-mota-scripts-publication-ajax', get_theme_file_uri( '/assets/js/publication-ajax.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/publication-ajax.js'), true );
        wp_enqueue_script( 'nathalie-mota-scripts-lightbox-ajax', get_theme_file_uri( '/assets/js/lightbox-front-page-ajax.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-front-page-ajax.js'), true );
    };   

    wp_enqueue_style ( 'dashicons' ); 
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_theme_enqueue' );

function menu_nav() {
    $menu2 = wp_nav_menu(array('theme_location' => 'main'));
    $menu3 = wp_nav_menu(array('menu' => 'header'));
}

add_theme_support( 'post-thumbnails' );

set_post_thumbnail_size( 600, 0, false );
add_image_size( 'hero', 1450, 960, true );
add_image_size( 'desktop-home', 600, 520, true );
add_image_size( 'lightbox', 1300, 900, true );
add_theme_support( 'title-tag' );


function register_my_menu(){
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
 }
 add_action('after_setup_theme', 'register_my_menu');

function nathalie_mota_widgets(){
    register_sidebar(
        array(
            'name' => "Widget Sidebar",
            'id' => 'main-sidebar',
            'description' => "Widget pour la sidebar principale",
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
        )
    );
   
    register_sidebar(
        array(
            'name' => "Widget footer",
            'id' => 'footer-widget',
            'description' => "Widget pour le pied de page",
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
        )
    );
 }
 add_action('widgets_init', 'nathalie_mota_widgets'); 


function contact_btn($string) {
	$string .= '<a href="#" id="contact_btn" class="contact">Contact</a>';
	return $string;
}
add_shortcode('contact', 'contact_btn');

function my_acf_load_value( $variable,  $field ) {
    $return = "";
    foreach($field as $key => $value) {
        if ($key === $variable) {
            $return = $value;
        }
    }
    return $return;
}


function add_custom_types_to_tax( $query ) {
    echo(is_category());
    echo(is_tag());
    if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
        $post_types = array('post','page','my_cpt_1','my_cpt_2','photo');
        $query->set( 'post_type', $post_types );
        return $query;
    }
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );
include get_template_directory() . '/includes/ajax.php';


