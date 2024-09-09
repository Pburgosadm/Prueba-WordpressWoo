<?php
/**
 * Plugin Name: Orders Completed Last Month
 * Description: Muestra todos los pedidos completados en el último mes en una página de administración personalizada.
 * Version: 1.0
 * Author: PbWebDev
 */

// Asegurarse de que el plugin no se ejecute directamente
if (!defined('ABSPATH')) {
    exit;
}

// Crear el menú en el admin de WordPress
function oclm_add_admin_menu() {
    add_menu_page(
        'Pedidos del último mes', // Título de la página
        'Pedidos del mes', // Nombre del menú
        'manage_options', // Capacidad
        'oclm-orders-last-month', // Slug del menú
        'oclm_orders_last_month_page', // Función para mostrar el contenido
        'dashicons-clipboard', // Icono del menú
        20 // Posición del menú
    );
}
add_action('admin_menu', 'oclm_add_admin_menu');

// Consulta para obtener los pedidos completados en el último mes
function oclm_get_completed_orders_last_month() {
    global $wpdb;

    // Fecha de hace un mes
    $last_month = date('Y-m-d H:i:s', strtotime('-1 month'));

    // Modificamos la consulta para reflejar el post_type y post_status actuales
    $query = "
        SELECT posts.ID, posts.post_date, pm_billing_first_name.meta_value AS first_name, 
               pm_billing_last_name.meta_value AS last_name, pm_total.meta_value AS total
        FROM {$wpdb->prefix}posts AS posts
        LEFT JOIN {$wpdb->prefix}postmeta AS pm_billing_first_name ON posts.ID = pm_billing_first_name.post_id AND pm_billing_first_name.meta_key = '_billing_first_name'
        LEFT JOIN {$wpdb->prefix}postmeta AS pm_billing_last_name ON posts.ID = pm_billing_last_name.post_id AND pm_billing_last_name.meta_key = '_billing_last_name'
        LEFT JOIN {$wpdb->prefix}postmeta AS pm_total ON posts.ID = pm_total.post_id AND pm_total.meta_key = '_order_total'
        WHERE posts.post_type = 'shop_order_placehold'  -- Cambiado para reflejar tu post_type
        AND posts.post_status = 'draft'  -- Cambiado para reflejar el estado actual
        AND posts.post_date >= CAST(%s AS DATETIME)
        ORDER BY posts.post_date DESC
    ";

    $results = $wpdb->get_results($wpdb->prepare($query, $last_month));

    return $results;
}

// Función que genera la página de administración personalizada
function oclm_orders_last_month_page() {
    $orders = oclm_get_completed_orders_last_month();

    echo '<h1>Pedidos en estado borrador del Último Mes</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID del Pedido</th>';
    echo '<th>Nombre del Cliente</th>';
    echo '<th>Fecha del Pedido</th>';
    echo '<th>Total del Pedido</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    if (!empty($orders)) {
        foreach ($orders as $order) {
            // Formatear el total como precio sin HTML
            $formatted_total = wc_price($order->total);
            
            echo '<tr>';
            echo '<td>' . esc_html($order->ID) . '</td>';
            echo '<td>' . esc_html($order->first_name . ' ' . $order->last_name) . '</td>';
            echo '<td>' . esc_html($order->post_date) . '</td>';
            echo '<td>' . wp_kses_post($formatted_total) . '</td>'; // Escapamos correctamente el HTML generado por wc_price
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="4">No hay pedidos en estado borrador en el último mes.</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
