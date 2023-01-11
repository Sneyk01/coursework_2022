$("document").ready(function (){                                            // Изменение стилей кнопок при нажатии
    $(document).on("click", ".top_list", function () {                                // И очистка старого наполнения
        event.preventDefault();
        if (!($(this).hasClass("btn-primary"))) {
            $(".btn-primary").eq(4).removeClass("btn-primary").addClass("btn-light"); // Первые 4 кнопки - в модпльных окнах
            $(this).removeClass("btn-light").addClass("btn-primary");
        }
    })

    $(document).on("click", "#residents_list", function () {
        table = "resident_table";
        //$("#table_head").html("template/residents_table_head.php");
        //$("#table_body").html("template/residents_table_body.php");
        $.get("template/residents_table_head.php", function (html) {
            $("#table_head").html(html);
        })
        $.get("template/residents_table_body.php", function (html) {
            $("#table_body").html(html);
        })
    })

    $(document).on("click", "#visitors_list", function () {
        table = "visitors_table"

        $.get("template/visitors_table_head.php", function (html) {
            $("#table_head").html(html);
        })
        $.get("template/visitors_table_body.php", function (html) {
            $("#table_body").html(html);
        })
    })

    $(document).on("click", "#exit", function () {
        let cookie = document.cookie;
        let array = cookie.split("=");
        cookie = (array[0] === "Token")? array[1] : null;
        $.ajax({
            url: "exit.php",
            type: "POST",
            dataType: "html",
            data: { token: cookie},
            success: function (data) {
                data = JSON.parse(data);
                if (data["result"] === "True")
                    location.replace("../login.php");
            }
        })
    })

    $(document).on("click", "#setting", function () {
        $.get("template/setting_head.php", function (html) {
            $("#table_head").html(html);
        })

        $.get("template/setting_body.php", function (html) {
            $("#table_body").html(html);
        })
    })

    $(document).on("click", "#account", function () {
        $.get("template/account_head.php", function (html) {
            $("#table_head").html(html);
        })
        //$("#table_head").empty();
        $.get("template/account_body.php", function (html) {
            $("#table_body").html(html);
        })
    })
})