<?php
/*
Plugin Name: Catalogo Magentis
Description: Plugin para integración con Salesforce.
Version: 1.0
Author: arkix
*/


include_once(plugin_dir_path(__FILE__) . 'configuracion-catalogo.php');
include_once(plugin_dir_path(__FILE__) . 'salesforce-integration.php');
include_once(plugin_dir_path(__FILE__) . 'cronsalesforce.php');

// Función que se ejecuta cuando el plugin se activa
function catalogo_magentis_activado()
{
    // Verificar si la página ya existe
    $pagina_existente = get_page_by_title('Filtrar Catálogo Magentis ');

    // Si la página no existe, la creamos
    if (!$pagina_existente) {
        // Crea la página
        $pagina = array(
            'post_title'    => 'Filtrar Catálogo Magentis',
            'post_content'  => '[filtro_categorias]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        // Inserta la página y obtén su ID
        $pagina_id = wp_insert_post($pagina);

        // Puedes imprimir un mensaje si lo deseas
        if ($pagina_id) {
            echo 'La página "Filtrar Catálogo Magentis" se ha creado automáticamente.';
        } else {
            echo 'Error al crear la página.';
            return;
        }
    }
}

// Función para cargar la plantilla personalizada
function cargar_plantilla_personalizada($original_template)
{
    // Verificar si estamos en una página específica (ajusta 'mi-pagina' al slug de tu página)
    if (is_page('mi-pagina')) {
        // Ruta de la plantilla personalizada en el plugin
        $plantilla_personalizada = plugin_dir_path(__FILE__) . 'templates/template-filtro-categorias.php';

        // Verificar si la plantilla personalizada existe
        if (file_exists($plantilla_personalizada)) {
            return $plantilla_personalizada;
        }
    }

    // Si no estamos en una página específica, devuelve la plantilla original
    return $original_template;
}

// Hook para cargar la plantilla personalizada
add_filter('template_include', 'cargar_plantilla_personalizada');


// Función para crear u obtener una categoría
function crear_obtener_categoria($taxonomy, $term)
{
    $existing_term = term_exists($term, $taxonomy);

    if ($existing_term) {
        return $existing_term['term_id'];
    } else {
        // Crea la categoría si no existe
        $term_info = wp_insert_term($term, $taxonomy);

        if (!is_wp_error($term_info)) {
            return $term_info['term_id'];
        } else {
            // Manejar el error de inserción de término
            error_log('Error al insertar término: ' . $term_info->get_error_message());
        }
    }

    return 0;
}

function registrar_tipo_productos_platon()
{

    // die();
    $args = array(
        'public' => true,
        'label' => 'Productos Platon',
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'productos-platon'),
    );

    // Verificar si el tipo de entrada ya está registrado
    if (!post_type_exists('productos_platon')) {
        register_post_type('productos_platon', $args);
    } else {
        // Manejar el caso en que el tipo de entrada ya está registrado
        error_log('Tipo de entrada "productos_platon" ya registrado.');
    }

    // Obtener la entrada existente por título
    // $existing_entry = get_page_by_title('Título de la Entrada', OBJECT, 'productos_platon');

    // // Si la entrada existe, agrega las categorías
    // if ($existing_entry) {
    //     // Obtener las nuevas categorías (reemplaza con tu lógica para obtener las categorías dinámicamente)
    //     $nuevas_categorias = array('Categoria1', 'Categoria2', 'Categoria3');

    //     foreach ($nuevas_categorias as $categoria) {
    //         $taxonomy = 'category'; // Reemplaza con tu taxonomía específica
    //         $term_id = crear_obtener_categoria($taxonomy, $categoria);

    //         // Asociar la categoría a la entrada existente
    //         if ($term_id) {
    //             wp_set_post_terms($existing_entry->ID, $term_id, $taxonomy, true);
    //         }
    //     }
    // }
    // var_dump($existing_entry);
    // die();

    // Registrar taxonomías
    registrar_taxonomia_country();
    registrar_taxonomia_segment();
    registrar_taxonomia_category();
    registrar_taxonomia_product_for_sale();
    registrar_taxonomia_product_final();
    registrar_taxonomia_technicalneed();
    registrar_taxonomia_functional_group();
    registrar_taxonomia_functional_subgroup();
    registrar_taxonomia_magentis_brand();
    registrar_taxonomia_distribution();
}

