const setupGenVouchersModal = function (open) {

    "use strict";

    const setupSave = function () {

        $("#gen-voucher-modal-save").click(function () {

            const voucherProps = $("#gen-voucher-form").serializeArray();

            util.formatFormDate(voucherProps, {
                fld: "expiration-date",
                picker: "gen-voucher-expiration-date"
            });

            util.sendRequest({
                method: "POST",
                url: root_path + "vouchers/gen",
                data: $.param(voucherProps)
            }).then(function (data) {

                const msg = `Created ${data.created_qtt} vouchers`;

                if (data.error !== undefined) {

                    const err = data.error.reduce((str, e) => `${str} [${e.errno}] ${e.sqlstate}: ${e.error}`, "");

                    alert(msg + "\nThere was an error creating the voucher:\n" + err);

                    return;
                }

                alert(msg);

                // Update report and vouchers table
                showVouchers();

                util.clearFields("gen-voucher-modal");
                util.closeModal("gen-voucher-modal");

            }).catch(function () {
                console.error("genVoucherModal.js setupSave: request failed");
                console.error(arguments);
            });
        });
    };

    const setupFields = function () {

        const cache = {};

        // Recipient
        const fields = {
            specialOffer: {
                type: "autocomplete",
                domId: "gen-voucher-special-offer",
                source: function (req, res) {
                    util.searchAsset({
                        req,
                        res,
                        cache,
                        url: root_path + "special_offers/search",
                        cacheKey: "specialOffers",
                        filter: "name"
                    });
                },
                change: function (selected) {
                    util.setSpecialOfferProps({
                        specialOffers: cache.specialOffers,
                        selected,
                        modalId: "gen-voucher"
                    });
                }
            },
            expirationDate: {
                type: "datepicker",
                domId: "gen-voucher-expiration-date",
                options: {
                    minDate: 0
                }
            }
        };

        Object.keys(fields).forEach(function (key) {

            const fld = fields[key];

            switch (fld.type) {
            case "autocomplete":
                util.setupAutocomplete(fld);
                break;
            case "datepicker":
                util.setupDatepicker(fld)
                break;
            case "uniqueCode":
                setupUniqueCode();
                break;
            }

        });
    };

    if (open) {
        util.showModal("gen-voucher-modal");
        return;
    }

    setupFields();
    setupSave();
};
