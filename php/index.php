<?php
require_once "Database.php";


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if (count($uri) == 4) {
    // echo "documentation";
    die();
} else {
    // get subarray from position 4
    $uri = array_slice($uri, 4);

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    switch ($uri[0]) {
        case "range":
            if ($requestMethod == "POST") {
                if (!is_null($_POST)) {
                    $response['body'] = json_encode(array("Variabile globale Post" => $_POST));
                } else {
                    $response['body'] = json_encode(array("Body raw" => file_get_contents('php://input')));
                }

                // $response['body'] = rangeMeasure();
            }
            header("HTTP/1.1 200 OK");
            echo $response['body'];
            break;

        default:
            // $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            // header($response['status_code_header']);
            header("HTTP/1.1 404 Not Found");
            exit();
            break;
    }



    // $input = (array) json_decode(file_get_contents('php://input'), TRUE);

                    /*if (count($input) == 0) {
                        $input = file_get_contents('php://input');
                        $input = iconv("windows-1251", "UTF-8", $input);
                        parse_str(urldecode($input), $result);
                        $input = json_encode($result, JSON_UNESCAPED_UNICODE);
                        $input = (array) json_decode($input);
                    }*/
}

function rangeMeasure()
{
    $conn = new Database("localhost", "acquario");
    $conn = $conn->getConnection();

    $query = "SELECT vasche.id AS idvasca, vasche.nome AS nomevasca, sensori.id AS idsensore, sensori.tipo AS tiposensore, misure.valore AS valoremisura
                FROM vasche
                JOIN sensori ON vasche.id = sensori.idVasca
                JOIN misure ON sensori.id = misure.idSensore
                WHERE misure.valore NOT BETWEEN sensori.min AND sensori.max
                AND misure.data > DATE_SUB(CURDATE(), INTERVAL 3 DAY)";

    try {
        $statement = $conn->query($query);
        return json_encode(array("valori" => $statement->fetchAll(\PDO::FETCH_ASSOC)));
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
}
