<?php
include_once ($_SERVER["DOCUMENT_ROOT"]."/functions.php");

$link = connect_db();

$setting = get_params($link);
$visitors_time = 86400; // Значение по умолчанию (1 день)
foreach ($setting as $param)
    if ($param["Name"] == "visitors_time")
        $visitors_time = $param["Value"];

$data = get_visitors($link);

foreach ($data as $person) {
    if ($person["creation_time"] + $visitors_time < time()) {
        $sql = "DELETE FROM `visitors_table` WHERE `visitors_table`.`id` = ".$visitor["id"].";";    // Удаляем запись в таблице
        //$result = mysqli_query($link, $sql);
        continue;
    }

    echo "<div class='row' id='r".$person["id"]."'>";
    echo "<div class='col  border-bottom border-end border-start border-dark'> <h6 class='mb-2' align='center' id='visitor_i".$person['id']."'>".$person["id"]."</h6></div>";
    echo "<div class='col-3  border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='visitor_c".$person['id']."'>".$person["car_number"]."</h6></div>";
    echo "<div class='col-3 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='visitor_inv".$person['id']."'>".$person["inviting_id"]."</h6></div>";
    echo "<div class='col-3 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='visitor_d".$person['id']."'>".gmdate("Y-m-d\ | H:i:s", $person["creation_time"]+10800)."</h6></div>";
    echo "<div class='col-1 mb-1'>"."<button value='".$person["id"]."' class='btn btn-warning border border-dark col-12 text-white edit_visitor' data-bs-toggle='modal' data-bs-target='#editFormModalVisitor'> Изменить </button>"."</div>";
    echo "<div class='col-1 mb-1'>"."<button value='".$person["id"]."' class='btn btn-danger border border-dark col-12 delete'> Удалить </button>"."</div>";
    echo "</div>";
}
