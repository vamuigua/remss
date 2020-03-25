// Updates the values in the Payment Form through Ajax
function updateDetails() {
    //get Invoice Balance
    var invoice_id = $("#invoice_id").val();
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url: "/admin/payments/getInvoiceBalance",
        method: "POST",
        data: { invoice_id: invoice_id, _token: _token },
        success: function(data) {
            $("#prev_balance").val(data.balance);
        }
    });

    //get Current Balance
    var amount_paid = $("#amount_paid").val();
    var prev_balance = $("#prev_balance").val();
    var current_balance = prev_balance - amount_paid;
    $("#balance").val(current_balance);
}

// Toggle importFile style display
function toggleImport() {
    var x = document.getElementById("importFile");
    var value = $("#send_to").val();

    if (value === "excel") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
