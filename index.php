<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type:charset=utf-8");
/**
 * API framework front controller.
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */

/**
 * Generic class autoloader.
 * 
 * @param string $class_name
 */
function autoload_class($class_name) {
    $directories = array(
        'rest/',
        'rest/controllers/',
        'rest/models/'
    );
    foreach ($directories as $directory) {
        $filename = $directory . $class_name . '.php';
        if (is_file($filename)) {
            require($filename);
            break;
        }
    }
}

/**
 * Register autoloader functions.
 */
spl_autoload_register('autoload_class');

/**
 * Parse the incoming request.
 */
$request = new Request();
if (isset($_SERVER['PATH_INFO'])) {
    $request->url_elements = explode('/', trim($_SERVER['PATH_INFO'], '/'));
}
$request->method = strtoupper($_SERVER['REQUEST_METHOD']);
switch ($request->method) {
    case 'GET':
        $request->parameters = $_GET;
    break;
    case 'POST':
        $request->parameters = $_POST;
    break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $request->parameters);
    break;
}

/**
 * Route the request.
 */
if (!empty($request->url_elements)) {
    $controller_name = ucfirst($request->url_elements[0]) . 'Controller';
    if (class_exists($controller_name)) {
        $controller = new $controller_name;
        $action_name = strtolower($request->method);
        $response_str = call_user_func_array(array($controller, $action_name), array($request));
    }
    else {
        header('HTTP/1.1 404 Not Found');
        $response_str = 'Unknown request: ' . $request->url_elements[0];
    }
}
else {
header("Location: underlying.php");
die();
}

/**
 * Send the response to the client.
 */
$response_obj = Response::create($response_str, $_SERVER['HTTP_ACCEPT']);
echo $response_obj->render();
?>