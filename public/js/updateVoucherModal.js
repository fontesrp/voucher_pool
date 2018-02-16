const setupUpdateVoucherModal = function (open, vouchersIds) {

    "use strict";

    const twoDigits = function (num) {
        return String(num).padStart(2, "0");
    };

    const setDefaultVals = function () {

        const now = new Date();

        const date = $.datepicker.formatDate("mm/dd/yy", now);

        const time = `${twoDigits(now.getHours())}:${twoDigits(now.getMinutes())}:${twoDigits(now.getSeconds())}`;

        $("#upd-voucher-date").val(date);
        $("#upd-voucher-time").val(time);
    };

    const concatenateDateTime = function () {

        const isoDate = util.datepickerIso("upd-voucher-date");

        $("#upd-voucher-date-time").val(`${isoDate} ${$("#upd-voucher-time").val()}`);
    };

    const setupSave = function () {

        $("#upd-voucher-modal-save").click(function () {

            concatenateDateTime();

            const voucherProps = $("#upd-voucher-form").serialize();

            util.sendRequest({
                method: "PATCH",
                url: root_path + "vouchers/update",
                data: voucherProps
            }).then(function (data) {

                const msg = `The date of usage was updated for ${data.updated_qtt} vouchers`;

                if (data.error !== undefined) {

                    const err = data.error.reduce((str, e) => `${str} [${e.errno}] ${e.sqlstate}: ${e.error}`, "");

                    alert(msg + "\nThere were errors updating some vouchers:\n" + err);

                    return;
                }

                alert(msg);

                // Update report and vouchers table
                showVouchers();

                setDefaultVals();
                util.closeModal("upd-voucher-modal");

            }).catch(function () {
                console.error("updateVoucherModal.js setupSave: request failed");
                console.error(arguments);
            });
        });
    };

    const setIds = function () {
        $("#upd-voucher-ids").val(vouchersIds.join(","));
    };

    if (open) {
        setIds();
        util.showModal("upd-voucher-modal");
        return;
    }

    util.setupDatepicker({
        domId: "upd-voucher-date",
        options: {
            maxDate: 0
        }
    });
    setupSave();
};
