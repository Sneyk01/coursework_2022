<?php
include_once "functions.php";
check_cookie();

if (empty($_POST["resident_name"])) {
    echo json_encode(["message" => "Укажите имя"]);
    exit();
}

if (empty($_POST["resident_last_name"])) {
    echo json_encode(["message" => "Укажите фамилию"]);
    exit();
}
if (empty($_POST["resident_house"])) {
    echo json_encode(["message" => "Укажите номер дома"]);
    exit();
}

if (empty($_POST["resident_car"])) {
    echo json_encode(["message" => "Укажите номера автомобилей"]);
    exit();
}

if (!check_car_number($_POST["resident_car"])) {
    echo json_encode(["message" => "Некоректный автомобильный номер"]);
    exit();
}

$data = $_POST;
$data["resident_car"] = trim(mb_strtolower($data["resident_car"]));

$key = gen_str(10);

$link = connect_db();

if (!check_number_duplicate($data["resident_car"], $link)) {
    echo json_encode(["message" => "Данный автомобильный номер уже есть в базе"]);
    exit();
}

//$sql = "INSERT INTO `resident_table` (`id`, `first_name`, `last_name`, `car_numbers`, `house_number`, `telegram_id`, `secret_key`) VALUES (NULL, ' ".$data["resident_name"]."', '".$data["resident_last_name"]."', '".$data["resident_car"]."', '".$data["resident_house"]."', NULL, '".$key."');";
$sql = "INSERT INTO `resident_table` (`id`, `first_name`, `last_name`, `car_numbers`, `house_number`, `telegram_id`, `secret_key`) VALUES (NULL, '".$data["resident_name"]."', '".$data["resident_last_name"]."', '".$data["resident_car"]."', '".$data["resident_house"]."', '', '".$key."');";
$result = mysqli_query($link, $sql);

$sql = "SELECT MAX(id) FROM resident_table";
$result = mysqli_query($link, $sql);
$answer = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode(array_merge(["result"=> "True", "secret_key" => $key, "id" => $answer[0]["MAX(id)"], "telegram_id" => ""], $data));
