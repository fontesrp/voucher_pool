/**
 * /public/js/newVouchersModal.js
 *
 * Sets up the functionalities and behaviors of elements inside the modal for
 * creating a new voucher.
 *
 */

const setupNewVoucherModal = function () {

    "use strict";

    const setupSave = function () {

        $("#add-voucher-modal-save").click(function () {

            const voucherProps = $("#new-voucher-form").serializeArray();

            util.formatFormDate(voucherProps, {
                fld: "expiration-date",
                picker: "new-voucher-expiration-date"
            });

            util.sendRequest({
                method: "POST",
                url: root_path + "vouchers/index",
                data: $.param(voucherProps)
            }).then(function (data) {

                if (data.error !== undefined) {

                    const err = data.error.reduce((str, e) => `${str} [${e.errno}] ${e.sqlstate}: ${e.error}`, "");

                    alert("There was an error creating the voucher:\n" + err);

                    return;
                }

                // Update report and vouchers table
                showVouchers();

                util.clearFields("add-voucher-modal");
                util.closeModal("add-voucher-modal");

            }).catch(function () {
                console.error("newVoucherModal.js setupSave: request failed");
                console.error(arguments);
            });
        });
    };

    const updateCode = function (data) {
        $("#new-voucher-code").val(data.code);
    };

    const setupUniqueCode = function () {

        const $reloadBtn = $("#new-vouche-code-reload");

        $reloadBtn.click(function () {
            util.sendRequest({
                method: "GET",
                url: root_path + "vouchers/code_gen"
            }).then(updateCode).catch(function () {
                console.error("newVoucherModal.js setupUniqueCode: failed to get code from server");
                console.error(arguments);
            });
        });

        $("#add-voucher-btn").click(function () {
            $reloadBtn.click();
        });
    };

    const setRecipientId = function (param) {

        const rec = util.findSelectedAsset({
            arr: param.recipients,
            key: "email",
            selected: param.selected
        });

        const id = (rec === undefined)
            ? ""
            : rec.id;

        $("#new-voucher-recipient-id").val(id);
    };

    const setupFields = function () {

        const cache = {};

        // Recipient
        const fields = {
            recipient: {
                type: "autocomplete",
                domId: "new-voucher-recipient",
                source: function (req, res) {
                    util.searchAsset({
                        req,
                        res,
                        cache,
                        url: root_path + "recipients/search",
                        cacheKey: "recipients",
                        filter: "email"
                    });
                },
                change: function (selected) {
                    setRecipientId({
                        recipients: cache.recipients,
                        selected
                    });
                }
            },
            specialOffer: {
                type: "autocomplete",
                domId: "new-voucher-special-offer",
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
                        modalId: "new-voucher"
                    });
                }
            },
            code: {
                type: "uniqueCode"
            },
            expirationDate: {
                type: "datepicker",
                domId: "new-voucher-expiration-date",
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

    setupFields();
    setupSave();
};
