<?php
include_once "functions.php";
check_cookie();

if (empty($_POST["visitor_car"])) {
    echo json_encode(["message" => "Укажите номер автомобиля"]);
    exit();
}

if (!check_car_number($_POST["visitor_car"])) {
    echo json_encode(["message" => "Некоректный автомобильный номер"]);
    exit();
}

$data = $_POST;
$data["visitor_car"] = trim(mb_strtolower($data["visitor_car"]));

$link = connect_db();

if (!check_number_duplicate($data["visitor_car"], $link)) {
    echo json_encode(["message" => "Данный автомобильный номер уже есть в базе"]);
    exit();
}

$time = time();

$sql = "INSERT INTO `visitors_table` (`id`, `car_number`, `inviting_id`, `creation_time`) VALUES (NULL, '".$data['visitor_car']."', 'Администратор', '".$time."');";
$add = mysqli_query($link, $sql);

$sql = "SELECT MAX(id) FROM visitors_table";
$result = mysqli_query($link, $sql);
$answer = mysqli_fetch_all($result, MYSQLI_ASSOC);

$data["visitor_inv_id"] = "Администратор";
$data["id"] = $answer[0]["MAX(id)"];
$data["visitor_time"] = $time;

echo json_encode(array_merge(["result" => "True"], $data));