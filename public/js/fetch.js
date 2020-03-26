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

// Updates the values in the Water Reading Form through Ajax
function updateWaterReading() {
    //get Invoice Balance
    var house_id = $("#house_id").val();
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url: "/admin/water-readings/getPrevWaterReading",
        method: "POST",
        data: { house_id: house_id, _token: _token },
        success: function(data) {
            $("#prev_reading").val(data.prev_reading);
        }
    });

    //calculate units_used
    var current_reading = $("#current_reading").val();
    var prev_reading = $("#prev_reading").val();
    var units_used = current_reading - prev_reading;
    $("#units_used").val(units_used);

    // calculate total_charges
    var cost_per_unit = $("#cost_per_unit").val();
    var units_used = $("#units_used").val();
    var total_charges = units_used * cost_per_unit;
    $("#total_charges").val(total_charges);
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
