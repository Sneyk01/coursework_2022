<?php
include_once "functions.php";

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

$link = connect_db();
$result = get_admins($link);

foreach ($result as $admin) {
    if ($login == $admin["login"]) {
        [$h_password, $h_salt] = hash_password($password, $admin["salt"]);
        if ($h_password == $admin["password"]) {
            $token = gen_str(20);
            $sql = "UPDATE `admin_table` SET `token` = '".$token."', `time` = '".time()."' WHERE `admin_table`.`id` = ".$admin["id"].";";
            $send = mysqli_query($link, $sql);
            setcookie("Token", $token);

            echo "True";
            exit();
        }
    }

}

echo "Неверные имя пользователя или пароль";






