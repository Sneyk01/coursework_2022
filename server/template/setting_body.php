<?php
include_once ($_SERVER["DOCUMENT_ROOT"]."/functions.php");

$link = connect_db();

$data = get_params($link);
foreach ($data as $parametr) {
    echo "<div class='row' id='r".$parametr["id"]."'>";
    echo "<div class='col-5 border-bottom border-start border-end border-dark param".$parametr["id"]."'> <h6 class='mt-3' align='center' id='name_p".$parametr["id"]."'>".$parametr["Name"]."</h6></div>";
    echo "<div class='col-5 border-bottom border-end border-dark param".$parametr["id"]."'><input type='text' name='".$parametr["id"]."' class='mt-2 mb-2 form-control col-6' value='".$parametr["Value"]."' id='value_p".$parametr["id"]."'></div>";
    echo "<div class='col-2'>"."<button type='submit' value='".$parametr["id"]."' class=' mt-2 btn btn-warning border border-dark col-12 text-white save_param'> Изменить </button>"."</div>";
    echo "</div>";
}
