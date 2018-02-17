<?php
/**
 * /views/vouchers/gen.php
 *
 * Form for creating a new voucher. Since it's used only inside a modal in the
 * main application page, it doesn't need the standard HTML page tags.
 *
 */
?>

<form id="new-voucher-form">

    <div class="form-group ui-widget">
        <label for="new-voucher-recipient">Recipient email</label>
        <input type="email" class="form-control" id="new-voucher-recipient" placeholder="name@example.com">
        <small class="form-text text-muted">Select from suggestions</small>
        <input type="hidden" name="recipient-id" id="new-voucher-recipient-id">
    </div>

    <div class="form-row">
        <div class="form-group col-sm-6">
            <label for="new-voucher-special-offer">Special offer</label>
            <input type="text" class="form-control" id="new-voucher-special-offer" placeholder="Special offer name">
            <small class="form-text text-muted">Select from suggestions</small>
            <input type="hidden" name="special-offer-id" id="new-voucher-special-offer-id">
        </div>
        <div class="form-group col-sm-6">
            <label for="new-voucher-special-offer-discount">Discount (%)</label>
            <input type="text" class="form-control" id="new-voucher-special-offer-discount" placeholder="(%)" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-sm-4">
            <label for="new-voucher-code">Code</label>
            <input type="text" class="form-control" name="code" id="new-voucher-code" readonly>
        </div>
        <div class="form-group col-sm-2">
            <label for="new-vouche-code-reload">&nbsp;</label>
            <button type="button" class="btn btn-outline-secondary w-100" id="new-vouche-code-reload">
                <img class="icon" src="<?= request_vendor("img/open-iconic/svg/reload.svg") ?>">
            </button>
        </div>
        <div class="form-group col-sm-6">
            <label for="new-voucher-expiration-date">Expiration date</label>
            <input type="text" class="form-control" name="expiration-date" id="new-voucher-expiration-date">
        </div>
    </div>

</form>
