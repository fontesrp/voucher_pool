/**
 * /public/js/newRecipientModal.js
 *
 * Sets up the functionalities and behaviors of elements inside the modal for
 * creating a new recipient.
 *
 */

const setupNewRecipientModal = function (open) {

    "use strict";

    const setupSave = function () {

        $("#add-recipient-modal-save").click(function () {

            const recipientProps = $("#new-recipient-form").serialize();

            util.sendRequest({
                method: "POST",
                url: root_path + "recipients/index",
                data: recipientProps
            }).then(function (data) {

                if (data.error !== undefined) {

                    const err = data.error.reduce((str, e) => `${str} [${e.errno}] ${e.sqlstate}: ${e.error}`, "");

                    alert("There was en error creating the recipient:\n" + err);

                    return;
                }

                alert("Recipient created");

                // Update report and vouchers table
                showVouchers();

                util.clearFields("add-recipient-modal");
                util.closeModal("add-recipient-modal");

            }).catch(function () {
                console.error("newRecipientModal.js setupSave: request failed");
                console.error(arguments);
            });
        });
    };

    if (open) {
        util.showModal("add-recipient-modal");
        return;
    }

    setupSave();
};
