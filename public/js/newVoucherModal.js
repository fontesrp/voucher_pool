const setupNewVoucherModal = function () {

    "use strict";

    const clearFields = function () {
        $("#add-voucher-modal input").val("");
    };

    const closeModal = function () {
        $("#add-voucher-modal-close").click();
    };

    const formatDate = function (props) {

        const dt = props.find((prp) => (prp.name === "expiration-date"));

        dt.value = datepickerIso("new-voucher-expiration-date");
    };

    const setupSave = function () {

        $("#add-voucher-modal-save").click(function () {

            const voucherProps = $("#new-voucher-form").serializeArray();

            formatDate(voucherProps);

            sendRequest({
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

                clearFields();
                closeModal();

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
            sendRequest({
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

    const setupAutocomplete = function (param) {

        $(`#${param.domId}`).autocomplete({
            minLength: 2,
            source: param.source,
            select: function (ignore, ui) {
                param.change(ui.item.value);
            },
            change: function (ignore, ui) {

                const selected = (ui.item === null)
                    ? null
                    : ui.item.value;

                param.change(selected);
            }
        });
    };

    const findSelectedAsset = function (param) {

        return param.arr.find((obj) => (obj[param.key] === param.selected));
    };

    const setSpecialOfferProps = function (param) {

        const so = findSelectedAsset({
            arr: param.specialOffers,
            key: "name",
            selected: param.selected
        });

        const props = {
            id: "",
            discount: 0
        };

        if (so !== undefined) {
            props.id = so.id;
            props.discount = so.discount;
        }

        $("#new-voucher-special-offer-id").val(props.id);
        $("#new-voucher-special-offer-discount").val(Number(props.discount) * 100);
    };

    const setRecipientId = function (param) {

        const rec = findSelectedAsset({
            arr: param.recipients,
            key: "email",
            selected: param.selected
        });

        const id = (rec === undefined)
            ? ""
            : rec.id;

        $("#new-voucher-recipient-id").val(id);
    };

    const filterResponse = function (param) {
        return param.data.map((obj) => obj[param.key]);
    };

    const searchAsset = function (param) {

        sendRequest({
            method: "GET",
            url: param.url,
            data: param.req
        }).then(function (data) {

            param.cache[param.cacheKey] = data;

            param.res(filterResponse({
                data,
                key: param.filter
            }));
        }).catch(function () {

            console.error("newVoucherModal.js searchAsset: Failed to search on server");
            console.error(arguments);

            param.res([]);
        });
    };

    const setupFields = function () {

        const cache = {};

        // Recipient
        const fields = {
            recipient: {
                type: "autocomplete",
                domId: "new-voucher-recipient",
                source: function (req, res) {
                    searchAsset({
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
                    searchAsset({
                        req,
                        res,
                        cache,
                        url: root_path + "special_offers/search",
                        cacheKey: "specialOffers",
                        filter: "name"
                    });
                },
                change: function (selected) {
                    setSpecialOfferProps({
                        specialOffers: cache.specialOffers,
                        selected
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
                setupAutocomplete(fld);
                break;
            case "datepicker":
                setupDatepicker(fld)
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
