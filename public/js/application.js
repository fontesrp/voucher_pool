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
