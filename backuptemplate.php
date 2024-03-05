<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Bootstrap JS y Dependencias Popper.js y jQuery (si no las tienes ya) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>

<body>
    <div class="wrap">
        <div id="mi-contenedor">
            <form method="post" action="">
                <!-- Países (Radio) -->
                <div class="accordion" id="accordionCountries">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCountries">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCountries" aria-expanded="true" aria-controls="collapseCountries">
                                Países
                            </button>
                        </h2>
                        <div id="collapseCountries" class="accordion-collapse collapse show" aria-labelledby="headingCountries" data-bs-parent="#accordionCountries">
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
                </div>

                <!-- Segmentos (Radio) -->
                <div class="accordion" id="accordionSegments">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSegments">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSegments" aria-expanded="false" aria-controls="collapseSegments">
                                Segmentos
                            </button>
                        </h2>
                        <div id="collapseSegments" class="accordion-collapse collapse" aria-labelledby="headingSegments" data-bs-parent="#accordionSegments">
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



                <!-- Categorías (Checkbox) -->
                <div class="accordion" id="accordionCategories">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCategories">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false" aria-controls="collapseCategories">
                                Categorías
                            </button>
                        </h2>
                        <div id="collapseCategories" class="accordion-collapse collapse" aria-labelledby="headingCategories" data-bs-parent="#accordionCategories">
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
                </div>


                <!-- Productos en Venta (Checkbox) -->
                <div class="accordion" id="accordionProductForSale">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProductForSale">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductForSale" aria-expanded="false" aria-controls="collapseProductForSale">
                                Productos en Venta
                            </button>
                        </h2>
                        <div id="collapseProductForSale" class="accordion-collapse collapse" aria-labelledby="headingProductForSale" data-bs-parent="#accordionProductForSale">
                            <div class="accordion-body">
                                <!-- Contenido del acordeón para Productos en Venta -->
                                <?php
                                // Obtener todas las categorías para "product_for_sale"
                                $product_for_sale_terms = get_terms(array(
                                    'taxonomy'   => 'product_for_sale',
                                    'hide_empty' => false,
                                    'parent'     => 0,
                                ));

                                // Mostrar checkboxes para las categorías de "product_for_sale"
                                foreach ($product_for_sale_terms as $product_for_sale_term) {
                                    echo '<label><input type="checkbox" name="filter_product_for_sale" value="' . esc_attr($product_for_sale_term->term_id) . '" class="mi-checkbox"> ' . esc_html($product_for_sale_term->name) . '</label><br>';

                                    // Obtener hijos de la categoría de "product_for_sale" actual
                                    $product_for_sale_children = get_terms(array(
                                        'taxonomy'   => 'product_for_sale',
                                        'hide_empty' => false,
                                        'parent'     => $product_for_sale_term->term_id,
                                    ));

                                    // Mostrar checkboxes para los hijos de la categoría de "product_for_sale"
                                    foreach ($product_for_sale_children as $product_for_sale_child) {
                                        echo '<label style="margin-left: 20px;"><input type="checkbox" name="filter_product_for_sale" value="' . esc_attr($product_for_sale_child->term_id) . '" class="mi-checkbox"> ' . esc_html($product_for_sale_child->name) . '</label><br>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Necesidades Técnicas del Producto (Checkbox) -->
                <div class="accordion" id="accordionTechnicalNeed">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTechnicalNeed">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTechnicalNeed" aria-expanded="false" aria-controls="collapseTechnicalNeed">
                                Necesidades Técnicas del Producto
                            </button>
                        </h2>
                        <div id="collapseTechnicalNeed" class="accordion-collapse collapse" aria-labelledby="headingTechnicalNeed" data-bs-parent="#accordionTechnicalNeed">
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
                </div>


                <!-- Grupo Funcional (Checkbox) -->
                <div class="accordion" id="accordionFunctionalGroup">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFunctionalGroup">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFunctionalGroup" aria-expanded="false" aria-controls="collapseFunctionalGroup">
                                Grupo Funcional
                            </button>
                        </h2>
                        <div id="collapseFunctionalGroup" class="accordion-collapse collapse" aria-labelledby="headingFunctionalGroup" data-bs-parent="#accordionFunctionalGroup">
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
                </div>

                <!-- Subgrupo Funcional (Checkbox) -->
                <div class="accordion" id="accordionFunctionalSubgroup">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFunctionalSubgroup">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFunctionalSubgroup" aria-expanded="false" aria-controls="collapseFunctionalSubgroup">
                                Subgrupo Funcional
                            </button>
                        </h2>
                        <div id="collapseFunctionalSubgroup" class="accordion-collapse collapse" aria-labelledby="headingFunctionalSubgroup" data-bs-parent="#accordionFunctionalSubgroup">
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
                </div>


                <!-- Marca Magentis (Checkbox) -->
                <div class="accordion" id="accordionMagentisBrand">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingMagentisBrand">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMagentisBrand" aria-expanded="false" aria-controls="collapseMagentisBrand">
                                Marca Magentis
                            </button>
                        </h2>
                        <div id="collapseMagentisBrand" class="accordion-collapse collapse" aria-labelledby="headingMagentisBrand" data-bs-parent="#accordionMagentisBrand">
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
                </div>


                <!-- Distribución (Checkbox) -->
                <div class="accordion" id="accordionDistribucion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDistribucion">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDistribucion" aria-expanded="false" aria-controls="collapseDistribucion">
                                Distribución
                            </button>
                        </h2>
                        <div id="collapseDistribucion" class="accordion-collapse collapse" aria-labelledby="headingDistribucion" data-bs-parent="#accordionDistribucion">
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

                <!-- Product Final (Checkbox) -->
                <div class="accordion" id="accordionProductFinal">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProductFinal">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductFinal" aria-expanded="false" aria-controls="collapseProductFinal">
                                Producto Final
                            </button>
                        </h2>
                        <div id="collapseProductFinal" class="accordion-collapse collapse" aria-labelledby="headingProductFinal" data-bs-parent="#accordionProductFinal">
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
                </div>





            </form>
        </div>
        <div id="mi-contenedor-respose">
        </div>
    </div>
    <!-- ... Tu código HTML existente ... -->

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
                                console.log(item.taxonomies)

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
                                var postHtml = '<div class="post">';
                                postHtml += '<h3>' + item.title + '</h3>';
                                postHtml += '<div class="content">' + item.content + '</div>';
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


    <!-- ... Tu código HTML existente ... -->

</body>

</html>