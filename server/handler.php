<?php
$GLOBALS["symb_base"] = "0987654321=zxcvbnmasdfghjklqwertyuiopPOIUYTREWQLKJHGFDSAMNBVCXZ";
if (empty($_POST["login"])) {
    echo "Укажите логин";
    exit();
}

if (empty($_POST["password"])) {
    echo "Укажите пароль";
    exit();
}

$login = $_POST["login"];
$password = $_POST["password"];

$link = mysqli_connect("localhost", "course_work_db", "qwerty", "kpp_coursework");
$sql = "SELECT * FROM admin_table";
$result = mysqli_query($link, $sql);

foreach ($result as $admin) {
    if ($login == $admin["login"]) {
        [$h_password, $h_salt] = hash_password($password, $admin["salt"]);
        if ($h_password == $admin["password"]) {
            $token = gen_str(20);
            $sql = "UPDATE `admin_table` SET `token` = '".$token."', 'time' = '".time()."' WHERE `admin_table`.`id` = 1;";
            $send = mysqli_query($link, $sql);
            setcookie("Token", $token);

            echo "Try";
            exit();
        }
    }

}

echo "Неверные имя пользователя или пароль";

function hash_password($password, $h_salt = null): array
{
    $h_salt = is_null($h_salt) ? gen_str(10) : $h_salt;
    $password = $password.$h_salt;
    $hash = hash("md5", $password);

    return array($hash, $h_salt);
}




function gen_str($count) {
    $str = "";
    for ($i = 0; $i < $count; $i++) {
        $num = rand(0, (strlen($GLOBALS["symb_base"]) - 1));
        $rand_symb = $GLOBALS["symb_base"][$num];
        $str = $str.$rand_symb;
    }
    return $str;
}