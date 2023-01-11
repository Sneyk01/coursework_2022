$("document").ready(function () {
    $("#addResident").on("submit", function(){
        event.preventDefault();
        $.ajax({
            url: 'add_new_resident.php',
            type: 'POST',
            dataType: 'html',
            data: $(this).serialize(),
            success: function (data){
                old_token(data);
                let message = document.getElementById("message")
                data = JSON.parse(data);
                if (data["result"] === "True") {
                    message.style.color = "green";
                    $(message).text("Запись создана");
                    update_table(data);
                    $("#submit_button_1").prop("disabled", true);
                }
                else {
                    message.style.color = "red";
                    $(message).html(data["message"]);
                }
            }
        })
    })

    $("#addVisitor").on("submit", function(){
        event.preventDefault();
        $.ajax({
            url: 'add_new_visitor.php',
            type: 'POST',
            dataType: 'html',
            data: $(this).serialize(),
            success: function (data){
                old_token(data);
                let message = document.getElementById("visitor_message")
                data = JSON.parse(data);
                if (data["result"] === "True") {
                    message.style.color = "green";
                    $(message).text("Запись создана");
                    update_visitors_table(data);
                    $("#visitor_submit_button_1").prop("disabled", true);
                }
                else {
                    message.style.color = "red";
                    $(message).html(data["message"]);
                }
            }
        })
    })
})


function update_table(data) {

    let str = "";
    str+=("<div class='row' id='r"+data["id"]+"'>");
    str+=("<div class='col-1  border-bottom border-end border-start border-dark'> <h6 class='mb-2' align='center' id='resident_i"+data['id']+"'>"+ data["id"] +"</h6></div>");
    str+=("<div class='col-2  border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_f"+data['id']+"'>"+data["resident_name"]+"</h6></div>");
    str+=("<div class='col-2 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_l"+data['id']+"'>"+data["resident_last_name"]+"</h6></div>");
    str+=("<div class='col-2 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_c"+data['id']+"'>"+data["resident_car"]+"</h6></div>");
    str+=("<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_h"+data['id']+"'>"+data["resident_house"]+"</h6></div>");
    str+=("<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_t"+data['id']+"'>"+ data["telegram_id"]+"</h6></div>");
    str+=("<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_k"+data['id']+"'>"+ data["secret_key"]+"</h6></div>");
    str+=("<div class='col-1 mb-1'> <button value='"+data["id"]+"' class='btn btn-warning border border-dark col-12 text-white edit' data-bs-toggle='modal' data-bs-target='#editFormModal'> Изменить </button> </div>");
    str+=("<div class='col-1 mb-1'> <button value='"+data["id"]+"' class='btn btn-danger border border-dark col-12 delete'> Удалить </button> </div>");
    str+=("</div>");

    $("#table_body").append(str);
}

function update_visitors_table(data) {

    let str = "";
    str+=("<div class='row' id='r"+data["id"]+"'>");
    str+=("<div class='col  border-bottom border-end border-start border-dark'> <h6 class='mb-2' align='center' id='visitor_i"+data['id']+"'>"+ data["id"] +"</h6></div>");
    str+=("<div class='col-3  border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='visitor_c"+data['id']+"'>"+data["visitor_car"]+"</h6></div>");
    str+=("<div class='col-3 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='visitor_inv"+data['id']+"'>"+data["visitor_inv_id"]+"</h6></div>");
    str+=("<div class='col-3 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='visitor_t"+data['id']+"'>"+timestampToDate(data["visitor_time"])+"</h6></div>");
    str+=("<div class='col-1 mb-1'> <button value='"+data["id"]+"' class='btn btn-warning border border-dark col-12 text-white edit_visitor' data-bs-toggle='modal' data-bs-target='#editFormModalVisitor'> Изменить </button> </div>");
    str+=("<div class='col-1 mb-1'> <button value='"+data["id"]+"' class='btn btn-danger border border-dark col-12 delete'> Удалить </button> </div>");
    str+=("</div>");

    $("#table_body").append(str);
}


function timestampToDate(ts) {
    let d = new Date(ts * 1000);
    return (d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2)) + ' | ' + ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2) + ':' + ('0' + d.getSeconds()).slice(-2);
}