<?php
/* links css and javascript files to the wordpress site */
/* enqueue script for theme stylesheets and scripts */   
// Enqueue own styles
function enqueue_custom_styles() {
    //style css
    wp_enqueue_style( 'style', get_stylesheet_directory_uri( ) .'/style.css', array(), null, 'all' );
    //custom shop css
    wp_enqueue_style( 'custom-shop', get_stylesheet_directory_uri( ) .'/eshop/custom.css', array(), null, 'all' );}

function defer_parsing_of_js( $url ) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );

// Register Script
add_action( 'wp_enqueue_scripts', 'enqueue_custom_styles' );
// custom scripts that runs last on the website 
    add_action('wp_enqueue_scripts', 'enqueue_script_js');
    function enqueue_script_js() {
    //script - dark mode, copyright year, scroll
    wp_enqueue_script('script', get_stylesheet_directory_uri(). '/js/script.js');
    //script - form
    wp_enqueue_script('formscript', get_stylesheet_directory_uri(). '/eshop/formscript.js');
    //script - shop
    wp_enqueue_script('shopscript', get_stylesheet_directory_uri(). '/eshop/shopscript.js');}