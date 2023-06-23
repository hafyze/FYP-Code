let = urlParams = newURLSearchParams(window.location.search);
if(urlParams.get('success') === '1') {
    alert("Update Successful");
}

//Payment Details
$(document).ready(function() {
    // Hide the bank details and proof of payment initially
    $("#bank_details").hide();
    $("#proof_of_payment").hide();

    // Radio button change event handler
    $(".payment-radio").change(function() {
        var selectedValue = $(this).val();

        // Show/hide relevant payment options based on the selected radio button
        if (selectedValue === "cash") {
            $("#bank_details").hide();
            $("#proof_of_payment").hide();
        } else if (selectedValue === "bank") {
            $("#bank_details").show();
            $("#proof_of_payment").show();
        }
        // Add more conditions for other payment options if needed

    });
});
