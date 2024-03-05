<?php
// Incluye el archivo de WordPress para acceder a sus funciones
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

// Verifica si se recibió el término de búsqueda
if (isset($_POST['search_term'])) {
  // Sanitiza el término de búsqueda
  $search_term = sanitize_text_field($_POST['search_term']);

  // Realiza la consulta para obtener resultados filtrados (ajusta esto según tu lógica de consulta)
  $args = array(
    'post_type'      => 'tu_tipo_de_post', // Reemplaza 'tu_tipo_de_post' con el tipo de post que estás filtrando
    'posts_per_page' => -1,
    's'              => $search_term,
  );

  $query = new WP_Query($args);

  // Comienza a imprimir los resultados
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      ?>
      <div class="resultado">
        <!-- Muestra la información del post, ajusta según tus necesidades -->
        <h2><?php the_title(); ?></h2>
        <div class="contenido"><?php the_content(); ?></div>
      </div>
      <?php
    }
  } else {
    echo 'No se encontraron resultados.';
  }

  // Restaura la configuración global de WordPress
  wp_reset_postdata();
}
?>
