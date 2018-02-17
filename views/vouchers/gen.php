<?php
/**
 * /views/vouchers/gen.php
 *
 * Form for generating a voucher for each recipient. Since it's used only inside
 * a modal in the main application page, it doesn't need the standard HTML page
 * tags.
 *
 */
?>

<form id="gen-voucher-form">

    <div class="form-row">
        <div class="form-group col-sm-6">
            <label for="gen-voucher-special-offer">Special offer</label>
            <input type="text" class="form-control" id="gen-voucher-special-offer" placeholder="Special offer name">
            <small class="form-text text-muted">Select from suggestions</small>
            <input type="hidden" name="special-offer-id" id="gen-voucher-special-offer-id">
        </div>
        <div class="form-group col-sm-6">
            <label for="gen-voucher-special-offer-discount">Discount (%)</label>
            <input type="text" class="form-control" id="gen-voucher-special-offer-discount" placeholder="(%)" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="gen-voucher-expiration-date">Expiration date</label>
        <input type="text" class="form-control" name="expiration-date" id="gen-voucher-expiration-date">
    </div>

</form>
