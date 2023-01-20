<?php
header('Content-type: application/json; charset=UTF-8');

$answer = ["result" => "False"];

$method = $_SERVER['REQUEST_METHOD'];
$o_data = get_data($method);

$request = parse_get();
$router = $request[0];
$data = array_slice($request, 1);

if (file_exists("routers/".$router.".php")) {
    include_once "routers/".$router.".php";
    $answer = route($method, $data, $o_data);
}

echo json_encode($answer);


function parse_get() {          // Данные из преобразованной строки запроса 
    $result = (isset($_GET["q"])) ? $_GET["q"] : "";
    $result = rtrim($result, "/");
    return explode("/", $result);
}


function get_data($method) {    // Данные в запросе
    if ($method == "GET") return $_GET;
    if ($method == "POST") return $_POST;

    $data = array();
    $exploded = explode('&', file_get_contents("php://input"));
    foreach ($exploded as $pair) {
        $item = explode("=", $pair);
        if (count($item) == 2) {
            $data[urldecode($item[0])] = urldecode($item[1]);
        }
    }
    return $data;
}

?>

