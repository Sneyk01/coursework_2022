<?php
$GLOBALS["symb_base"] = "0987654321zxcvbnmasdfghjklqwertyuiopPOIUYTREWQLKJHGFDSAMNBVCXZ";


function connect_db() {
    $link = mysqli_connect("localhost", "course_work_db", "qwerty", "kpp_coursework");
    mysqli_set_charset($link, "utf8");

    return $link;
}


function check_cookie() {   // Если токен подходит - true, иначе просто отпраавляем на login.php
    $link = connect_db();
    $token = isset($_COOKIE["Token"]) ? $_COOKIE["Token"] : null;

    if($token == null) {
        if ($_SERVER["REQUEST_URI"] == "/login.php")    // Если мы уже на login.php (иначе постоянная пересылка)
            return false;
        //echo json_encode(["result" => "Token"]);
        header("location: login.php");
        exit();
    }

    $data = get_admins($link);

    foreach ($data as $admin) {
        if ($admin["token"] === $token) {
            global $TOKEN_TIME;
            if (($admin["time"] + get_token_time()) >= time())
                return true;
            else {  // Удаляем старый токен
                $sql = "UPDATE `admin_table` SET `token` = '' WHERE `admin_table`.`token` = '".$token."';";
                $result = mysqli_query($link, $sql);
                header("location: login.php?s");
                //echo json_encode(["result" => "Token_s"]);
                exit();
            }
        }
    }

    if ($_SERVER["REQUEST_URI"] == "/login.php" || $_SERVER["REQUEST_URI"] == "/login.php?s") // Сообщение о сессии
        return false;
    header("location: login.php");
    //echo json_encode(["result" => "Token"]);
    exit();
}


function get_params($link) {
    $sql = "SELECT * FROM parameters";
    return mysqli_query($link, $sql);
}


function get_admins($link) {
    $sql = "SELECT * FROM admin_table";
    return mysqli_query($link, $sql);
}


function get_residents($link): array
{
    $sql = "SELECT * FROM resident_table ORDER BY id";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function get_visitors($link): array
{
    $sql = "SELECT * FROM visitors_table ORDER BY id";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function gen_str($count): string
{
    $str = "";
    for ($i = 0; $i < $count; $i++) {
        $num = rand(0, (strlen($GLOBALS["symb_base"]) - 1));
        $rand_symb = $GLOBALS["symb_base"][$num];
        $str = $str.$rand_symb;
    }
    return $str;
}


function hash_password($password, $h_salt = null): array
{
    $h_salt = is_null($h_salt) ? gen_str(10) : $h_salt;
    $password = $password.$h_salt;
    $hash = hash("md5", $password);

    return array($hash, $h_salt);
}


function check_car_number($number): bool
{
    if (mb_strlen($number) < 6)
        return false;

    return true;
}


function check_number_duplicate($number, $link): bool
{
    $result = get_residents($link);

    foreach ($result as $resident) {
        $numbers = explode(";", $resident["car_numbers"]);
        if (in_array($number, $numbers))
            return false;
    }

    $result = get_visitors($link);
    foreach ($result as $resident) {
        if ($resident["car_number"] == $number) {    // If number contain in visitors table
            return false;
        }
    }

    return true;
}


function get_token_time() {
    $link = connect_db();

    $sql = "SELECT * FROM `parameters` WHERE `Name` = 'token_time';";
    $result = mysqli_query($link, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $result[0]["Value"];
}


function message() {
    if (isset($_GET["s"]))
        echo "Ваша сессия устарела. Пожалуйста, повторите вход";
}