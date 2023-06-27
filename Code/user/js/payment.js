document.addEventListener("DOMContentLoaded", function () {
    var paymentMethodSelect = document.getElementById("paymentMethod");
    var extraFieldsContainer = document.getElementById("extraFieldsContainer");
    var extraFields = extraFieldsContainer.getElementsByClassName("extra-fields");
    var qrCodeImage = document.getElementById("qrCodeImage");

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

        // Show QR code image if "QR Code" payment method is selected
        if (selectedPaymentMethod === "qrcode") {
            qrCodeImage.style.display = "block";
        } else {
            qrCodeImage.style.display = "none";
        }
    });
});