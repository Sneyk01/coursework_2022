<?php
include_once "functions.php";

if (empty($_POST["token"])) {
    echo json_encode(["result" => "False"]);
    exit();
}

$link = connect_db();

$sql = "UPDATE `admin_table` SET `token` = '' WHERE `admin_table`.`token` = '".$_POST["token"]."';";
$result = mysqli_query($link, $sql);

echo json_encode(["result" => "True"]);