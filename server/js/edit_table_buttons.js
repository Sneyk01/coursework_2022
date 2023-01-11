$("document").ready(function (){

    $(document).on("click", ".delete", function() {         // Одна для двух таблиц
        event.preventDefault();
        $.ajax({
            url: 'edit_table.php',
            type: 'POST',
            dataType: 'html',
            data: {
                id: $(this).val(),
                method: "delete",
                table_type: table
            },
            success: function (data){
                old_token(data);
                data = JSON.parse(data);
                if (data["result"] === "True")
                    document.getElementById("r"+data["id"]).remove();
            }
        })

    })

    $(document).on("click", ".edit",function (){            // Чтобы работали элементы после подгрузки qna.habr.com/q/63544
        document.getElementById("resident_name_e").value = $("#resident_f"+$(this).val()).text();
        document.getElementById("resident_last_name_e").value = $("#resident_l"+$(this).val()).text();
        document.getElementById("resident_house_e").value = $("#resident_h"+$(this).val()).text();
        document.getElementById("resident_car_e").value = $("#resident_c"+$(this).val()).text();
        document.getElementById("resident_telegram_id_e").value = $("#resident_t"+$(this).val()).text();
        document.getElementById("resident_key_e").value = $("#resident_k"+$(this).val()).text();
        document.getElementById("id_e").value = $(this).val();
    })

    $("#editResident").on("submit", function(){
        event.preventDefault();
        $.ajax({
            url: 'edit_table.php',
            type: 'POST',
            dataType: 'html',
            data: $(this).serialize(),
            success: function (data){
                old_token(data);
                let message = document.getElementById("message_e")
                data = JSON.parse(data);
                if (data["result"] === "True") {
                    message.style.color = "green";
                    $("#message_e").text("Запись изменена");
                    edit_table(data);
                    $("#submit_button_2").prop("disabled", true);
                }
                else {
                    message.style.color = "red";
                    $("#message_e").html(data["message"]);
                }
            }
        })
    })


    $(document).on("click", ".edit_visitor",function (){    // Автозаполнение формы
        //document.getElementById("visitor_inv_id_e").value = $("#visitor_inv"+$(this).val()).text();   // Если нужно вписать изначальный id создателя
        document.getElementById("visitor_inv_id_e").value = "Администратор"
        $("#visitor_inv_id_e").prop("readonly", true);                              // Блокируется ввод
        document.getElementById("visitor_car_e").value = $("#visitor_c"+$(this).val()).text();
        document.getElementById("visitor_id_e").value = $(this).val();
    })

    $("#editVisitor").on("submit", function(){
        event.preventDefault();
        $.ajax({
            url: 'edit_table.php',
            type: 'POST',
            dataType: 'html',
            data: $(this).serialize(),
            success: function (data){
                old_token(data);
                let message = document.getElementById("visitor_message_e")
                data = JSON.parse(data);
                if (data["result"] === "True") {
                    message.style.color = "green";
                    $("#visitor_message_e").text("Запись изменена");
                    edit_visitor_table(data);
                    $("#visitor_submit_button_2").prop("disabled", true);
                }
                else {
                    message.style.color = "red";
                    $("#visitor_message_e").html(data["message"]);
                }
            }
        })
    })

    $(document).on("click", ".save_param", function () {
        let button_val = $(this).val();
        $(".param"+button_val).stop(true, false);
        $.ajax({
            url: 'edit_table.php',
            type: 'POST',
            dataType: 'html',
            data: {
                method: "edit_setting",
                id: document.getElementById("value_p"+button_val).name,
                value: document.getElementById("value_p"+button_val).value
            },
            success: function (data) {
                old_token(data);
                data = JSON.parse(data);
                if (data["result"] === "True") {
                    $(".param"+button_val).animate({
                        "background-color": "#8BEA00",
                    }, 600);
                    $(".param"+button_val).animate({
                        "background-color": "#ffffff"
                    }, 600);
                }
                if (data["result"] === "False") {
                    document.getElementById("value_p"+button_val).value = data["old_val"]
                    $(".param"+button_val).animate({
                        "background-color": "#FF0700",
                    }, 600);
                    $(".param"+button_val).animate({
                        "background-color": "#ffffff"
                    }, 600);
                }
            }
        })
    })

    $(document).on("click", "#reset_params", function () {
        $.ajax({
            url: 'edit_table.php',
            type: 'POST',
            dataType: 'html',
            data: {
                method: "reset_params",
            },
            success: function (data) {
                old_token(data);
                data = JSON.parse(data);
                if (data["result"] === "True") {
                    $.get("template/setting_body.php", function (html) {
                        $("#table_body").html(html);
                    })
                }
            }
        })
    })

    $(document).on("submit", "#change_password", function(){
        event.preventDefault();
        $.ajax({
            url: 'edit_table.php',
            type: 'POST',
            dataType: 'html',
            data: $(this).serialize(),
            success: function (data){
                old_token(data);
                let message = document.getElementById("a_message")
                data = JSON.parse(data);
                if (data["result"] === "True") {
                    message.style.color = "green";
                    $(message).text("Пароль изменен");
                    document.getElementById("old_password").value = "";     // Очищаем поля
                    document.getElementById("new_password").value = "";
                    document.getElementById("r_new_password").value = "";
                }
                if (data["result"] === "False") {
                    message.style.color = "red";
                    $(message).html(data["message"]);

                }
            }
        })
    })
})


function edit_table(data) {
    $("#resident_f"+data["id"]).html(data["resident_name"]);
    $("#resident_l"+data["id"]).html(data["resident_last_name"]);
    $("#resident_h"+data["id"]).html(data["resident_house"]);
    $("#resident_c"+data["id"]).html(data["resident_car"]);
    $("#resident_k"+data["id"]).html(data["resident_key"]);
    $("#resident_t"+data["id"]).html(data["resident_telegram_id"]);
}

function edit_visitor_table(data) {
    $("#visitor_c" + data["id"]).html(data["visitor_car"]);
    $("#visitor_inv" + data["id"]).html(data["visitor_inv_id"]);
    $("#visitor_d" + data["id"]).html(timestampToDate(data["visitor_time"]));
}


function old_token(data) {
    if (data.length > 2910) {
        location.replace("../login.php?s");
        return;
    }
    if (data.length > 2900)
        location.replace("../login.php");

        //$(document).html(data);
}