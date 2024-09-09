<?php
// Cargar la hoja de estilo del tema padre y la del tema hijo
function my_theme_enqueue_styles() {
    $parent_style = 'storefront-style'; // Identificador del estilo del tema padre

    // Cargar el estilo del tema padre
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');

    // Cargar el estilo del tema hijo
    wp_enqueue_style('storefront-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

