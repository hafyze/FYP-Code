var paymentMethodSelect = document.getElementById("paymentMethod");
    var extraFieldsContainer = document.getElementById("extraFieldsContainer");
    var extraFields = document.getElementsByClassName("extra-fields");

    // Initially hide all extra fields
    for (var i = 0; i < extraFields.length; i++) {
        extraFields[i].style.display = "none";
    }

    // Event listener to show/hide extra fields based on selected payment method
    paymentMethodSelect.addEventListener("change", function () {
        // Hide all extra fields
        for (var i = 0; i < extraFields.length; i++) {
            extraFields[i].style.display = "none";
        }

        // Show extra fields based on selected payment method
        var selectedPaymentMethod = paymentMethodSelect.value;
        var selectedFields = document.getElementById(selectedPaymentMethod + "Fields");
        if (selectedFields) {
            selectedFields.style.display = "block";
        }
});