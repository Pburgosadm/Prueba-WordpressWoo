<?php
/*
Plugin Name: Custom WooCommerce Features
Description: Muestra un mensaje personalizado en la página de checkout basado en el valor del carrito.
Version: 1.3
Author: PbWebDevSEO
*/

// Variable global para evitar la duplicación del mensaje
global $cwcf_message_displayed;
$cwcf_message_displayed = false;

// Hook para mostrar el mensaje personalizado después del total en la página de checkout
add_action('woocommerce_review_order_after_order_total', 'cwcf_display_custom_message_on_checkout');

// Función para mostrar el mensaje personalizado
function cwcf_get_custom_message() {
    // Asegúrate de que WooCommerce esté activo
    if ( ! class_exists( 'WooCommerce' ) ) {
        return '';
    }

    // Asegúrate de que el carrito no esté vacío
    if ( WC()->cart->is_empty() ) {
        return '';
    }

    // Obtener el total del carrito en formato numérico
    $cart_total = WC()->cart->get_total('edit'); // Total sin HTML
    
    // Convertir el valor del total del carrito a float para comparar
    $cart_total_numeric = floatval(preg_replace('/[^\d.]/', '', $cart_total));

    // Mensaje dinámico basado en el valor del carrito
    if ($cart_total_numeric >= 100) {
        return '<p style="background-color: #56cd63; color: #000000; font-weight: 600; padding: 10px; border-radius: 4px; margin: 0; box-shadow: none;">Gracias por tu compra. ¡Obtendrás un <strong style="font-weight: 600;">DESCUENTO del 10%</strong> en tu próxima compra al completar este pedido!</p>';
    } else {
        return '<p style="background-color: #56cd63; color: #000000; font-weight: 600; padding: 10px; border-radius: 4px; margin: 0; box-shadow: none;">Estás cerca de obtener un DESCUENTO del 10% en tu próxima compra. ¡Gasta más de $100 hoy para aplicar!</p>';
    }
}

// Mostrar el mensaje en la página de checkout
function cwcf_display_custom_message_on_checkout() {
    // Detectar si es una actualización de AJAX
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return; // No mostrar el mensaje durante una actualización de AJAX
    }

    global $cwcf_message_displayed;

    // Mostrar el mensaje solo una vez
    if ( ! $cwcf_message_displayed ) {
        echo cwcf_get_custom_message();
        $cwcf_message_displayed = true;
    }
}

// Crear el shortcode para el mensaje personalizado
function cwcf_custom_message_shortcode() {
    return cwcf_get_custom_message();
}
add_shortcode('custom_checkout_message', 'cwcf_custom_message_shortcode');

// Activar el plugin
register_activation_hook(__FILE__, 'cwcf_activate_plugin');
function cwcf_activate_plugin() {
    if ( ! class_exists('WooCommerce') ) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('Este plugin requiere WooCommerce para funcionar. Por favor, instala y activa WooCommerce.');
    }
}
