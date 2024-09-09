<?php
/*
Plugin Name: Update Order Totals
Description: Plugin para actualizar automáticamente los totales de los pedidos en WooCommerce.
Version: 1.1
Author: PbWebDev
*/

// Hook para actualizar automáticamente los totales de los pedidos después del checkout
add_action('woocommerce_checkout_order_processed', 'update_order_total_on_checkout', 10, 1);

function update_order_total_on_checkout($order_id) {
    // Obtener el pedido usando el ID del pedido
    $order = wc_get_order($order_id);

    if ($order) {
        $total = 0;

        // Calcular el total basado en los productos del pedido
        foreach ($order->get_items() as $item) {
            $total += $item->get_total();
        }

        // Actualizar el meta key '_order_total' solo si el total es mayor que 0
        if ($total > 0) {
            update_post_meta($order_id, '_order_total', $total);
        }
    }
}

// (Opcional) Agregar el menú manual para actualizar los pedidos incompletos creados antes
add_action('admin_menu', 'add_order_total_updater_menu');

function add_order_total_updater_menu() {
    add_menu_page(
        'Actualizar Totales de Pedidos', // Título de la página
        'Actualizar Totales',            // Título del menú
        'manage_options',                // Capacidad
        'update-order-totals',           // Slug
        'render_order_total_updater_page'// Función que renderiza el contenido
    );
}

function render_order_total_updater_page() {
    if (isset($_POST['update_order_totals'])) {
        update_order_totals_for_incomplete_orders();
    }

    echo '<h1>Actualizar Totales de Pedidos</h1>';
    echo '<form method="post">';
    echo '<input type="submit" name="update_order_totals" value="Actualizar Totales" class="button button-primary">';
    echo '</form>';
}

// Función opcional para actualizar los totales de pedidos incompletos
function update_order_totals_for_incomplete_orders() {
    global $wpdb;

    // Obtener los pedidos que no tienen el meta_key '_order_total'
    $query = "
        SELECT posts.ID
        FROM {$wpdb->prefix}posts AS posts
        LEFT JOIN {$wpdb->prefix}postmeta AS pm_total ON posts.ID = pm_total.post_id AND pm_total.meta_key = '_order_total'
        WHERE posts.post_type = 'shop_order'
        AND pm_total.meta_value IS NULL
    ";

    $orders = $wpdb->get_results($query);

    // Recorrer cada pedido y actualizar su total
    foreach ($orders as $order_data) {
        $order = wc_get_order($order_data->ID);

        if ($order) {
            $total = 0;

            foreach ($order->get_items() as $item) {
                $total += $item->get_total();
            }

            if ($total > 0) {
                update_post_meta($order_data->ID, '_order_total', $total);
            }
        }
    }

    echo 'Totales de pedidos actualizados exitosamente.';
}
