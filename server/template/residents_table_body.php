<?php
include_once ($_SERVER["DOCUMENT_ROOT"]."/functions.php");

$link = connect_db();

$data = get_residents($link);

foreach ($data as $person) {
    echo "<div class='row' id='r".$person["id"]."'>";
    echo "<div class='col-1  border-bottom border-end border-start border-dark'> <h6 class='mb-2' align='center' id='resident_i".$person['id']."'>".$person["id"]."</h6></div>";
    echo "<div class='col-2  border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_f".$person['id']."'>".$person["first_name"]."</h6></div>";
    echo "<div class='col-2 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_l".$person['id']."'>".$person["last_name"]."</h6></div>";
    echo "<div class='col-2 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_c".$person['id']."'>".$person["car_numbers"]."</h6></div>";
    echo "<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_h".$person['id']."'>".$person["house_number"]."</h6></div>";
    echo "<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_t".$person['id']."'>".$person["telegram_id"]."</h6></div>";
    echo "<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_k".$person['id']."'>".$person["secret_key"]."</h6></div>";
    echo "<div class='col-1 mb-1'>"."<button value='".$person["id"]."' class='btn btn-warning border border-dark col-12 text-white edit' data-bs-toggle='modal' data-bs-target='#editFormModal'> Изменить </button>"."</div>";
    echo "<div class='col-1 mb-1'>"."<button value='".$person["id"]."' class='btn btn-danger border border-dark col-12 delete'> Удалить </button>"."</div>";
    echo "</div>";
}