// Función para agregar categorías a una entrada existente
function agregar_categorias_a_entrada_existente($entry_id, $categorias)
{
    // Obtiene las categorías existentes de la entrada
    $entry_categories = wp_get_object_terms($entry_id, 'category', array('fields' => 'ids'));

    // Obtiene los IDs de las nuevas categorías sin duplicados
    $new_category_ids = array();
    foreach ($categorias as $categoria) {
        $categoria_id = crear_obtener_categoria('category', $categoria);

        // Verifica si la categoría ya está asociada a la entrada
        if (!in_array($categoria_id, $entry_categories)) {
            $new_category_ids[] = $categoria_id;
        }
    }

    // Agrega las nuevas categorías a la entrada
    if (!empty($new_category_ids)) {
        $updated_categories = array_merge($entry_categories, $new_category_ids);
        wp_set_post_terms($entry_id, $updated_categories, 'category', false);
    }
}



// Registrar taxonomía "country"
function registrar_taxonomia_country()
{
    $labels = array(
        'name'              => _x('Países', 'taxonomy general name'),
        'singular_name'     => _x('País', 'taxonomy singular name'),
        'search_items'      => __('Buscar Países'),
        'all_items'         => __('Todos los Países'),
        'parent_item'       => __('País Padre'),
        'parent_item_colon' => __('País Padre:'),
        'edit_item'         => __('Editar País'),
        'update_item'       => __('Actualizar País'),
        'add_new_item'      => __('Agregar Nuevo País'),
        'new_item_name'     => __('Nuevo Nombre de País'),
        'menu_name'         => __('Países'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'country'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('country', 'productos_platon', $args);
}


// Registrar taxonomía "segment"
function registrar_taxonomia_segment()
{
    $labels = array(
        'name'              => _x('Segmentos', 'taxonomy general name'),
        'singular_name'     => _x('Segmento', 'taxonomy singular name'),
        'search_items'      => __('Buscar Segmentos'),
        'all_items'         => __('Todos los Segmentos'),
        'parent_item'       => __('Segmento Padre'),
        'parent_item_colon' => __('Segmento Padre:'),
        'edit_item'         => __('Editar Segmento'),
        'update_item'       => __('Actualizar Segmento'),
        'add_new_item'      => __('Agregar Nuevo Segmento'),
        'new_item_name'     => __('Nuevo Nombre de Segmento'),
        'menu_name'         => __('Segmentos'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'segment'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('segment', 'productos_platon', $args);
}

// Registrar taxonomía "category"
function registrar_taxonomia_category()
{
    $labels = array(
        'name'              => _x('Categorías', 'taxonomy general name'),
        'singular_name'     => _x('Categoría', 'taxonomy singular name'),
        'search_items'      => __('Buscar Categorías'),
        'all_items'         => __('Todas las Categorías'),
        'parent_item'       => __('Categoría Padre'),
        'parent_item_colon' => __('Categoría Padre:'),
        'edit_item'         => __('Editar Categoría'),
        'update_item'       => __('Actualizar Categoría'),
        'add_new_item'      => __('Agregar Nueva Categoría'),
        'new_item_name'     => __('Nuevo Nombre de Categoría'),
        'menu_name'         => __('Categorías'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('category', 'productos_platon', $args);
}

// Registrar taxonomía "product_for_sale"
function registrar_taxonomia_product_for_sale()
{
    $labels = array(
        'name'              => _x('Estado del Producto', 'taxonomy general name'),
        'singular_name'     => _x('Estado del Producto', 'taxonomy singular name'),
        'search_items'      => __('Buscar Estados del Producto'),
        'all_items'         => __('Todos los Estados del Producto'),
        'parent_item'       => __('Estado del Producto Padre'),
        'parent_item_colon' => __('Estado del Producto Padre:'),
        'edit_item'         => __('Editar Estado del Producto'),
        'update_item'       => __('Actualizar Estado del Producto'),
        'add_new_item'      => __('Agregar Nuevo Estado del Producto'),
        'new_item_name'     => __('Nuevo Nombre de Estado del Producto'),
        'menu_name'         => __('Estados del Producto'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'product-for-sale'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('product_for_sale', 'productos_platon', $args);
}

// Registrar taxonomía "product_for_sale"
function registrar_taxonomia_product_final()
{
    $labels = array(
        'name'              => _x('Producto Final', 'taxonomy general name'),
        'singular_name'     => _x('Producto Final', 'taxonomy singular name'),
        'search_items'      => __('Buscar Estados del Producto'),
        'all_items'         => __('Todos los Estados del Producto Final'),
        'parent_item'       => __('Producto Final Padre'),
        'parent_item_colon' => __('Producto Final Padre:'),
        'edit_item'         => __('Editar Producto Final'),
        'update_item'       => __('Actualizar Producto Final'),
        'add_new_item'      => __('Agregar Nuevo Producto Final'),
        'new_item_name'     => __('Nuevo Nombre de Producto Final'),
        'menu_name'         => __('Estados del Producto Final'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'product-final'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('product_final', 'productos_platon', $args);
}


// Registrar taxonomía "product_for_sale"
function registrar_taxonomia_technicalneed()
{
    $labels = array(
        'name'              => _x('Necesidad tecnica', 'taxonomy general name'),
        'singular_name'     => _x('Necesidad tecnica', 'taxonomy singular name'),
        'search_items'      => __('Buscar Estados del Producto'),
        'all_items'         => __('Todos los Estados del Necesidad tecnica'),
        'parent_item'       => __('Necesidad tecnica Padre'),
        'parent_item_colon' => __('Necesidad tecnica Padre:'),
        'edit_item'         => __('Editar Necesidad tecnica'),
        'update_item'       => __('Actualizar Necesidad tecnica'),
        'add_new_item'      => __('Agregar Nuevo Necesidad tecnica'),
        'new_item_name'     => __('Nuevo Nombre de Necesidad tecnica'),
        'menu_name'         => __('Estados del Necesidad tecnica'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'technicalneed'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('product_technicalneed', 'productos_platon', $args);
}

// Registrar taxonomía "product_for_sale"
function registrar_taxonomia_functional_group()
{
    $labels = array(
        'name'              => _x('Grupo Funcional', 'taxonomy general name'),
        'singular_name'     => _x('Grupo Funcional', 'taxonomy singular name'),
        'search_items'      => __('Buscar Estados del Producto'),
        'all_items'         => __('Todos los Estados del Grupo Funcional'),
        'parent_item'       => __('Grupo Funcional Padre'),
        'parent_item_colon' => __('Grupo Funcional Padre:'),
        'edit_item'         => __('Editar Grupo Funcional'),
        'update_item'       => __('Actualizar Grupo Funcional'),
        'add_new_item'      => __('Agregar Nuevo Grupo Funcional'),
        'new_item_name'     => __('Nuevo Nombre de Grupo Funcional'),
        'menu_name'         => __('Estados del Grupo Funcional'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'functional-group'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('functional_group', 'productos_platon', $args);
}



// Registrar taxonomía "product_for_sale"
function registrar_taxonomia_functional_subgroup()
{
    $labels = array(
        'name'              => _x('Subgrupo Funcional', 'taxonomy general name'),
        'singular_name'     => _x('Subgrupo Funcional', 'taxonomy singular name'),
        'search_items'      => __('Buscar Estados del Producto'),
        'all_items'         => __('Todos los Estados del Subgrupo Funcional'),
        'parent_item'       => __('Subgrupo Funcional Padre'),
        'parent_item_colon' => __('Subgrupo Funcional Padre:'),
        'edit_item'         => __('Editar Subgrupo Funcional'),
        'update_item'       => __('Actualizar Subgrupo Funcional'),
        'add_new_item'      => __('Agregar Nuevo Subgrupo Funcional'),
        'new_item_name'     => __('Nuevo Nombre de Subgrupo Funcional'),
        'menu_name'         => __('Estados del Subgrupo Funcional'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'functional-subgroup'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('functional_subgroup', 'productos_platon', $args);
}


function registrar_taxonomia_magentis_brand()
{
    $labels = array(
        'name'              => _x('Marca magentis', 'taxonomy general name'),
        'singular_name'     => _x('Marca magentis', 'taxonomy singular name'),
        'search_items'      => __('Buscar Estados del Producto'),
        'all_items'         => __('Todos los Estados del Marca magentis'),
        'parent_item'       => __('Marca magentis Padre'),
        'parent_item_colon' => __('Marca magentis Padre:'),
        'edit_item'         => __('Editar Marca magentis'),
        'update_item'       => __('Actualizar Marca magentis'),
        'add_new_item'      => __('Agregar Nuevo Marca magentis'),
        'new_item_name'     => __('Nuevo Nombre de Marca magentis'),
        'menu_name'         => __('Estados del Marca magentis'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'magentis-brand'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('magentis_brand', 'productos_platon', $args);
}


function registrar_taxonomia_distribution()
{
    $labels = array(
        'name'              => _x('Distribucion', 'taxonomy general name'),
        'singular_name'     => _x('Distribucion', 'taxonomy singular name'),
        'search_items'      => __('Buscar Estados del Producto'),
        'all_items'         => __('Todos los Estados del Distribucion'),
        'parent_item'       => __('Distribucion Padre'),
        'parent_item_colon' => __('Distribucion Padre:'),
        'edit_item'         => __('Editar Distribucion'),
        'update_item'       => __('Actualizar Distribucion'),
        'add_new_item'      => __('Agregar Nuevo Distribucion'),
        'new_item_name'     => __('Nuevo Nombre de Distribucion'),
        'menu_name'         => __('Estados del Distribucion'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'distribucion'),
        'object_type'       => array('productos_platon'), // Asociar con el tipo de entrada 'productos_platon'
    );

    register_taxonomy('distribucion', 'productos_platon', $args);
}

// Shortcode para el formulario de filtros
function filtro_categorias_shortcode()
{
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/template-filtro-categorias.php';
    return ob_get_clean();
}



function mi_accion_ajax() {
    global $wpdb;
    $per_page = 20;
    // Obtiene las categorías seleccionadas desde la solicitud
    $selected_categories = isset($_POST['filter_categories']) ? $_POST['filter_categories'] : array();

    $page = isset($_POST['page']) ? max(0, (((int)$_POST['page'] - 1) * $per_page)) : 0;

    // Inicializa variables
    $taxonomy_conditions = [];
    $taxonomy_joins = [];
    $unique_taxonomies = [];
    $tax_count = 0;

    // Procesa cada filtro
    foreach ($selected_categories as $taxonomy => $terms) {
        if (is_array($terms)) {
            // Múltiples términos para la taxonomía
            $terms_list = implode(',', array_map('intval', $terms));
            $taxonomy_conditions[] = "(tt.taxonomy = '{$taxonomy}' AND t.term_id IN ({$terms_list}))";
        } else {
            // Un solo término para la taxonomía
            $term_value = intval($terms);
            $taxonomy_conditions[] = "(tt.taxonomy = '{$taxonomy}' AND t.term_id = {$term_value})";
        }
        if (!in_array($taxonomy, $unique_taxonomies)) {
            $unique_taxonomies[] = $taxonomy;
            $tax_count++;
        }
    }

    // Construye la subconsulta
    $subquery_conditions = implode(' OR ', $taxonomy_conditions);
    $subquery = "SELECT tr.object_id
                 FROM wp_term_relationships tr
                 INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                 INNER JOIN wp_terms t ON tt.term_id = t.term_id
                 WHERE $subquery_conditions
                 GROUP BY tr.object_id
                 HAVING COUNT(DISTINCT tt.taxonomy) = $tax_count";

    // Busqueda
    $search = isset($_POST['search']) ? $_POST['search'] : '';

    $search_sql = '';
    if($search != ''){
        $search_sql = " AND (p.post_title LIKE '%$search%' OR p.post_content LIKE '%$search%')";
    }
    $sub_sql = '';
    if(count($selected_categories)>0){
        $sub_sql = 'INNER JOIN ('.$subquery.') AS filtered_posts ON p.ID = filtered_posts.object_id';
    }

    // Construye la consulta principal
    $sql = "SELECT p.ID, p.post_title, p.post_content
            FROM wp_posts p
            $sub_sql
            WHERE p.post_type = 'productos_platon' AND p.post_status = 'publish'
            $search_sql
            GROUP BY p.post_title, p.post_content
            ";

    if(isset($_POST['order']) && $_POST['order']!=''){
        $sql .= "ORDER BY p.post_title " . $_POST['order'];
    }

    $result['clean_sql'] = $sql;

    $sql_count = "SELECT COUNT(*) AS total_items FROM ($sql
                 ) AS grouped_posts";

    $sql .= " LIMIT ";
    $sql .= "$page,"; //Offset
    $sql .= "$per_page"; //Limit

    $result['limit_sql'] = $sql;

    $posts = $wpdb->get_results($sql);

    $result['count_sql'] = $sql_count;

    $total_items_result = $wpdb->get_var($sql_count);

    // Esta consulta obtiene las taxonomías y los IDs de término para los productos filtrados

    // BOF custom subquery para las taxonomias. Si no aplica comentar esto hasta el siguiente EOF
        // Inicializa variables
        $taxonomy_conditions = [];
        $taxonomy_joins = [];
        $unique_taxonomies = [];
        $tax_count = 0;

        // Procesa cada filtro

        foreach ($selected_categories as $taxonomy => $terms) {
            if ($taxonomy=='country' || $taxonomy=='segment') {

                $term_value = intval($terms);
                $taxonomy_conditions[] = "(tt.taxonomy = '{$taxonomy}' AND t.term_id = {$term_value})";

                if (!in_array($taxonomy, $unique_taxonomies)) {
                    $unique_taxonomies[] = $taxonomy;
                    $tax_count++;
                }
            }
        }

        // Construye la subconsulta
        $subquery_conditions = implode(' OR ', $taxonomy_conditions);
        $subquery = "SELECT tr.object_id
                     FROM wp_term_relationships tr
                     INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                     INNER JOIN wp_terms t ON tt.term_id = t.term_id
                     WHERE $subquery_conditions
                     GROUP BY tr.object_id
                     HAVING COUNT(DISTINCT tt.taxonomy) = $tax_count";

     // EOF custom subquery para las taxonomias

    $taxonomies_sql = "SELECT tt.taxonomy, t.term_id
                       FROM wp_term_relationships tr
                       INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                       INNER JOIN wp_terms t ON tt.term_id = t.term_id
                       INNER JOIN ($subquery) AS filtered_posts ON tr.object_id = filtered_posts.object_id";


    $taxonomies_sql = "
        SELECT tt.taxonomy, t.term_id
        FROM {$wpdb->term_relationships} tr
        INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
        WHERE tr.object_id IN (
            SELECT DISTINCT p.ID
            FROM {$wpdb->posts} p
            $sub_sql
            WHERE p.post_type = 'productos_platon' AND p.post_status = 'publish'
            $search_sql
            )
    ";

    $result['taxonomies_sql'] = $taxonomies_sql;


    // Ejecuta la consulta para obtener las taxonomías y los IDs de término
    $taxonomy_results = $wpdb->get_results($taxonomies_sql);

    // Prepara los datos para la función JS
    $taxonomies_info = [];
    foreach ($taxonomy_results as $row) {
        // Asegúrate de que la taxonomía esté inicializada como un array
        if (!isset($taxonomies_info[$row->taxonomy])) {
            $taxonomies_info[$row->taxonomy] = [];
        }
        // Agrega el ID del término al array de la taxonomía correspondiente
        if (!in_array($row->term_id, $taxonomies_info[$row->taxonomy])) {
            $taxonomies_info[$row->taxonomy][] = $row->term_id;
        }
    }

    $plugin_dir = plugin_dir_path(__FILE__);
    $save_path = $plugin_dir . 'imgsalesforce/imgsalesforce.json';
    $imgsales = file_get_contents($save_path);
    $dataimgsal = json_decode($imgsales, true);

    $result['pagination_info'] = array('total_items' => $total_items_result); //total_items

    $result['taxonomies_info'] = $taxonomies_info; // Taxonomies

    $result['products'] = [];

    $result['images'] = obtenerCombinacionesImagenes();

    foreach ($posts as $post) {
        setup_postdata($post);
        $taxonomies_data = array();
        $taxonomies = get_object_taxonomies('productos_platon');
        foreach ($taxonomies as $taxonomy) {
            $terms_ids = wp_get_post_terms($post->ID, $taxonomy, array('fields' => 'ids'));
            $taxonomies_data[$taxonomy] = $terms_ids;
        }
        $urlimg = isset($dataimgsal["records"]) ? $dataimgsal["records"] : 'URL o datos de imagen no disponibles';

        $result['products'][] = [
            'title' => $post->post_title,
            'content' => $post->post_content,
            'taxonomies' => $taxonomies_data,
            'urlimg' => $urlimg,
        ];
    }

    wp_reset_postdata();
    wp_send_json($result); // Envía el resultado como una respuesta JSON
    die();
}

function obtenerCombinacionesImagenes() {
    $plugin_dir = plugin_dir_path(__FILE__);
    $save_path = $plugin_dir . 'imgsalesforce/imgsalesforce.json';
    $imgsales = file_get_contents($save_path);
    $dataimgsal = json_decode($imgsales, true);

    $combinacionesImagenes = [];

    if (isset($dataimgsal["records"]) && is_array($dataimgsal["records"])) {
        foreach ($dataimgsal["records"] as $record) {
            // Asumiendo que cada record contiene UA_Pais__c, UA_AplicacionN1__c (segmento), y UA_URLImagenes__c
            if (isset($record["UA_Pais__c"], $record["UA_AplicacionN1__c"], $record["UA_URLImagenes__c"])) {
                $pais = $record["UA_Pais__c"];
                $segmento = $record["UA_AplicacionN1__c"];
                $urlImagen = $record["UA_URLImagenes__c"];

                // Crear una clave única para cada combinación de país y segmento
                $claveUnica = $pais . '-' . $segmento;

                // Evitar duplicados: solo agregar si la clave única no existe ya
                if (!array_key_exists($claveUnica, $combinacionesImagenes)) {
                    $combinacionesImagenes[$claveUnica] = [
                        'pais' => $pais,
                        'segmento' => $segmento,
                        'urlImagen' => $urlImagen
                    ];
                }
            }
        }
    }

    // Devolver las combinaciones de imágenes como un array indexado
    return array_values($combinacionesImagenes);
}


// Registra la acción AJAX
add_action('wp_ajax_mi_accion_ajax', 'mi_accion_ajax');
add_action('wp_ajax_nopriv_mi_accion_ajax', 'mi_accion_ajax');

function incluir_jquery()
{
    wp_enqueue_script('jquery');
}

function enqueue_custom_styles()
{
    // Obtener la URL del directorio del plugin
    $plugin_url = plugins_url('/', __FILE__);

    // Enlazar el archivo CSS desde la carpeta css del plugin
    wp_enqueue_style('custom-plugin-styles', $plugin_url . 'css/style.css');
    wp_enqueue_style('custom-plugin', $plugin_url . 'css/main.css');
}

// Agregar el estilo al hook 'wp_enqueue_scripts'
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


add_action('wp_enqueue_scripts', 'incluir_jquery');






// En alguna parte de tu código PHP en el lado del servidor
// function enqueue_my_script()
// {
//     wp_enqueue_script('my-script', 'https://code.jquery.com/jquery-3.7.1.min.js', array('jquery'), '1.0', true);

//     // Localiza las variables para el script
//     wp_localize_script('my-script', 'mi_script_vars', array(
//         'ajaxurl' => admin_url('admin-ajax.php'),
//     ));
// }


function enqueue_my_script()
{
    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue DataTables script
    wp_enqueue_script('data-tables', 'https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js', array('jquery'), '1.13.7', true);

    // Enqueue tu script personalizado
    wp_enqueue_script('my-script', 'https://code.jquery.com/jquery-3.7.1.min.js', array('jquery'), '1.0', true);

    // Localiza las variables para el script
    wp_localize_script('my-script', 'mi_script_vars', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}



$args = array(
    'post_type' => 'productos_platon', // Ajusta esto al tipo de post que estás utilizando
    'posts_per_page' => -1,
    'tax_query' => array(
        'relation' => 'OR', // Relación OR para incluir publicaciones que pertenecen a al menos una categoría
        array(
            'taxonomy' => 'country',
            'field'    => 'id',
            'terms'    => 10,
        ),

    ),
);

// En tu archivo principal del plugin o functions.php
function enqueue_simple_pagination_script()
{
    wp_enqueue_script('simple-pagination', plugins_url('js/main.js', __FILE__), array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_simple_pagination_script');


add_action('wp_enqueue_scripts', 'enqueue_my_script');


// Registra el shortcode
add_shortcode('filtro_categorias', 'filtro_categorias_shortcode');

add_action('cron_platon', 'consumir_servicio_salesforce_cron');

add_action('init', 'registrar_taxonomia_country');
add_action('init', 'registrar_taxonomia_segment');
add_action('init', 'registrar_taxonomia_category');
add_action('init', 'registrar_taxonomia_product_for_sale');
add_action('init', 'registrar_taxonomia_product_final');
add_action('init', 'registrar_taxonomia_technicalneed');
add_action('init', 'registrar_taxonomia_functional_group');
add_action('init', 'registrar_taxonomia_functional_subgroup');
add_action('init', 'registrar_taxonomia_magentis_brand');
add_action('init', 'registrar_taxonomia_distribution');

add_action('init', 'registrar_tipo_productos_platon');



// Registra la función para ejecutarse cuando el plugin se activa
register_activation_hook(__FILE__, 'catalogo_magentis_activado');
add_action('wp_ajax_search_action', 'tu_funcion_de_busqueda');
add_action('wp_ajax_nopriv_search_action', 'tu_funcion_de_busqueda');
