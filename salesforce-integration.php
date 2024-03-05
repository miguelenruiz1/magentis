<?php


// Incluye el archivo de configuración


// Función para obtener y almacenar el token
function obtener_y_almacenar_token()
{
    $token_url = 'https://login.salesforce.com/services/oauth2/token';
    $credentials  = [
        'grant_type' => 'password',
        'client_id' => '3MVG9szVa2RxsqBYEDDTYr4eCa87htJlTRixa_8V5jHIJ1auPf61U7a02s4k6ZiIWJB1vTKlVgWkzkzzT4j8T',
        'client_secret' => '2ECB121AAF812EE46F235BA07D5FA5EF00D198698927A102E20850E4693E743F',
        'username' => 'terceros.apisdisan@disan.com.co',
        'password' => 'T3rc3r05D154nAP20BvBVx1hA9cftut45TeWO2q8I',
    ];

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($credentials));

    $response = curl_exec($ch);

    if ($response === false) {
        // Maneja el error adecuadamente
        error_log('Error cURL: ' . curl_error($ch));
        return null; // Retorna null en caso de error
    }

    $body = json_decode($response, true);

    // Verifica si 'created' está presente en el array antes de intentar acceder a él
    if (isset($body['created'])) {
        // Almacena el token en la base de datos o donde lo requieras
        update_option('salesforce_access_token', $body['access_token']);
    } else {
        // Maneja el caso donde 'created' no está presente en la respuesta
        error_log('La clave "created" no está presente en la respuesta JSON.');
    }

    curl_close($ch);

    return $body;
}



// Función para obtener el token existente o uno nuevo si es necesario
function obtener_o_actualizar_token()
{
    // Intenta obtener el token almacenado
    $existing_token = get_option('salesforce_access_token');

    // Si no hay un token existente o está vencido, obtén uno nuevo
    if (empty($existing_token) || token_expirado($existing_token)) {
        return obtener_y_almacenar_token();
    }

    return $existing_token;
}

// Función para verificar si un token ha expirado
function token_expirado($token = null)
{
    // Verifica si el token es nulo o no contiene la clave 'created'
    if (empty($token) || !isset($token['created'])) {
        return true; // Tratamos un token nulo o incompleto como expirado
    }

    // Agrega lógica para verificar la expiración del token según tus necesidades
    // En este ejemplo, asumimos que el token expira después de 1 hora (3600 segundos)
    $expiration_time = $token['created'] + 3600;
    return current_time('timestamp') > $expiration_time;
}



