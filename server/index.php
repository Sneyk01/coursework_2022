<?php
include_once "functions.php";
check_cookie();

include_once ("modal.php");
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <!-- Кодировка веб-страницы -->
    <meta charset="utf-8">
    <!-- Настройка viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Main </title>

    <link rel="stylesheet" href="css/styles.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/color/jquery.color-2.1.2.js"></script>   <!-- Для анимаций цвета -->

    <script>let table = "resident_table"; </script>

    <!--<link href="css/bootstrap.min.css" rel="stylesheet"> Для локального использования
    <script defer src="js/bootstrap.bundle.min.js"></script>
    -->
</head>

<body>
<div class="header_div mb-2" > <h1 class="text-white mb-3" style="margin-left: 1%"> Панель администратора  </h1> </div>
<div class="container-fluid but_cont" style="margin-left: 0; max-width: 98.6%;!important;">
    <div class="row mb-4" >
        <div class="col"> <button class="btn btn-primary col-12 border border-dark shadow-none top_list" id="residents_list"> Список жителей </button> </div>
        <div class="col"> <button class="btn btn-light col-12 border border-dark shadow-none top_list" id="visitors_list"> Список гостей </button> </div>
        <div class="col"> <button class="btn btn-light col-12 border border-dark shadow-none top_list" id="setting"> Настройка параметров </button> </div>
        <div class="col"> <button class="btn btn-light col-12 border border-dark shadow-none top_list" id="account"> Учетная запись </button> </div>
        <div class="col"> <button class="btn btn-light col-12 border border-dark shadow-none top_list" id="exit"> Выход </button> </div>
    </div>
</div>

<div class="scrollable container-fluid" align="left" style="margin-left: 0.6%" id="table">
    <div class="row sticky-top" id="table_head">
        <?php include("template/residents_table_head.php"); ?>
    </div>

    <div id="table_body">
        <?php include("template/residents_table_body.php"); ?>
    </div>
</div>


<script src="js/add_new_person.js"> </script>
<script src="js/reset_modal_windows.js"> </script>
<script src="js/edit_table_buttons.js"> </script>
<script src="js/top_buttons.js"> </script>

</body>
</html>
