<?php 
include_once(plugin_dir_path(__FILE__) . 'salesforce-integration.php');
function consumir_servicio_salesforce_cron()
{
  // Inicializa los resultados totales
  $resultados_totales = array();
  $nextRecordsUrl = null;
  do {
      // Realiza la solicitud al servicio de Salesforce y maneja la paginación
      if (!empty($nextRecordsUrl)) {
          $data = consultar_informacion_con_token('https://disanlatinoamerica.my.salesforce.com' . $nextRecordsUrl);
      } else {
          $data = consultar_informacion_con_token($nextRecordsUrl);
      }

      // Verifica si hay un error en la respuesta de Salesforce
      if ($data === null) {
          echo 'Error en la respuesta de Salesforce.';
          return;
      }

      // Agrega los resultados de la página actual a los resultados totales
      $resultados_totales = array_merge($resultados_totales, $data['records']);
      
      // Actualiza la URL de la siguiente página
      $nextRecordsUrl = $data['nextRecordsUrl'];

  } while (!empty($nextRecordsUrl));

  // Ahora $resultados_totales contiene todos los registros de productos

  // Procesa los resultados como sea necesario
  foreach ($resultados_totales as $dat) {
      // Resto del código
      $countries = explode(';', $dat["CNT_Producto_PLATON__r"]["UA_Paises_Portafolio__c"]); // Dividir países por punto y coma
      $segment = $dat["UA_Aplicacion_N1__c"]; // Categoría segmento
      $category = $dat["UA_Aplicacion_N2__c"]; // Categoría 
      $description = $dat["CNT_Producto_PLATON__r"]["UA_Descripcion_Prod_PLATON__c"]; // Cuerpo de la entrada
      $product_for_sale = $dat["CNT_Producto_PLATON__r"]["UA_Tipo_de_Producto__c"];  // Categoría estado del producto
      $name = $dat["CNT_Producto_PLATON__r"]["Name"]; // Título de la entrada

      $product_final = $dat['UA_Aplicacion_N3__c'];
      $product_technicalneed = $dat["CNT_Producto_PLATON__r"]["UA_Necesidades__c"]; //viene null
      $functional_group = $dat["CNT_Producto_PLATON__r"]["UA_Grupo_Productos_N2__c"];
      $functional_subgroup = $dat["CNT_Producto_PLATON__r"]["UA_Grupo_Productos_N3__c"];
      $magentis_brand = $dat["CNT_Producto_PLATON__r"]["UA_Familia_Marcaria__c"]; // viene null
      $distribucion  = $dat["CNT_Producto_PLATON__r"]["UA_Distribucion__c"];

      // Verifica si las categorías existen, si no, las crea
      $segment_id = crear_obtener_categoria('segment', $segment);
      $category_id = crear_obtener_categoria('category', $category);
      $product_for_sale_id = crear_obtener_categoria('product_for_sale', $product_for_sale);

      $product_final_id = crear_obtener_categoria('product_final', $product_final);
      $product_technicalneed_id = crear_obtener_categoria('product_technicalneed', $product_technicalneed);
      $functional_group_id = crear_obtener_categoria('functional_group', $functional_group);
      $functional_subgroup_id = crear_obtener_categoria('functional_subgroup', $functional_subgroup);
      $magentis_brand_id = crear_obtener_categoria('magentis_brand', $magentis_brand);
      $distribucion_id = crear_obtener_categoria('distribucion', $distribucion);

      $existing_entry = get_page_by_title($name, OBJECT, 'productos_platon');

      if (!$existing_entry) {
          // Crea la entrada "Productos Platon"
          $post_data = array(
              'post_title'   => $name,
              'post_content' => $description,
              'post_status'  => 'publish',
              'post_type'    => 'productos_platon',
              'tax_input'    => array(
                  'country'           => array(), // No asigna países individualmente
                  'segment'           => array($segment_id),
                  'category'          => array($category_id),
                  'product_for_sale'  => array($product_for_sale_id),
                  'product_final'  => array($product_final_id),
                  'product_technicalneed'  => array($product_technicalneed_id),
                  'functional_group'  => array($functional_group_id),
                  'functional_subgroup'  => array($functional_subgroup_id),
                  'magentis_brand'  => array($magentis_brand_id),
                  'distribucion'  => array($distribucion_id),
              ),
          );

          // Inserta la entrada
          $post_id = wp_insert_post($post_data);

          // Después de realizar la inserción
          if (is_wp_error($post_id)) {
              echo 'Error al insertar la entrada: ' . $post_id->get_error_message();
          }

          // Asigna los países como términos de la taxonomía 'country' a la entrada
          foreach ($countries as $country_name) {
              $country_id = crear_obtener_categoria('country', $country_name);
              wp_set_post_terms($post_id, $country_id, 'country', true);
          }
      } else {
          // Insertar la nueva entrada si no existe

          // die();
          // Insertar la nueva entrada si no existe
          $name = $dat["CNT_Producto_PLATON__r"]["Name"];
          $existing_entry = get_page_by_title($name, OBJECT, 'productos_platon');
          $post_id =  $existing_entry->ID;

          // Después de realizar la inserción

          // Asignar los países como términos de la taxonomía 'country' a la entrada
          foreach ($countries as $country_name) {
              $country_id = crear_obtener_categoria('country', $country_name);
              wp_set_post_terms($post_id, $country_id, 'country', true);
          }

          // Asignar otras taxonomías a la entrada recién creada
          wp_set_post_terms($post_id, $segment_id, 'segment', true);
          wp_set_post_terms($post_id, $category_id, 'category', true);
          wp_set_post_terms($post_id, $product_for_sale_id, 'product_for_sale', true);
          wp_set_post_terms($post_id, $product_final_id, 'product_final', true);
          wp_set_post_terms($post_id, $product_technicalneed_id, 'product_technicalneed', true);
          wp_set_post_terms($post_id, $functional_group_id, 'functional_group', true);
          wp_set_post_terms($post_id, $functional_subgroup_id, 'functional_subgroup', true);
          wp_set_post_terms($post_id, $magentis_brand_id, 'magentis_brand', true);
          wp_set_post_terms($post_id, $distribucion_id, 'distribucion', true);
      }
  }
}