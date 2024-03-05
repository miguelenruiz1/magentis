<?php

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

$search_ids_sql = '';
if (!empty($search)) {
    $search_escaped = '%' . $wpdb->esc_like($search) . '%';
    $search_condition = $wpdb->prepare(" AND (p.post_title LIKE %s OR p.post_content LIKE %s)", $search_escaped, $search_escaped);

    $search_ids_sql = "SELECT p.ID
                       FROM wp_posts p
                       WHERE p.post_type = 'productos_platon' AND p.post_status = 'publish' $search_condition";
    $search_ids_results = $wpdb->get_results($search_ids_sql, OBJECT);
    $search_ids = wp_list_pluck($search_ids_results, 'ID');
}

// Verifica si hay taxonomías seleccionadas
$has_taxonomies = (!empty($selected_categories['country']) || !empty($selected_categories['segment'])) ? true : false;

// Verifica si hay una búsqueda
$has_search = !empty($search);

if ($has_taxonomies && $has_search) {
    // Caso: Taxonomías y búsqueda combinadas
    $search_ids_string = implode(',', array_map('intval', $search_ids));
    $taxonomies_sql = "SELECT tt.taxonomy, t.term_id
                      FROM wp_term_relationships tr
                      INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                      INNER JOIN wp_terms t ON tt.term_id = t.term_id
                      WHERE tr.object_id IN ($subquery) AND tr.object_id IN ($search_ids_string)";
} elseif ($has_taxonomies && !$has_search) {
    // Caso: Solo taxonomías seleccionadas
    $taxonomies_sql = "SELECT tt.taxonomy, t.term_id
                      FROM wp_term_relationships tr
                      INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                      INNER JOIN wp_terms t ON tt.term_id = t.term_id
                      INNER JOIN ($subquery) AS filtered_posts ON tr.object_id = filtered_posts.object_id";
} elseif (!$has_taxonomies && $has_search) {
    // Caso: Solo hay búsqueda
    $taxonomies_sql = "SELECT tt.taxonomy, t.term_id
                       FROM wp_term_relationships tr
                       INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                       INNER JOIN wp_terms t ON tt.term_id = t.term_id
                       INNER JOIN wp_posts p ON tr.object_id = p.ID
                       WHERE p.post_type = 'productos_platon' AND p.post_status = 'publish'
                       AND (p.post_title LIKE '%$search%' OR p.post_content LIKE '%$search%')";
} else {
    // Caso: No hay taxonomías seleccionadas ni búsqueda
    // Manejar según sea necesario, por ejemplo, devolver todas las taxonomías o ninguna
    $taxonomies_sql = "SELECT tt.taxonomy, t.term_id
                      FROM wp_term_relationships tr
                      INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                      INNER JOIN wp_terms t ON tt.term_id = t.term_id
                      WHERE 1=0"; // Ejemplo para no devolver resultados
}
