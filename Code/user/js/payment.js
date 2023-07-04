document.addEventListener("DOMContentLoaded", function () {
    var paymentMethodSelect = document.getElementById("paymentMethod");
    var extraFieldsContainer = document.getElementById("extraFieldsContainer");
    var extraFields = extraFieldsContainer.getElementsByClassName("extra-fields");
    var qrCodeImage = document.getElementById("qrCodeImage");

    // hide all extra fields
    for (var i = 0; i < extraFields.length; i++) {
        extraFields[i].style.display = "none";
    }

    // Event listener to show/hide fields based on payment method
    paymentMethodSelect.addEventListener("change", function () {
        // Hide all extra fields
        for (var i = 0; i < extraFields.length; i++) {
            extraFields[i].style.display = "none";
        }

        // Show extra fields based on  payment method
        var selectedPaymentMethod = paymentMethodSelect.value;
        var selectedFields = document.getElementById(selectedPaymentMethod + "Fields");
        if (selectedFields) {
            selectedFields.style.display = "block";
        }

        // Show QR code image if "QR Code" payment method is selected
        if (selectedPaymentMethod === "qrcode") {
            qrCodeImage.style.display = "block";
            preloadImage(qrCodeImage.src);
        } else {
            qrCodeImage.style.display = "none";
        }
    });

    // Function to preload an image
    function preloadImage(url) {
        var img = new Image();
        img.src = url;
    }
});