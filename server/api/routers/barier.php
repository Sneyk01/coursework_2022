<?php
include_once ($_SERVER["DOCUMENT_ROOT"]."/functions.php");

function route($method, $data, $o_data) {
    $link = connect_db();

    if ($method == "GET") {
        $number = isset($data[1]) ? $data[1] : null;
        if (mb_strlen($number) < 6)
            return ["result" => "False"];

        $data = get_residents($link);   // проверяем таблицу жителей
        foreach ($data as $resident)
            if (strpos($resident["car_numbers"], $number) !== false)
                return ["result" => "True"];

        $data = get_visitors($link);    // проверяем таблицу гостей

        $setting = get_params($link);
        $visitors_time = 86400; // Значение по умолчанию (1 день)
        foreach ($setting as $param)
            if ($param["Name"] == "visitors_time")
                $visitors_time = $param["Value"];

        foreach ($data as $visitor) {
            if ($number == $visitor["car_number"]) {
                $sql = "DELETE FROM `visitors_table` WHERE `visitors_table`.`id` = ".$visitor["id"].";";    // Удаляем запись в таблице
                $result = mysqli_query($link, $sql);

                if ($visitor["creation_time"] + $visitors_time >= time())   // Если время работы еще не вышло - пропускаем
                    return ["result" => "True"];
            }
        }
    }
    return ["result" => "False"];
}