const setupGenVouchersModal = function (open) {

    "use strict";

    const clearFields = function () {
        $("#gen-voucher-modal input").val("");
    };

    const closeModal = function () {
        $("#gen-voucher-modal-close").click();
    };

    const formatDate = function (props) {

        const dt = props.find((prp) => (prp.name === "expiration-date"));

        dt.value = datepickerIso("gen-voucher-expiration-date");
    };

    const setupSave = function () {

        $("#gen-voucher-modal-save").click(function () {

            const voucherProps = $("#gen-voucher-form").serializeArray();

            formatDate(voucherProps);

            sendRequest({
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

                clearFields();
                closeModal();

            }).catch(function () {
                console.error("genVoucherModal.js setupSave: request failed");
                console.error(arguments);
            });
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

        $("#gen-voucher-special-offer-id").val(props.id);
        $("#gen-voucher-special-offer-discount").val(Number(props.discount) * 100);
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

            console.error("genVoucherModal.js searchAsset: Failed to search on server");
            console.error(arguments);

            param.res([]);
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

    const showModal = function () {
        $("#gen-voucher-modal").modal("show");
    };

    if (open) {
        showModal();
        return;
    }

    setupFields();
    setupSave();
};
