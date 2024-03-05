<?php
/*
Template Name: Filtrar Catálogo Magentis
*/

//get_header();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">


<div class="container-fluid m-0 p-0">
  <div class="banner-section img-fluid">
    <h2 class="text-banner-section">
      Conoce nuestro portafolio
    </h2>
  </div>
</div>

<div class="container-fluid">


  <div class="buscador-mb">
    <div class="box buscar-por">
      <form class="container-1">
        <input type="search" id="searc_other" placeholder="Buscar productos" />
        <input class="icon" type="submit" value="" /><i class="fa fa-search"></i>
      </form>
    </div>

    <form class="ordenarpor-mb">
      <p> Ordenar por:
        <select class="opciones" id="ordenarTabla" name="curso" required>
          <option value="">Elige una opción</option>
          <option value="asc">A-Z</option>
          <option value="desc">Z-A</option>
        </select>
      </p>
    </form>
  </div>
  <!-- ERICK -->

  <div class="container-fluid">
    <div class="acordion-1">
      <p class="title-12">Selecciona el País y el Segmento de interés</p>
      <div class="row">
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
          <!-- Acordeón para PAÍS -->
          <div class="accordion" id="accordionCountries">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingCountries">
                <button class="acord-perzon accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCountries" aria-expanded="true" aria-controls="collapseCountries">PAÍS</button>
              </h2>
              <div id="collapseCountries" class="accordion-collapse collapse show" aria-labelledby="headingCountries">
                <div class="accordion-body">
                  <!-- Contenido del acordeón para Países -->
                  <?php
                  // Obtener todas las categorías
                  $countries = get_terms(array(
                    'taxonomy'   => 'country',
                    'hide_empty' => false,
                    'parent'     => 0,
                  ));

                  // Definir el orden deseado de los países
                  $desiredOrder = array("México", "Colombia", "Ecuador", "Perú");

                  // Ordenar los países según el orden deseado
                  usort($countries, function ($a, $b) use ($desiredOrder) {
                    $aIndex = array_search($a->name, $desiredOrder);
                    $bIndex = array_search($b->name, $desiredOrder);

                    return $aIndex - $bIndex;
                  });

                  // Mostrar radios para las categorías
                  foreach ($countries as $country) {
                    echo '<div class="country-radio">';
                    echo '<input class="checkeable mi-radio" type="radio" id="' . esc_attr($country->term_id) . '"  name="filter_countries" value="' . esc_attr($country->term_id) . '">';
                    echo '<label for="' . esc_attr($country->term_id) . '">' . esc_html($country->name) . '</label>';

                    // Obtener hijos de la categoría actual
                    $children = get_terms(array(
                      'taxonomy'   => 'country',
                      'hide_empty' => false,
                      'parent'     => $country->term_id,
                    ));

                    // Ordenar los hijos según el orden deseado
                    usort($children, function ($a, $b) use ($desiredOrder) {
                      $aIndex = array_search($a->name, $desiredOrder);
                      $bIndex = array_search($b->name, $desiredOrder);

                      return $aIndex - $bIndex;
                    });

                    // Mostrar radios para los hijos de la categoría
                    foreach ($children as $child) {
                      echo '<div class="child-country-radio">';
                      echo '<input class="checkeable mi-radio" type="radio" id="' . esc_attr($child->term_id) . '"  name="filter_countries" value="' . esc_attr($child->term_id) . '">';
                      echo '<label for="' . esc_attr($child->term_id) . '" class="mi-radio">' . esc_html($child->name) . '</label>';
                      echo '</div>';
                    }

                    echo '</div>';
                  }

                  ?>
                </div>
              </div>
            </div>
          </div>
          <!-- BUSCADOR AL FINAL DE LA PRIMERA COLUMNA -->
          <div class="buscador">
            <h3>BUSCAR PRODUCTO</h3>
            <div class="box">
              <div class="container-1">
                <input type="search" id="search" placeholder="Buscar productos" />
                <input class="icon" type="button" id="search_button" value="" /><i class="fa fa-search"></i>
            </div>
            </div>

            <div class="ordenarpor">
              <p>
                Ordenar por
                <select class="opciones" id="ordenarTabla_1" name="curso" disabled="disabled">
                  <option value="">Elige una opci&#243;n</option>
                  <option value="ASC">A-Z</option>
                  <option value="DESC">Z-A</option>
                </select>
              </p>
          </div>

          </div>
          <!-- FIN BUSCADOR AL FINAL DE LA PRIMERA COLUMNA -->
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
          <!-- Acordeón para SEGMENTO -->
          <div class="accordion" id="accordionSegments">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSegments">
                <button class="acord-perzon accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSegments" aria-expanded="true" aria-controls="collapseSegments">SEGMENTO</button>
              </h2>
              <div id="collapseSegments" class="accordion-collapse collapse show" aria-labelledby="headingSegments">
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
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
          <div class="cont-buscador">
            <div class="img-planificacion">
              <div class="top">Conoce nuestro portafolio</div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- ERICK END -->
  <div id="selected-categories"></div>
  <!-- <div class="container-clearFilters">
    <input type="checkbox" name="limpiar_filtros" id="limpiarFiltrosCheckbox" class="mi-radio-clear">
    <label for="limpiarFiltrosCheckbox">Limpiar filtros</label>
  </div> -->
  <div class="container-clearFilters">
    <button type="button" name="limpiar_filtros" id="limpiarFiltrosButton" class="mi-button-clear">Limpiar filtros</button>
  </div>




  <div class="buscador-productos">
    <div class="accordion" id="accordionExample">
      <table id="miTabla">
        <!-- UNO -->
        <tr>
          <td>
            <h2 class="accordion-header" id="headingOne">
              <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                CATEGORÍA
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
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
                  echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_categories" value="' . esc_attr($category_term->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name"> ' . esc_html($category_term->name) . '</h3></label>';

                  // Obtener hijos de la categoría de "category" actual
                  $category_children = get_terms(array(
                    'taxonomy'   => 'category',
                    'hide_empty' => false,
                    'parent'     => $category_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "category"
                  foreach ($category_children as $category_child) {
                    echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_categories" value="' . esc_attr($category_child->term_id) . '" class="mi-checkbox" class="mi-checkbox category_filter_input"><h3 class="mi-checkbox category_filter_name"> ' . esc_html($category_child->name) . '</h3></label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </td>
        </tr>
        <!-- DOS -->
        <tr>
          <td>
            <h2 class="accordion-header" id="headingOneTwo">
              <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                PRODUCTO FINAL
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <?php
                $product_final_terms = get_terms(array(
                  'taxonomy'   => 'product_final',
                  'hide_empty' => false,
                  'parent'     => 0,
                ));

                // Mostrar checkboxes para las categorías de "product_final"
                foreach ($product_final_terms as $product_final_term) {
                  echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_product_final" value="' . esc_attr($product_final_term->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($product_final_term->name) . '</h3></label>';


                  // Obtener hijos de la categoría de "product_final" actual
                  $product_final_children = get_terms(array(
                    'taxonomy'   => 'product_final',
                    'hide_empty' => false,
                    'parent'     => $product_final_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "product_final"
                  foreach ($product_final_children as $product_final_child) {
                    echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_product_final" value="' . esc_attr($product_final_child->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($product_final_child->name) . '</h3></label>';
                  }
                }
                ?>
              </div>
            </div>
          </td>
        </tr>
        <!-- TRES -->
        <tr>
          <td>
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                NECESIDAD TÉCNICA
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
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

                  echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_technical_need" value="' . esc_attr($technical_need_term->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($technical_need_term->name) . '</h3></label>';


                  // Obtener hijos de la categoría de "product_technicalneed" actual
                  $technical_need_children = get_terms(array(
                    'taxonomy'   => 'product_technicalneed',
                    'hide_empty' => false,
                    'parent'     => $technical_need_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "product_technicalneed"
                  foreach ($technical_need_children as $technical_need_child) {
                    echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_technical_need" value="' . esc_attr($technical_need_child->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($technical_need_child->name) . '</h3></label>';
                  }
                }
                ?>
              </div>
            </div>
          </td>
        </tr>

        <!-- CUATRO -->
        <tr>
          <td>
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                GRUPO FUNCIONAL
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
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
                  echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_functional_group" value="' . esc_attr($functional_group_term->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($functional_group_term->name) . '</h3></label>';

                  // Obtener hijos de la categoría de "functional_group" actual
                  $functional_group_children = get_terms(array(
                    'taxonomy'   => 'functional_group',
                    'hide_empty' => false,
                    'parent'     => $functional_group_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "functional_group"
                  foreach ($functional_group_children as $functional_group_child) {
                    echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_functional_group" value="' . esc_attr($functional_group_child->term_id) . '" class="mi-checkbox category_filter_input"><h3 category_filter_name>' . esc_html($functional_group_child->name) . '</h3></label><br>';
                  }
                }
                ?>
              </div>
            </div>
          </td>
        </tr>

        <!-- CINCO -->
        <tr>
          <td>
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                SUBGRUPO FUNCIONAL
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
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
                  echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_functional_subgroup" value="' . esc_attr($functional_subgroup_term->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($functional_subgroup_term->name) . '</h3></label>';

                  // Obtener hijos de la categoría de "functional_subgroup" actual
                  $functional_subgroup_children = get_terms(array(
                    'taxonomy'   => 'functional_subgroup',
                    'hide_empty' => false,
                    'parent'     => $functional_subgroup_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "functional_subgroup"
                  foreach ($functional_subgroup_children as $functional_subgroup_child) {
                    echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_functional_subgroup" value="' . esc_attr($functional_subgroup_child->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($functional_subgroup_child->name) . '</h3></label>';
                  }
                }
                ?>
              </div>
            </div>
          </td>
        </tr>

        <!-- SEIS -->
        <tr>
          <td>
            <h2 class="accordion-header" id="headingSix">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                MARCA MAGENTIS
              </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
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
                  echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_magentis_brand" value="' . esc_attr($magentis_brand_term->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($magentis_brand_term->name) . '</h3></label>';

                  // Obtener hijos de la categoría de "magentis_brand" actual
                  $magentis_brand_children = get_terms(array(
                    'taxonomy'   => 'magentis_brand',
                    'hide_empty' => false,
                    'parent'     => $magentis_brand_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "magentis_brand"
                  foreach ($magentis_brand_children as $magentis_brand_child) {
                    echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_magentis_brand" value="' . esc_attr($magentis_brand_child->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($magentis_brand_child->name) . '</h3></label>';
                  }
                }
                ?>
              </div>
            </div>
          </td>
        </tr>

        <tr>
          <td>
            <h2 class="accordion-header" id="headingSeven">
              <button class="accordion-button collapsed style-perzon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                DISTRIBUCIÓN
              </button>
            </h2>
            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven">
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
                  echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_distribucion" value="' . esc_attr($distribucion_term->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($distribucion_term->name) . '</h3></label>';

                  // Obtener hijos de la categoría de "distribucion" actual
                  $distribucion_children = get_terms(array(
                    'taxonomy'   => 'distribucion',
                    'hide_empty' => false,
                    'parent'     => $distribucion_term->term_id,
                  ));

                  // Mostrar checkboxes para los hijos de la categoría de "distribucion"
                  foreach ($distribucion_children as $distribucion_child) {
                    echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_distribucion" value="' . esc_attr($distribucion_child->term_id) . '" class="mi-checkbox category_filter_input"><h3 class="category_filter_name">' . esc_html($distribucion_child->name) . '</h3></label>';
                  }
                }
                ?>
              </div>
            </div>
          </td>
        </tr>
    </div>
    </table>
  </div>
  <div id="loader-container"></div>
  <div id="mi-contenedor-respose">
  </div>

</div>
<div class="magentis-pager" id="magentis-pager">&nbsp;</div>

<div class="buscador-productos-mb">
  <p>
    <button class="btn btn-primary button-filter accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      Filtros
    </button>
  </p>
  <div class="collapse" id="collapseExample">
    <div class="filtro-mb">

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
              echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_categories" value="' . esc_attr($category_term->term_id) . '" class="mi-checkbox"><h3> ' . esc_html($category_term->name) . '</h3></label><br>';

              // Obtener hijos de la categoría de "category" actual
              $category_children = get_terms(array(
                'taxonomy'   => 'category',
                'hide_empty' => false,
                'parent'     => $category_term->term_id,
              ));

              // Mostrar checkboxes para los hijos de la categoría de "category"
              foreach ($category_children as $category_child) {
                echo '<label class="checkeable-prueba""><input type="checkbox" name="filter_categories" value="' . esc_attr($category_child->term_id) . '" class="mi-checkbox"><h3> ' . esc_html($category_child->name) . '</h3></label><br>';
              }
            }
            ?>
          </div>
        </div>
      </div>

      <div class="accordion-item style-perzon">
        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
          <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
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
              echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_product_final" value="' . esc_attr($product_final_term->term_id) . '" class="mi-checkbox filter_product_final"><h3>' . esc_html($product_final_term->name) . '</h3></label><br>';

              // Obtener hijos de la categoría de "product_final" actual
              $product_final_children = get_terms(array(
                'taxonomy'   => 'product_final',
                'hide_empty' => false,
                'parent'     => $product_final_term->term_id,
              ));

              // Mostrar checkboxes para los hijos de la categoría de "product_final"
              foreach ($product_final_children as $product_final_child) {
                echo '<label class="checkeable-prueba" ><input type="checkbox" name="filter_product_final" value="' . esc_attr($product_final_child->term_id) . '" class="mi-checkbox filter_product_final"><h3>' . esc_html($product_final_child->name) . '</h3></label><br>';
              }
            }
            ?>
          </div>
        </div>
      </div>

      <div class="accordion-item style-perzon">
        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
          <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
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

              echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_technical_need" value="' . esc_attr($technical_need_term->term_id) . '" class="mi-checkbox"><h3>' . esc_html($technical_need_term->name) . '</h3></label><br>';


              // Obtener hijos de la categoría de "product_technicalneed" actual
              $technical_need_children = get_terms(array(
                'taxonomy'   => 'product_technicalneed',
                'hide_empty' => false,
                'parent'     => $technical_need_term->term_id,
              ));

              // Mostrar checkboxes para los hijos de la categoría de "product_technicalneed"
              foreach ($technical_need_children as $technical_need_child) {
                echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_technical_need" value="' . esc_attr($technical_need_child->term_id) . '" class="mi-checkbox"><h3>' . esc_html($technical_need_child->name) . '</h3></label><br>';
              }
            }
            ?>
          </div>
        </div>
      </div>

      <div class="accordion-item style-perzon">
        <h2 class="accordion-header" id="panelsStayOpen-headingFour">
          <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
            GRUPO FUNCIONAL
          </button>
        </h2>
        <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
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
              echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_functional_group" value="' . esc_attr($functional_group_term->term_id) . '" class="mi-checkbox"><h3>' . esc_html($functional_group_term->name) . '</h3></label><br>';

              // Obtener hijos de la categoría de "functional_group" actual
              $functional_group_children = get_terms(array(
                'taxonomy'   => 'functional_group',
                'hide_empty' => false,
                'parent'     => $functional_group_term->term_id,
              ));

              // Mostrar checkboxes para los hijos de la categoría de "functional_group"
              foreach ($functional_group_children as $functional_group_child) {
                echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_functional_group" value="' . esc_attr($functional_group_child->term_id) . '" class="mi-checkbox"><h3>' . esc_html($functional_group_child->name) . '</h3></label><br>';
              }
            }
            ?>
          </div>
        </div>
      </div>

      <div class="accordion-item style-perzon">
        <h2 class="accordion-header" id="panelsStayOpen-headingFive">
          <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
            SUBGRUPO FUNCIONAL
          </button>
        </h2>
        <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
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
              echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_functional_subgroup" value="' . esc_attr($functional_subgroup_term->term_id) . '" class="mi-checkbox"><h3>' . esc_html($functional_subgroup_term->name) . '</h3></label><br>';

              // Obtener hijos de la categoría de "functional_subgroup" actual
              $functional_subgroup_children = get_terms(array(
                'taxonomy'   => 'functional_subgroup',
                'hide_empty' => false,
                'parent'     => $functional_subgroup_term->term_id,
              ));

              // Mostrar checkboxes para los hijos de la categoría de "functional_subgroup"
              foreach ($functional_subgroup_children as $functional_subgroup_child) {
                echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_functional_subgroup" value="' . esc_attr($functional_subgroup_child->term_id) . '" class="mi-checkbox"><h3>' . esc_html($functional_subgroup_child->name) . '</h3></label><br>';
              }
            }
            ?>
          </div>
        </div>
      </div>

      <div class="accordion-item style-perzon">
        <h2 class="accordion-header" id="panelsStayOpen-headingSix">
          <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
            MARCA MAGENTIS
          </button>
        </h2>
        <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
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
              echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_magentis_brand" value="' . esc_attr($magentis_brand_term->term_id) . '" class="mi-checkbox"><h3>' . esc_html($magentis_brand_term->name) . '</h3></label><br>';

              // Obtener hijos de la categoría de "magentis_brand" actual
              $magentis_brand_children = get_terms(array(
                'taxonomy'   => 'magentis_brand',
                'hide_empty' => false,
                'parent'     => $magentis_brand_term->term_id,
              ));

              // Mostrar checkboxes para los hijos de la categoría de "magentis_brand"
              foreach ($magentis_brand_children as $magentis_brand_child) {
                echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_magentis_brand" value="' . esc_attr($magentis_brand_child->term_id) . '" class="mi-checkbox"><h3>' . esc_html($magentis_brand_child->name) . '</h3></label><br>';
              }
            }
            ?>
          </div>
        </div>
      </div>

      <div class="accordion-item style-perzon">
        <h2 class="accordion-header" id="panelsStayOpen-headingSeven">
          <button class="style-perzon accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">
            DISTRIBUCIÓN
          </button>
        </h2>
        <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
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
              echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_distribucion" value="' . esc_attr($distribucion_term->term_id) . '" class="mi-checkbox"><h3>' . esc_html($distribucion_term->name) . '</h3></label><br>';

              // Obtener hijos de la categoría de "distribucion" actual
              $distribucion_children = get_terms(array(
                'taxonomy'   => 'distribucion',
                'hide_empty' => false,
                'parent'     => $distribucion_term->term_id,
              ));

              // Mostrar checkboxes para los hijos de la categoría de "distribucion"
              foreach ($distribucion_children as $distribucion_child) {
                echo '<label class="checkeable-prueba"><input type="checkbox" name="filter_distribucion" value="' . esc_attr($distribucion_child->term_id) . '" class="mi-checkbox"><h3>' . esc_html($distribucion_child->name) . '</h3></label><br>';
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="loader-container">
    <div class="movil-magentis" id="mi-contenedor-respose-movil">


    </div>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php

//get_footer();
