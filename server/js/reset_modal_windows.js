$("#addFormModal").on("hidden.bs.modal", function () {
    $("#message").text("");
    document.getElementById("addResident").reset();
    $("#submit_button_1").prop("disabled", false);
})

$("#editFormModal").on("hidden.bs.modal", function () {
    $("#message_e").text("");
    document.getElementById("editResident").reset();
    $("#submit_button_2").prop("disabled", false);
})

$("#addFormModalVisitor").on("hidden.bs.modal", function () {
    $("#visitor_message").text("");
    document.getElementById("addVisitor").reset();
    $("#visitor_submit_button_1").prop("disabled", false);
})

$("#editFormModalVisitor").on("hidden.bs.modal", function () {
    $("#visitor_message_e").text("");
    document.getElementById("editVisitor").reset();
    $("#visitor_submit_button_2").prop("disabled", false);
})