const setupNewSpecialOfferModal = function (open) {

    "use strict";

    const closeModal = function () {
        $("#add-special-offer-modal-close").click();
    };

    const clearFields = function () {
        $("#add-special-offer-modal input").val("");
    };

    const setupSave = function () {

        $("#add-special-offer-modal-save").click(function () {

            const specialOfferProps = $("#new-special-offer-form").serialize();

            sendRequest({
                method: "POST",
                url: root_path + "special_offers/index",
                data: specialOfferProps
            }).then(function (data) {

                if (data.error !== undefined) {

                    const err = data.error.reduce((str, e) => `${str} [${e.errno}] ${e.sqlstate}: ${e.error}`, "");

                    alert("There was en error creating the special offer:\n" + err);

                    return;
                }

                alert("Special offer created");

                // Update report and vouchers table
                showVouchers();

                clearFields();
                closeModal();

            }).catch(function () {
                console.error("newSpecialOfferModal.js setupSave: request failed");
                console.error(arguments);
            });
        });
    };

    const setupDiscount = function () {

        $("#new-special-offer-discount").on("input", function (evt) {

            const inputVal = $(this).val();

            if (isNaN(inputVal)) {
                alert("Invalid discount");
                return;
            }

            $("#new-special-offer-discount-num").val(Number(inputVal) / 100);
        });
    };

    const showModal = function () {
        $("#add-special-offer-modal").modal("show");
    };

    if (open) {
        showModal();
        return;
    }

    setupDiscount();
    setupSave();
};
