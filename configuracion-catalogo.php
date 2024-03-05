<?php
// Agrega un menú de administración
add_action('admin_menu', 'agregar_pagina_configuracion');

function agregar_pagina_configuracion() {
    add_menu_page(
        'Configuración de Catálogo Magentis',
        'Catálogo Magentis',
        'manage_options',
        'configuracion-catalogo',
        'pagina_configuracion',
        'dashicons-admin-tools',
        100
    );
}

function pagina_configuracion() {
    // Contenido de la página de configuración
    include_once(plugin_dir_path(__FILE__) . 'pagina-configuracion.php');
}


