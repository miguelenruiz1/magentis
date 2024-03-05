jQuery(document).ready(function ($) {
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
        categoryValues.forEach(function (categoryValue) {
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
              ' <span class="remove-category">x</span></div>'
          );
          $("#selected-categories").append(categoryItem);

          // Manejar el evento de clic para quitar la categoría
          categoryItem.find(".remove-category").on("click", function () {
            // Obtener el índice de la categoría seleccionada
            var indexToRemove =
              selectedCategories[propertyName].indexOf(categoryValue);

            // Deseleccionar la categoría al hacer clic en la 'x'
            if (indexToRemove > -1) {
              selectedCategories[propertyName].splice(indexToRemove, 1);

              // Obtener el valor del checkbox asociado con la categoría eliminada
              var checkboxValue = categoryValue; // Puedes ajustar esto según la estructura de tus datos

              // Deseleccionar el checkbox correspondiente
              $(
                'input[name="filter_' +
                  propertyName +
                  '"][value="' +
                  checkboxValue +
                  '"]'
              ).prop("checked", false);

              // Actualizar las categorías seleccionadas
              updateSelectedCategories(selectedCategories);

              // Llama a la función o código necesario para actualizar el contenido
              // después de desseleccionar la categoría
            }
          });
        });
      }
    }

    // Llama a la función o código necesario para actualizar el contenido
    // después de actualizar las categorías
  }

  // Manejador para el evento de cambio en los radios y checkboxes
  $("body").on("change", ".mi-radio, .mi-checkbox ", function () {
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
        .map(function () {
          return $(this).val();
        })
        .get(),
      product_for_sale: $('input[name="filter_product_for_sale"]:checked')
        .map(function () {
          return $(this).val();
        })
        .get(),
      technical_need: $('input[name="filter_technical_need"]:checked')
        .map(function () {
          return $(this).val();
        })
        .get(),
      functional_group: $('input[name="filter_functional_group"]:checked')
        .map(function () {
          return $(this).val();
        })
        .get(),
      functional_subgroup: $('input[name="filter_functional_subgroup"]:checked')
        .map(function () {
          return $(this).val();
        })
        .get(),
      magentis_brand: $('input[name="filter_magentis_brand"]:checked')
        .map(function () {
          return $(this).val();
        })
        .get(),
      distribucion: $('input[name="filter_distribucion"]:checked')
        .map(function () {
          return $(this).val();
        })
        .get(),
      product_final: $('input[name="filter_product_final"]:checked')
        .map(function () {
          return $(this).val();
        })
        .get(),
    };

    updateSelectedCategories(selectedCategories);
    showLoader();

    // Deshabilitar todos los elementos del menú
    // $('.mi-checkbox').prop('disabled', true);

    // Realizar la solicitud AJAX con todas las categorías seleccionadas
    var data = {
      action: "mi_accion_ajax",
      filter_categories: selectedCategories,
      posts_per_page: 50,
    };

    // Muestra el loader antes de la solicitud AJAX
    // showLoader();
    // Limpiar el contenedor antes de agregar nuevo contenido
    $("#mi-contenedor-respose").empty();
    $.ajax({
      type: "POST",
      url: mi_script_vars.ajaxurl,
      data: data,
      success: function (response) {
        showLoader();
        // Limpiar el contenedor antes de agregar nuevo contenido
        $("#mi-contenedor-respose").empty();
        // Comprobar si hay contenido en la respuesta
        if (response.length > 0) {
          var allCheckboxIds = getAllCheckboxIds();
          // console.log(response)
          // Iterar sobre cada elemento en la respuesta
          response.forEach(function (item) {
            // console.log("product", item.taxonomies);

            var combinedArray = [].concat(
              item.taxonomies.category,
              item.taxonomies.distribucion,
              item.taxonomies.functional_group,
              item.taxonomies.functional_subgroup,
              item.taxonomies.magentis_brand,
              item.taxonomies.product_final,
              item.taxonomies.product_for_sale,
              item.taxonomies.product_technicalneed
              // item.taxonomies.segment
            );
            // Crear elementos HTML y agregarlos al contenedor
            var postHtml = `<table id="paginador" style="width:100%"><tr
                      data-category="${item.taxonomies.category}"
                      data-distribucion="${item.taxonomies.distribucion}"
                      data-functional_group="${item.taxonomies.functional_group}"
                      data-functional_subgroup="${item.taxonomies.functional_subgroup}"
                      data-magentis_brand="${item.taxonomies.magentis_brand}"
                      data-product_final="${item.taxonomies.product_final}"
                      data-product_for_sale="${item.taxonomies.product_for_sale}"
                      data-product_technicalneed="${item.taxonomies.product_technicalneed}"
                      data-distribucion="${item.taxonomies.distribucion}"
                    >`;
            postHtml += '<td class="nombre" style="vertical-align:top">';
            postHtml += '<h3 class="text-nombre">' + item.title + "</h3>";
            postHtml += "</td>";
            postHtml +=
              '<td class="text-descripcion"><p>' + item.content + "</p>";
            postHtml += "</td>";
            postHtml += "</tr></table>";

            $("#mi-contenedor-respose").append(postHtml);
            $("#mi-contenedor-respose-movil").append(postHtml);

            var selectedSegmentRadio = $(
              'input[name="filter_categories_seg"]:checked'
            );
            // var labelText = selectedSegmentRadio.parent().next('label').text();
            var labelText = selectedSegmentRadio
              .closest("label")
              .find("h3")
              .text();

            // Obtener todas las filas visibles y sus atributos data-*
            var allDataValues = [];

            $("tr:visible").each(function () {
              var rowData = {};

              // Obtener todos los atributos data-* del elemento <tr>
              $.each(this.dataset, function (key, value) {
                rowData[key] = value.split(",").map(function (id) {
                  return parseInt(id, 10);
                });
              });

              allDataValues.push(rowData);
            });

            // Deshabilitar solo los checkboxes asociados a las filas visibles
            // $('.mi-checkbox').prop('disabled', true);

            // Obtener todos los IDs únicos presentes en los datos de filas visibles
            var uniqueIds = Array.from(
              new Set(
                allDataValues
                  .flatMap((rowData) => Object.values(rowData))
                  .flat()
              )
            );
            // console.log(uniqueIds)

            // Habilitar solo los checkboxes asociados a las filas visibles
            $(".mi-checkbox")
              .prop("disabled", true)
              .closest("label")
              .css("display", "none");

            // Obtener todos los checkboxes con la clase 'mi-checkbox'
            var checkboxes = $(".mi-checkbox");

            // Iterar sobre los checkboxes y habilitar solo los necesarios
            checkboxes.each(function () {
              var checkboxValue = parseInt($(this).val(), 10);
              if (uniqueIds.includes(checkboxValue)) {
                $(this)
                  .prop("disabled", false)
                  .closest("label")
                  .css("display", "block");
                // $('.checkeable-prueba input.mi-checkbox').closest('label').css('display', 'block');
              }
            });

            var selectedCountryCode = ""; // Variable para almacenar el código de país seleccionado por el usuario

            switch (selectedCategories.country) {
              case "10":
                selectedCountryCode = "CO";
                break;
              case "11":
                selectedCountryCode = "EC";
                break;
              case "12":
                selectedCountryCode = "PE";
                break;
              case "194":
                selectedCountryCode = "MX";
                break;
              // Agrega más casos según sea necesario
            }

            item.urlimg;

            // Crear el array combinado
            var combinedArray = [
              selectedCountryCode,
              selectedSegmentRadio.parent().text().trim(),
            ];
            // Variables para almacenar la URL de la imagen y el índice del elemento
            var imageUrl;
            var foundIndex = -1;

            var imageFound = false;
            // Iterar sobre el array dentro de item
            for (var i = 0; i < item.urlimg.length; i++) {
              var elemento = item.urlimg[i];

              // Verificar si los elementos están presentes en el array
              if (elemento.UA_Pais__c == selectedCountryCode) {
                if (combinedArray[1] == elemento.UA_AplicacionN1__c) {
                  imageUrl = elemento.UA_URLImagenes__c;
                  foundIndex = i;

                  $(".img-planificacion").css(
                    "background-image",
                    'url("' + imageUrl + '")'
                  );
                  $("div.top").text(
                    selectedSegmentRadio.parent().text().trim()
                  );

                  // Establecer la variable a true para indicar que se encontró la imagen
                  imageFound = true;
                  break; // Salir del bucle, ya que se encontró la imagen
                }
              }
            }

            // Verificar si se encontró la URL de la imagen
            if (imageUrl) {
              // console.log('La URL de la imagen es:', imageUrl);
              // console.log('El índice del elemento es:', foundIndex);
            } else {
              // console.log('No se encontró una URL de imagen para el país y segmento seleccionados.');
            }
          });

          // Inicializar DataTable en la tabla
          // $('#paginador').DataTable({
          //   // Configuración adicional según tus necesidades
          //   // Puedes ajustar las opciones según la documentación de DataTable
          //   paging: true,
          //   searching: false, // Deshabilitar la búsqueda si lo prefieres
          // });
        } else {
          $("#mi-contenedor-respose").html(
            "<p>No hay contenido disponible.</p>"
          );
        }
        response = "";
        hideLoader();
      },
      error: function (error) {
        console.log(error);
        hideLoader();
      },
    });
  });

  // Función para obtener las categorías seleccionadas
  function getSelectedCategories() {
    return $('input[name="filter_categories"]:checked')
      .map(function () {
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
    checkboxes.each(function () {
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
    var ids = idsArray.map(function (id) {
      return parseInt(id, 10);
    });

    $(".mi-checkbox").prop("disabled", true);
  }

  $("body").on("click", ".mi-button-clear", function () {
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
    $("#mi-contenedor-respose .text-nombre").each(function () {
      var elementText = $(this).text().toLowerCase();
      var highlightedText = getHighlightedText(
        elementText,
        searchTermLowerCase
      );
      $(this).html(highlightedText);
    });

    // Itera sobre los elementos y aplica la clase de resaltado a los que coinciden en la descripción
    $("#mi-contenedor-respose .text-descripcion").each(function () {
      var elementText = $(this).text().toLowerCase();
      var highlightedText = getHighlightedText(
        elementText,
        searchTermLowerCase
      );
      $(this).html(highlightedText);
    });

    // Ocultar o mostrar las filas según si contienen información coincidente
    $("#mi-contenedor-respose tr").each(function () {
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
  $(".container-1 #search").on("input", function () {
    var searchTerm = $(this).val();
    searchInDynamicElements(searchTerm);
  });

  //   orden de la tabla

  jQuery(document).ready(function ($) {
    $("select#ordenarTabla").change(function () {
      var orden = $(this).val(); // Obtener el valor seleccionado del select
      ordenarTabla(orden);
    });

    // Función para ordenar la respuesta AJAX
    function ordenarTabla(orden) {
      var $contenedor = $("#mi-contenedor-respose");
      var $items = $contenedor.children().toArray();

      $items.sort(function (a, b) {
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
  });
});
