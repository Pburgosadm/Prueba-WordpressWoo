<?php
/**
 * Plugin Name: Orders Completed Last Month
 * Description: Muestra todos los pedidos completados en el último mes en una página de administración personalizada.
 * Version: 1.1
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
    // Fecha de hace un mes
    $last_month = strtotime('-1 month');
    $start_date = date('Y-m-d H:i:s', $last_month);

    // Creamos una instancia de WC_Order_Query
    $args = array(
        'limit'        => -1, // Sin límite
        'status'       => 'completed', // Estado de las órdenes
        'date_created' => '>' . $start_date, // Órdenes creadas después de la fecha especificada
        'orderby'      => 'date',
        'order'        => 'DESC', // Orden descendente por fecha
    );

    // Obtenemos las órdenes
    $orders = wc_get_orders($args);

    // Preparamos los resultados
    $results = array();

    foreach ($orders as $order) {
        $results[] = array(
            'ID'         => $order->get_id(),
            'post_date'  => $order->get_date_created()->date('Y-m-d H:i:s'),
            'first_name' => $order->get_billing_first_name(),
            'last_name'  => $order->get_billing_last_name(),
            'total'      => $order->get_total(),
        );
    }

    return $results;
}

// Función que genera la página de administración personalizada
function oclm_orders_last_month_page() {
    $orders = oclm_get_completed_orders_last_month();

    echo '<h1>Pedidos Completados en el Último Mes</h1>';
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
            $formatted_total = wc_price($order['total']);
            
            echo '<tr>';
            echo '<td>' . esc_html($order['ID']) . '</td>';
            echo '<td>' . esc_html($order['first_name'] . ' ' . $order['last_name']) . '</td>';
            echo '<td>' . esc_html($order['post_date']) . '</td>';
            echo '<td>' . wp_kses_post($formatted_total) . '</td>'; // Escapamos correctamente el HTML generado por wc_price
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="4">No hay pedidos completados en el último mes.</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
?>