// Función para consultar información con el token
function consultar_informacion_con_token($nextRecordsUrl = null)
{

    
    $access_token = obtener_o_actualizar_token();

    //$url_request = 'https://disanlatinoamerica.my.salesforce.com/services/data/v58.0/query?q=+select+CNT_Producto_PLATON__r.UA_Paises_Portafolio__c%2CCNT_Producto_PLATON__r.UA_Tipo_de_Producto__c%2CCNT_Producto_PLATON__r.Name%2CCNT_Producto_PLATON__r.UA_Grupo_Productos_N2__c%2CCNT_Producto_PLATON__r.UA_Grupo_Productos_N3__c%2CCNT_Producto_PLATON__r.UA_Familia_Marcaria__c%2CCNT_Producto_PLATON__r.UA_Distribucion__c%2CCNT_Producto_PLATON__r.UA_Descripcion_Prod_PLATON__c%2CCNT_Producto_PLATON__r.UA_Activo__c%2CUA_Aplicacion_N1__c%2CUA_Aplicacion_N2__c%2CUA_Aplicacion_N3__c%2CUA_Necesidades__c+from+CNT_Aplicaciones_por_Producto_PLATON__c+where+RecordTypeId%3D%270126T000001cqaDQAQ%27+and+CNT_Producto_PLATON__r.UA_Activo__c%21%3Dfalse';
    // Define la URL de la solicitud, considerando la paginación si se proporciona la URL siguiente
    $url_request = $nextRecordsUrl ? $nextRecordsUrl : 'https://disanlatinoamerica.my.salesforce.com/services/data/v58.0/query?q=+select+CNT_Producto_PLATON__r.UA_Paises_Portafolio__c%2CCNT_Producto_PLATON__r.UA_Tipo_de_Producto__c%2CCNT_Producto_PLATON__r.Name%2CCNT_Producto_PLATON__r.UA_Grupo_Productos_N2__c%2CCNT_Producto_PLATON__r.UA_Grupo_Productos_N3__c%2CCNT_Producto_PLATON__r.UA_Familia_Marcaria__c%2CCNT_Producto_PLATON__r.UA_Distribucion__c%2CCNT_Producto_PLATON__r.UA_Descripcion_Prod_PLATON__c%2CCNT_Producto_PLATON__r.UA_Activo__c%2CUA_Aplicacion_N1__c%2CUA_Aplicacion_N2__c%2CUA_Aplicacion_N3__c%2CUA_Necesidades__c+from+CNT_Aplicaciones_por_Producto_PLATON__c+where+RecordTypeId%3D%270126T000001cqaDQAQ%27+and+CNT_Producto_PLATON__r.UA_Activo__c%21%3Dfalse';
    $curl = curl_init();
    
  
    curl_setopt_array($curl, array(
        CURLOPT_URL =>   $url_request,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => array('password' => '4Kji2SMJVhaSjKcZe7IpeR5754Kji2SMJVhaSjKcZe7IpeR575', 'username' => 'terceros.apisdisan@disan.com.co', 'client_secret' => '2ECB121AAF812EE46F235BA07D5FA5EF00D198698927A102E20850E4693E743F', 'client_id' => '3MVG9szVa2RxsqBYEDDTYr4eCa87htJlTRixa_8V5jHIJ1auPf61U7a02s4k6ZiIWJB1vTKlVgWkzkzzT4j8T', 'grant_type' => 'password'),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $access_token['access_token'],
            'Cookie: BrowserId=u6iJe6MnEe261nucBDbXNA; CookieConsentPolicy=0:1; LSKey-c$CookieConsentPolicy=0:1'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $data = json_decode($response, true);
    // var_dump($access_token['access_token']);
    // Cierra la sesión cURL
    // Manejar paginación si hay más registros
    if (!empty($data['done']) && !$data['done'] && !empty($data['nextRecordsUrl'])) {
        // Concatenar los resultados de la próxima página
        $next_data = consultar_informacion_con_token($data['nextRecordsUrl']);
        $data['records'] = array_merge($data['records'], $next_data['records']);
    }


    return $data;
}


// Función para obtener la información de los países con token
function obtener_imagenes_paises_con_token()
{
    $access_token = obtener_o_actualizar_token();

    $url_request = 'https://disanlatinoamerica.my.salesforce.com/services/data/v58.0/query?q=select+UA_AplicacionN1__c%2CUA_Pais__c%2CUA_URLImagenes__c+from+UA_AdministracionImagenesPLATON__c';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL =>   $url_request,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $access_token['access_token'],
            'Cookie: BrowserId=u6iJe6MnEe261nucBDbXNA; CookieConsentPolicy=0:1; LSKey-c$CookieConsentPolicy=0:1'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $data = json_decode($response, true);
    // Guardar la data en un archivo JSON
    $json_data = json_encode($data, JSON_PRETTY_PRINT);

    // Obtener la ruta del directorio del plugin y concatenar la carpeta específica
    $plugin_dir = plugin_dir_path(__FILE__);
    $save_path = $plugin_dir . 'imgsalesforce/';

    // Verificar si la carpeta imgsalesforce existe, si no, crearla
    if (!file_exists($save_path)) {
        mkdir($save_path, 0755, true);
    }

    // Concatenar el nombre del archivo al path
    $file_path = $save_path . 'imgsalesforce.json';

    // Guardar el archivo JSON
    file_put_contents($file_path, $json_data);

    return $data;
}


function registrar_tipo_catalogo()
{
    $args = array(
        'public' => true,
        'label'  => 'Catálogo',  // Nombre del tipo de publicación
        'supports' => array('title', 'editor', 'thumbnail'),
    );
    register_post_type('catalogo', $args);
}
// add_action('init', 'registrar_tipo_catalogo');

// // Registra una acción para ejecutar la función de obtención del token
// add_action('wp_enqueue_scripts', 'obtener_y_almacenar_token');
