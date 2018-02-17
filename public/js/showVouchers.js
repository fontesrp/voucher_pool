/**
 * /public/js/genVouchersModal.js
 *
 * Sets up the functionalities and behaviors of elements in the main page of the
 * application.
 *
 */

// Since the DataTable API does not offer a way to access the table object after
// initalization, it has to be stored in a global variable.
let vouchersTable;

const showVouchers = function (init) {

    "use strict";

    const genVouchers = function () {
        setupGenVouchersModal(true);
    };

    const newSO = function () {
        setupNewSpecialOfferModal(true);
    };

    const newRecipient = function () {
        setupNewRecipientModal(true);
    };

    const selectedChecks = function () {
        return $("input[type='checkbox'][name^='check-voucher-']:checked");
    };

    const markAsUsed = function () {

        const $checks = selectedChecks();

        if ($checks.length === 0) {
            alert("Please select at least one voucher");
            return;
        }

        const vouchers = [];

        $checks.each(function (ignore, chk) {
            vouchers.push(chk.name.replace("check-voucher-", ""));
        });

        setupUpdateVoucherModal(true, vouchers);
    };

    const setupMenu = function () {

        const links = {
            "link-mark-as-used": markAsUsed,
            "link-new-recipient": newRecipient,
            "link-new-special-offer": newSO,
            "link-generate-vouchers": genVouchers
        };

        Object.keys(links).forEach(function (id) {
            $(`#${id}`).click(links[id]);
        });
    };

    const individualChecks = function () {
        return $("input[type='checkbox'][name^='check-voucher-']");
    };

    const setupChecks = function () {

        $("#check-all").change(function () {
            const checked = $(this).prop("checked");
            individualChecks().prop("checked", checked);
        });
    };

    const setupSearch = function () {

        $("#vouchers-table-search").on("input", function () {
            const searchFor = $(this).val();
            $("#vouchers-table_filter input").val(searchFor).keyup();
        });
    };

    const updateReport = function () {

        util.sendRequest({
            method: "GET",
            url: root_path + "vouchers/report"
        }).then(function (data) {

            Object.keys(data).forEach(function (type) {
                data[type] = util.numberFormat(data[type]);
            });

            $("#generated-vouchers").html(data.generated);
            $("#unused-vouchers").html(data.unused);
            $("#used-vouchers").html(data.used);
        }).catch(function () {
            console.error("application.js updateReport: Error communicating with the server");
            console.error(arguments);
        });
    };

    const updateTable = function () {

        util.sendRequest({
            method: "GET",
            url: root_path + "vouchers/index",
            data: {
                recipientInfo: true
            }
        }).then(function (data) {
            vouchersTable.clear().rows.add(data).draw();
        }).catch(function () {
            console.error("application.js setupTable: Error communicating with the server");
            console.error(arguments);
        });
    };

    const iso2en = function (dateStr) {

        if (dateStr === null) {
            return "";
        }

        // Discard time
        const isoDate = dateStr.split(" ")[0];

        // ["yyyy", "mm", "dd"]
        const isoComps = isoDate.split("-");

        // mm/dd/yyyy
        return `${isoComps[1]}/${isoComps[2]}/${isoComps[0]}`;
    };

    const setupTable = function () {

        vouchersTable = $("#vouchers-table").DataTable({
            columns: [
                { data: "id", orderable : false, render: (data) => `<input type="checkbox" name="check-voucher-${data}">` },
                { data: "code", orderable : true },
                { data: "used_at", orderable : false, render: (data) => `<img class="icon" src="${(data === null) ? icons.x : icons.check}">` },
                { data: "email", orderable : true },
                { data: "used_at", orderable : true, render: iso2en }
            ],
            pageLength: 5,
            data: [],
            order: []
        });
    };

    if (init) {
        setupTable();
        setupSearch();
        setupChecks();
        setupMenu();
    }

    updateTable();
    updateReport();
};
