<?php
/**
 * /views/special_offer/new.php
 *
 * Form for creating a new special offer. Since it's used only inside a modal in
 * the main application page, it doesn't need the standard HTML page tags.
 *
 */
?>

<form id="new-special-offer-form">

    <div class="form-group ui-widget">
        <label for="new-special-offer-name">Name</label>
        <input type="text" class="form-control" id="new-special-offer-name" name="name" placeholder="Spring Clearance">
    </div>

    <div class="form-group ui-widget">
        <label for="new-special-offer-email">Discount (%)</label>
        <input type="text" class="form-control" id="new-special-offer-discount" placeholder="25.3">
        <input type="hidden" id="new-special-offer-discount-num" name="discount">
    </div>

</form>
