<?php
/**
 * /views/vouchers/update.php
 *
 * Form for updating a voucher. Since it's used only inside a modal in the
 * main application page, it doesn't need the standard HTML page tags.
 *
 */
?>

<form id="upd-voucher-form">

    <input type="hidden" id="upd-voucher-ids" name="ids">
    <input type="hidden" id="upd-voucher-date-time" name="used-at">

    <div class="form-group ui-widget">
        <label for="upd-voucher-date">Used date</label>
        <input type="text" class="form-control" id="upd-voucher-date">
    </div>

    <div class="form-group ui-widget">
        <label for="upd-voucher-time">Used time</label>
        <input type="time" class="form-control" id="upd-voucher-time" step="1">
    </div>

</form>
