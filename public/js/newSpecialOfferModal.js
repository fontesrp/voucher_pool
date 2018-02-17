/**
 * /public/js/newSpecialOfferModal.js
 *
 * Sets up the functionalities and behaviors of elements inside the modal for
 * creating a new special offer.
 *
 */

const setupNewSpecialOfferModal = function (open) {

    "use strict";

    const setupSave = function () {

        $("#add-special-offer-modal-save").click(function () {

            const specialOfferProps = $("#new-special-offer-form").serialize();

            util.sendRequest({
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

                util.clearFields("add-special-offer-modal");
                util.closeModal("add-special-offer-modal");

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

    if (open) {
        util.showModal("add-special-offer-modal");
        return;
    }

    setupDiscount();
    setupSave();
};
