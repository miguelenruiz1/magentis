<?php
/*
Template Name: Filtrar Catálogo Magentis
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portafolio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

  <div class="container-fluid">
    <div class="banner-section img-fluid">
      <h2 class="text-banner-section">
        Conoce nuestro portafolio
      </h2>
    </div>

    <div class="cont-mb-buscador">

      <div class="buscador-mb">
        <div class="box">
          <div class="container-1">
            <input type="search" id="search" placeholder="Buscar productos" />
            <span class="icon"><i class="fa fa-search"></i></span>
          </div>
        </div>
      </div>

      <div class="ordenarpor-mb">
        <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Ordenar por
          </button>
          <ul class="dropdown-menu menu-style" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">Opción 1</a></li>
            <li><a class="dropdown-item" href="#">Opción 2</a></li>
            <li><a class="dropdown-item" href="#">Opción 3</a></li>
          </ul>
        </div>
      </div>

    </div>

    <div class="acordion-1">

      <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingOne">
            <button class="acord-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              PAÍS
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              <!-- Contenido del acordeón para Países -->
              <?php
              // Obtener todas las categorías
              $countries = get_terms(array(
                'taxonomy'   => 'country',
                'hide_empty' => false,
                'parent'     => 0,
              ));

              // Mostrar radios para las categorías
              foreach ($countries as $country) {
                echo '<label><input type="radio" name="filter_countries" value="' . esc_attr($country->term_id) . '" class="mi-radio"> ' . esc_html($country->name) . '</label><br>';

                // Obtener hijos de la categoría actual
                $children = get_terms(array(
                  'taxonomy'   => 'country',
                  'hide_empty' => false,
                  'parent'     => $country->term_id,
                ));

                // Mostrar radios para los hijos de la categoría
                foreach ($children as $child) {
                  echo '<label style="margin-left: 20px;"><input type="radio" name="filter_countries" value="' . esc_attr($child->term_id) . '" class="mi-radio"> ' . esc_html($child->name) . '</label><br>';
                }
              }
              ?>
            </div>
          </div>
        </div>


        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed acord-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              SEGMENTO
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              <!-- Contenido del acordeón para Segmentos -->
              <?php
              // Obtener todas las categorías para "segment"
              $segment_categories = get_terms(array(
                'taxonomy'   => 'segment',
                'hide_empty' => false,
                'parent'     => 0,
              ));

              // Mostrar radios para las categorías de "segment"
              foreach ($segment_categories as $segment_category) {
                echo '<label><input type="radio" name="filter_categories_seg" value="' . esc_attr($segment_category->term_id) . '" class="mi-radio"> ' . esc_html($segment_category->name) . '</label><br>';

                // Obtener hijos de la categoría de "segment" actual
                $segment_children = get_terms(array(
                  'taxonomy'   => 'segment',
                  'hide_empty' => false,
                  'parent'     => $segment_category->term_id,
                ));

                // Mostrar radios para los hijos de la categoría de "segment"
                foreach ($segment_children as $segment_child) {
                  echo '<label style="margin-left: 20px;"><input type="radio" name="filter_categories_seg" value="' . esc_attr($segment_child->term_id) . '" class="mi-radio"> ' . esc_html($segment_child->name) . '</label><br>';
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="cont-buscador">
      <div class="img-planificacion">

      </div>
      <div class="buscador">
        <h3>PRODUCT FINDER</h3>
        <div class="box">
          <div class="container-1">
            <input type="search" id="search" placeholder="Buscar productos" />
            <span class="icon"><i class="fa fa-search"></i></span>
          </div>
        </div>
      </div>
      <div class="ordenarpor">
        <div class="dropdown">
          <h3>Ordenar por</h3>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Selecciona una Opción
          </button>
          <ul class="dropdown-menu menu-style" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">Opción 1</a></li>
            <li><a class="dropdown-item" href="#">Opción 2</a></li>
            <li><a class="dropdown-item" href="#">Opción 3</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="buscador-productos">
      <div class="filtro">

        <div class="accordion" id="accordionPanelsStayOpenExample">

          <div class="accordion-item style-perzon">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
              <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                CATEGORÍA
              </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
              <div class="accordion-body">
                <!-- Contenido del acordeón para Categorías -->
                <?php
                // Obtener todas las categorías para "category"
                $category_terms = get_terms(array(
                  'taxonomy'   => 'category',
                  'hide_empty' => false,
                  'parent'     => 0,
                ));

                // Mostrar checkboxes para las categorías de "category"
                foreach ($category_terms as $category_term) {
                  echo '<label><input type="checkbox" name="filter_categories" value="' . esc_attr($category_term->term_id) . '" class="mi-checkbox"> ' . esc_html($category_term->name) . '</label><br>';

                  // Obtener hijos de la categoría de "category" actual
                  $category_children = get_terms(array(
                    'taxonomy'   => 'category',
                    'hide_empty' => false,
                    'parent'     => $category_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "category"
                  foreach ($category_children as $category_child) {
                    echo '<label style="margin-left: 20px;"><input type="checkbox" name="filter_categories" value="' . esc_attr($category_child->term_id) . '" class="mi-checkbox"> ' . esc_html($category_child->name) . '</label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </div>

          <div class="accordion-item style-perzon">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                PRODUCTO FINAL
              </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
              <div class="accordion-body">
                <!-- Contenido del acordeón para Producto Final -->
                <?php
                // Obtener todas las categorías para "product_final"
                $product_final_terms = get_terms(array(
                  'taxonomy'   => 'product_final',
                  'hide_empty' => false,
                  'parent'     => 0,
                ));

                // Mostrar checkboxes para las categorías de "product_final"
                foreach ($product_final_terms as $product_final_term) {
                  echo '<label><input type="checkbox" name="filter_product_final[]" value="' . esc_attr($product_final_term->term_id) . '" class="mi-checkbox filter_product_final"> ' . esc_html($product_final_term->name) . '</label><br>';

                  // Obtener hijos de la categoría de "product_final" actual
                  $product_final_children = get_terms(array(
                    'taxonomy'   => 'product_final',
                    'hide_empty' => false,
                    'parent'     => $product_final_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "product_final"
                  foreach ($product_final_children as $product_final_child) {
                    echo '<label style="margin-left: 20px;"><input type="checkbox" name="filter_product_final[]" value="' . esc_attr($product_final_child->term_id) . '" class="mi-checkbox filter_product_final"> ' . esc_html($product_final_child->name) . '</label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </div>

          <div class="accordion-item style-perzon">
            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                NECESIDAD TÉCNICA
              </button>
            </h2>
            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
              <div class="accordion-body">
                <!-- Contenido del acordeón para Necesidades Técnicas del Producto -->
                <?php
                // Obtener todas las categorías para "product_technicalneed"
                $technical_need_terms = get_terms(array(
                  'taxonomy'   => 'product_technicalneed',
                  'hide_empty' => false,
                  'parent'     => 0,
                ));

                // Mostrar checkboxes para las categorías de "product_technicalneed"
                foreach ($technical_need_terms as $technical_need_term) {
                  echo '<label><input type="checkbox" name="filter_technical_need" value="' . esc_attr($technical_need_term->term_id) . '" class="mi-checkbox"> ' . esc_html($technical_need_term->name) . '</label><br>';

                  // Obtener hijos de la categoría de "product_technicalneed" actual
                  $technical_need_children = get_terms(array(
                    'taxonomy'   => 'product_technicalneed',
                    'hide_empty' => false,
                    'parent'     => $technical_need_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "product_technicalneed"
                  foreach ($technical_need_children as $technical_need_child) {
                    echo '<label style="margin-left: 20px;"><input type="checkbox" name="filter_technical_need" value="' . esc_attr($technical_need_child->term_id) . '" class="mi-checkbox"> ' . esc_html($technical_need_child->name) . '</label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </div>

          <div class="accordion-item style-perzon">
            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                GRUPO FUNCIONAL
              </button>
            </h2>
            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
              <div class="accordion-body">
                <!-- Contenido del acordeón para Grupo Funcional -->
                <?php
                // Obtener todas las categorías para "functional_group"
                $functional_group_terms = get_terms(array(
                  'taxonomy'   => 'functional_group',
                  'hide_empty' => false,
                  'parent'     => 0,
                ));

                // Mostrar checkboxes para las categorías de "functional_group"
                foreach ($functional_group_terms as $functional_group_term) {
                  echo '<label><input type="checkbox" name="filter_functional_group" value="' . esc_attr($functional_group_term->term_id) . '" class="mi-checkbox"> ' . esc_html($functional_group_term->name) . '</label><br>';

                  // Obtener hijos de la categoría de "functional_group" actual
                  $functional_group_children = get_terms(array(
                    'taxonomy'   => 'functional_group',
                    'hide_empty' => false,
                    'parent'     => $functional_group_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "functional_group"
                  foreach ($functional_group_children as $functional_group_child) {
                    echo '<label style="margin-left: 20px;"><input type="checkbox" name="filter_functional_group" value="' . esc_attr($functional_group_child->term_id) . '" class="mi-checkbox"> ' . esc_html($functional_group_child->name) . '</label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </div>

          <div class="accordion-item style-perzon">
            <h2 class="accordion-header" id="panelsStayOpen-headingFive">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                SUBGRUPO FUNCIONAL
              </button>
            </h2>
            <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive">
              <div class="accordion-body">
                <!-- Contenido del acordeón para Subgrupo Funcional -->
                <?php
                // Obtener todas las categorías para "functional_subgroup"
                $functional_subgroup_terms = get_terms(array(
                  'taxonomy'   => 'functional_subgroup',
                  'hide_empty' => false,
                  'parent'     => 0,
                ));

                // Mostrar checkboxes para las categorías de "functional_subgroup"
                foreach ($functional_subgroup_terms as $functional_subgroup_term) {
                  echo '<label><input type="checkbox" name="filter_functional_subgroup" value="' . esc_attr($functional_subgroup_term->term_id) . '" class="mi-checkbox"> ' . esc_html($functional_subgroup_term->name) . '</label><br>';

                  // Obtener hijos de la categoría de "functional_subgroup" actual
                  $functional_subgroup_children = get_terms(array(
                    'taxonomy'   => 'functional_subgroup',
                    'hide_empty' => false,
                    'parent'     => $functional_subgroup_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "functional_subgroup"
                  foreach ($functional_subgroup_children as $functional_subgroup_child) {
                    echo '<label style="margin-left: 20px;"><input type="checkbox" name="filter_functional_subgroup" value="' . esc_attr($functional_subgroup_child->term_id) . '" class="mi-checkbox"> ' . esc_html($functional_subgroup_child->name) . '</label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </div>

          <div class="accordion-item style-perzon">
            <h2 class="accordion-header" id="panelsStayOpen-headingSix">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
                MARCA MAGENTIS
              </button>
            </h2>
            <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix">
              <div class="accordion-body">
                <!-- Contenido del acordeón para Marca Magentis -->
                <?php
                // Obtener todas las categorías para "magentis_brand"
                $magentis_brand_terms = get_terms(array(
                  'taxonomy'   => 'magentis_brand',
                  'hide_empty' => false,
                  'parent'     => 0,
                ));

                // Mostrar checkboxes para las categorías de "magentis_brand"
                foreach ($magentis_brand_terms as $magentis_brand_term) {
                  echo '<label><input type="checkbox" name="filter_magentis_brand" value="' . esc_attr($magentis_brand_term->term_id) . '" class="mi-checkbox"> ' . esc_html($magentis_brand_term->name) . '</label><br>';

                  // Obtener hijos de la categoría de "magentis_brand" actual
                  $magentis_brand_children = get_terms(array(
                    'taxonomy'   => 'magentis_brand',
                    'hide_empty' => false,
                    'parent'     => $magentis_brand_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "magentis_brand"
                  foreach ($magentis_brand_children as $magentis_brand_child) {
                    echo '<label style="margin-left: 20px;"><input type="checkbox" name="filter_magentis_brand" value="' . esc_attr($magentis_brand_child->term_id) . '" class="mi-checkbox"> ' . esc_html($magentis_brand_child->name) . '</label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </div>

          <div class="accordion-item style-perzon">
            <h2 class="accordion-header" id="panelsStayOpen-headingSeven">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">
                DISTRIBUCIÓN
              </button>
            </h2>
            <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSeven">
              <div class="accordion-body">
                <!-- Contenido del acordeón para Distribución -->
                <?php
                // Obtener todas las categorías para "distribucion"
                $distribucion_terms = get_terms(array(
                  'taxonomy'   => 'distribucion',
                  'hide_empty' => false,
                  'parent'     => 0,
                ));

                // Mostrar checkboxes para las categorías de "distribucion"
                foreach ($distribucion_terms as $distribucion_term) {
                  echo '<label><input type="checkbox" name="filter_distribucion" value="' . esc_attr($distribucion_term->term_id) . '" class="mi-checkbox"> ' . esc_html($distribucion_term->name) . '</label><br>';

                  // Obtener hijos de la categoría de "distribucion" actual
                  $distribucion_children = get_terms(array(
                    'taxonomy'   => 'distribucion',
                    'hide_empty' => false,
                    'parent'     => $distribucion_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "distribucion"
                  foreach ($distribucion_children as $distribucion_child) {
                    echo '<label style="margin-left: 20px;"><input type="checkbox" name="filter_distribucion" value="' . esc_attr($distribucion_child->term_id) . '" class="mi-checkbox"> ' . esc_html($distribucion_child->name) . '</label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </div>



        </div>
      </div>

      <div id="mi-contenedor-respose">
      </div>

    </div>

  </div>
  <?php
    // El bucle de WordPress
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



  <script>
    jQuery(document).ready(function($) {
      // Manejador para el evento de cambio en los radios y checkboxes
      $('body').on('change', '.mi-radio, .mi-checkbox', function() {
        // Obtener todas las categorías seleccionadas
        var selectedCategories = {
          'country': $('input[name="filter_countries"]:checked').val(),
          'segment': $('input[name="filter_categories_seg"]:checked').val(),
          'category': $('input[name="filter_categories"]:checked').map(function() {
            return $(this).val();
          }).get(),
          'product_for_sale': $('input[name="filter_product_for_sale"]:checked').map(function() {
            return $(this).val();
          }).get(),
          'technical_need': $('input[name="filter_technical_need"]:checked').map(function() {
            return $(this).val();
          }).get(),
          'functional_group': $('input[name="filter_functional_group"]:checked').map(function() {
            return $(this).val();
          }).get(),
          'functional_subgroup': $('input[name="filter_functional_subgroup"]:checked').map(function() {
            return $(this).val();
          }).get(),
          'magentis_brand': $('input[name="filter_magentis_brand"]:checked').map(function() {
            return $(this).val();
          }).get(),
          'distribucion': $('input[name="filter_distribucion"]:checked').map(function() {
            return $(this).val();
          }).get(),
          'filter_product_final': $('input[name="filter_product_final"]:checked').map(function() {
            return $(this).val();
          }).get()
        };

        // Deshabilitar todos los elementos del menú
        $('.mi-checkbox').prop('disabled', true);

        // Habilitar solo los elementos correspondientes a las categorías seleccionadas
        $.each(selectedCategories, function(key, values) {
          if (Array.isArray(values) && values.length > 0) {
            $.each(values, function(index, value) {
              $('.mi-checkbox[value="' + value + '"]').prop('disabled', false);
            });
          }
        });

        // Realizar la solicitud AJAX con todas las categorías seleccionadas
        var data = {
          'action': 'mi_accion_ajax',
          'filter_categories': selectedCategories,
        };

        // console.log(selectedCategories);

        $.ajax({
          type: 'POST',
          url: mi_script_vars.ajaxurl,
          data: data,
          success: function(response) {
            // Limpiar el contenedor antes de agregar nuevo contenido
            $('#mi-contenedor-respose').empty();

            // Comprobar si hay contenido en la respuesta
            if (response.length > 0) {

              // Iterar sobre cada elemento en la respuesta
              response.forEach(function(item) {
                // console.log(item.taxonomies)

                // Ejemplo de uso
                var allCheckboxIds = getAllCheckboxIds();
                var combinedArray = [].concat(
                  item.taxonomies.category,
                  item.taxonomies.distribucion,
                  item.taxonomies.functional_group,
                  item.taxonomies.functional_subgroup,
                  item.taxonomies.magentis_brand,
                  item.taxonomies.product_final,
                  item.taxonomies.product_for_sale,
                  item.taxonomies.product_technicalneed,
                  item.taxonomies.segment
                );
                // console.log(item.taxonomies.product_final)
                enableCheckboxesByValuesAndClass(allCheckboxIds, combinedArray);
                // Crear elementos HTML y agregarlos al contenedor
                var postHtml = '<div class="nombre">';
                postHtml += '<h3>' + item.title + '</h3>';
                postHtml += ' </div>';
                postHtml += '<div class="descripcion"><p>' + item.content + '</p></div>';
                postHtml += '</div>';
                $('#mi-contenedor-respose').append(postHtml);

              });
            } else {
              // Si no hay contenido, mostrar un mensaje o realizar otra acción
              $('#mi-contenedor-respose').html('<p>No hay contenido disponible.</p>');
            }
          },
          error: function(error) {
            console.log(error);
          }
        });
      });

      function getAllCheckboxIds() {
        // Array para almacenar todos los IDs de los checkboxes
        var allCheckboxIds = [];

        // Seleccionar todos los checkboxes con la clase 'mi-checkbox'
        var checkboxes = $('.mi-checkbox');

        // Iterar sobre los checkboxes y agregar los IDs al array
        checkboxes.each(function() {
          allCheckboxIds.push($(this).val());
        });

        // Devolver el array de IDs como resultado
        return allCheckboxIds;
      }

      function enableCheckboxesByValuesAndClass(values, valuesresponse) {
        // Deshabilitar todos los checkboxes con la clase específica
        $('.mi-checkbox').prop('disabled', true);

        // Habilitar solo los checkboxes con los valores presentes en valuesresponse
        valuesresponse.forEach(function(value) {
          $('.mi-checkbox[value="' + value + '"]').prop('disabled', false);
        });
      }




    });
  </script>
  <script>
    $(document).ready(function() {
      // Función para realizar la búsqueda
      function realizarBusqueda() {
        // Obtén el valor de búsqueda y conviértelo a minúsculas
        var searchTerm = $('#search').val().toLowerCase();

        // Itera sobre cada elemento con la clase .nombre
        $('.nombre').each(function() {
          // Obtén el texto dentro de h3 y conviértelo a minúsculas
          var itemName = $(this).find('h3').text().toLowerCase();

          // Muestra u oculta los elementos según si coinciden con el término de búsqueda
          var match = itemName.includes(searchTerm);
          $(this).toggle(match);
        });
      }

      // Evento de entrada en el campo de búsqueda
      $('#search').on('input', function() {
        realizarBusqueda();
      });

      // Evento para manejar los resultados AJAX
      $(document).ajaxComplete(function() {
        realizarBusqueda();
      });
    });
  </script>




</body>

</html>