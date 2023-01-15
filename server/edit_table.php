<?php
include_once "functions.php";
check_cookie();

$link = connect_db();

if ($_POST["method"] == "delete") {
    $id = $_POST["id"];

    $sql = "DELETE FROM `".$_POST["table_type"]."` WHERE `".$_POST["table_type"]."`.`id` = ".$id.";";
    $result = mysqli_query($link, $sql);

    echo json_encode(["result" => "True", "id" => $id]);
    exit();
}

if ($_POST["method"] == "edit" && $_POST["table_type"] == "resident_table") {
    $data = $_POST;
    $data["resident_car"] = trim(mb_strtolower($data["resident_car"]));

    if (!check_car_number($data["resident_car"])) {
        echo json_encode(["message" => "Некоректный автомобильный номер"]);
        exit();
    }

    if (!check_number_duplicate($data["resident_car"], $link)) {

        $sql = "SELECT * FROM `resident_table` WHERE `id` = '".$data["id"]."';";
        $result = mysqli_query($link, $sql);
        $answer = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($answer[0]["car_numbers"] != $data["resident_car"]) {                        // Если не меняем номер
            echo json_encode(["message" => "Данный автомобильный номер уже есть в базе"]);
            exit();
        }
        else {
            if ($answer[0]["first_name"] == $data["resident_name"] &&
                $answer[0]["last_name"] == $data["resident_last_name"] &&
                $answer[0]["house_number"] == $data["resident_house"] &&
                $answer[0]["telegram_id"] == $data["resident_telegram_id"] &&
                $answer[0]["secret_key"] == $data["resident_key"]) {
                echo json_encode(["message" => "Вы не внесли никаких изменений"]);
                exit();
            }
        }
    }

    $sql = "UPDATE `resident_table` SET `telegram_id` = '".$data["resident_telegram_id"]."', `secret_key` = '".$data["resident_key"]."', `first_name` = '".$data["resident_name"]."', `last_name` = '".$data["resident_last_name"]."', `car_numbers` = '".$data["resident_car"]."', `house_number` = '".$data["resident_house"]."'  WHERE `resident_table`.`id` = ".$data["id"].";";
    $result = mysqli_query($link, $sql);

    echo json_encode(array_merge(["result" => "True"], $data));
    exit();
}

if ($_POST["method"] == "edit" && $_POST["table_type"] == "visitors_table") {
    $data = $_POST;
    $data["visitor_car"] = trim(mb_strtolower($data["visitor_car"]));

    if (!check_car_number($data["visitor_car"])) {
        echo json_encode(["message" => "Некоректный автомобильный номер"]);
        exit();
    }

    if (!check_number_duplicate($data["visitor_car"], $link)) {

        $sql = "SELECT * FROM `visitors_table` WHERE `id` = '".$data["id"]."';";
        $result = mysqli_query($link, $sql);
        $answer = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($answer[0]["car_number"] != $data["visitor_car"])                      // Если не меняем номер
            echo json_encode(["message" => "Данный автомобильный номер уже есть в базе"]);
        else
            echo json_encode(["message" => "Вы не внесли никаих изменений"]);
        exit();
    }

    $time = time();
    $sql = "UPDATE `visitors_table` SET `car_number` = '".$data["visitor_car"]."', `inviting_id` = '".$data["visitor_inv_id"]."', `creation_time` = '".$time."' WHERE `visitors_table`.`id` = ".$data["id"].";";
    $result = mysqli_query($link, $sql);

    echo json_encode(array_merge(["result" => "True", "visitor_time" => $time], $data));
    exit();
}

if ($_POST["method"] == "edit_setting") {
    if ($_POST["value"] < 60 || !is_numeric($_POST["value"])) { // защита от слишком маленьких значений и букв
        $sql = "SELECT * FROM `parameters` WHERE `id` = '".$_POST["id"]."';";
        $result = mysqli_query($link, $sql);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(["result" => "False", "old_val" => $result[0]["Value"]]);
        exit();
    }
    $sql = "UPDATE `parameters` SET `Value` = '".$_POST["value"]."' WHERE `parameters`.`id` = ".$_POST["id"].";";
    $result = mysqli_query($link, $sql);
    echo json_encode(["result" => "True"]);
    exit();
}

if ($_POST["method"] == "reset_params") {
    $data = ["1", "2"];
    $value = [3600, 86400];

    for ($i = 0; $i < count($data); $i++) {
        $sql = "UPDATE `parameters` SET `Value` = '".$value[$i]."' WHERE `parameters`.`id` = ".$data[$i].";";
        $result = mysqli_query($link, $sql);
    }

    echo json_encode(["result" => "True"]);
    exit();
}

if ($_POST["method"] == "change_password") {
    if (empty($_POST["old_password"])) {
        echo json_encode(["result" => "False", "message" => "Укажите старый пароль"]);
        exit();
    }
    if (empty($_POST["new_password"])) {
        echo json_encode(["result" => "False", "message" => "Укажите новый пароль"]);
        exit();
    }
    if (empty($_POST["r_new_password"])) {
        echo json_encode(["result" => "False", "message" => "Повторите новый пароль"]);
        exit();
    }
    if ($_POST["new_password"] != $_POST["r_new_password"]) {
        echo json_encode(["result" => "False", "message" => "Пароли не совпадают"]);
        exit();
    }
    if (strlen($_POST["new_password"]) < 4) {
        echo json_encode(["result" => "False", "message" => "Новый пароль слишком короткий"]);
        exit();
    }

    $link = connect_db();
    $result = get_admins($link);

    foreach ($result as $admin) {
        if ($_COOKIE["Token"] == $admin["token"]) {
            [$h_password, $h_salt] = hash_password($_POST["old_password"], $admin["salt"]);
            if ($h_password == $admin["password"]) {
                        [$new_password, $h_salt] = hash_password($_POST["new_password"]);
                        $token = gen_str(20);
                        setcookie("Token", $token);

                        $sql = "UPDATE `admin_table` SET `token` = '".$token."', `time` = '".time()."', `password` = '".$new_password."', `salt` = '".$h_salt."' WHERE `admin_table`.`id` = ".$admin["id"].";";
                        $result = mysqli_query($link, $sql);

                        echo json_encode(["result" => "True"]);
                        exit();
            }
            else {
                echo json_encode(["result" => "False", "message" => "Неверный пароль"]);
                exit();
            }
        }
    }

    echo json_encode(["result" => "False", "message" => "Что-то пошло не так"]);
    exit();
}
