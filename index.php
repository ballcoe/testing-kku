<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Get the request URI
//$requestUri = str_replace('/', '', $_SERVER['REQUEST_URI']);
//$requestUri = rtrim(strtok($requestUri, '?'), '/'); // Remove query string and trailing slash
//$requestUri = '/' . ltrim($requestUri, '/'); // Ensure leading slash
// $requestUri = strtolower(trim($_SERVER['REQUEST_URI'], '/')); // Normalize request URI
// $requestUri = '/' . $requestUri; // Ensure leading slash

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = rtrim($requestUri, '/'); // Remove trailing slash
$requestUri = $requestUri === '' ? '/' : $requestUri; // If empty, set to root

// error_log("Raw Request URI: " . $_SERVER['REQUEST_URI']);
// error_log("Processed Request URI: " . $requestUri);
// Define routes
$routes = [
    '/' => '/view/home.php',
    '/test' => '/view/test.php',
];
// error_log("Available Routes: " . print_r(array_keys($routes), true));
// Map the request URI to the corresponding PHP file
if (isset($routes[$requestUri])) {
    $fileToInclude = __DIR__ . $routes[$requestUri];
    // error_log("Including file: " . $fileToInclude);

    if (file_exists($fileToInclude)) {
        require_once $fileToInclude;
    } else {
        // error_log("File not found: " . $fileToInclude);
        http_response_code(404);
        require_once __DIR__ . '/404.php';
    }
} else {
    // error_log("Route not found for URI: " . $requestUri);
    http_response_code(404);
    require_once __DIR__ . '/404.php';
}
