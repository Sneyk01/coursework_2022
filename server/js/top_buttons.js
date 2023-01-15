$("document").ready(function (){
    const time_update = 60000
    let auto_update = setInterval(residents_body, time_update);

    $(document).on("click", ".top_list", function () {   // Изменение стилей кнопок при нажатии
        event.preventDefault();
        if (!($(this).hasClass("btn-primary"))) {
            $(".btn-primary").eq(4).removeClass("btn-primary").addClass("btn-light"); // Первые 4 кнопки - в модальных окнах
            $(this).removeClass("btn-light").addClass("btn-primary");
        }
    })

    $(document).on("click", "#residents_list", function () {
        clearInterval(auto_update);

        table = "resident_table";
        //$("#table_head").html("template/residents_table_head.php");
        //$("#table_body").html("template/residents_table_body.php");
        $.get("template/residents_table_head.php", function (html) {
            $("#table_head").html(html);
        })
        residents_body();
        auto_update = setInterval(residents_body, time_update);
    })

    $(document).on("click", "#visitors_list", function () {
        clearInterval(auto_update);


        table = "visitors_table"

        $.get("template/visitors_table_head.php", function (html) {
            $("#table_head").html(html);
        })
        visitors_body();
        auto_update = setInterval(visitors_body, time_update);
    })

    $(document).on("click", "#exit", function () {
        clearInterval(auto_update);

        let cookie = document.cookie;
        let array = cookie.split("; ");
        cookie = null;
        for (let i = 0; i < array.length; i++) {
            let array2 = array[i].split("=");
            if (array2[0] === "Token") {
                cookie = array2[1];
                break;
            }
        }
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
        clearInterval(auto_update);

        $.get("template/setting_head.php", function (html) {
            $("#table_head").html(html);
        })

        $.get("template/setting_body.php", function (html) {
            $("#table_body").html(html);
        })
    })

    $(document).on("click", "#account", function () {
        clearInterval(auto_update);

        $.get("template/account_head.php", function (html) {
            $("#table_head").html(html);
        })
        //$("#table_head").empty();
        $.get("template/account_body.php", function (html) {
            $("#table_body").html(html);
        })
    })
})

function residents_body() {
    $.get("template/residents_table_body.php", function (html) {
        $("#table_body").html(html);
    })
}
function visitors_body() {
    $.get("template/visitors_table_body.php", function (html) {
        $("#table_body").html(html);
    })
}
