const Util = function () {

    "use strict";

    const self = this;

    this.sendRequest = function (param) {

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

    this.numberFormat = function (num, type) {

        if (type === undefined) {
            type = "num"
        }

        let prefix;
        let decimals;

        switch (type) {
        case "num":
            prefix = "";
            decimals = 0;
            break;
        case "curr":
            prefix = "$";
            decimals = 2;
            break;
        }

        return prefix + Number(num).toFixed(decimals).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    };

    this.datepickerIso = function (domId) {

        return $.datepicker.formatDate("yy-mm-dd", $(`#${domId}`).datepicker("getDate"));
    };

    this.setupDatepicker = function (param) {

        $(`#${param.domId}`).datepicker(param.options);
    };

    this.showModal = function (id) {

        $(`#${id}`).modal("show");
    };

    this.closeModal = function (id) {

        $(`#${id}-close`).click();
    };

    this.clearFields = function (containerId) {

        $(`#${containerId} input`).val("");
    };

    this.formatFormDate = function (form, props) {

        const dt = form.find((fld) => (fld.name === props.fld));

        dt.value = self.datepickerIso(props.picker);
    };

    this.setupAutocomplete = function (param) {

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

    this.findSelectedAsset = function (param) {

        return param.arr.find((obj) => (obj[param.key] === param.selected));
    };

    this.setSpecialOfferProps = function (param) {

        const so = self.findSelectedAsset({
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

        $(`#${param.modalId}-special-offer-id`).val(props.id);
        $(`#${param.modalId}-special-offer-discount`).val(Number(props.discount) * 100);
    };

    this.filterResponse = function (param) {
        return param.data.map((obj) => obj[param.key]);
    };

    this.searchAsset = function (param) {

        self.sendRequest({
            method: "GET",
            url: param.url,
            data: param.req
        }).then(function (data) {

            param.cache[param.cacheKey] = data;

            param.res(self.filterResponse({
                data,
                key: param.filter
            }));
        }).catch(function () {

            console.error("util.js searchAsset: Failed to search on server");
            console.error(arguments);

            param.res([]);
        });
    };
};
