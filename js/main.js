jQuery(document).ready(function($) {
    // Agregar la propiedad 'display: none' al label con la clase 'checkeable-prueba'
    // $('.checkeable-prueba input.mi-checkbox').closest('label').css('display', 'none');

    $("#mi-contenedor-respose").empty();
    var body = $("body");
    var miContenedorResponse = $("#mi-contenedor-respose");
    var miCheckbox = $(".mi-checkbox");

    // Función para actualizar las categorías seleccionadas en la parte superior
    function updateSelectedCategories(selectedCategories) {
        // console.log(selectedCategories)
        // Limpiar el contenedor antes de agregar las nuevas categorías seleccionadas
        $("#selected-categories").empty();

        // Iterar sobre las propiedades de categorías y agregarlas al contenedor
        for (const propertyName in selectedCategories) {
            if (
                selectedCategories.hasOwnProperty(propertyName) &&
                Array.isArray(selectedCategories[propertyName])
            ) {
                const categoryValues = selectedCategories[propertyName];

                // Iterar sobre los valores de la categoría y agregarlos al contenedor
                categoryValues.forEach(function(categoryValue) {
                    // Convertir el objeto a cadena de texto si es un objeto
                    if (typeof categoryValue === "object") {
                        categoryValue = JSON.stringify(categoryValue);
                    }

                    var text = $(
                        'label.checkeable-prueba input.mi-checkbox[value="' +
                        categoryValue +
                        '"] + h3:first'
                    ).text();
                    var categoryItem = $(
                        '<div class="selected-category">' +
                        text +
                        ' <span class="remove-category" data-category-id="'+categoryValue+'">x</span></div>'
                    );
                    $("#selected-categories").append(categoryItem);
                });
            }
        }

        // Llama a la función o código necesario para actualizar el contenido
        // después de actualizar las categorías
    }

    // Manejador para el evento de cambio en los radios y checkboxes
    var search_in_text = false;
    var search_text = '';

    $("body").on("click", ".remove-category", function(){
        console.log('Called');
        index_deselect = $(this).attr("data-category-id");
        let cat_id = "segment_category_id_"+ index_deselect;
        console.log(cat_id);
        $('#'+cat_id).prop('checked', false);
        handleEvents();
    });

    let lastInputMethod = '';

    $('#search').on('keydown', function(e) {
        lastInputMethod = '';
        if (e.keyCode == 8) {
            lastInputMethod = 'keyboard';
        }
    });

    $('#search').on('input', function() {
        if ($(this).val() == '') {
            if (lastInputMethod != 'keyboard') {
                handleEvents();
            }
        }
    });


    $("body").on("change", ".mi-radio, .mi-checkbox", handleEvents)
             .on("click", ".pagina", handleEvents);
    $('#search').keyup(function(e){
        if(e.keyCode == 13)
        {
            console.log()
            if($(this).val()!='' && $(this).val().length > 3 ){
                search_in_text = true;
                handleEvents();
            } else {

            }
        }
    });

    $('.search_button').on('click', function(e){
        search_in_text = true;
        handleEvents();
    });
    $('.search_len').on('click', function(e){
        search_in_text = true;
        handleEvents();
    });

    $('#ordenarTabla_1').change(() => {
        handleEvents();
    });
    function handleEvents(event) {
        $('#ordenarTabla_1').prop('disabled', false);
        var pageNumber = 0;
        if (typeof search_in_text !== 'undefined' && search_in_text === true) {
            search_text = $('#search').val();
            search_in_text = false;
        } else if (event && $(event.target).hasClass('pagina')) {
            pageNumber = $(event.target).attr('page_number');
        }

        if (
            $(this).attr("name") === "filter_categories_seg" ||
            $(this).attr("name") === "limpiar_filtros"
        ) {
            // Obtener el valor seleccionado del radio 'segment'
            var selectedSegment = $(
                'input[name="filter_categories_seg"]:checked'
            ).val();

            // Limpiar todos los filtros excepto el 'segment'
            // clearFilters('filter_countries');
            clearFilters("filter_categories");
            clearFilters("filter_product_for_sale");
            clearFilters("filter_technical_need");
            clearFilters("filter_functional_group");
            clearFilters("filter_functional_subgroup");
            clearFilters("filter_magentis_brand");
            clearFilters("filter_distribucion");
            clearFilters("filter_product_final");

            if ($("#limpiarFiltrosCheckbox").is(":checked")) {
                $("#selected-categories").html("");
            }
        }

        function clearFilters(filterName) {
            // Limpiar los filtros excepto el 'segment'
            if (filterName !== "filter_categories_seg") {
                $('input[name="' + filterName + '"]').prop("checked", false);
            }
        }
        // Obtener todas las categorías seleccionadas
        var selectedCategories = {
            country: $('input[name="filter_countries"]:checked').val(),
            segment: $('input[name="filter_categories_seg"]:checked').val(),
            category: $('input[name="filter_categories"]:checked')
                .map(function() {
                    return $(this).val();
                })
                .get(),
            product_for_sale: $('input[name="filter_product_for_sale"]:checked')
                .map(function() {
                    return $(this).val();
                })
                .get(),
            technical_need: $('input[name="filter_technical_need"]:checked')
                .map(function() {
                    return $(this).val();
                })
                .get(),
            functional_group: $('input[name="filter_functional_group"]:checked')
                .map(function() {
                    return $(this).val();
                })
                .get(),
            functional_subgroup: $('input[name="filter_functional_subgroup"]:checked')
                .map(function() {
                    return $(this).val();
                })
                .get(),
            magentis_brand: $('input[name="filter_magentis_brand"]:checked')
                .map(function() {
                    return $(this).val();
                })
                .get(),
            distribucion: $('input[name="filter_distribucion"]:checked')
                .map(function() {
                    return $(this).val();
                })
                .get(),
            product_final: $('input[name="filter_product_final"]:checked')
                .map(function() {
                    return $(this).val();
                })
                .get(),
        };

        updateSelectedCategories(selectedCategories);
        showLoader();
        // Deshabilitar todos los elementos del menú
        // $('.mi-checkbox').prop('disabled', true);

        let order = $('#ordenarTabla_1').val();

        // Realizar la solicitud AJAX con todas las categorías seleccionadas
        var data = {
            action: "mi_accion_ajax",
            filter_categories: selectedCategories,
            posts_per_page: 10,
            page: pageNumber,
            search: search_text,
            order: order
        };

        // Muestra el loader antes de la solicitud AJAX
        // showLoader();
        // Limpiar el contenedor antes de agregar nuevo contenido
        $("#mi-contenedor-respose").empty();
        console.log('This is the data');
        console.log(data);
        $.ajax({
            type: "POST",
            url: mi_script_vars.ajaxurl,
            data: data,
            success: function(response) {
                showLoader(); // Asegúrate de que esta función maneje la visualización de algún tipo de indicador de carga
                //console.log(response.clean_sql);
                //console.log(response.taxonomies_sql);
                //console.log(response.count_sql);
                //console.log(response.pagination_info.total_items);
                //console.log(response.images);

                var countrySelected = $('input[name="filter_countries"]:checked').length > 0;
                var segmentSelected = $('input[name="filter_categories_seg"]:checked').length > 0;

                // Si ambos, país y segmento, están seleccionados, procede a habilitar y mostrar solo los checkboxes relevantes
                if (countrySelected && segmentSelected) {

                    // Actualización de la paginación
                    updatePagination(response.pagination_info.total_items, data.page);
                    updateCheckboxes(response.taxonomies_info);
                    updateImageBasedOnSelections(response.images);
                    // Limpieza del contenedor antes de agregar nuevo contenido
                    $("#mi-contenedor-respose").empty();
                    $("#mi-contenedor-respose-movil").empty();

                    // Verificación y manejo de productos
                    console.log(response.products);
                    if (response.products && (response.products.length !== 0) ) {
                        response.products.forEach((item) => renderProduct(item));
                        response.products.forEach((item) => renderProductSmall(item));
                    } else {
                        $("#mi-contenedor-respose").html("<p class=\"result_msge\">No hay resultados disponibles.</p>");
                        $("#mi-contenedor-respose-movil").html("<p class=\"result_msge\">No hay resultados disponibles.</p>");
                    }
                } else {

                }

                hideLoader(); // Ocultar el indicador de carga
                if(pageNumber>0){
                    var elementPosition = $("#limpiarFiltrosButton").position();
                    $("html, body").animate({ scrollTop: elementPosition.top }, 500);
                }
            },
            error: function(error) {
                console.error("Error AJAX:", error);
                hideLoader(); // Asegúrate de ocultar el indicador de carga incluso en caso de error
            },
        });
    }

    function updateImageBasedOnSelections(imagesArray) {
        var countryCodes = {
            "México": "MX",
            "Ecuador": "EC",
            "Perú": "PE",
            "Colombia": "CO"
        };

        var selectedCountryText = $('input[name="filter_countries"]:checked').parent().text().trim();
        var selectedSegmentText = $('input[name="filter_categories_seg"]:checked').closest('label').text().trim();
        var selectedCountryCode = countryCodes[selectedCountryText];

        var foundImage = imagesArray.find(function(image) {
            return image.pais === selectedCountryCode && image.segmento === selectedSegmentText;
        });

        if (foundImage) {
            // Anima la opacidad a 0 antes de cambiar la imagen
            $('.img-planificacion').animate({ opacity: 0.1 }, 500, function() {
                // Cambia la imagen de fondo
                var img = new Image();
                img.onload = function() {
                    $('.img-planificacion').css('background-image', 'url("' + img.src + '")');
                    // Anima la opacidad de vuelta a 1 después de cambiar la imagen
                    $('.img-planificacion').animate({ opacity: 1 }, 500);
                };
                img.src = foundImage.urlImagen;
                $("div.top").text(selectedSegmentText.trim());
            });
        }
    }




    function updatePagination(totalItems, currentPage) {
        currentPage = (currentPage == 0) ? 1 : currentPage;
        console.log(currentPage);

        let page_content = '<ul class="ul-pages">';
        let total_pages = Math.ceil(totalItems/20);
        for (let i = 1; i <= total_pages; i++) {
            let selected = i == currentPage ? 'page_selected' : 'pagina';
            page_content += `<li class="${selected}" page_number="${i}">${i}</li>`;
        }
        page_content += '</ul>';
        $('#magentis-pager').html(page_content);
        $('#magentis-pager-small').html(page_content);
    }

    function renderProduct(item) {
        const postHtml = `<table id="paginador" class="results_mini_table" style="width:100%"><tr
            data-category="${item.taxonomies.category.join(',')}"
            data-distribucion="${item.taxonomies.distribucion.join(',')}"
            data-functional_group="${item.taxonomies.functional_group.join(',')}"
            data-functional_subgroup="${item.taxonomies.functional_subgroup.join(',')}"
            data-magentis_brand="${item.taxonomies.magentis_brand.join(',')}"
            data-product_final="${item.taxonomies.product_final.join(',')}"
            data-product_for_sale="${item.taxonomies.product_for_sale.join(',')}"
            data-product_technicalneed="${item.taxonomies.product_technicalneed.join(',')}"
            data-distribucion="${item.taxonomies.distribucion.join(',')}">
            <td class="nombre" style="vertical-align:top">
                <h3 class="text-nombre">${item.title}</h3>
            </td>
            <td class="text-descripcion"><p>${item.content}</p></td>
        </tr></table>`;

        // Agregar el HTML construido al contenedor
        $("#mi-contenedor-respose").append(postHtml);
    }

    function renderProductSmall(item) {
        const postHtml = `<table id="paginador" style="width:100%"><tr
            data-category="${item.taxonomies.category.join(',')}"
            data-distribucion="${item.taxonomies.distribucion.join(',')}"
            data-functional_group="${item.taxonomies.functional_group.join(',')}"
            data-functional_subgroup="${item.taxonomies.functional_subgroup.join(',')}"
            data-magentis_brand="${item.taxonomies.magentis_brand.join(',')}"
            data-product_final="${item.taxonomies.product_final.join(',')}"
            data-product_for_sale="${item.taxonomies.product_for_sale.join(',')}"
            data-product_technicalneed="${item.taxonomies.product_technicalneed.join(',')}"
            data-distribucion="${item.taxonomies.distribucion.join(',')}">
            <td class="nombre" style="vertical-align:top">
                <h3 class="text-nombre">${item.title}</h3>
            </td>
            </tr>
            <tr>
            <td class="text-descripcion"><p>${item.content}</p></td>
        </tr></table>`;
        $("#mi-contenedor-respose-movil").append(postHtml);
    }

    function updateCheckboxes(taxonomies_info) {
        console.log("------------------");
        console.log("Taxonomies Info");
        console.log(JSON.stringify(taxonomies_info));
        console.log("------------------");

        // Primero, deshabilita todos los checkboxes y oculta sus etiquetas
        $(".mi-checkbox").prop("disabled", true).closest("label").css("display", "none");

        // Verifica si hay un país y un segmento seleccionados
        var countrySelected = $('input[name="filter_countries"]:checked').length > 0;
        var segmentSelected = $('input[name="filter_categories_seg"]:checked').length > 0;

        // Si ambos, país y segmento, están seleccionados, procede a habilitar y mostrar solo los checkboxes relevantes
        if (countrySelected && segmentSelected) {
            Object.keys(taxonomies_info).forEach((taxonomy) => {
                taxonomies_info[taxonomy].forEach((termId) => {
                    $(`input.mi-checkbox[value='${termId}']`)
                        .prop("disabled", false)
                        .closest("label")
                        .css("display", "inline-flex");
                });
            });
        }
    }


    // Función para obtener las categorías seleccionadas
    function getSelectedCategories() {
        return $('input[name="filter_categories"]:checked')
            .map(function() {
                return $(this).val();
            })
            .get();
    }

    // Función para deseleccionar una categoría
    function deselectCategory(category) {
        // Buscar la categoría en los checkboxes y deseleccionarla
        $('input[name="filter_categories"][value="' + category + '"]').prop(
            "checked",
            false
        );
    }

    // Función para mostrar el loader
    function showLoader() {
        // Verifica si el loader ya está presente

        // Agrega el código para mostrar el loader en el contenedor deseado
        var loaderHtml = '<div class="loader">Cargando...</div>';
        $("#loader-container").html(loaderHtml).show();
    }

    // Función para ocultar el loader
    function hideLoader() {
        // Oculta el contenedor del loader
        $("#loader-container").hide();
    }

    function getAllCheckboxIds() {
        // Array para almacenar todos los IDs de los checkboxes
        var allCheckboxIds = [];

        // Seleccionar todos los checkboxes con la clase 'mi-checkbox'
        var checkboxes = $(".mi-checkbox");

        // Iterar sobre los checkboxes y agregar los IDs al array
        checkboxes.each(function() {
            allCheckboxIds.push($(this).val());
        });

        // Devolver el array de IDs como resultado
        return allCheckboxIds;
    }

    function enableCheckboxesByValuesAndClass() {
        // Deshabilitar todos los checkboxes con la clase específica

        // Obtener el valor del atributo data-category
        var dataCategoryValues = $("tr[data-category]").data("category");

        // Dividir la cadena en una matriz de IDs
        var idsArray = dataCategoryValues.split(",");

        // Convertir los valores de la matriz a números enteros
        var ids = idsArray.map(function(id) {
            return parseInt(id, 10);
        });

        $(".mi-checkbox").prop("disabled", true);
    }

    $("body").on("click", ".mi-button-clear", function() {
        // Recargar la página
        location.reload();
    });

    // Función para buscar en elementos dinámicamente agregados
    function searchInDynamicElements(searchTerm) {
        // Obtener el término de búsqueda en minúsculas para una comparación insensible a mayúsculas
        var searchTermLowerCase = searchTerm.toLowerCase();

        // Remueve la clase de resaltado de todos los elementos
        $("#mi-contenedor-respose .nombre").removeClass("highlight");
        $("#mi-contenedor-respose .text-descripcion").removeClass("highlight");

        // Si el término de búsqueda está vacío, muestra todos los elementos y termina la función
        if (searchTerm === "") {
            $("#mi-contenedor-respose tr").show();
            return;
        }

        // Itera sobre los elementos y aplica la clase de resaltado a los que coinciden en el nombre
        $("#mi-contenedor-respose .text-nombre").each(function() {
            var elementText = $(this).text().toLowerCase();
            var highlightedText = getHighlightedText(
                elementText,
                searchTermLowerCase
            );
            $(this).html(highlightedText);
        });

        // Itera sobre los elementos y aplica la clase de resaltado a los que coinciden en la descripción
        $("#mi-contenedor-respose .text-descripcion").each(function() {
            var elementText = $(this).text().toLowerCase();
            var highlightedText = getHighlightedText(
                elementText,
                searchTermLowerCase
            );
            $(this).html(highlightedText);
        });

        // Ocultar o mostrar las filas según si contienen información coincidente
        $("#mi-contenedor-respose tr").each(function() {
            var hasMatchingContent = $(this).find(".highlight").length > 0;

            if (hasMatchingContent) {
                $(this).show(); // Muestra las filas que tienen información coincidente
            } else {
                $(this).hide(); // Oculta las filas que no tienen información coincidente
            }
        });

        // Mostrar el mensaje de "No hay más contenido" si no hay filas coincidentes
        var hasMatchingRows = $("#mi-contenedor-respose tr:visible").length > 0;

        if (!hasMatchingRows) {
            $("#no-content-message").show(); // Mostrar el mensaje
        } else {
            $("#no-content-message").hide(); // Ocultar el mensaje
        }
        // $('#mi-contenedor-respose').html('<p>No hay contenido disponible  </p>');
    }

    // Función para obtener el texto resaltado
    function getHighlightedText(text, searchTerm) {
        var startIndex = text.indexOf(searchTerm);
        if (startIndex !== -1) {
            var endIndex = startIndex + searchTerm.length;
            var highlightedText =
                text.substring(0, startIndex) +
                '<span class="highlight">' +
                text.substring(startIndex, endIndex) +
                "</span>" +
                text.substring(endIndex);
            return highlightedText;
        } else {
            return text;
        }
    }

    // Manejar la entrada en el campo de búsqueda
    $(".container-1 #search").on("input", function() {
        var searchTerm = $(this).val();
        //searchInDynamicElements(searchTerm);
    });

    //   orden de la tabla

    jQuery(document).ready(function($) {
        $("select#ordenarTabla").change(function() {
            var orden = $(this).val(); // Obtener el valor seleccionado del select
            //ordenarTabla(orden);
        });

        // Función para ordenar la respuesta AJAX
        function ordenarTabla(orden) {
            var $contenedor = $("#mi-contenedor-respose");
            var $items = $contenedor.children().toArray();

            $items.sort(function(a, b) {
                var keyA = $(a).text().toUpperCase();
                var keyB = $(b).text().toUpperCase();

                if (orden === "asc") {
                    return keyA > keyB ? 1 : -1;
                } else {
                    return keyA < keyB ? 1 : -1;
                }
            });

            $contenedor.empty().append($items);
        }

        $('#volver_arriba').on('click', function(e){
            e.preventDefault();
            var elementPosition = $("#accordionCountries").position();
            $("html, body").animate({ scrollTop: elementPosition.top }, 500);
        });
        $('#volver_arriba_small').on('click', function(e){
            e.preventDefault();
            var elementPosition = $("#accordionCountries").position();
            $("html, body").animate({ scrollTop: elementPosition.top }, 500);
        });
    });

    current_page = 0;

    // Inicialmente deshabilitar todos los checkboxes de taxonomías
    $("input.mi-checkbox").prop("disabled", true);

});
