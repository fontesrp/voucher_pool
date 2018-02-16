const setupNewRecipientModal = function (open) {

    "use strict";

    const closeModal = function () {
        $("#add-recipient-modal-close").click();
    };

    const clearFields = function () {
        $("#add-recipient-modal input").val("");
    };

    const setupSave = function () {

        $("#add-recipient-modal-save").click(function () {

            const recipientProps = $("#new-recipient-form").serialize();

            sendRequest({
                method: "POST",
                url: root_path + "recipients/index",
                data: recipientProps
            }).then(function (data) {

                if (data.error !== undefined) {

                    const err = data.error.reduce((str, e) => `${str} [${e.errno}] ${e.sqlstate}: ${e.error}`, "");

                    alert("There were errors updating some vouchers:\n" + err);

                    return;
                }

                alert("Recipient created");

                // Update report and vouchers table
                showVouchers();

                clearFields();
                closeModal();

            }).catch(function () {
                console.error("updateVoucherModal.js setupSave: request failed");
                console.error(arguments);
            });
        });
    };

    const showModal = function () {
        $("#add-recipient-modal").modal("show");
    };

    if (open) {
        showModal();
        return;
    }

    setupSave();
};
