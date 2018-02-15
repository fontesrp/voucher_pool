(function () {

    "use strict";

    const sendRequest = function (param) {

        return new Promise(function (resolve, reject) {

            $.ajax({
                method: param.method,
                data: param.data,
                url: param.url,
                dataType: "json",
                success: resolve,
                error: reject
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
                console.error("application.js setupUniqueCode: failed to get code from server");
                console.error(arguments);
            });
        });

        $("#add-voucher-btn").click(function () {
            $reloadBtn.click();
        });
    };

    const setupDatepicker = function (param) {

        $(`#${param.domId}`).datepicker({
            minDate: 0
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

            console.error("application.js searchAsset: Failed to search on server");
            console.error(arguments);

            param.res([]);
        });
    };

    const setupModalFields = function () {

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
                domId: "new-voucher-expiration-date"
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

    $(document).ready(function () {

        setupModalFields();

        let id = 0;

        $("#vouchers-table").DataTable({
            order: [],
            pageLength: 5,
            data: [
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "y",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                },
                {
                    code: "X3A9309B",
                    recipient: "someone@example.com",
                    used: "n",
                    usedAt: "14.02.2018"
                }
            ],
            columns: [
                { orderable : false, render: () => `<input type="checkbox" name="check-${id += 1}">` },
                { data: "code", orderable : true },
                { data: "used", orderable : false, render: (data) => `<img class="icon" src="${(data === "y" ? y : x)}">` },
                { data: "recipient", orderable : true },
                { data: "usedAt", orderable : true }
            ]
        });
    });

})();
