<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
if (count($uri) == 3) {
    echo "CIAO";
    die();
} else {
    // get subarray from position 4
    $uri = array_slice($uri, 3);

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    switch ($uri[0]) {
        case 1:
            break;

        default:
            // $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            // header($response['status_code_header']);
            header("HTTP/1.1 404 Not Found");
            exit();
            break;
    }
}

var_dump(file_get_contents('php://input'));

$input = (array) json_decode(file_get_contents('php://input'), TRUE);

if (count($input) == 0) {
    $input = file_get_contents('php://input');
    $input = iconv("windows-1251", "UTF-8", $input);
    parse_str(urldecode($input), $result);
    $input = json_encode($result, JSON_UNESCAPED_UNICODE);
    $input = (array) json_decode($input);
}
