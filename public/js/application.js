/**
 * /public/js/application.js
 *
 * Initializes global objects and page components
 *
 */

const util = new Util();

$(document).ready(function () {

    "use strict";

    setupNewVoucherModal();
    setupUpdateVoucherModal();
    setupNewRecipientModal();
    setupNewSpecialOfferModal();
    setupGenVouchersModal();

    showVouchers(true);
});
