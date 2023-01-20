<?php
include_once ($_SERVER["DOCUMENT_ROOT"]."/functions.php");
function route($method, $data, $o_data) {

    $link = connect_db();

    if ($method == "GET") {     // GET resident info
        $t_id = isset($data[1]) ? $data[1] : null;

        $result = get_residents($link);

        foreach ($result as $resident) {
            if ($resident["telegram_id"] == $t_id)
                return array_merge(["result" => "True"], $resident);
        }
    }

    if ($method == "POST") {    // Create new visitor
        if (!check_car_number($o_data["number"]))
            return ["result" => "False", "message" => "Некорректный номер"];

        if (!check_number_duplicate($o_data["number"], $link))
            return ["result" => "False", "message" => "Данный номер уже есть в списке"];

        $sql = "INSERT INTO `visitors_table` (`id`, `car_number`, `inviting_id`, `creation_time`) VALUES (NULL, '".$o_data['number']."', '".$o_data['user_id']."', '".time()."');";
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
