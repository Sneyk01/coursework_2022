<?php
function route($method, $data, $o_data) {

    $link = mysqli_connect("localhost", "course_work_db", "qwerty", "kpp_coursework");
    mysqli_set_charset($link, "utf8");

    if ($method == "GET") {     // GET resident info
        $t_id = isset($data[1]) ? $data[1] : null;

        $result = get_residents($link);

        foreach ($result as $resident) {
            if ($resident["telegram_id"] == $t_id)
                return array_merge(["result" => "True"], $resident);
        }
    }

    if ($method == "POST") {    // Create new visitor
        $result = get_residents($link);
        foreach ($result as $resident) {
            if (strpos($resident["car_numbers"], $o_data["number"]) !== false)    // If number contain in resident table
                return ["result" => "False"];
        }

        $result = get_visitors($link);
        foreach ($result as $resident) {
            if (strpos($resident["car_number"], $o_data["number"]) !== false)    // If number contain in visitors table
                return ["result" => "False"];
        }

        $sql = "INSERT INTO `visitors_table` (`id`, `car_number`, `inviting_id`, `creation_time`) VALUES (NULL, ' ".$o_data['number']."', '".$o_data['user_id']."', '".time()."');";
        $add = mysqli_query($link, $sql);
        return ["result" => "True"];
    }

    if ($method == "PUT") {     // Resident telegram registration
        if (strlen($o_data["key"]) < 10)
            return ["result" => "False"];

        $result = get_residents($link);

        foreach ($result as $resident) {
            if ($resident["secret_key"] == $o_data["key"]) {
                $sql = "UPDATE `resident_table` SET `telegram_id` = '".$o_data["telegram_id"]."', `secret_key` = '' WHERE `resident_table`.`id` = ".$resident["id"].";";
                $change = mysqli_query($link, $sql);
                return array_merge(["result" => "True"], $resident);
            }
        }
    }

    return ["result" => "False"];
}

function get_residents($link) {
    $sql = "SELECT * FROM resident_table";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_visitors($link) {
    $sql = "SELECT * FROM visitors_table";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}