<?php
include_once ($_SERVER["DOCUMENT_ROOT"]."/functions.php");
check_cookie();

$link = connect_db();
$data = get_admins($link);

foreach ($data as $user) {
    if ($user["token"] == $_COOKIE["Token"]) {
        echo "<div class='row' id='r" . $user["id"] . "'>";
        echo "<div class='col-10'>";
        echo "<form id='change_password'>";
            echo "<div class='mb-2'>";
            echo "<label for='old_password' class='col-form-label'>Старый пароль:</label>";
            echo "<input type='password' class='form-control' id='old_password' name='old_password'>";
            echo "</div>";
            echo "<div class='mb-2'>";
            echo "<label for='new_password' class='col-form-label'>Новый пароль:</label>";
            echo "<input type='password' class='form-control' id='new_password' name='new_password'>";
            echo "</div>";
            echo "<div class='mb-2'>";
            echo "<label for='r_new_password' class='col-form-label'>Повторите новый пароль:</label>";
            echo "<input type='password' class='form-control' id='r_new_password' name='r_new_password'>";
            echo "</div>";
            echo "<div class='mb-2'>";
            echo "<button type='submit' id='change_password_button' class='mb-2 float-end btn btn-primary'>Изменить пароль</button>";
            echo "</div>";
            echo "<div class='col-8'>";
            echo "<div class='mb-2 text-start' style='color: red; height: 15px' id='a_message'></div>";
            echo "</div>";
            echo "<input type='hidden' name='method' value='change_password'>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
}
